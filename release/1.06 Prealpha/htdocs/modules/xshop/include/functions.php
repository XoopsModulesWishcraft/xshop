<?php

if (!function_exists("xshop_getuser_id")) {
	function xshop_getuser_id()
	{
		if (is_object($GLOBALS['xoopsUser']))
			$ret['uid'] = $GLOBALS['xoopsUser']->getVar('uid');
		else 
			$ret['uid'] = 0;
	
		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			$ret['ip']  = $_SERVER["HTTP_X_FORWARDED_FOR"];
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"].':'.$_SERVER["REMOTE_ADDR"];
			$net = gethostbyaddr($_SERVER["HTTP_X_FORWARDED_FOR"]);
		} else { 
			$ip = $_SERVER["REMOTE_ADDR"];
			$net = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
			$ret['ip']  = $_SERVER["REMOTE_ADDR"];
		}
		
		$ret['md5'] = md5($GLOBALS['xoopsModuleConfig']['salt'] . $ip . $net);	
		return $ret;
	}
}

if (!function_exists("get_users_id")) {
	function get_users_id($mixed) {
		$handler = xoops_gethandler('user');
		if (empty($mixed)||$mixed==0) {
			return '';
		} elseif (is_numeric($mixed)) {
			$obj = $handler->get($mixed);
			if (is_object($obj)) {
				$out = array();
				$out['data'] = $obj->toArray();
				$out['html'] = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$obj->getVar('uid').'">'.$obj->getVar('uname').'</a>';
				return $out; 
			} else {
				return '';
			}
		} elseif (is_array($mixed)) {
			$ret = array();
			foreach($mixed as $id) {
				$obj = $handler->get($id);
				if (is_object($obj)) {
					$out = array();
					$out['data'] = $obj->toArray();
					$out['html'] = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$obj->getVar('uid').'">'.$obj->getVar('uname').'</a>';
					$ret[$id] = $out; 
				}
			}
			return $ret;
		}
	}
}

if (!function_exists("get_item_id")) {
	function get_item_id($mixed) {
		$handler = xoops_getmodulehandler('items', 'xshop');
		if (empty($mixed)||$mixed==0) {
			return '';
		} elseif (is_numeric($mixed)) {
			$obj = $handler->get($mixed);
			if (is_object($obj)) {
				$digest = $obj->retrieveDigest($GLOBALS['xoopsConfig']['language']);
				if (is_object($digest))
					return $digest->toArray(true);
				else 
					return array(); 
			} else {
				return '';
			}
		} elseif (is_array($mixed)) {
			$ret = array();
			foreach($mixed as $id) {
				$obj = $handler->get($id);
				if (is_object($obj)) {
					$digest = $obj->retrieveDigest($GLOBALS['xoopsConfig']['language']);
					$ret[$id] = $digest->toArray(true); 
				}
			}
			return $ret;
		}
	}
}

if (!function_exists("get_address_id")) {
	function get_address_id($mixed) {
		$handler = xoops_getmodulehandler('addresses', 'xshop');
		if (empty($mixed)||$mixed==0) {
			return '';
		} elseif (is_numeric($mixed)) {
			$obj = $handler->get($mixed);
			if (is_object($obj)) {
				return $obj->toArray(); 
			} else {
				return '';
			}
		} elseif (is_array($mixed)) {
			$ret = array();
			foreach($mixed as $id) {
				$obj = $handler->get($id);
				if (is_object($obj)) {
					$ret[$id] = $obj->toArray(); 
				}
			}
			return $ret;
		}
	}
}

if (!function_exists("get_contact_id")) {
	function get_contact_id($mixed) {
		$handler = xoops_getmodulehandler('contacts', 'xshop');
		if (empty($mixed)||$mixed==0) {
			return '';
		} elseif (is_numeric($mixed)) {
			$obj = $handler->get($mixed);
			if (is_object($obj)) {
				return $obj->toArray(); 
			} else {
				return '';
			}
		} elseif (is_array($mixed)) {
			$ret = array();
			foreach($mixed as $id) {
				$obj = $handler->get($id);
				if (is_object($obj)) {
					$ret[$id] = $obj->toArray(); 
				}
			}
			return $ret;
		}
	}
}

