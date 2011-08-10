<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopManufactures extends XoopsObject 
{
    function __construct()
    {
        $this->initVar('manu_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('ordering', XOBJ_DTYPE_ENUM, '_SHOP_MI_MANU_PLACESTOCKORDER', false, false, false, array('_SHOP_MI_MANU_PLACESTOCKORDER','_SHOP_MI_MANU_DONTPLACESTOCKORDER','_SHOP_MI_MANU_MANUALORDER','_SHOP_MI_MANU_RAISETOPURCHASEOFFICER','_SHOP_MI_MANU_APIORDERING'));
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_MANU_UNKNOWN', false, false, false, array('_SHOP_MI_MANU_LOCAL','_SHOP_MI_MANU_INTERSTATE','_SHOP_MI_MANU_OVERSEAS','_SHOP_MI_MANU_INTERNAL','_SHOP_MI_MANU_UNKNOWN'));
        $this->initVar('item_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('address_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('contact_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('mobile_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('email_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('last_order_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('logo_manu_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('rating', XOBJ_DTYPE_DECIMAL, 0);
        $this->initVar('votes', XOBJ_DTYPE_INT, 0);
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, '', 32);
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
        $this->initVar('actioned', XOBJ_DTYPE_INT);
        
    }
    
    function toArray() {
    	$ret = parent::toArray();
    	$ret['when'] = get_when_associative($this);
    	$ret['item'] = get_item_id($this->getVar('item_id'));
    	//$ret['users']['broker'] = get_users_id($this->getVar('item_id'));
    	$ret['address'] = get_address_id($this->getVar('address_id'));
    	$ret['last_order'] = get_order_id($this->getVar('last_order_id'));
    	$ret['contact'] = get_contact_id($this->getVar('contact_id'));
    	$ret['mobile'] = get_contact_id($this->getVar('mobile_id'));
    	$ret['email'] = get_contact_id($this->getVar('email_id'));
    	$ret['picture'] = get_picture_id($this->getVar('logo_manu_id'));
    	$ret['rank'] = number_format($this->getVar('rating')/$this->getVar('votes')*100,2).'%';
    	$frms = $this->getForm($_SERVER['QUERY_STRING'], false, false, '', 'base', array());
    	foreach($frms as $key => $value) {
    		if ($key!='required') {
   	 			foreach($value as $field => $valueb) {
	    		    $ret['forms'][$key][$field] = $frms[$key][$field]->render();
    			}
    		}
    	}
    	foreach($ret as $key => $value) {
    		if (is_array($value)) {
    			foreach($value as $keyb => $valueb) {
    				if (is_array($valueb)) {
    					foreach($valueb as $keyc => $valuec) {
    						$ret[$key.'_'.$keyb.'_'.$keyc] = $valuec;
    						unset($ret[$key][$keyb][$keyc]);
    					}
    				} else {
    					$ret[$key.'_'.$keyb] = $valueb;
    					unset($ret[$key][$keyb]);
    				}
    			}
    			unset($ret[$key]);
    		} else {
    			if (defined($value)) {
    				$ret[$key] = ucfirst(constant($value));
    			}
    		}
    	}
    	
    	
    	return $ret;
    }
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array(), $const = '_SHOP_MI_MANUFACTURE') {
    
    	xoops_loadLanguage('forms', 'xshop');
    	    	
    	$addresses_handler =& xoops_getmodulehandler('addresses', 'xshop');
    	$contacts_handler =& xoops_getmodulehandler('contacts', 'xshop');
    	$items_digest_handler =& xoops_getmodulehandler('items_digest', 'xshop');
    	
    	$digest = $items_digest_handler->getItem($this->getVar('item_id'));
    	$address = $addresses_handler->getItem($this->getVar('address_id'), '_SHOP_MI_ADDRESS_MANUFACTURE');
    	$contact = $contacts_handler->getItem($this->getVar('contact_id'), '_SHOP_MI_CONTACTS_PHONE');
    	$mobile = $contacts_handler->getItem($this->getVar('mobile_id'), '_SHOP_MI_CONTACTS_MOBILE');
    	$email = $contacts_handler->getItem($this->getVar('email_id'), '_SHOP_MI_CONTACTS_EMAIL');
    	
    	if (!empty($index))
    		$id = $index . '['. $this->getVar('manu_id') . ']';
    	else 
    		$id = $this->getVar('manu_id');
    	
    	if ($render == true||$captions==true) {
    		if (defined($const)&&defined($const.'_LABEL')&&defined($const.'_LABEL_DESC')) {
		    	$frmobj[$cursor]['label'] = new XoopsFormLabel('<font style="font-size:1.25em;">'.constant($const).'</font>', '<font style="font-size:1.25em;">'.sprintf(constant($const.'_LABEL'), constant($const)).'</font>');
		    	$frmobj[$cursor]['label']->setDescription(constant($const.'_LABEL_DESC'));
     		}   	    	
	    	$frmobj[$cursor]['ordering'] = new XShopFormSelectManufacturesOrdering(_SHOP_FRM_MANUFACTURES_ORDERING,  $id.'[ordering]', $this->getVar('ordering'));
	    	$frmobj[$cursor]['ordering']->setDescription(_SHOP_FRM_MANUFACTURES_ORDERING_DESC);
	    	$frmobj[$cursor]['type'] = new XShopFormSelectManufacturesType(_SHOP_FRM_MANUFACTURES_TYPE,  $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_MANUFACTURES_TYPE_DESC);
	    	$frmobj = $digest->getForm($querystring, true, false, $id.'[item]', 'item', $frmobj);
	    	$frmobj = $address->getForm($querystring, true, false, $id.'[address]', 'address', $frmobj);
	    	$frmobj = $contact->getForm($querystring, true, false, $id.'[contact]', 'contact', $frmobj);
	    	$frmobj = $mobile->getForm($querystring, true, false, $id.'[mobile]', 'mobile', $frmobj);
	    	$frmobj = $email->getForm($querystring, true, false, $id.'[email]', 'email', $frmobj);
	    	$frmobj[$cursor]['logo_manu_id'] = new XoopsFormFile(_SHOP_FRM_MANUFACTURES_UPLOAD_LOGO, str_replace(']', '', str_replace('[', '_', $id.'[upload]')), $GLOBALS['xoopsModuleConfig']['max_file_size']);
	    	$frmobj[$cursor]['logo_manu_id']->setDescription(_SHOP_FRM_MANUFACTURES_UPLOAD_LOGO_DESC);
	    	
	    	if (!empty($index))	
	    		$frmobj[$cursor]['manu_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('manu_id').']', 'manufactures');
	    	else 
	    		$frmobj[$cursor]['manu_id'] = new XoopsFormHidden('id['.$this->getVar('manu_id').']', 'manufactures');
	    	
	    	if ($render==false)
	    		return $frmobj;
	    	
	    	if ($_REQUEST['fct']=='manufactures') {
	    		$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    		$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'manufactures');
	    	}
    	} else {
    		
	    	$frmobj[$cursor]['ordering'] = new XShopFormSelectManufacturesOrdering('',  $id.'[ordering]', $this->getVar('ordering'));
	    	$frmobj[$cursor]['type'] = new XShopFormSelectManufacturesType('',  $id.'[type]', $this->getVar('type'));
	    	$frmobj = $digest->getForm($querystring, false, false, $id.'[item]', 'item', $frmobj);
	    	$frmobj = $address->getForm($querystring, false, false, $id.'[address]', 'address',$frmobj);
	    	$frmobj = $contact->getForm($querystring, false, false, $id.'[contact]', 'contact', $frmobj);
	    	$frmobj = $mobile->getForm($querystring, false, false, $id.'[mobile]', 'mobile', $frmobj);
	    	$frmobj = $email->getForm($querystring, false, false, $id.'[email]', 'email', $frmobj);
	    	$frmobj[$cursor]['logo_manu_id'] = new XoopsFormFile('', str_replace(']', '', str_replace('[', '_', $id.'[upload]')), $GLOBALS['xoopsModuleConfig']['max_file_size']);
	    	
	    	if (!empty($index))	
	    		$frmobj[$cursor]['manu_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('manu_id').']', 'manufactures');
	    	else 
	    		$frmobj[$cursor]['manu_id'] = new XoopsFormHidden('id['.$this->getVar('manu_id').']', 'manufactures');
	    	
    		return $frmobj;
    	}
    	
    	$frmobj['submit']['submit'] = new XoopsFormButton('', _SUBMIT, 'submit', _SUBMIT);
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_MANUFACTURES, 'manufactures', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_MANUFACTURES, 'manufactures', $_SERVER['PHP_SELF'], 'post');
    	}
    	
    	foreach($frmobj as $key => $value) {
    		if ($key!='required') {
   	 			foreach($value as $field => $valueb) {
		    		if (!in_array($field, $frmobj['required'])) {
		    			$form->addElement($frmobj[$key][$field], false);
		    		} else {
		    			$form->addElement($frmobj[$key][$field], true);
		    		}
    			}
    		}
    	}
    	
    	return $form->render();
    }
        
	function runPreInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
		if (defined('_PLUGIN'.$this->getVar('type'))) { 
			$func = constant('_PLUGIN'.$this->getVar('type')).'PreInsert';
			if (function_exists($func))  {
				@$func($this);
			}
		}
		if (defined('_PLUGIN'.$this->getVar('ordering'))) { 
			$func = constant('_PLUGIN'.$this->getVar('ordering')).'PreInsert';
			if (function_exists($func))  {
				@$func($this);
			}
		}
		
		return true;
	}
	
    function runPostInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
    	if (defined('_PLUGIN'.$this->getVar('type'))) { 
			$func = constant('_PLUGIN'.$this->getVar('type')).'PostInsert';
			if (function_exists($func))  {
				@$func($this);
			}
		}
		
		if (defined('_PLUGIN'.$this->getVar('ordering'))) { 
			$func = constant('_PLUGIN'.$this->getVar('ordering')).'PostInsert';
			if (function_exists($func))  {
				@$func($this);
			}
		}	
		return true;
	}
	
    function runPostGetPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
    	if (defined('_PLUGIN'.$this->getVar('type'))) { 
			$func = constant('_PLUGIN'.$this->getVar('type')).'PostGet';
			if (function_exists($func))  {
				@$func($this);
			}
		}
		
		if (defined('_PLUGIN'.$this->getVar('ordering'))) { 
			$func = constant('_PLUGIN'.$this->getVar('ordering')).'PostGet';
			if (function_exists($func))  {
				@$func($this);
			}
		}	
				
		return true;
	}
}

class xshopManufacturesHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopManufacturesHandler($db, $type) {
	    parent::__construct($db, 'shop_manufacturer', 'xshopManufactures', 'manu_id');
    }

    function insert($object, $force = true) {
    	
    	if ($object->isNew()) {
    		$object->setVar('created', time());
    		$criteria = new Criteria('md5', xshop_md5calc($object));
    		if (parent::getCount($criteria)) {
    			foreach(parent::getObjects($criteria, true) as $id => $item)	   			
    				return $id; 
    		}
			$object->setVar('md5', xshop_md5calc($object));    		
    	} else {
    		$object->setVar('updated', time());		
    		$object->setVar('md5', xshop_md5calc($object));
    	}
    	
    	$run_plugin = false;
    	if ($object->vars['type']['changed']==true) {	
			$object->setVar('actioned', time());
			$run_plugin = true;
		}
		if ($object->vars['ordering']['changed']==true) {	
			$object->setVar('actioned', time());
			$run_plugin = true;
		}
		
		if ($run_plugin == true) {
			@$object->runPreInsertPlugin();
			$id = parent::insert($object, $force);
			$object = parent::get($id);
			@$object->runPostInsertPlugin();
			return $id;
		} else {
			return parent::insert($object, $force);
		}
    }
    
	function get($id=0, $fields='*') {
    	$obj = parent::get($id, $fields);
    	@$obj->runPostGetPlugin();
    	return $obj;
    }
    
    function getObject($criteria, $id_as_key=false, $object=true) {
    	$objs = parent::getObjects($criteria, $id_as_key=false, $object=true);
    	foreach($objs as $key => $obj) {
    		@$objs[$key]->runPostGetPlugin();
    	}
    	return $objs;
    }
    
    function getFilterCriteria($filter) {
    	$parts = explode('|', $filter);
    	$criteria = new CriteriaCompo();
    	foreach($parts as $part) {
    		$var = explode(',', $part);
    		if (!empty($var[1])&&!is_numeric($var[0])) {
    			$object = $this->create();
    			if (		$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTBOX || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTAREA) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%'.$var[1].'%', (isset($var[2])?$var[2]:'LIKE')));
    			} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_INT || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_DECIMAL || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_FLOAT ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));			
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ENUM ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));    				
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ARRAY ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%"'.$var[1].'";%', (isset($var[2])?$var[2]:'LIKE')));    				
				}
    		} elseif (!empty($var[1])&&is_numeric($var[0])) {
    			$criteria->add(new Criteria("'".$var[0]."'", $var[1]));
    		}
    	}
    	return $criteria;
    }
        
	function getFilterForm($filter, $field, $sort='created', $fct = '') {
    	$ele = xshop_getFilterElement($filter, $field, $sort, $fct);
    	if (is_object($ele))
    		return $ele->render();
    	else 
    		return '&nbsp;';
    }
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array(), $id=0) {
    	if ($id==0) {
    		$object = $this->create();
    	} else { 
    		$object = $this->get($id);
    	}
    	return $object->getForm($querystring, $captions, $render, $index, $cursor, $frmobj);
    }    
    
    function getIn($cat_id=0, $shop_id=0, $manu_id=0, $product_id=0) {
    	$products_handler = xoops_getmodulehandler('products', 'xshop');
    	$criteria = new CriteriaCompo();
        if($cat_id!=0&&!is_array($cat_id)) {
    		$criteria->add(new Criteria('cat_id', $cat_id));
    	} elseif (is_array($cat_id)) {
    		$criteria->add(new Criteria('cat_id', '('.implode(',',$cat_id).')', 'IN'));
    	}
    	if($shop_id!=0&&!is_array($shop_id)) {
    		$criteria->add(new Criteria('shop_id', $shop_id));
    	} elseif (is_array($shop_id)) {
    		$criteria->add(new Criteria('shop_id', '('.implode(',',$shop_id).')', 'IN'));
    	}
    	if($manu_id!=0&&!is_array($manu_id)) {
    		$criteria->add(new Criteria('manu_id', $manu_id));
    	} elseif (is_array($manu_id)) {
    		$criteria->add(new Criteria('manu_id', '('.implode(',',$manu_id).')', 'IN'));
    	}
    	if($product_id!=0&&!is_array($product_id)) {
    		$criteria->add(new Criteria('product_id', $product_id));
    	} elseif (is_array($product_id)) {
    		$criteria->add(new Criteria('product_id', '('.implode(',',$product_id).')', 'IN'));
    	}
    	$ret = array();
    	foreach($products_handler->getObjects($criteria, true) as $key => $object) {
    		$ret[$object->getVar('manu_id')] = $object->getVar('manu_id');
    	}
    	return $ret;
    }
}
?>