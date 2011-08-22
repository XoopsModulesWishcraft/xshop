<?php

	include('header.php');

	switch($op) {
		case 'save':
		
			foreach($_POST['id'] as $id => $handler) {		
				
				$object_handler =& xoops_getmodulehandler($handler, 'xshop');
				
				if ($id!=0)
					$object = $object_handler->get($id);
				else 
					$object = $object_handler->create();
					
				if (is_object($object)) {
					$object->setVars($_POST[$id]);
					if (isset($_POST[$id]['start']))
						$object->setVar('start', strtotime($_POST[$id]['start']));
					if (isset($_POST[$id]['end']))
						$object->setVar('end', strtotime($_POST[$id]['end']));			
					if (is_a($object_handler, 'xshopItems_digestHandler')) {
						$obj_id = $object_handler->insert($object, $_POST[$id]['item_id'], $_POST[$id]['language'], true);
					} else {
						$obj_id = $object_handler->insert($object, true);
					}
					$object = $object_handler->get($obj_id);
					
					foreach($_POST['uploade_file_name'] as $media){
						if (strlen($_FILE[$media]['name'])) {
							include_once $GLOBALS['xoops']->path('/modules/xshop/class/myuploader.php');
					  		$gallery_handler = xoops_getmodulehandler('gallery', 'xshop');
					  		$downloads_handler = xoops_getmodulehandler('downloads', 'xshop');
							if (is_a($object_handler, 'xshopProductsHandler')) {
								$gallery_field = 'feature_picture_id';
							} elseif (is_a($object_handler, 'xshopShippingHandler')) {
								$gallery_field = 'logo_picture_id';
							} elseif (is_a($object_handler, 'xshopShopsHandler')) {
								$gallery_field = 'logo_picture_id';
							} elseif (is_a($object_handler, 'xshopGalleryHandler')) {
								$gallery_field = 'picture_id';
							} elseif (is_a($object_handler, 'xshopDownloadsHandler')) {
								$download_field = 'download_id';
							}	  
							
							if (strlen($gallery_field)) {
								if (!is_a($object_handler, 'xshopGalleryHandler')) {
									if ($object->getVar($gallery_field)!=0)	{
										$gallery = $gallery_handler->get($object->getVar($gallery_field));
										$gallery_handler->delete($gallery);
									}
									$gallery = $gallery_handler->create();
									$gallery->createFolders();
								} else {
									$gallery = $gallery_handler->get($object->getVar($gallery_field));
									unlink(XOOPS_UPLOAD_PATH.$gallery->getVar('path').$gallery->getVar('filename'));
		    						unlink(XOOPS_UPLOAD_PATH.$gallery->getVar('thumbnail_path').$gallery->getVar('filename'));
								}
								$allowed_mimetypes = explode('|', $GLOBALS['xoopsModuleConfig']['images_mimetypes']);
								$allowed_exts = explode('|', $GLOBALS['xoopsModuleConfig']['images_extensions']);
								$maxfilesize = $GLOBALS['xoopsModuleConfig']['max_file_size'];
								$uploaddir = XOOPS_UPLOAD_PATH.$gallery->getVar('path');
							} elseif (strlen($download_field)) {
								if ($object->getVar('filename')!='') {
									unlink(XOOPS_VAR_PATH.$object->getVar('path').$object->getVar('filename'));
									$object->setVar('filename', '');
								}	
								$object->createFolders();
								$allowed_mimetypes = explode('|', $GLOBALS['xoopsModuleConfig']['download_mimetypes']);
								$allowed_exts = explode('|', $GLOBALS['xoopsModuleConfig']['download_extensions']);
								$maxfilesize = $GLOBALS['xoopsModuleConfig']['max_file_size'];
								$uploaddir = XOOPS_VAR_PATH.$object->getVar('path');
							}
							
							$uploader = new MyXoopsMediaUploader($uploaddir, $allowed_mimetypes, $maxfilesize, 0, 0, $allowed_exts);
							if ($uploader->fetchMedia($media)) {
							    if (!$uploader->upload()) {
									$object_handler->delete($object);				    	
							       	echo $uploader->getErrors();
									xshop_footer_adminMenu();
									xoops_cp_footer();
									exit(0);	       	
							    } elseif (strlen($gallery_field)) {
							    	if (!is_a($object_handler, 'xshopGalleryHandler')) {
								    	$gallery->getVar('filename', $uploader->getSavedFileName());
								    	$object->setVar($gallery_field, $gallery_handler->insert($gallery, true, true));
							    	} else {
							    		$object->getVar('filename', $uploader->getSavedFileName());
							    		$object_handler->insert($object, true, true);
							    	}
							    } elseif (strlen($download_field)) {
							    	$object->getVar('filename', $uploader->getSavedFileName());		
								      	
								}
							} else {
								$object_handler->delete($object);				    	
						       	echo $uploader->getErrors();
								xshop_footer_adminMenu();
								xoops_cp_footer();
								exit(0);	       	
							}
						}
					}	
					
					foreach(array(	'item', 'address', 'contact', 'mobile', 'email', 
									'contact', 'fax', 'delivery', 'sms', 'billing_address', 
									'billing_contact', 'billing_mobile', 'billing_fax', 'billing_email',
									'shipping_address', 'shipping_contact', 'shipping_mobile', 
									'shipping_fax', 'shipping_email') as $key) {
	
						if (isset($_POST[$id][$key]['id'])) {
							foreach($_POST[$id][$key]['id'] as $sub_id => $sub_handler) {		
								$sub_object_handler =& xoops_getmodulehandler($sub_handler, 'xshop');
								if ($sub_id!=0)
									$sub_object = $sub_object_handler->get($sub_id);
								else 
									$sub_object = $sub_object_handler->create();
	
								if (is_object($sub_object)) {
									$sub_object->setVars($_POST[$id][$key][$sub_id]);
									if (isset($_POST[$id][$key][$sub_id]['start']))
										$sub_object->setVar('start', strtotime($_POST[$id][$key][$sub_id]['start']));
									if (isset($_POST[$id][$key][$sub_id]['end']))
										$sub_object->setVar('end', strtotime($_POST[$id][$key][$sub_id]['end']));								
									switch ($handler) {
										case 'products':
											$sub_object->setVar('cat_id', $object->getVar('cat_id'));
											$sub_object->setVar('product_id', $obj_id);
											break;
										case 'manufactures':
											$sub_object->setVar('manu_id', $obj_id);
											break;
										case 'category':
											$sub_object->setVar('cat_id', $obj_id);
											break;
										case 'discounts':
											$sub_object->setVar('discount_id', $obj_id);
											break;
										case 'shipping':
											$sub_object->setVar('shipping_id', $obj_id);
											break;
										case 'days':
											$sub_object->setVar('days_id', $obj_id);
											break;
										case 'gallery':
											$sub_object->setVar('picture_id', $obj_id);
											break;
										case 'orders':
											$sub_object->setVar('order_id', $obj_id);
											break;
										case 'currency':
											$sub_object->setVar('currency_id', $obj_id);
											break;
										case 'shops':
											$sub_object->setVar('shop_id', $obj_id);
											break;
									}
									if (is_a($sub_object_handler, 'xshopItems_digestHandler')) {
										$sub_obj_id = $sub_object_handler->insert($sub_object, $_POST[$id][$key]['item_id'][$sub_id], $_POST[$id][$key]['language'][$sub_id], true);
										$sub_object = $sub_object_handler->get ($sub_obj_id);
										if (is_object($sub_object))
											$object->setVar('item_id', $sub_object->getVar('item_id'));
									} else {
										$sub_obj_id = $sub_object_handler->insert($sub_object, true);
										$sub_object = $sub_object_handler->get ($sub_obj_id);
										switch ($key) {
											case 'address':
											case 'mobile':
											case 'email':
											case 'fax':
											case 'delivery':
											case 'billing_address':
											case 'billing_contact':
											case 'billing_mobile':
											case 'billing_fax':
											case 'billing_email':
											case 'shipping_address':
											case 'shipping_contact':
											case 'shipping_mobile':
											case 'shipping_fax':
											case 'shipping_email':
											case 'sms':
												$object->setVar($key.'_id', $sub_obj_id);
												break;
											case 'contact':
												$object->setVar('last_cat_id', $object->getVar('cat_id'));
												$object->setVar($key.'_id', $sub_obj_id);
												break;
										}																				}
									}
									if (isset($_POST[$id][$key][$sub_id]['days'])) {
										foreach($_POST[$id][$key][$sub_id]['days'] as $days_id => $days_handler) {		
											$days_object_handler =& xoops_getmodulehandler('days', 'xshop');
											if ($days_id!=0)
												$days_object = $days_object_handler->get($days_id);
											else 
												$days_object = $days_object_handler->create();	
											$days_object->setVars($_POST[$id][$key][$sub_id]['days'][$days_id]);
											switch ($sub_handler) {
												case 'addresses':
													$days_object->setVar('address_id', $sub_obj_id);
													break;
												case 'contacts':
													$days_object->setVar('contact_id', $sub_obj_id);
													break;
												case 'items':
													$days_object->setVar('item_id', $sub_obj_id);
													break;
												case 'products':
													$days_object->setVar('cat_id', $sub_object->getVar('cat_id'));
													$days_object->setVar('product_id', $sub_obj_id);
													break;
												case 'manufactures':
													$days_object->setVar('manu_id', $sub_obj_id);
													break;
												case 'category':
													$days_object->setVar('cat_id', $sub_obj_id);
													break;
												case 'discounts':
													$days_object->setVar('discount_id', $sub_obj_id);
													break;
												case 'shipping':
													$days_object->setVar('shipping_id', $sub_obj_id);
													break;
												case 'days':
													$days_object->setVar('days_id', $sub_obj_id);
													break;
												case 'gallery':
													$days_object->setVar('picture_id', $sub_obj_id);
													break;
												case 'orders':
													$days_object->setVar('order_id', $sub_obj_id);
													break;
												case 'currency':
													$days_object->setVar('currency_id', $sub_obj_id);
													break;
												case 'shops':
													$days_object->setVar('shop_id', $sub_obj_id);
													break;
											}	
											$day_id = $days_object_handler->insert($days_object, true);
											$sub_object->setVar('days_id', $day_id);																
										}
									}
									if (is_a($sub_object_handler, 'xshopItems_digestHandler')) {
										$sub_obj_id = $sub_object_handler->insert($sub_object, $_POST[$id][$key]['item_id'][$sub_id], $_POST[$id][$key]['language'][$sub_id], true);
										$sub_object = $sub_object_handler->get ($sub_obj_id);
									} else {
										$sub_obj_id = $sub_object_handler->insert($sub_object, true);
										$sub_object = $sub_object_handler->get ($sub_obj_id);
									}
								}
							}
						}
					
					if (is_a($object_handler, 'xshopItems_digestHandler')) {
						$obj_id = $object_handler->insert($object, $_POST[$id]['item_id'], $_POST[$id]['language'], true);
					} else {
						$obj_id = $object_handler->insert($object, true);
					}
				}
			}
			
			switch ($fct) {
				case "orders":
					if ($object->getVar('mode')!='_SHOP_MI_ORDER_GONETOINVOICE') {
						
						$object->setVar('mode', '_SHOP_MI_ORDER_GONETOINVOICE');
										
						$currency_handler =& xoops_getmodulehandler('currency', 'xshop');
						$currency = $currency_handler->getVar($object->getVar('currency_id'));
						
						$contacts_handler =& xoops_getmodulehandler('contacts', 'xshop');
						$billing_email = $contacts_handler->getVar($object->getVar('billing_email_id'));
						
						$invoice_handler =& xoops_getmodulehandler('invoice', 'xpayment');
						$invoice_items_handler =& xoops_getmodulehandler('invoice_items', 'xpayment');
									
						$invoice = $invoice_handler->create();
						
						$invoice->setVar('return', XOOPS_URL.'/modules/xshop/index.php?op=return&order_id='.$obj_id);
						$invoice->setVar('cancel', XOOPS_URL.'/modules/xshop/index.php?op=cancel&order_id='.$obj_id);
						$invoice->setVar('ipn', XOOPS_URL.'/modules/xshop/ipn.php?order_id='.$obj_id);
						$invoice->setVar('currency', $currency->getVar('iso_code'));
						$invoice->setVar('drawfor', $GLOBALS['xoopsConfig']['sitename']));
						$invoice->setVar('drawto', (strlen($billing_email->getVar('citation'))?$billing_email->getVar('citation'). ' ':'').$billing_email->getVar('name'));
						$invoice->setVar('drawto_email', $billing_email->getVar('value'));
						$invoice->setVar('key', $object->getVar('key').'|'.$object->getVar('order_id'));
						$invoice->setVar('plugin', 'xshop');
						$invoice->setVar('weight_unit', 'kgs');
						$invoice->setVar('mode', 'UNPAID');
						$invoice->setVar('reoccurrence', 0);
						$invoice->setVar('reoccurrence_period_days', 30);
						$invoice->setVar('donation', false);
						
						$invoice->setVar('user_ip', $object->getVar('ip'));
						$invoice->setVar('user_netaddy', $object->getVar('netbios'));
						$invoice->setVar('user_uid', $object->getVar('uid'));
						
						if ($iid = $invoice_handler->insert($invoice)) {
							$invoice = $invoice_handler->get($iid);
							if (strlen($invoice->getVar('invoicenumber'))==0)
								$invoice->setVar('invoicenumber', $invoice->getVar('iid'));
							$amount=0;
							$shipping=0;
							$handling=0;
							$weight=0;
							$items=0;
							$tax=0;
							$orders_digest_handler = xoops_getmodulehandler('orders_digest', 'xshop');
							$products_handler = xoops_getmodulehandler('products', 'xshop');
							$orders_digest = $orders_digest_handler->getObjects(new Criteria('order_id', $object->getVar('order_id')), true);
							foreach($orders_digest as $id => $item) {
								$product = $products_handler->get($item->getVar('product_id'));
								$itemobj = $invoice_items_handler->create();
								$itemobj->setVar('iid', $invoice->getVar('iid'));
								$itemobj->setVar('cat', $product->getCatNumber());		
								$itemobj->setVar('name', $product->getName());
								$itemobj->setVar('amount', $item->getVar('price')-$item->getVar('discount_amount'));
								$itemobj->setVar('quanity', $item->getVar('quanity'));
								$itemobj->setVar('shipping', $item->getVar('shipping'));
								$itemobj->setVar('handling', $item->getVar('handling'));
								$itemobj->setVar('tax', $item->getVar('tax')/$item->getVar('price')*100);
								if ($iiid = $invoice_items_handler->insert($itemobj)) {
									$items=$items+$itemobj->getVar('quantity');
									$totals = $itemobj->getTotalsArray();
									$amount = $amount + $totals['amount'];
									$shipping = $shipping + $totals['shipping'];
									$handling = $handling + $totals['handling'];
									$weight = $weight + $totals['weight'];
									$tax = $tax + $totals['tax'];					
								}
							}
						}
							
						$invoice->setVar('items', $items);
						$invoice->setVar('shipping', $shipping);
						$invoice->setVar('handling', $handling);
						$invoice->setVar('weight', $weight);
						$invoice->setVar('tax', $tax);
						$invoice->setVar('amount', $amount);
						$grand = ($amount+$handling+$shipping+$tax);
						$invoice->setVar('grand', $grand);
						
						$groups_handler  =& xoops_getmodulehandler('groups', 'xpayment');
						$invoice->setVar('broker_uids', $groups_handler->getUids('BROKERS', $invoice->getVar('plugin'), $grand));
						$invoice->setVar('accounts_uids', $groups_handler->getUids('ACCOUNTS', $invoice->getVar('plugin'), $grand));
						$invoice->setVar('officer_uids', $groups_handler->getUids('OFFICERS', $invoice->getVar('plugin'), $grand));
						
						$invoice_handler->insert($invoice);
						
						$xoopsMailer =& getMailer();
						$xoopsMailer->setHTML(true);
						$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/xpayment/language/'.$GLOBALS['xoopsConfig']['language'].'/mail_templates/'));
						$xoopsMailer->setTemplate('xpayment_invoice_created.tpl');
						$xoopsMailer->setSubject(sprintf(_XPY_EMAIL_CREATED_SUBJECT, $grand, $_POST['currency'], $_POST['drawto']));
						
						$xoopsMailer->setToEmails($billing_email->getVar('value'));
						
						$xoopsMailer->assign("SITEURL", XOOPS_URL);
						$xoopsMailer->assign("SITENAME", $GLOBALS['xoopsConfig']['sitename']);
						$xoopsMailer->assign("INVOICENUMBER", $invoice->getVar('invoicenumber'));
						$xoopsMailer->assign("CURRENCY", $invoice->getVar('currency'));
						$xoopsMailer->assign("DRAWTO", $invoice->getVar('drawto'));
						$xoopsMailer->assign("DRAWTO_EMAIL", $invoice->getVar('drawto_email'));
						$xoopsMailer->assign("DRAWFOR", $invoice->getVar('drawfor'));	
						$xoopsMailer->assign("AMOUNT", $grand);
						$xoopsMailer->assign("INVURL", $invoice->getURL());
						$xoopsMailer->assign("PDFURL", $invoice->getPDFURL());
						
						if(!$xoopsMailer->send() ){
							xoops_error($xoopsMailer->getErrors(true), 'Email Send Error');
						}

						$object->setVar('invoice_url', $invoice->getURL());
						$object->setVar('pdf_url', $invoice->getPDFURL());
						$obj_id = $object_handler->insert($object, true);
					}	
				
			}
			
			$url = $_SERVER["PHP_SELF"].'?op=orders&fct=invoiced';
			redirect_header($url, 10, _SHOP_MN_MSG_ITEMWASSAVEDOKEY);
			exit(0);
			break;
		
		case 'orders':
			switch($fct){
				case "view":
					$orders_handler = xoops_getmodulehandler('orders', 'xshop');
					$order = $orders_handler->get($_REQUEST['order_id']);
					if ($order->getVar('uid')!=0) {
						if (is_object($GLOBALS['xoopsUser'])) {
							if ($order->getVar('uid')!=$GLOBALS['xoopsUser']->getVar('uid')) {
								redirect_header(XOOPS_URL.'/modules/xshop', 10, _NOPERM);
								exit(0);
							}
						} else {
							redirect_header(XOOPS_URL.'/modules/xshop', 10, _NOPERM);
							exit(0);
						}
					} elseif ($order->getVar('user_key')!=$GLOBALS['user']['md5']) {
						redirect_header(XOOPS_URL.'/modules/xshop', 10, _NOPERM);
						exit(0);
					}
					if ($order->getVar('offline')<time()) {
						redirect_header(XOOPS_URL.'/modules/xshop', 10, _NOPERM);
						exit(0);
					}

					$xoopsOption['template_main'] = 'xshop_orders_details.html';
					include($GLOBALS['xoops']->path('/header.php'));
					
					$GLOBALS['xoopsTpl']->assign('order', $order->toArray());
					
					$orders_digest_handler = xoops_getmodulehandler('orders_digest', 'xshop');
					$criteria = new Criteria('order_id', $order->getVar('order_id'));
					$items = $orders_digest_handler->getObjects($criteria, true);
					
					foreach($items as $order_digest_id => $order_digest) {
						$GLOBALS['xoopsTpl']->append('digest', $order_digest->toArray());
					}

				case "finalise":
					
					$orders_handler = xoops_getmodulehandler('orders', 'xshop');
					$order = $orders_handler->get($_REQUEST['order_id']);
					if ($order->getVar('uid')!=0) {
						if (is_object($GLOBALS['xoopsUser'])) {
							if ($order->getVar('uid')!=$GLOBALS['xoopsUser']->getVar('uid')) {
								redirect_header(XOOPS_URL.'/modules/xshop', 10, _NOPERM);
								exit(0);
							}
						} else {
							redirect_header(XOOPS_URL.'/modules/xshop', 10, _NOPERM);
							exit(0);
						}
					} elseif ($order->getVar('user_key')!=$GLOBALS['user']['md5']) {
						redirect_header(XOOPS_URL.'/modules/xshop', 10, _NOPERM);
						exit(0);
					}
					if ($order->getVar('offline')<time()) {
						redirect_header(XOOPS_URL.'/modules/xshop', 10, _NOPERM);
						exit(0);
					}

					$xoopsOption['template_main'] = 'xshop_orders_finalise.html';
					include($GLOBALS['xoops']->path('/header.php'));
					
					$GLOBALS['xoopsTpl']->assign('order', $order->toArray());
					$GLOBALS['xoopsTpl']->assign('form', $order->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
					
				case "open":
					$orders_handler = xoops_getmodulehandler('orders', 'xshop');
					$criteria_a = new CriteriaCompo(new Criteria('user_key', $GLOBALS['user']['md5']), 'OR');
					$criteria_a->add(new Criteria('uid', $GLOBALS['user']['uid']), 'OR');
					$criteria = new CriteriaCompo($criteria_a, 'AND');
					$criteria->add(new Criteria('`mode`', '_SHOP_MI_ORDER_OPENORDER'), "AND");
					
					$orders = $orders_handler->getObjects($criteria, true);
					
					$xoopsOption['template_main'] = 'xshop_orders.html';
					include($GLOBALS['xoops']->path('/header.php'));

					foreach($orders as $order_id => $order) {
						$GLOBALS['xoopsTpl']->append('orders', $order->toArray());
					}
					
					break;

				case "closed":
					$orders_handler = xoops_getmodulehandler('orders', 'xshop');
					$criteria_a = new CriteriaCompo(new Criteria('user_key', $GLOBALS['user']['md5']), 'OR');
					$criteria_a->add(new Criteria('uid', $GLOBALS['user']['uid']), 'OR');
					$criteria = new CriteriaCompo($criteria_a, 'AND');
					$criteria->add(new Criteria('`mode`', '_SHOP_MI_ORDER_CLOSEDORDER'), "AND");
					
					$orders = $orders_handler->getObjects($criteria, true);
					
					$xoopsOption['template_main'] = 'xshop_orders_closed.html';
					include($GLOBALS['xoops']->path('/header.php'));

					foreach($orders as $order_id => $order) {
						$GLOBALS['xoopsTpl']->append('orders', $order->toArray());
					}
					
					break;

				case "checkout":
					$orders_handler = xoops_getmodulehandler('orders', 'xshop');
					$criteria_a = new CriteriaCompo(new Criteria('user_key', $GLOBALS['user']['md5']), 'OR');
					$criteria_a->add(new Criteria('uid', $GLOBALS['user']['uid']), 'OR');
					$criteria = new CriteriaCompo($criteria_a, 'AND');
					$criteria->add(new Criteria('`mode`', '_SHOP_MI_ORDER_CHECKEDOUT'), "AND");
					
					$orders = $orders_handler->getObjects($criteria, true);
					
					$xoopsOption['template_main'] = 'xshop_orders_checkedout.html';
					include($GLOBALS['xoops']->path('/header.php'));

					foreach($orders as $order_id => $order) {
						$GLOBALS['xoopsTpl']->append('orders', $order->toArray());
					}
					
					break;
					
				case "invoiced":
					$orders_handler = xoops_getmodulehandler('orders', 'xshop');
					$criteria_a = new CriteriaCompo(new Criteria('user_key', $GLOBALS['user']['md5']), 'OR');
					$criteria_a->add(new Criteria('uid', $GLOBALS['user']['uid']), 'OR');
					$criteria = new CriteriaCompo($criteria_a, 'AND');
					$criteria->add(new Criteria('`mode`', '_SHOP_MI_ORDER_GONETOINVOICE'), "AND");
					
					$orders = $orders_handler->getObjects($criteria, true);
					
					$xoopsOption['template_main'] = 'xshop_orders_invoiced.html';
					include($GLOBALS['xoops']->path('/header.php'));

					foreach($orders as $order_id => $order) {
						$GLOBALS['xoopsTpl']->append('orders', $order->toArray());
					}
					
					break;					
			}
			break;
		case 'cart':
			xoops_load('xoopscache');
			if (!class_exists('XoopsCache'))
				xoops_load('cache');
			
			if ($ret['a'] = XoopsCache::read('xshop_cart_'.$GLOBALS['user']['uid'].'_'.$GLOBALS['user']['md5'])) {
				if ($ret['b'] = XoopsCache::read('xshop_cart_0_'.$GLOBALS['user']['md5'])){
					$caddy = array_merge($ret['a'], $ret['b']);		
				} else {
					$caddy = $ret['a'];
				}
			}  else 
				$caddy = array();

			unset($caddy['totals']);
			foreach($caddy as $shop_id => $valuesb) {
				unset($caddy[$shop_id]['totals']);
				if (is_numeric($shop_id)) {
					foreach($valuesb as $prod_id => $value) {
						if (is_numeric($prod_id)) {
							$caddy[$shop_id]['totals']['handling'] = $caddy[$shop_id]['totals']['handling'] + $caddy[$shop_id][$prod_id]['handling'];		
							$caddy[$shop_id]['totals']['shipping'] = $caddy[$shop_id]['totals']['shipping'] + $caddy[$shop_id][$prod_id]['shipping'];
							$caddy[$shop_id]['totals']['total'] = $caddy[$shop_id]['totals']['total'] + $caddy[$shop_id][$prod_id]['total'];
							$caddy[$shop_id]['totals']['tax'] = $caddy[$shop_id]['totals']['tax'] + $caddy[$shop_id][$prod_id]['tax'];
							$caddy[$shop_id]['totals']['discount'] = $caddy[$shop_id]['totals']['discount'] + $caddy[$shop_id][$prod_id]['discount']['amount'];
							$caddy[$shop_id]['totals']['grand'] = $caddy[$shop_id]['totals']['grand'] + ($caddy[$shop_id]['totals']['handling'] + $caddy[$shop_id]['totals']['shipping'] + $caddy[$shop_id]['totals']['total'] - $caddy[$shop_id]['totals']['discount'] + $caddy[$shop_id][$prod_id]['tax']);
							$caddy[$shop_id]['money']['handling'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['handling']);		
							$caddy[$shop_id]['money']['shipping'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['shipping']);
							$caddy[$shop_id]['money']['total'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['total']);
							$caddy[$shop_id]['money']['tax'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['tax']);
							$caddy[$shop_id]['money']['discount'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['discount']);
							$caddy[$shop_id]['money']['grand'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['grand']);
						} 
					}
					$caddy['totals']['handling'] = $caddy['totals']['handling'] + $caddy[$shop_id]['totals']['handling'];
					$caddy['totals']['shipping'] = $caddy['totals']['shipping'] + $caddy[$shop_id]['totals']['shipping'];
					$caddy['totals']['tax'] = $caddy['totals']['tax'] + $caddy[$shop_id]['totals']['tax'];
					$caddy['totals']['total'] = $caddy['totals']['total'] + $caddy[$shop_id]['totals']['total'];
					$caddy['totals']['discount'] = $caddy['totals']['discount'] + $caddy[$shop_id]['totals']['discount'];
					$caddy['totals']['grand'] = $caddy['totals']['grand'] + $caddy[$shop_id]['totals']['grand'];
					$caddy['money']['handling'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['handling']);		
					$caddy['money']['shipping'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['shipping']);
					$caddy['money']['total'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['total']);
					$caddy['money']['tax'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['tax']);
					$caddy['money']['discount'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['discount']);
					$caddy['money']['grand'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['grand']);
			
				}
			}
			
			$xoopsOption['template_main'] = 'xshop_cart.html';
			include($GLOBALS['xoops']->path('/header.php'));
			
			$shops_handler = xoops_getmodulehandler('shops', 'xshop');
			$products_handler = xoops_getmodulehandler('products', 'xshop');
			$ret = array();
			foreach($caddy as $shop_id => $values) {
				if ($shop_id == 'totals') {
					$GLOBALS['xoopsTpl']->assign('grand', $values);
				} elseif ($shop_id == 'money') {
					$GLOBALS['xoopsTpl']->assign('grand_money', $values);
				} else {
					$shop = $shops_handler->get($shop_id);
					if (is_object($shop)) {
						$ret[$shop_id]['data'] = $shop->toArray();
						foreach($values as $product_id => $prod) {
							if ($product_id == 'totals') {
								$ret[$shop_id]['totals'] = $prod;
							} elseif ($product_id == 'money') {
								$ret[$shop_id]['money'] = $prod;
							} else {
								$product = $products_handler->get($product_id);
								if (is_object($product)) {
									$ret[$shop_id][$product_id]['data'] = $product->toArray(); 
									$ret[$shop_id][$product_id]['values'] = $prod;
								}
							}
						}
					}
				}
			}
			
			$GLOBALS['xoopsTpl']->assign('cart', $ret);
			
			break;
		default:
			switch($fct){
				default:
					
					$category_handler = xoops_getmodulehandler('category', 'xshop');
					$manufactures_handler = xoops_getmodulehandler('manufactures', 'xshop');
					$products_handler = xoops_getmodulehandler('products', 'xshop');
					$shops_handler = xoops_getmodulehandler('shops', 'xshop');
					
					$category_in = $category_handler->getIn($cat_id, $shop_id, $manu_id, $product_id);
					$manufactures_in = $manufactures_handler->getIn((empty($cat_id)?$category_in:$cat_id), $shop_id, $manu_id, $product_id);
					$shops_in = $shops_handler->getIn((empty($cat_id)?$category_in:$cat_id), $shop_id, (empty($manu_id)?$manufactures_in:$manu_id), $product_id, true, true);
					$products_in = $products_handler->getIn((empty($cat_id)?$category_in:$cat_id), (empty($shop_id)?$shops_in:$shop_id), (empty($manu_id)?$manufactures_in:$manu_id), $product_id); 

					$criteria = new Criteria('manu_id', '('.implode(',', $manufactures_in).')', 'IN');
					$manufactures_ttl = $manufactures_handler->getCount($criteria);
					$manufactures_pagenav = new XoopsPageNav($manufactures_ttl, $limit, $start['manufactures'], 'start[manufactures]', 'limit[manufactures]='.$limit['manufactures'].'&sort[manufactures]='.$sort['manufactures'].'&limit[products]='.$limit['products'].'&sort[products]='.$sort['products'].'&order[products]='.$order['products'].'&limit[shops]='.$limit['shops'].'&sort[shops]='.$sort['shops'].'&order[shops]='.$order['shops'].'&op='.$op.'&fct='.$fct.'&start[products]='.$start['products'].'&start[shops]='.$start['shops']);
					$criteria->setStart($start['manufactures']);
					$criteria->setLimit($limit['manufactures']);
					$criteria->setSort('`'.$sort['manufactures'].'`');
					$criteria->setOrder($order['manufactures']);
					$manufactures = $manufactures_handler->getObjects($criteria, true);

					$criteria = new Criteria('shop_id', '('.implode(',', $shops_in).')', 'IN');
					$shops_ttl = $shops_handler->getCount($criteria);
					$shops_pagenav = new XoopsPageNav($shops_ttl, $limit, $start['shops'], 'start[shops]', 'limit[manufactures]='.$limit['manufactures'].'&sort[manufactures]='.$sort['manufactures'].'&limit[products]='.$limit['products'].'&sort[products]='.$sort['products'].'&order[products]='.$order['products'].'&limit[shops]='.$limit['shops'].'&sort[shops]='.$sort['shops'].'&order[shops]='.$order['shops'].'&op='.$op.'&fct='.$fct.'&start[products]='.$start['products'].'&start[manufactures]='.$start['manufactures']);
					$criteria->setStart($start['shops']);
					$criteria->setLimit($limit['shops']);
					$criteria->setSort('`'.$sort['shops'].'`');
					$criteria->setOrder($order['shops']);
					$shops = $shops_handler->getObjects($criteria, true);
					
					$criteria = new Criteria('product_id', '('.implode(',', $products_in).')', 'IN');
					$products_ttl = $products_handler->getCount($criteria);
					$products_pagenav = new XoopsPageNav($products_ttl, $limit, $start['products'], 'start[products]', 'limit[manufactures]='.$limit['manufactures'].'&sort[manufactures]='.$sort['manufactures'].'&limit[products]='.$limit['products'].'&sort[products]='.$sort['products'].'&order[products]='.$order['products'].'&limit[shops]='.$limit['shops'].'&sort[shops]='.$sort['shops'].'&order[shops]='.$order['shops'].'&op='.$op.'&fct='.$fct.'&start[manufactures]='.$start['manufactures'].'&start[shops]='.$start['shops']);
					$criteria->setStart($start['products']);
					$criteria->setLimit($limit['products']);
					$criteria->setSort('`'.$sort['products'].'`');
					$criteria->setOrder($order['products']);
					$products = $products_handler->getObjects($criteria, true);

					$xoopsOption['template_main'] = 'xshop_index.html';
					include($GLOBALS['xoops']->path('/header.php'));
				
					$GLOBALS['xoopsTpl']->assign('categories', $category_handler->renderSmarty($cat_id));
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->assign('manufactures_pagenav', $manufactures_pagenav->renderNav());
					$GLOBALS['xoopsTpl']->assign('shops_pagenav', $shops_pagenav->renderNav());
					$GLOBALS['xoopsTpl']->assign('products_pagenav', $products_pagenav->renderNav());

					
					foreach($products as $product_id => $product) {
						$GLOBALS['xoopsTpl']->append('products', $product->toArray());
					}

					foreach($shops as $shop_id => $shop){
						$GLOBALS['xoopsTpl']->append('shops', $shop->toArray());
					}
					foreach($manufactures as $manufacture_id => $manufacture){
						$GLOBALS['xoopsTpl']->append('manufactures', $manufacture->toArray());
					}
			
			}
	}

	$GLOBALS['xoopsTpl']->assign('limit', $limit);
	$GLOBALS['xoopsTpl']->assign('start', $start);
	$GLOBALS['xoopsTpl']->assign('order', $order);
	$GLOBALS['xoopsTpl']->assign('sort', $sort);
	$GLOBALS['xoopsTpl']->assign('filter', $filter);
	$GLOBALS['xoopsTpl']->assign('user', $GLOBALS['user']);
	$GLOBALS['xoopsTpl']->assign('json_salt', sha1($GLOBALS['xoopsModuleConfig']['salt'].$GLOBALS['user']['uid'].$GLOBALS['user']['md5'].date('Ymdh')));
	$GLOBALS['xoopsTpl']->assign('xoModule', $GLOBALS['xoopsModule']->toArray());
	$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
	$GLOBALS['xoopsTpl']->assign('xoopsConfig', $GLOBALS['xoopsConfig']);
	$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/browse.php?Frameworks/jquery/jquery.js');
	$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/'.$GLOBALS['xoopsModule']->getVar('dirname').'/js/core.js', array('type'=>'text/javascript'));
	$GLOBALS['xoTheme']->addScript(XOOPS_URL.'/modules/'.$GLOBALS['xoopsModule']->getVar('dirname').'/js/json_caddy.js', array('type'=>'text/javascript'));

	include($GLOBALS['xoops']->path('/footer.php'));
	
?>
