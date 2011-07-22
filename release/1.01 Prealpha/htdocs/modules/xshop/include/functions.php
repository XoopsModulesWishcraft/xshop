<?php

function get_users_id($mixed) {
	$handler = xoops_gethandler('user');
	if (empty($mixed)||$mixed=0) {
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

function get_item_id($mixed) {
	$handler = xoops_getmodulehandler('items', 'xshop');
	if (empty($mixed)||$mixed=0) {
		return '';
	} elseif (is_numeric($mixed)) {
		$obj = $handler->get($mixed);
		if (is_object($obj)) {
			$digest = $obj->retrieveDigest($GLOBALS['xoopsConfig']['language']);
			return $digest->toArray(); 
		} else {
			return '';
		}
	} elseif (is_array($mixed)) {
		$ret = array();
		foreach($mixed as $id) {
			$obj = $handler->get($id);
			if (is_object($obj)) {
				$digest = $obj->retrieveDigest($GLOBALS['xoopsConfig']['language']);
				$ret[$id] = $digest->toArray(); 
			}
		}
		return $ret;
	}
}

function get_address_id($mixed) {
	$handler = xoops_getmodulehandler('addresses', 'xshop');
	if (empty($mixed)||$mixed=0) {
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

function get_contact_id($mixed) {
	$handler = xoops_getmodulehandler('contacts', 'xshop');
	if (empty($mixed)||$mixed=0) {
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

function get_picture_id($mixed) {
	$handler = xoops_getmodulehandler('gallery', 'xshop');
	if (empty($mixed)||$mixed=0) {
		return '';
	} elseif (is_numeric($mixed)) {
		$obj = $handler->get($mixed);
		if (is_object($obj)) {
			$ret = array();
			$ret['html']['thumbnail'] = "<img src='".XOOPS_UPLOAD_URL.$obj->getVar('thumbnail_path').$obj->getVar('filename').'" />';
			$ret['html']['orginal'] = "<img src='".XOOPS_UPLOAD_URL.$obj->getVar('path').$obj->getVar('filename')."' />";
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

function get_cat_id($mixed) {
	$handler = xoops_getmodulehandler('category', 'xshop');
	if (empty($mixed)||$mixed=0) {
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

function get_manufacture_id($mixed) {
	$handler = xoops_getmodulehandler('manufactures', 'xshop');
	if (empty($mixed)||$mixed=0) {
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

function get_shipping_id($mixed) {
	$handler = xoops_getmodulehandler('shipping', 'xshop');
	if (empty($mixed)||$mixed=0) {
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

function get_currency_id($mixed) {
	$handler = xoops_getmodulehandler('currency', 'xshop');
	if (empty($mixed)||$mixed=0) {
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

function get_discount_id($mixed) {
	$handler = xoops_getmodulehandler('discounts', 'xshop');
	if (empty($mixed)||$mixed=0) {
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

function get_product_id($mixed) {
	$handler = xoops_getmodulehandler('products', 'xshop');
	if (empty($mixed)||$mixed=0) {
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

function get_order_id($mixed) {
	$handler = xoops_getmodulehandler('orders', 'xshop');
	if (empty($mixed)||$mixed=0) {
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

function get_shop_id($mixed) {
	$handler = xoops_getmodulehandler('shops', 'xshop');
	if (empty($mixed)||$mixed=0) {
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

function filter_querystring($string, $element) {
	foreach(explode('&', $string) as $component) {
		$value = explode('=', $component);
		if (strtolower($value[0])!=strtolower($element))
			$ret[] = $component;
	}
	return implode('&', $ret);
}

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
?>