if (!function_exists("get_picture_id")) {
	function get_picture_id($mixed) {
		$handler = xoops_getmodulehandler('gallery', 'xshop');
		if (empty($mixed)||$mixed==0) {
			return '';
		} elseif (is_numeric($mixed)) {
			$obj = $handler->get($mixed);
			if (is_object($obj)) {
				$ret = array();
				$ret['html']['thumbnail'] = "<img src='".XOOPS_UPLOAD_URL.$obj->getVar('thumbnail_path').$obj->getVar('filename').'" />';
				$ret['html']['orginal'] = "<img src='".XOOPS_UPLOAD_URL.$obj->getVar('path').$obj->getVar('filename')."' width='".$GLOBALS['xoopsModuleConfig']['orginal_width']."' />";
				$ret['direct']['thumbnail'] = XOOPS_UPLOAD_PATH.$obj->getVar('thumbnail_path').$obj->getVar('filename');
				$ret['direct']['orginal'] = XOOPS_UPLOAD_PATH.$obj->getVar('path').$obj->getVar('filename');
				$ret['url']['thumbnail'] = XOOPS_UPLOAD_URL.$obj->getVar('thumbnail_path').$obj->getVar('filename');
				$ret['url']['orginal'] = XOOPS_UPLOAD_URL.$obj->getVar('path').$obj->getVar('filename');
				return $ret; 
			} else {
				return '';
			}
		} elseif (is_array($mixed)) {
			$ret = array();
			foreach($mixed as $id) {
				$obj = $handler->get($id);
				if (is_object($obj)) {
					$out = array();
					$out['html']['thumbnail'] = "<img src='".XOOPS_UPLOAD_URL.$obj->getVar('thumbnail_path').$obj->getVar('filename').'" />';
					$out['html']['orginal'] = "<img src='".XOOPS_UPLOAD_URL.$obj->getVar('path').$obj->getVar('filename')."' />";
					$out['direct']['thumbnail'] = XOOPS_UPLOAD_PATH.$obj->getVar('thumbnail_path').$obj->getVar('filename');
					$out['direct']['orginal'] = XOOPS_UPLOAD_PATH.$obj->getVar('path').$obj->getVar('filename');
					$out['url']['thumbnail'] = XOOPS_UPLOAD_URL.$obj->getVar('thumbnail_path').$obj->getVar('filename');
					$out['url']['orginal'] = XOOPS_UPLOAD_URL.$obj->getVar('path').$obj->getVar('filename');
					$ret[$id] = $out; 
				}
			}
			return $ret;
		}
	}
}

if (!function_exists("get_cat_id")) {
	function get_cat_id($mixed) {
		$handler = xoops_getmodulehandler('category', 'xshop');
		if (empty($mixed)||$mixed==0) {
			return '';
		} elseif (is_numeric($mixed)) {
			$obj = $handler->get($mixed);
			if (is_object($obj)) {
				return $obj->toArray(); 
			} else {
				return '';
			}
		} elseif (is_array($mixed)) {
			$ret = array();
			foreach($mixed as $id) {
				$obj = $handler->get($id);
				if (is_object($obj)) {
					$ret[$id] = $obj->toArray(); 
				}
			}
			return $ret;
		}
	}
}

if (!function_exists("get_manufacture_id")) {
	function get_manufacture_id($mixed) {
		$handler = xoops_getmodulehandler('manufactures', 'xshop');
		if (empty($mixed)||$mixed==0) {
			return '';
		} elseif (is_numeric($mixed)) {
			$obj = $handler->get($mixed);
			if (is_object($obj)) {
				return $obj->toArray(); 
			} else {
				return '';
			}
		} elseif (is_array($mixed)) {
			$ret = array();
			foreach($mixed as $id) {
				$obj = $handler->get($id);
				if (is_object($obj)) {
					$ret[$id] = $obj->toArray(); 
				}
			}
			return $ret;
		}
	}
}

