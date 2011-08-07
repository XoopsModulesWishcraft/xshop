<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopShipping extends XoopsObject 
{
	var $_objects = array();
	
    function __construct($type)
    {
        $this->initVar('shipping_id', XOBJ_DTYPE_INT);
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_SHIPPING_UNKNOWN', false, false, false, array('_SHOP_MI_SHIPPING_LOCAL','_SHOP_MI_SHIPPING_INTERSTATE','_SHOP_MI_SHIPPING_OVERSEAS','_SHOP_MI_SHIPPING_INTERNAL','_SHOP_MI_SHIPPING_BYSEA','_SHOP_MI_SHIPPING_BYROAD','_SHOP_MI_SHIPPING_BYTRAIN','_SHOP_MI_SHIPPING_BYPLANE','_SHOP_MI_SHIPPING_EXPRESS','_SHOP_MI_SHIPPING_UNKNOWN'));
        $this->initVar('method', XOBJ_DTYPE_ENUM, '_SHOP_MI_SHIPPING_MANUALPHONECALL', false, false, false, array('_SHOP_MI_SHIPPING_MANUALPHONECALL','_SHOP_MI_SHIPPING_EMAIL','_SHOP_MI_SHIPPING_APICALL','_SHOP_MI_SHIPPING_FAX','_SHOP_MI_SHIPPING_OTHER'));
        $this->initVar('uid', XOBJ_DTYPE_INT);
        $this->initVar('broker_uids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('item_id', XOBJ_DTYPE_INT);
        $this->initVar('address_id', XOBJ_DTYPE_INT);
        $this->initVar('contact_id', XOBJ_DTYPE_INT);
        $this->initVar('mobile_id', XOBJ_DTYPE_INT);
        $this->initVar('email_id', XOBJ_DTYPE_INT);
        $this->initVar('logo_picture_id', XOBJ_DTYPE_INT);
        $this->initVar('price_per_kilo', XOBJ_DTYPE_DECIMAL);
        $this->initVar('price_per_pound', XOBJ_DTYPE_DECIMAL);
        $this->initVar('price_per_other', XOBJ_DTYPE_DECIMAL);
        $this->initVar('country_ids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('handling_per_unit', XOBJ_DTYPE_DECIMAL);
        $this->initVar('region_ids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('opening', XOBJ_DTYPE_INT);
		$this->initVar('closing', XOBJ_DTYPE_INT);
        $this->initVar('days_id', XOBJ_DTYPE_INT);
        $this->initVar('rating', XOBJ_DTYPE_DECIMAL);
        $this->initVar('votes', XOBJ_DTYPE_INT);        
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, false, 32);
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
        $this->initVar('actioned', XOBJ_DTYPE_INT);
    }
    
	function toArray() {
    	$ret = parent::toArray();
    	$ret['when'] = get_when_associative($this);
    	$ret['users']['uid'] = get_users_id($this->getVar('uid'));
    	$ret['users']['broker'] = get_users_id($this->getVar('broker_uids'));
    	//$ret['item'] = get_item_id($this->getVar('item_id'));
    	$ret['address'] = get_address_id($this->getVar('address_id'));
    	$ret['contact'] = get_contact_id($this->getVar('contact_id'));
    	$ret['mobile'] = get_contact_id($this->getVar('mobile_id'));
    	$ret['email'] = get_contact_id($this->getVar('email_id'));
    	$ret['picture'] = get_picture_id($this->getVar('logo_picture_id'));
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

    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array(), $const = '_SHOP_MI_SHIPPING') {
        xoops_loadLanguage('forms', 'xshop');
    	        
		$addresses_handler =& xoops_getmodulehandler('addresses', 'xshop');
    	$contacts_handler =& xoops_getmodulehandler('contacts', 'xshop');
    	$items_digest_handler =& xoops_getmodulehandler('items_digest', 'xshop');
    	
    	$digest = $items_digest_handler->getItem($this->getVar('item_id'));
    	$address = $addresses_handler->getItem($this->getVar('address_id'), '_SHOP_MI_ADDRESS_POSTAL');
    	$contact = $contacts_handler->getItem($this->getVar('contact_id'), '_SHOP_MI_CONTACTS_PHONE');
    	$mobile = $contacts_handler->getItem($this->getVar('mobile_id'), '_SHOP_MI_CONTACTS_MOBILE');
    	$email = $contacts_handler->getItem($this->getVar('email_id'), '_SHOP_MI_CONTACTS_EMAIL');
    	
        if (!empty($index))
    		$id = $index . '['. $this->getVar('shipping_id') . ']';
    	else 
    		$id = $this->getVar('shipping_id');
    		
    	if ($render==true||$captions==true) {
    		if (defined($const)&&defined($const.'_LABEL')&&defined($const.'_LABEL_DESC')) {
		    	$frmobj[$cursor]['label'] = new XoopsFormLabel('<font style="font-size:1.25em;">'.constant($const).'</font>', '<font style="font-size:1.25em;">'.sprintf(constant($const.'_LABEL'), constant($const)).'</font>');
		    	$frmobj[$cursor]['label']->setDescription(constant($const.'_LABEL_DESC'));
     		}   	    	
	    	$frmobj[$cursor]['type'] = new XShopFormSelectShippingType(_SHOP_FRM_SHIPPING_TYPE, $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_SHIPPING_TYPE_DESC);
	    	$frmobj[$cursor]['method'] = new XShopFormSelectShippingType(_SHOP_FRM_SHIPPING_METHOD, $id.'[method]', $this->getVar('method'));
	    	$frmobj[$cursor]['method']->setDescription(_SHOP_FRM_SHIPPING_METHOD_DESC);
	    	$frmobj[$cursor]['broker_uids'] = new XShopFormSelectGroupedUser(_SHOP_FRM_SHIPPING_BROKERS, 'broker_uids', $this->getVar('broker_uids'), 6, true, $GLOBALS['xoopsModuleConfig']['broker']);
	    	$frmobj[$cursor]['broker_uids']->setDescription(_SHOP_FRM_SHIPPING_BROKERS_DESC);

	    	$frmobj = $digest->getForm($querystring, true, false, $id.'[item]', 'item', $frmobj);
	    	$frmobj = $address->getForm($querystring, true, false, $id.'[address]', 'address', $frmobj);
	    	$frmobj = $contact->getForm($querystring, true, false, $id.'[contact]', 'contact', $frmobj);
	    	$frmobj = $mobile->getForm($querystring, true, false, $id.'[mobile]', 'mobile', $frmobj);
	    	$frmobj = $email->getForm($querystring, true, false, $id.'[email]', 'email', $frmobj);
	    	
	    	$frmobj[$cursor]['price_per_kilo'] = new XoopsFormText(_SHOP_FRM_SHIPPING_PRICE_PER_KILO, $id.'[price_per_kilo]', 10, 25, $this->getVar('price_per_kilo'));
	    	$frmobj[$cursor]['price_per_kilo']->setDescription(_SHOP_FRM_SHIPPING_PRICE_PER_KILO_DESC);
	    	$frmobj[$cursor]['price_per_pound'] = new XoopsFormText(_SHOP_FRM_SHIPPING_PRICE_PER_POUND, $id.'[price_per_pound]', 10, 25, $this->getVar('price_per_pound'));
	    	$frmobj[$cursor]['price_per_pound']->setDescription(_SHOP_FRM_SHIPPING_PRICE_PER_POUND_DESC);
	    	$frmobj[$cursor]['price_per_other'] = new XoopsFormText(_SHOP_FRM_SHIPPING_PRICE_PER_OTHER, $id.'[price_per_other]', 10, 25, $this->getVar('price_per_other'));
	    	$frmobj[$cursor]['price_per_other']->setDescription(_SHOP_FRM_SHIPPING_PRICE_PER_OTHER_DESC);
	    	$frmobj[$cursor]['handling_per_unit'] = new XoopsFormText(_SHOP_FRM_SHIPPING_HANDLING_PER_UNIT, $id.'[handling_per_unit]', 10, 25, $this->getVar('handling_per_unit'));
	    	$frmobj[$cursor]['handling_per_unit']->setDescription(_SHOP_FRM_SHIPPING_HANDLING_PER_UNIT_DESC);
	    	$frmobj[$cursor]['country_ids'] = new XShopFormSelectCountry(_SHOP_FRM_SHIPPING_COUNTRIES, 'country_ids', $this->getVar('country_ids'), 6, true);
	    	$frmobj[$cursor]['country_ids']->setDescription(_SHOP_FRM_SHIPPING_COUNTRIES_DESC);
	    	$frmobj[$cursor]['region_ids'] = new XShopFormSelectRegion(_SHOP_FRM_SHIPPING_REGIONS, 'region_ids', $this->getVar('region_ids'), 6, true);
	    	$frmobj[$cursor]['region_ids']->setDescription(_SHOP_FRM_SHIPPING_SHIPPINGS_DESC);
	    	$frmobj[$cursor]['opening'] = new XShopFormSelectTime(_SHOP_FRM_SHIPPINGS_OPENING,  $id.'[opening]', $this->getVar('opening'));
	    	$frmobj[$cursor]['opening']->setDescription(_SHOP_FRM_SHIPPINGS_OPENING_DESC);
	    	$frmobj[$cursor]['closing'] = new XShopFormSelectTime(_SHOP_FRM_SHIPPINGS_CLOSING,  $id.'[closing]', $this->getVar('closing'));
	    	$frmobj[$cursor]['closing']->setDescription(_SHOP_FRM_SHIPPINGS_CLOSING_DESC);
	    	
	    	$days_handler = xoops_getmodulehandler('days', 'xshop');
	    	$days = $days_handler->getItem($this->getVar('days_id'));
	    	$frmobj[$cursor]['days_id'] = $days->getFormTray($querystring, true, $id.'[days]');
	    	$frmobj[$cursor]['days_id']->setDescription(_SHOP_FRM_SHIPPINGS_DAYS_DESC);  
	    	
	    	$frmobj[$cursor]['logo_picture_id'] = new XoopsFormFile(_SHOP_FRM_SHIPPING_UPLOAD_LOGO, $id.'[logo_picture_id]', $GLOBALS['xoopsModuleConfig']['max_file_size']);
	    	$frmobj[$cursor]['logo_picture_id']->setDescription(_SHOP_FRM_SHIPPING_UPLOAD_LOGO_DESC);
	    	
		    if (!empty($index))		    
	    		$frmobj[$cursor]['shipping_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('shipping_id').']', 'shipping');
	    	else 
	    		$frmobj[$cursor]['shipping_id'] = new XoopsFormHidden('id['.$this->getVar('shipping_id').']', 'shipping');
	    		
	    	if ($render==false)
	    		return $frmobj;
	    	
	    	if ($_REQUEST['fct']=='shipping') {
	    		$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    		$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'region');
	    	}
    	} else {
	    	
	    	$frmobj[$cursor]['type'] = new XShopFormSelectShippingType('', $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['method'] = new XShopFormSelectShippingType('', $id.'[method]', $this->getVar('method'));
	    	$frmobj[$cursor]['broker_uids'] = new XShopFormSelectGroupedUser('', 'broker_uids', $this->getVar('broker_uids'), 6, true, $GLOBALS['xoopsModuleConfig']['broker']);

	    	$frmobj = $digest->getForm($querystring, false, false, $id.'[item]', 'item', $frmobj);
	    	$frmobj = $address->getForm($querystring, false, false, $id.'[address]', 'address', $frmobj);
	    	$frmobj = $contact->getForm($querystring, false, false, $id.'[contact]', 'contact', $frmobj);
	    	$frmobj = $mobile->getForm($querystring, false, false, $id.'[mobile]', 'mobile', $frmobj);
	    	$frmobj = $email->getForm($querystring, false, false, $id.'[email]', 'email', $frmobj);
	    	
	    	$frmobj[$cursor]['price_per_kilo'] = new XoopsFormText('', $id.'[price_per_kilo]', 10, 25, $this->getVar('price_per_kilo'));
	    	$frmobj[$cursor]['price_per_pound'] = new XoopsFormText('', $id.'[price_per_pound]', 10, 25, $this->getVar('price_per_pound'));
	    	$frmobj[$cursor]['price_per_other'] = new XoopsFormText('', $id.'[price_per_other]', 10, 25, $this->getVar('price_per_other'));
	    	$frmobj[$cursor]['handling_per_unit'] = new XoopsFormText('', $id.'[handling_per_unit]', 10, 25, $this->getVar('handling_per_unit'));
	    	$frmobj[$cursor]['country_ids'] = new XShopFormSelectCountry('', 'country_ids', $this->getVar('country_ids'), 6, true);
	    	$frmobj[$cursor]['region_ids'] = new XShopFormSelectRegion('', 'region_ids', $this->getVar('region_ids'), 6, true);
	    	$frmobj[$cursor]['opening'] = new XShopFormSelectTime('',  $id.'[opening]', $this->getVar('opening'));
	    	$frmobj[$cursor]['closing'] = new XShopFormSelectTime('',  $id.'[closing]', $this->getVar('closing'));
	    	
	    	$days_handler = xoops_getmodulehandler('days', 'xshop');
	    	$days = $days_handler->getItem($this->getVar('days_id'));
	    	$frmobj[$cursor]['days_id'] = $days->getFormTray($querystring, true, $id.'[days]');
	    	
	    	$frmobj[$cursor]['logo_picture_id'] = new XoopsFormFile('', 'upload_gallery', $GLOBALS['xoopsModuleConfig']['max_file_size']);
	    	
	    	
		    if (!empty($index))		    
	    		$frmobj[$cursor]['shipping_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('shipping_id').']', 'shipping');
	    	else 
	    		$frmobj[$cursor]['shipping_id'] = new XoopsFormHidden('id['.$this->getVar('shipping_id').']', 'shipping');
	    		
	    			    	
	    	return $frmobj;
    	}
    	
    	$frmobj['submit']['submit'] = new XoopsFormButton('', _SUBMIT, 'submit', _SUBMIT);
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_SHIPPING, 'shipping', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_SHIPPING, 'shipping', $_SERVER['PHP_SELF'], 'post');
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

		if (defined('_PLUGIN'.$this->getVar('method'))) { 
			$func = constant('_PLUGIN'.$this->getVar('method')).'PreInsert';
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

		if (defined('_PLUGIN'.$this->getVar('method'))) {
			$func = constant('_PLUGIN'.$this->getVar('method')).'PostInsert';
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

    	if (defined('_PLUGIN'.$this->getVar('method'))) {
			$func = constant('_PLUGIN'.$this->getVar('method')).'PostGet';
			if (function_exists($func))  {
				@$func($this);
			}
		}
		return true;
	}
}

class xshopShippingHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopShippingHandler($db, $type) {
	    parent::__construct($db, 'shop_shipping', 'xshopShipping', 'shipping_id');
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
		if ($object->vars['method']['changed']==true) {	
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
}
?>