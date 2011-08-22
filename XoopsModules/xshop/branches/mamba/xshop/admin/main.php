<?php
/**
 * @package     xshop
 * @subpackage  module
 * @description	Sector Network Security Drone
 * @author	    Simon Roberts WISHCRAFT <simon@chronolabs.coop>
 * @copyright	copyright (c) 2010-2013 XOOPS.org
 * @licence		GPL 2.0 - see docs/LICENCE.txt
 */

	
	include('../../../mainfile.php');
	include('../../../include/cp_functions.php');
	include('../include/functions.php');	
	include('../include/forms.xshop.php');
	include('../include/objects.xshop.php');
    include_once 'admin_header.php'; 
$indexAdmin = new ModuleAdmin();    

	$moduleHandler =& xoops_gethandler('module');
	$configHandler =& xoops_gethandler('config');
	$xoxshop = $moduleHandler->getByDirname('xshop');
	if (is_object($xoxshop))
		$GLOBALS['xoopsModuleConfig'] = $configHandler->getConfigList($xoxshop->getVar('mid'));
			
	xoops_cp_header();
	
	$op = isset($_REQUEST['op'])?$_REQUEST['op']:"list";
	$fct = isset($_REQUEST['fct'])?$_REQUEST['fct']:"";
	$limit = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
	$start = !empty($_REQUEST['start'])?intval($_REQUEST['start']):0;
	$order = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
	$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'created';
	$filter = !empty($_REQUEST['filter'])?''.$_REQUEST['filter'].'':'1,1';
		
	switch($op) {
	case 'savelist':
	case 'save':
		xoops_loadLanguage('admin', 'xshop');
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
				if (is_a($object_handler, 'xshopProductsHandler')&&$GLOBALS['xoopsModuleConfig']['tags']) {
					$tag_handler = xoops_getmodulehandler('tag', 'tag');
					$tag_handler->updateByItem($_POST[$id]['tags'], $obj_id, $xoopsModule->getVar("dirname"), $catid = 0);
				}
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
								//xshop_footer_adminMenu();
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
							//xshop_footer_adminMenu();
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
		$url = $_SERVER["PHP_SELF"].'?op=list&fct='.$fct.'&limit='.$limit.'&start='.$start.'&order='.$order.'&sort='.$sort.'&filter='.$filter;
		redirect_header($url, 10, _SHOP_AM_MSG_ITEMWASSAVEDOKEY);
		exit(0);
		break;

	case 'delete':
		xoops_loadLanguage('admin', 'xshop');		
		if (!isset($_POST['confirmed'])) {
			xoops_confirm(array('id'=>$_GET['id'], 'op'=>'delete', 'fct'=>$fct, 'confirm'=>true), $_SERVER['PHP_SELF'], _SHOP_AM_MSG_DELETEITEM, _SUBMIT);
		} else {
			$object_handler =& xoops_getmodulehandler($fct, 'xshop');
			$object = $object_handler->get($_POST['id']);
			if (is_object($object)) {
				$object_handler->delete($object);
			}
			$url = $_SERVER["PHP_SELF"].'?op=list&fct='.$fct;
			redirect_header($url, 10, _SHOP_AM_MSG_ITEMWASDELETED);
			exit(0);
		}
		break;

	case 'edit':
		xoops_loadLanguage('admin', 'xshop');

		include_once $GLOBALS['xoops']->path( "/class/template.php" );
		$GLOBALS['xshoTpl'] = new XoopsTpl();

		$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
		
		$object_handler =& xoops_getmodulehandler($fct, 'xshop');
		$object = $object_handler->get($_GET['id']);
		if (is_object($object)) {
			$GLOBALS['xshoTpl']->assign('form', $object->getForm($_SERVER['QUERY_STRING']));
		}

		$GLOBALS['xshoTpl']->display('db:xshop_cpanel_edit.html');
		break;		
	case 'permissions':

		xoops_loadLanguage('admin', 'xshop');
		//xshop_adminMenu(17);
        echo $indexAdmin->addNavigation('main.php?op=list&fct=permission'); 

		include_once $GLOBALS['xoops']->path('/class/xoopsform/grouppermform.php');
			
		foreach ($_POST as $k => $v) {
			${$k} = $v;
		} 
		
		foreach ($_GET as $k => $v) {
			${$k} = $v;
		} 
		
		echo '<div style="float:right; clear:both;"><form name="perms"><select name="permlinks" onChange="window.location=document.perms.permlinks.options[document.perms.permlinks.selectedIndex].value">';
		
		echo '<option value="'.XOOPS_URL.'/modules/xshop/admin/main.php?op=permissions&fct=category"';
		if ($fct=='category') echo ' selected="selected">'._SHOP_AM_PERM_CATEGORY.'</option>'; else echo '>'._SHOP_AM_PERM_CATEGORY.'</option>';

		echo '<option value="'.XOOPS_URL.'/modules/xshop/admin/main.php?op=permissions&fct=shops"';
		if ($fct=='shops') echo ' selected="selected">'._SHOP_AM_PERM_SHOPS.'</option>'; else echo '>'._SHOP_AM_PERM_SHOPS.'</option>';
				
		echo '</select>&nbsp;<input type="button" name="go" value="'._SUBMIT.'" onClick="window.location=document.perms.permlinks.options[document.perms.permlinks.selectedIndex].value"> </form></div>';

		// View Categories permissions
		$item_list_view = array();
		$block_view = array(); 

		$handler = xoops_getmodulehandler($fct, 'xshop');
		$objects = $handler->getObjects(NULL, true); 
		if ($objects) {
			foreach ($objects as $obj_id => $object) {
				$item_list_view['id'] = $obj_id;
				$item_list_view['title'] = $object->getTitle();
				$form_view = new XoopsGroupPermForm("", $GLOBALS['xoopsModule']->getVar('mid'), 'view_'.$fct, "<img id='toptableicon' src=".XOOPS_URL."/modules/".$GLOBALS['xoopsModule']->dirname()."/images/close12.gif alt='' /></a>"._SHOP_AM_PERMISSIONS_VIEW."</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">".ucfirst($fct)."</span>");
				$block_view[] = $item_list_view;
				foreach ($block_view as $itemlists) {
					$form_view->addItem($itemlists['id'], $itemlists['title']);
				} 
			} 
			echo $form_view->render();
		} else {
			echo "<img id='toptableicon' src=".XOOPS_URL."/modules/".$GLOBALS['xoopsModule']->dirname()."/images/close12.gif alt='' /></a>&nbsp;"._DOC_PERMISSIONSVIEWCATEGORY."</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">"._DOC_NOPERMSSET."</span>";

		} 
		echo "</div>";
		break;
				
	default:
	case 'lists':
		switch ($fct) {
			default:
			case 'shops':
				xoops_loadLanguage('admin', 'xshop'); 
//               	xoops_cp_header();
//				xshop_adminMenu(1);
                echo $indexAdmin->addNavigation('main.php?op=list&fct=lists'); 
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$shops_handler =& xoops_getmodulehandler('shops', 'xshop');
					
				$criteria = $shops_handler->getFilterCriteria($filter);
				$ttl = $shops_handler->getCount($criteria);
				
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
				
				foreach (array(	'shop_id','type','uid','admin_uids','broker_uids','sales_uids','email_id','address_id',
								'phone_id','mobile_id','fax_id','item_id', 'logo_picture_id', 'delivery_id', 
								'express_id', 'sms_id', 'serviced_id', 'days_id', 'start', 'end', 'opening', 'closed', 'sales_in_store',
								'sales_online', 'sales_with_warehouse', 'max_discount', 'special_product_id', 'special_cat_id', 
								'special_manu_id', 'timed', '24hour_online', '24hour_ordering', 'rating', 'votes', 'created', 'updated', 'actioned') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $shops_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$shopss = $shops_handler->getObjects($criteria, true);
				foreach($shopss as $id => $shops) {
					$GLOBALS['xshoTpl']->append('shops', $shops->toArray());
				}
							
				$GLOBALS['xshoTpl']->assign('form', $shops_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
						
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_shops_list.html');
				break;		
			
			case 'category':

				xoops_loadLanguage('admin', 'xshop');
				//xshop_adminMenu(2);
                echo $indexAdmin->addNavigation('main.php?op=list&fct=category');                
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$category_handler =& xoops_getmodulehandler('category', 'xshop');
					
				$criteria = $category_handler->getFilterCriteria($filter);
				$ttl = $category_handler->getCount($criteria);
								
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
				
				foreach (array(	'cat_id','parent_id','item_id','logo_picture_id','uid','rating','votes', 'created', 'updated') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $category_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$categorys = $category_handler->getObjects($criteria, true);
				foreach($categorys as $id => $category) {
					$GLOBALS['xshoTpl']->append('category', $category->toArray());
				}
				
				$GLOBALS['xshoTpl']->assign('form', $category_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
						
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_category_list.html');
				break;		

			case 'currency':
				xoops_loadLanguage('admin', 'xshop');
				//xshop_adminMenu(18);
                echo $indexAdmin->addNavigation('main.php?op=list&fct=currency');                                
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$currency_handler =& xoops_getmodulehandler('currency', 'xshop');
					
				$criteria = $currency_handler->getFilterCriteria($filter);
				$ttl = $currency_handler->getCount($criteria);
				
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
				
				foreach (array(	'currency_id','item_id','symbol_left','symbol_right','decimal_places','thousand_seperator','iso_code','default',
								'rate','exchange_currency_id','exchange_comparison_rate', 'created', 'updated', 'actioned') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $currency_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$currencies = $currency_handler->getObjects($criteria, true);
				foreach($currencies as $id => $currency) {
					$GLOBALS['xshoTpl']->append('currencies', $currency->toArray());
				}
							
				$GLOBALS['xshoTpl']->assign('form', $currency_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
						
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_currency_list.html');
				break;				
			case 'products':

				xoops_loadLanguage('admin', 'xshop');
                echo $indexAdmin->addNavigation('main.php?op=list&fct=products');                
				//xshop_adminMenu(3);
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$products_handler =& xoops_getmodulehandler('products', 'xshop');
					
				$criteria = $products_handler->getFilterCriteria($filter);
				$ttl = $products_handler->getCount($criteria);
								
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
				
				foreach (array(	'product_id','stock','type','uid','shop_id','cat_id','manu_id', 'item_id', 'currency_id',
								'shipping_id', 'feature_picture_id', 'discount_id', 'wholesale_discount_id', 'cat_number', 
								'sub_model', 'cat_prefix', 'cat_subfix', 'unit_price', 'unit_wholesale_price', 'weight_per_unit',
								'weight_measurement', 'quanity_in_unit', 'quanity_for_wholesale', 'quanity_measured', 
								'quanity_in_warehouse', 'quanity_to_order', 'tag', 'rating', 'votes', 'last_ordered',
								'shippment_arrived', 'created', 'updated', 'actioned', 'sales_uid', 'broker_uid', 'cat_num') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $products_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$productss = $products_handler->getObjects($criteria, true);
				foreach($productss as $id => $products) {
					$GLOBALS['xshoTpl']->append('products', $products->toArray());
				}
				
				$GLOBALS['xshoTpl']->assign('form', $products_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
						
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_products_list.html');
				break;

			case 'orders':

				xoops_loadLanguage('admin', 'xshop');
				//xshop_adminMenu(4);
                echo $indexAdmin->addNavigation('main.php?op=list&fct=orders');                
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$orders_handler =& xoops_getmodulehandler('orders', 'xshop');
					
				$criteria = $orders_handler->getFilterCriteria($filter);
				$ttl = $orders_handler->getCount($criteria);
				
				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
				
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());
		
				foreach (array(	'order_id','mode','remittion','key','uid','broker_uids','sales_uids', 'cat_ids', 'manu_ids',
								'shop_ids', 'product_ids', 'shipping_id', 'total', 'tax', 'shipping', 'handling', 'billing_address_id',
								'shipping_address_id', 'billing_email_id', 'shipping_email_id', 'billing_contact_id', 'shipping_contact_id',
								'billing_mobile_id', 'shipping_mobile_id', 'billing_fax_id', 'shipping_fax_id', 'discount_ids', 
								'discount_avg_percentile', 'discount_amount', 'started', 'paid', 'shipped', 'ended', 'offline',
								'ip', 'netbios', 'created', 'updated', 'actioned') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $orders_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$orderss = $orders_handler->getObjects($criteria, true);
				foreach($orderss as $id => $orders) {
					$GLOBALS['xshoTpl']->append('orders', $orders->toArray());
				}

				$GLOBALS['xshoTpl']->assign('form', $orders_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
				
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_orders_list.html');
				break;				

			case 'manufactures':

				xoops_loadLanguage('admin', 'xshop');
				//xshop_adminMenu(5);
                echo $indexAdmin->addNavigation('main.php?op=list&fct=manufactures');                
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$manufactures_handler =& xoops_getmodulehandler('manufactures', 'xshop');
					
				$criteria = $manufactures_handler->getFilterCriteria($filter);
				$ttl = $manufactures_handler->getCount($criteria);
								
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
				
				foreach (array(	'manu_id','ordering','type','broker_uid','item_id','address_id','contact_id',
								'mobile_id', 'email_id', 'last_order_id','logo_picture_id', 'rating', 'votes', 
								'created', 'updated', 'actioned') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $manufactures_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$manufacturess = $manufactures_handler->getObjects($criteria, true);
				foreach($manufacturess as $id => $manufactures) {
					$GLOBALS['xshoTpl']->append('manufactures', $manufactures->toArray());
				}
				
				$GLOBALS['xshoTpl']->assign('form', $manufactures_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
						
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_manufactures_list.html');
				break;				

			case 'shipping':

				xoops_loadLanguage('admin', 'xshop');
				//xshop_adminMenu(6);
                echo $indexAdmin->addNavigation('main.php?op=list&fct=shipping'); 
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$shipping_handler =& xoops_getmodulehandler('shipping', 'xshop');
					
				$criteria = $shipping_handler->getFilterCriteria($filter);
				$ttl = $shipping_handler->getCount($criteria);
								
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
		
				foreach (array(	'shipping_id','type','method','broker_uids','uid','item_id','address_id', 
								'contact_id', 'mobile_id', 'email_id', 'logo_picture_id', 'price_per_kilo', 'price_per_pound',
								'price_per_other', 'country_ids', 'handling_per_unit', 'region_ids', 'opening', 'closing',
								'days_id', 'rating', 'votes', 'created', 'updated', 'actioned') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $shipping_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$shippings = $shipping_handler->getObjects($criteria, true);
				foreach($shippings as $id => $shipping) {
					$GLOBALS['xshoTpl']->append('shipping', $shipping->toArray());
				}
						
				$GLOBALS['xshoTpl']->assign('form', $shipping_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
				
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_shipping_list.html');
				break;
				
			case 'discounts':

				xoops_loadLanguage('admin', 'xshop');
				//xshop_adminMenu(7);
                echo $indexAdmin->addNavigation('main.php?op=list&fct=discounts'); 
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$discounts_handler =& xoops_getmodulehandler('discounts', 'xshop');
					
				$criteria = $discounts_handler->getFilterCriteria($filter);
				$ttl = $discounts_handler->getCount($criteria);
								
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
				
				foreach (array(	'discount_id','type','item_id','percentage','min_quanity','shipping_id','timed','start', 
								'end', 'opening', 'closing', 'days_id', 'created', 'updated', 'actioned') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $discounts_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$discountss = $discounts_handler->getObjects($criteria, true);
				foreach($discountss as $id => $discounts) {
					$GLOBALS['xshoTpl']->append('discounts', $discounts->toArray());
				}
				
				$GLOBALS['xshoTpl']->assign('form', $discounts_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
						
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_discounts_list.html');
				break;			
			case 'contacts':

				xoops_loadLanguage('admin', 'xshop');
				//xshop_adminMenu(8);
                echo $indexAdmin->addNavigation('main.php?op=list&fct=contacts'); 
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$contacts_handler =& xoops_getmodulehandler('contacts', 'xshop');
					
				$criteria = $contacts_handler->getFilterCriteria($filter);
				$ttl = $contacts_handler->getCount($criteria);
								
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
				
				foreach (array(	'contact_id','last_sales_id','last_broker_id','last_cat_id','last_product_id','last_manu_id', 
								'last_shipping_id', 'last_order_id', 'type', 'citation', 'name', 'value',
								'days_id', 'opening', 'closing', 'timezone',
								'country_code', 'area_code', 'created', 'updated', 'actioned') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $contacts_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$contactss = $contacts_handler->getObjects($criteria, true);
				foreach($contactss as $id => $contacts) {
					$GLOBALS['xshoTpl']->append('contacts', $contacts->toArray());
				}
				
				$GLOBALS['xshoTpl']->assign('form', $contacts_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
						
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_contacts_list.html');
				break;	

			case 'addresses':

				xoops_loadLanguage('admin', 'xshop');
				//xshop_adminMenu(9);
                echo $indexAdmin->addNavigation('main.php?op=list&fct=addresses'); 
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$addresses_handler =& xoops_getmodulehandler('addresses', 'xshop');
					
				$criteria = $addresses_handler->getFilterCriteria($filter);
				$ttl = $addresses_handler->getCount($criteria);
								
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
				
				foreach (array(	'address_id','manu_id','shop_id','order_id','type','remittion', 
								'care_of', 'address_line_1', 'address_line_2', 'suburb', 'city', 'region_id',
								'country_id', 'postcode', 'created', 'updated', 'actioned') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $addresses_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$addressess = $addresses_handler->getObjects($criteria, true);
				foreach($addressess as $id => $addresses) {
					$GLOBALS['xshoTpl']->append('addresses', $addresses->toArray());
				}
				
				$GLOBALS['xshoTpl']->assign('form', $addresses_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
						
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_addresses_list.html');
				break;	

			case 'country':

				xoops_loadLanguage('admin', 'xshop');
				//xshop_adminMenu(10);
                echo $indexAdmin->addNavigation('main.php?op=list&fct=country'); 
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$country_handler =& xoops_getmodulehandler('country', 'xshop');
					
				$criteria = $country_handler->getFilterCriteria($filter);
				$ttl = $country_handler->getCount($criteria);
				$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'name';
				
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
				
				
				foreach (array(	'country_id','alpha2','alpha3','name') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $country_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$countrys = $country_handler->getObjects($criteria, true);
				foreach($countrys as $id => $country) {
					$GLOBALS['xshoTpl']->append('country', $country->toArray());
				}
				
				$GLOBALS['xshoTpl']->assign('form', $country_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
						
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_country_list.html');
				break;
			case 'region':

				xoops_loadLanguage('admin', 'xshop');
				//xshop_adminMenu(11);
                echo $indexAdmin->addNavigation('main.php?op=list&fct=region'); 
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$region_handler =& xoops_getmodulehandler('region', 'xshop');
					
				$criteria = $region_handler->getFilterCriteria($filter);
				$ttl = $region_handler->getCount($criteria);
				$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'name';
				
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
				
				foreach (array(	'region_id','name','longitude','latitude') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $region_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$regions = $region_handler->getObjects($criteria, true);
				foreach($regions as $id => $region) {
					$GLOBALS['xshoTpl']->append('region', $region->toArray());
				}
				
				$GLOBALS['xshoTpl']->assign('form', $region_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
						
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_region_list.html');
				break;							
		 	case 'items_digest':

				xoops_loadLanguage('admin', 'xshop');
				//xshop_adminMenu(12);
                echo $indexAdmin->addNavigation('main.php?op=list&fct=items_digest'); 
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$items_handler =& xoops_getmodulehandler('items_digest', 'xshop');
					
				$criteria = $items_handler->getFilterCriteria($filter);
				$ttl = $items_handler->getCount($criteria);
								
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
				
				foreach (array(	'item_id','uid','product_id','manu_id','cat_id','discount_id','shipping_id','days_id','language', 'lang_item_id',
								'picture_id', 'order_id', 'currency_id', 'shop_id', 'type', 'menu_title', 'created', 'updated', 'actioned') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $items_handler->getFilterForm($filter, $key, $sort, $fct));
				}
				
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$itemss = $items_handler->getObjects($criteria, true);
				
				foreach($itemss as $id => $items) {
					$GLOBALS['xshoTpl']->append('items', $items->toArray());
				}
				
				$GLOBALS['xshoTpl']->assign('form', $items_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
				
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_items_digest_list.html');
				break;	
 			case 'gallery':

				xoops_loadLanguage('admin', 'xshop');
				//xshop_adminMenu(13);
                echo $indexAdmin->addNavigation('main.php?op=list&fct=gallery'); 
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$gallery_handler =& xoops_getmodulehandler('gallery', 'xshop');
					
				$criteria = $gallery_handler->getFilterCriteria($filter);
				$ttl = $gallery_handler->getCount($criteria);
								
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
				
				foreach (array(	'picture_id','type','shipping_id','product_id','cat_id','manu_id','shop_id','item_id',
								'weight', 'path', 'filename', 'width', 'height', 'extension', 'created', 'updated', 'actioned') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $gallery_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$gallerys = $gallery_handler->getObjects($criteria, true);
				foreach($gallerys as $id => $gallery) {
					$GLOBALS['xshoTpl']->append('gallery', $gallery->toArray());
				}
				
				$GLOBALS['xshoTpl']->assign('form', $gallery_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
						
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_gallery_list.html');
				break;		
 			case 'autotax':

				xoops_loadLanguage('admin', 'xshop');
				//xshop_adminMenu(14);
                echo $indexAdmin->addNavigation('main.php?op=list&fct=autotax'); 
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$autotax_handler =& xoops_getmodulehandler('autotax', 'xshop');
					
				$criteria = $autotax_handler->getFilterCriteria($filter);
				$ttl = $autotax_handler->getCount($criteria);
				$sort = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':'country';
				
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
				
				foreach (array(	'id','country','code','rate') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $autotax_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$autotaxs = $autotax_handler->getObjects($criteria, true);
				foreach($autotaxs as $id => $autotax) {
					$GLOBALS['xshoTpl']->append('autotax', $autotax->toArray());
				}
						
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_autotax_list.html');
				break;
 			case 'downloads':

				xoops_loadLanguage('admin', 'xshop');
				//xshop_adminMenu(15);
                echo $indexAdmin->addNavigation('main.php?op=list&fct=downloads'); 
				
				include_once $GLOBALS['xoops']->path( "/class/pagenav.php" );
				include_once $GLOBALS['xoops']->path( "/class/template.php" );
				$GLOBALS['xshoTpl'] = new XoopsTpl();
				
				$downloads_handler =& xoops_getmodulehandler('downloads', 'xshop');
					
				$criteria = $downloads_handler->getFilterCriteria($filter);
				$ttl = $downloads_handler->getCount($criteria);
								
				$pagenav = new XoopsPageNav($ttl, $limit, $start, 'start', 'limit='.$limit.'&sort='.$sort.'&order='.$order.'&op='.$op.'&fct='.$fct.'&filter='.$filter.'&fct='.$fct.'&filter='.$filter);
				$GLOBALS['xshoTpl']->assign('pagenav', $pagenav->renderNav());

				$GLOBALS['xshoTpl']->assign('php_self', $_SERVER['PHP_SELF']);
				$GLOBALS['xshoTpl']->assign('limit', $limit);
				$GLOBALS['xshoTpl']->assign('start', $start);
				$GLOBALS['xshoTpl']->assign('order', $order);
				$GLOBALS['xshoTpl']->assign('sort', $sort);
				$GLOBALS['xshoTpl']->assign('filter', $filter);
				
				foreach (array(	'download_id','product_id','path','filename','mimetype','hits','created', 'updated') as $id => $key) {
					$GLOBALS['xshoTpl']->assign(strtolower(str_replace('-','_',$key).'_th'), '<a href="'.$_SERVER['PHP_SELF'].'?start='.$start.'&limit='.$limit.'&sort='.$key.'&order='.(($key==$sort)?($order=='DESC'?'ASC':'DESC'):$order).'&op='.$op.'&fct='.$fct.'&filter='.$filter.'">'.(defined('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key)))?constant('_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))):'_SHOP_AM_TH_'.strtoupper(str_replace('-','_',$key))).'</a>');
					$GLOBALS['xshoTpl']->assign('filter_'.strtolower(str_replace('-','_',$key)).'_th', $downloads_handler->getFilterForm($filter, $key, $sort, $fct));
				}
					
				$criteria->setStart($start);
				$criteria->setLimit($limit);
				$criteria->setSort('`'.$sort.'`');
				$criteria->setOrder($order);
					
				$downloadss = $downloads_handler->getObjects($criteria, true);
				foreach($downloadss as $id => $downloads) {
					$GLOBALS['xshoTpl']->append('downloads', $downloads->toArray());
				}
				
				$GLOBALS['xshoTpl']->assign('form', $downloads_handler->getForm($_SERVER['QUERY_STRING'], true, true, '', 'base', array()));
						
				$GLOBALS['xshoTpl']->display('db:xshop_cpanel_downloads_list.html');
				break;
		}																				
		break;
		
	}
	
//	xshop_footer_adminMenu();
include 'admin_footer.php';
?>