if (!function_exists("get_shipping_id")) {
	function get_shipping_id($mixed) {
		$handler = xoops_getmodulehandler('shipping', 'xshop');
		if (empty($mixed)||$mixed==0) {
			return '';
		} elseif (is_numeric($mixed)) {
			$obj = $handler->get($mixed);
			if (is_object($obj)) {
				return $obj->toArray(); 
			} else {
				return '';
			}
		} elseif (is_array($mixed)) {
			$ret = array();
			foreach($mixed as $id) {
				$obj = $handler->get($id);
				if (is_object($obj)) {
					$ret[$id] = $obj->toArray(); 
				}
			}
			return $ret;
		}
	}
}

if (!function_exists("get_currency_id")) {
	function get_currency_id($mixed) {
		$handler = xoops_getmodulehandler('currency', 'xshop');
		if (empty($mixed)||$mixed==0) {
			return '';
		} elseif (is_numeric($mixed)) {
			$obj = $handler->get($mixed);
			if (is_object($obj)) {
				return $obj->toArray(); 
			} else {
				return '';
			}
		} elseif (is_array($mixed)) {
			$ret = array();
			foreach($mixed as $id) {
				$obj = $handler->get($id);
				if (is_object($obj)) {
					$ret[$id] = $obj->toArray(); 
				}
			}
			return $ret;
		}
	}
}

if (!function_exists("get_discount_id")) {
	function get_discount_id($mixed) {
		$handler = xoops_getmodulehandler('discounts', 'xshop');
		if (empty($mixed)||$mixed==0) {
			return '';
		} elseif (is_numeric($mixed)) {
			$obj = $handler->get($mixed);
			if (is_object($obj)) {
				return $obj->toArray(); 
			} else {
				return '';
			}
		} elseif (is_array($mixed)) {
			$ret = array();
			foreach($mixed as $id) {
				$obj = $handler->get($id);
				if (is_object($obj)) {
					$ret[$id] = $obj->toArray(); 
				}
			}
			return $ret;
		}
	}
}

if (!function_exists("get_product_id")) {
	function get_product_id($mixed) {
		$handler = xoops_getmodulehandler('products', 'xshop');
		if (empty($mixed)||$mixed==0) {
			return '';
		} elseif (is_numeric($mixed)) {
			$obj = $handler->get($mixed);
			if (is_object($obj)) {
				return $obj->toArray(); 
			} else {
				return '';
			}
		} elseif (is_array($mixed)) {
			$ret = array();
			foreach($mixed as $id) {
				$obj = $handler->get($id);
				if (is_object($obj)) {
					$ret[$id] = $obj->toArray(); 
				}
			}
			return $ret;
		}
	}
}

if (!function_exists("get_order_id")) {
	function get_order_id($mixed) {
		$handler = xoops_getmodulehandler('orders', 'xshop');
		if (empty($mixed)||$mixed==0) {
			return '';
		} elseif (is_numeric($mixed)) {
			$obj = $handler->get($mixed);
			if (is_object($obj)) {
				return $obj->toArray(); 
			} else {
				return '';
			}
		} elseif (is_array($mixed)) {
			$ret = array();
			foreach($mixed as $id) {
				$obj = $handler->get($id);
				if (is_object($obj)) {
					$ret[$id] = $obj->toArray(); 
				}
			}
			return $ret;
		}
	}
}

if (!function_exists("get_shop_id")) {
	function get_shop_id($mixed) {
		$handler = xoops_getmodulehandler('shops', 'xshop');
		if (empty($mixed)||$mixed==0) {
			return '';
		} elseif (is_numeric($mixed)) {
			$obj = $handler->get($mixed);
			if (is_object($obj)) {
				return $obj->toArray(); 
			} else {
				return '';
			}
		} elseif (is_array($mixed)) {
			$ret = array();
			foreach($mixed as $id) {
				$obj = $handler->get($id);
				if (is_object($obj)) {
					$ret[$id] = $obj->toArray(); 
				}
			}
			return $ret;
		}
	}
}

if (!function_exists("get_money_format")) {
	function get_money_format($currency_id=0, $price=0) {
		$handler = xoops_getmodulehandler('currency', 'xshop');
		if (empty($currency_id)||$currency_id==0) {
			return number_format($price, 2);
		} elseif (is_numeric($currency_id)) {
			$obj = $handler->get($currency_id);
			if (is_object($obj)) {
				return $obj->toFormat($price); 
			} else {
				return number_format($price, 2);
			}
		} 
		return number_format($price, 2);
	}
}

if (!function_exists("change_money_rate")) {
	function change_money_rate($changefrom_currency_id=0, $changeto_currency_id=0, $amount=0) {
		if ($changefrom_currency_id==$changeto_currency_id)
			return $amount;
		$handler = xoops_getmodulehandler('currency', 'xshop');
		return $handler->getAmountRate($changefrom_currency_id, $changeto_currency_id, $amount=0);
	}
}

if (!function_exists("xshop_md5calc")) {
	function xshop_md5calc($object) {
		if (is_object($object)&&isset($object->vars)) {
			foreach($object->vars as $key => $item) {
				if (!in_array($key, array('md5', 'created', 'updated', 'actioned')))
					$ret .= md5($item['value']);
			}
			return md5($ret);
		} else {
			return md5($object);
		}
	}
}

if (!function_exists("filter_querystring")) {
	function filter_querystring($string, $element) {
		foreach(explode('&', $string) as $component) {
			$value = explode('=', $component);
			if (strtolower($value[0])!=strtolower($element))
				$ret[] = $component;
		}
		return implode('&', $ret);
	}
}

if (!function_exists("get_when_associative")) {
	function get_when_associative($object) {
		if ($object->getVar('created')==0)
			$ret['created'] = '';
		else 
			$ret['created'] = date(_DATESTRING, $object->getVar('created'));
		if ($object->getVar('updated')==0)
			$ret['updated'] = '';
		else 
			$ret['updated'] = date(_DATESTRING, $object->getVar('updated'));
		if ($object->getVar('actioned')==0)
			$ret['actioned'] = '';
		else 
			$ret['actioned'] = date(_DATESTRING, $object->getVar('actioned'));
		if ($object->getVar('dispatched')==0)
			$ret['dispatched'] = '';
		else 
			$ret['dispatched'] = date(_DATESTRING, $object->getVar('dispatched'));
		if ($object->getVar('returned')==0)
			$ret['returned'] = '';
		else 
			$ret['returned'] = date(_DATESTRING, $object->getVar('returned'));
		if ($object->getVar('paid')==0)
			$ret['paid'] = '';
		else 
			$ret['paid'] = date(_DATESTRING, $object->getVar('paid'));
		if ($object->getVar('shipped')==0)
			$ret['shipped'] = '';
		else 
			$ret['shipped'] = date(_DATESTRING, $object->getVar('shipped'));
		if ($object->getVar('ended')==0)
			$ret['ended'] = '';
		else 
			$ret['ended'] = date(_DATESTRING, $object->getVar('ended'));
		if ($object->getVar('started')==0)
			$ret['started'] = '';
		else 
			$ret['started'] = date(_DATESTRING, $object->getVar('started'));		
		if ($object->getVar('offline')==0)
			$ret['offline'] = '';
		else 
			$ret['offline'] = date(_DATESTRING, $object->getVar('offline'));								
		if ($object->getVar('end')==0)
			$ret['end'] = '';
		else 
			$ret['end'] = date(_DATESTRING, $object->getVar('end'));
		if ($object->getVar('start')==0)
			$ret['start'] = '';
		else 
			$ret['start'] = date(_DATESTRING, $object->getVar('start'));		
		if ($object->getVar('last_ordered')==0)
			$ret['last_ordered'] = '';
		else 
			$ret['last_ordered'] = date(_DATESTRING, $object->getVar('last_ordered'));
		if ($object->getVar('shippment_arrived')==0)
			$ret['shippment_arrived'] = '';
		else 
			$ret['shippment_arrived'] = date(_DATESTRING, $object->getVar('shippment_arrived'));	
		return $ret;
	}
}
if (!function_exists("xshop_adminMenu")) {
  function xshop_adminMenu ($currentoption = 0)  {
		$module_handler = xoops_gethandler('module');
		$xoModule = $module_handler->getByDirname('xshop');

	  /* Nice buttons styles */
	    echo "
    	<style type='text/css'>
		#form {float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/".$xoModule->getVar('dirname')."/images/bg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;}
		    	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/".$xoModule->getVar('dirname')."/images/bg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 0px; border-bottom: 1px solid black; }
    	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		  #buttonbar li { display:inline; margin:0; padding:0; }
		  #buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/".$xoModule->getVar('dirname')."/images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px;  text-decoration:none; }
		  #buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/".$xoModule->getVar('dirname')."/images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
		  /* Commented Backslash Hack hides rule from IE5-Mac \*/
		  #buttonbar a span {float:none;}
		  /* End IE5-Mac hack */
		  #buttonbar a:hover span { color:#333; }
		  #buttonbar #current a { background-position:0 -150px; border-width:0; }
		  #buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		  #buttonbar a:hover { background-position:0% -150px; }
		  #buttonbar a:hover span { background-position:100% -150px; }
		  </style>";
	
	   // global $xoopsDB, $xoModule, $xoopsConfig, $xoModuleConfig;
	
	   $myts = &MyTextSanitizer::getInstance();
	
	   $tblColors = Array();
		// $adminmenu=array();
	   if (file_exists(XOOPS_ROOT_PATH . '/modules/'.$xoModule->getVar('dirname').'/language/' . $GLOBALS['xoopsConfig']['language'] . '/modinfo.php')) {
		   include_once XOOPS_ROOT_PATH . '/modules/'.$xoModule->getVar('dirname').'/language/' . $GLOBALS['xoopsConfig']['language'] . '/modinfo.php';
	   } else {
		   include_once XOOPS_ROOT_PATH . '/modules/'.$xoModule->getVar('dirname').'/language/english/modinfo.php';
	   }
       
	   include XOOPS_ROOT_PATH . '/modules/'.$xoModule->getVar('dirname').'/admin/menu.php';
	   global $adminmenu;
	   echo "<table width=\"100%\" border='0'><tr><td>";
	   echo "<div id='buttontop'>";
	   echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
	   echo "<td style=\"width: 45%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"".XOOPS_URL."/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoModule->getVar('mid') . "\">" . _PREFERENCES . "</a></td>";
	   echo "<td style='font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;'><b>" . $myts->displayTarea($xoModule->name()) ."</td>";
	   echo "</tr></table>";
	   echo "</div>";
	   echo "<div id='buttonbar'>";
	   echo "<ul>";
		 foreach ($adminmenu as $key => $value) {
		   $tblColors[$key] = '';
		   $tblColors[$currentoption] = 'current';
	     echo "<li id='" . $tblColors[$key] . "'><a href=\"" . XOOPS_URL . "/modules/".$xoModule->getVar('dirname')."/".$value['link']."\"><span>" . $value['title'] . "</span></a></li>";
		 }
		 
	   echo "</ul></div>";
	   echo "</td></tr>";
	   echo "<tr><td><div id='form'>";
    
  }
  
  function xshop_footer_adminMenu()
  {
		echo "</div></td></tr>";
  		echo "</table>";
  }
}

if (!function_exists('xshop_getFilterElement')) {
	function xshop_getFilterElement($filter, $field, $sort='created', $fct = 'shops') {
		$components = xshop_getFilterURLComponents($filter, $field, $sort);
		include_once('objects.xshop.php');
		switch ($field) {
			case 'type':
				switch ($fct) {
					case 'shops':
						$ele = new XShopFormSelectShopType('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    			$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    			break;
					case 'contacts':
						$ele = new XShopFormSelectContactsType('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    			$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    			break;
					case 'discounts':
						$ele = new XShopFormSelectDiscountType('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    			$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    			break;
					case 'items_digest':
						$ele = new XShopFormSelectItemDigestType('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    			$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    			break;
					case 'manufactures':
						$ele = new XShopFormSelectManufacturesType('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    			$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    			break;
					case 'products':
						$ele = new XShopFormSelectProductsType('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    			$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    			break;
					case 'shipping':
						$ele = new XShopFormSelectShippingType('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    			$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    			break;
		    			
				}			
		    	break;
		    case 'parent_id':
		    case 'cat_ids':	
			case 'cat_id':
				$ele = new XShopFormSelectCategory('', 'filter_'.$field.'', $components['value']);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
			case 'discount_id':
			case 'wholesale_discount_id':
			case 'discount_ids':
			case 'discount_id':
				$ele = new XShopFormSelectDiscount('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
			case 'manu_id':
			case 'manu_ids':
				$ele = new XShopFormSelectManufactures('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
			case 'shipping_id':
			case 'shipping_ids':
				$ele = new XShopFormSelectShipping('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
			case 'last_order_id':
			case 'order_id':
			case 'order_ids':				
				$ele = new XShopFormSelectOrders('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;		    			    			    	
	    	case 'currency_ids':
		    case 'currency_id':
				$ele = new XShopFormSelectCurrency('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
			case 'country_ids':
		    case 'country_id':
				$ele = new XShopFormSelectCountry('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;		    	
		    case 'item_ids':
		    case 'item_id':
				$ele = new XShopFormSelectItems('', 'filter_'.$field.'', $components['value'], 1, false, true, $_REQUEST['fct']);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
		    case 'product_ids':
		    case 'product_id':
				$ele = new XShopFormSelectProduct('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;	
		    case 'stock':
				$ele = new XShopFormSelectProductsStock('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;	
		    case 'method':
		    	$ele = new XShopFormSelectShippingMethod('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
		    case 'mode':
		    	$ele = new XShopFormSelectOrdersMode('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
		    case 'remittion':
		    	$ele = new XShopFormSelectOrdersRemittion('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
		    case 'closing':
		    case 'closed':
	    	case 'opening':
				$ele = new XShopFormSelectTime('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
	    	case 'billing_address_id':
	    	case 'shipping_address_id':
		    case 'address_id':
				$ele = new XShopFormSelectAddress('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
		    case 'billing_email_id':
		    case 'shipping_email_id':
		    case 'billing_contact_id':
		    case 'shipping_contact_id':
		    case 'billing_mobile_id':
		    case 'shipping_mobile_id':
		    case 'billing_fax_id':
		    case 'shipping_fax_id':	
		    case 'contact_id':
		    case 'mobile_id':
		    case 'email_id':
				$ele = new XShopFormSelectAddress('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
			case 'broker_uid':		    	
		    case 'broker_uids':
		    	$ele = new XShopFormSelectGroupedUser('', 'filter_'.$field.'', $components['value'], 1, false, $GLOBALS['xoopsModuleConfig']['brokers']);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
		    case 'sales_uid':
		    case 'sales_uids':
		    	$ele = new XShopFormSelectGroupedUser('', 'filter_'.$field.'', $components['value'], 1, false, $GLOBALS['xoopsModuleConfig']['sales']);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
		    case 'admin_uid':
		    case 'admin_uids':
		    	$ele = new XShopFormSelectGroupedUser('', 'filter_'.$field.'', $components['value'], 1, false, $GLOBALS['xoopsModuleConfig']['admins']);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
		    case 'weight_measurement':
		    	$ele = new XShopFormSelectMeasurement('', 'filter_'.$field.'', $components['value'], 1, false, $GLOBALS['xoopsModuleConfig']['admins']);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;		    	
		    case 'cat_number':
		    case 'sub_model':
		    case 'cat_prefix':
		    case 'cat_subfix':
		    case 'unit_price':	
		    case 'unit_wholesale_price':
		    case 'weight_per_unit':
		    case 'quanity_in_unit':
		    case 'quanity_for_wholesale':
			case 'quanity_measured':
			case 'quanity_in_warehouse':
			case 'quanity_to_order':
			case 'tag':
			case 'menu_title':
			case 'long_title':
			case 'rss_title':
			case 'menu_subtitle':
			case 'long_subtitle':
			case 'menu_description':
			case 'long_description':
			case 'rss_description':
			case 'meta_description':
			case 'meta_keywords':
			case 'name':
			case 'longitude':
			case 'latitude':
			case 'price_per_kilo':
			case 'price_per_pound':
			case 'price_per_other':
			case 'care_of':
			case 'address_line_1':
			case 'address_line_2':
			case 'suburb':
			case 'city':
			case 'postcode':
			case 'citation':
			case 'value':
			case 'country_code':
			case 'area_code':
			case 'percentage':
			case 'min_quanity':
			case 'key':
			case 'min_quanity':
			case 'symbol_left':
			case 'symbol_right':
			case 'decimal_places':
			case 'thousand_seperator':
			case 'rate':				
			case 'iso_code':
		    	$ele = new XoopsFormElementTray('');
				$ele->addElement(new XoopsFormText('', 'filter_'.$field.'', 8, 40, $components['value']));
				$button = new XoopsFormButton('', 'button_'.$field.'', '[+]');
		    	$button->setExtra('onclick="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+$(\'#filter_'.$field.'\').val()'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	$ele->addElement($button);
		    	break;
			case 'cat_num':
				$components = array();
				$components['prefix'] = xshop_getFilterURLComponents($filter, 'prefix', $sort);
				$components['cat_number'] = xshop_getFilterURLComponents($components['prefix']['filter'], 'cat_number', $sort);
				$components['subfix'] = xshop_getFilterURLComponents($components['cat_number']['filter'], 'subfix', $sort);
		    	$ele = new XoopsFormElementTray('');
				$ele->addElement(new XoopsFormText('', 'filter_prefix', 1, 3, $components['prefix']['value']));
				$ele->addElement(new XoopsFormText('', 'filter_cat_number', 1, 10, $components['cat_number']['value']));
				$ele->addElement(new XoopsFormText('', 'filter_subfix', 1, 3, $components['subfix']['value']));
				$button = new XoopsFormButton('', 'button_'.$field.'', '[+]');
		    	$button->setExtra('onclick="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['subfix']['extra'].'&filter='.$components['subfix']['filter'].(!empty($components['subfix']['filter'])?'|':'').'prefix'.',\'+$(\'#filter_prefix\').val()'.(!empty($components['prefix']['operator'])?'+\','.$components['prefix']['operator'].'\'':'').'+\'|cat_number'.',\'+$(\'#filter_cat_number\').val()'.(!empty($components['cat_number']['operator'])?'+\','.$components['cat_number']['operator'].'\'':'').'+\'|subfix'.',\'+$(\'#filter_subfix\').val()'.(!empty($components['subfix']['operator'])?'+\','.$components['subfix']['operator'].'\'':'').',\'_self\')"');
		    	$ele->addElement($button);
		    	break;		    	
		}
		return $ele;
	}
}

if (!function_exists('xshop_getFilterComponents')) {
	function xshop_getFilterURLComponents($filter, $field, $sort='created') {
		$parts = explode('|', $filter);
		$ret = array();
		$value = '';
    	foreach($parts as $part) {
    		$var = explode(',', $part);
    		if (count($var)>1) {
	    		if ($var[0]==$field) {
	    			$ele_value = $var[1];
	    			if (isset($var[2]))
	    				$operator = $var[2];
	    		} elseif ($var[0]!=1) {
	    			$ret[] = implode(',', $var);
	    		}
    		}
    	}
    	$pagenav = array();
    	$pagenav['op'] = isset($_REQUEST['op'])?$_REQUEST['op']:"shops";
		$pagenav['fct'] = isset($_REQUEST['fct'])?$_REQUEST['fct']:"list";
		$pagenav['limit'] = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
		$pagenav['start'] = 0;
		$pagenav['order'] = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
		$pagenav['sort'] = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':$sort;
    	$retb = array();
		foreach($pagenav as $key=>$value) {
			$retb[] = "$key=$value";
		}
		return array('value'=>$ele_value, 'field'=>$field, 'operator'=>$operator, 'filter'=>implode('|', $ret), 'extra'=>implode('&', $retb));
	}
}
?>