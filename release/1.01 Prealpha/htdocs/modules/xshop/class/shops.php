<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopShops extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('shop_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_SHOPS_PHYSICALSTORE', false, false, false, array('_SHOP_MI_SHOPS_PHYSICALSTORE','_SHOP_MI_SHOPS_DELIVERYRUN','_SHOP_MI_SHOPS_SERVICECENTER','_SHOP_MI_SHOPS_SERVICEWAREHOUSE','_SHOP_MI_SHOPS_SERVICE','_SHOP_MI_SHOPS_OTHER'));
        $this->initVar('uid', XOBJ_DTYPE_INT);
        $this->initVar('admin_uids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('broker_uids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('sales_uids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('email_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('address_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('phone_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('mobile_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('fax_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('item_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('logo_picture_id', XOBJ_DTYPE_INT, 0);
		$this->initVar('delievery_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('express_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('sms_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('serviced_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('days_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('timed', XOBJ_DTYPE_INT, 0);
        $this->initVar('start', XOBJ_DTYPE_INT, 0);
        $this->initVar('end', XOBJ_DTYPE_INT, 0);
        $this->initVar('opening', XOBJ_DTYPE_INT, 32400);
        $this->initVar('closed', XOBJ_DTYPE_INT, 68400);
        $this->initVar('sales_in_store', XOBJ_DTYPE_INT, 1);
        $this->initVar('sales_online', XOBJ_DTYPE_INT, 1);
        $this->initVar('sales_with_warehouse', XOBJ_DTYPE_INT, 0);
        $this->initVar('max_discount', XOBJ_DTYPE_DECIMAL);
        $this->initVar('special_product_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('special_cat_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('special_manu_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('24hour_online', XOBJ_DTYPE_INT, 0);
        $this->initVar('24hour_ordering', XOBJ_DTYPE_INT, 0);
        $this->initVar('rating', XOBJ_DTYPE_DECIMAL);
        $this->initVar('votes', XOBJ_DTYPE_INT, 0);        
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
    	$ret['users']['sales'] = get_users_id($this->getVar('sales_uids'));
    	$ret['item'] = get_item_id($this->getVar('item_id'));
    	$ret['address'] = get_address_id($this->getVar('address_id'));
    	$ret['contact'] = get_contact_id($this->getVar('contact_id'));
    	$ret['mobile'] = get_contact_id($this->getVar('mobile_id'));
    	$ret['email'] = get_contact_id($this->getVar('email_id'));
    	$ret['fax'] = get_contact_id($this->getVar('fax_id'));
    	$ret['picture'] = get_picture_id($this->getVar('logo_picture_id'));
    	$ret['rank'] = number_format($this->getVar('rating')/$this->getVar('votes')*100,2).'%';
    	$frms = $this->getForm($_SERVER['QUERY_STRING'], false, false, 'base', array());
    	foreach($frms as $key => $value) {
    		if ($key!='required') {
   	 			foreach($value as $field => $valueb) {
	    		    $ret['forms'][$key][$field] = $frms[$key][$field]->render();
    			}
    		}
    	}
    	return $ret;
    }    
    
    
	function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array()) {
        xoops_loadLanguage('forms', 'xshop');
    	        
		$addresses_handler =& xoops_getmodulehandler('addresses', 'xshop');
    	$contacts_handler =& xoops_getmodulehandler('contacts', 'xshop');
    	$items_digest_handler =& xoops_getmodulehandler('items_digest', 'xshop');
    	
    	$digest = $items_digest_handler->getItem($this->getVar('item_id'));
    	$address = $addresses_handler->getItem($this->getVar('address_id'), '_SHOP_MI_ADDRESS_POSTAL');
    	$contact = $contacts_handler->getItem($this->getVar('contact_id'), '_SHOP_MI_CONTACTS_PHONE');
    	$mobile = $contacts_handler->getItem($this->getVar('mobile_id'), '_SHOP_MI_CONTACTS_MOBILE');
    	$email = $contacts_handler->getItem($this->getVar('shop_email_id'), '_SHOP_MI_CONTACTS_EMAIL');
    	$fax = $contacts_handler->getItem($this->getVar('fax_id'), '_SHOP_MI_CONTACTS_FAX');
    	$delivery = $addresses_handler->getItem($this->getVar('delievery_id'), '_SHOP_MI_ADDRESS_DELIEVERY');
    	$sms = $contacts_handler->getItem($this->getVar('sms_id'), '_SHOP_MI_CONTACTS_MOBILE');
    	
        if (!empty($index))
    		$id = $index . '['. $this->getVar('shop_id') . ']';
    	else 
    		$id = $this->getVar('shop_id');
    		
    	if ($render==true||$captions==true) {
	    	
	    	$frmobj[$cursor]['type'] = new XoopsFormSelectShopType(_SHOP_FRM_SHOPS_TYPE, $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_SHOPS_TYPE_DESC);
	    	$frmobj[$cursor]['admin_uids'] = new XoopsFormSelectGroupedUser(_SHOP_FRM_SHOPS_ADMINS, 'admin_uids', $this->getVar('admin_uids'), 6, true, $GLOBALS['xoopsModuleConfig']['administrators']);
	    	$frmobj[$cursor]['admin_uids']->setDescription(_SHOP_FRM_SHOPS_ADMINS_DESC);
	    	$frmobj[$cursor]['broker_uids'] = new XoopsFormSelectGroupedUser(_SHOP_FRM_SHOPS_BROKERS, 'broker_uids', $this->getVar('broker_uids'), 6, true, $GLOBALS['xoopsModuleConfig']['brokers']);
	    	$frmobj[$cursor]['broker_uids']->setDescription(_SHOP_FRM_SHOPS_BROKERS_DESC);
	    	$frmobj[$cursor]['sales_uids'] = new XoopsFormSelectGroupedUser(_SHOP_FRM_SHOPS_SALES, 'sales_uids', $this->getVar('sales_uids'), 6, true, $GLOBALS['xoopsModuleConfig']['sales']);
	    	$frmobj[$cursor]['sales_uids']->setDescription(_SHOP_FRM_SHOPS_SALES_DESC);
	    	$frmobj[$cursor]['express_id'] = new XoopsFormSelectShipping(_SHOP_FRM_SHOPS_EXPRESS, 'express_id', $this->getVar('express_id'), 1, false, true);
	    	$frmobj[$cursor]['express_id']->setDescription(_SHOP_FRM_SHOPS_EXPRESS_DESC);
	    	
	    	$frmobj = $digest->getForm($querystring, true, false, $id.'[item]', 'item', $frmobj);
	    	$frmobj = $address->getForm($querystring, true, false, $id.'[address]', 'address', $frmobj);
	    	$frmobj = $contact->getForm($querystring, true, false, $id.'[contact]', 'contact', $frmobj);
	    	$frmobj = $mobile->getForm($querystring, true, false, $id.'[mobile]', 'mobile', $frmobj);
	    	$frmobj = $email->getForm($querystring, true, false, $id.'[email]', 'email', $frmobj);
	    	$frmobj = $fax->getForm($querystring, true, false, $id.'[fax]', 'fax', $frmobj);
	    	$frmobj = $delivery->getForm($querystring, true, false, $id.'[delivery]', 'delivery', $frmobj);
	    	$frmobj = $sms->getForm($querystring, true, false, $id.'[sms]', 'sms', $frmobj);

	    	$days_handler = xoops_getmodulehandler('days', 'xshop');
	    	$days = $days_handler->getItem($this->getVar('days_id'));
	    	$frmobj[$cursor]['days_id'] = $days->getFormTray($querystring, true, $id.'[days]');
	    	$frmobj[$cursor]['days_id']->setDescription(_SHOP_FRM_SHOPSS_DAYS_DESC);  
	
	    	$frmobj[$cursor]['timed'] = new XoopsFormRadioYN(_SHOP_FRM_SHOPS_TIMED,  $id.'[timed]', $this->getVar('timed'));
	    	$frmobj[$cursor]['timed']->setDescription(_SHOP_FRM_SHOPS_TIMED_DESC);
	    	$frmobj[$cursor]['start'] = new XoopsFormTextDateSelect(_SHOP_FRM_SHOPS_START,  $id.'[start]', 15, $this->getVar('start'));
	    	$frmobj[$cursor]['start']->setDescription(_SHOP_FRM_SHOPS_START_DESC);
	    	$frmobj[$cursor]['end'] = new XoopsFormTextDateSelect(_SHOP_FRM_SHOPS_END,  $id.'[end]', 15, $this->getVar('end'));
	    	$frmobj[$cursor]['end']->setDescription(_SHOP_FRM_SHOPS_END_DESC);
	    	$frmobj[$cursor]['opening'] = new XoopsFormSelectTime(_SHOP_FRM_SHOPSS_OPENING,  $id.'[opening]', $this->getVar('opening'));
	    	$frmobj[$cursor]['opening']->setDescription(_SHOP_FRM_SHOPSS_OPENING_DESC);
	    	$frmobj[$cursor]['closing'] = new XoopsFormSelectTime(_SHOP_FRM_SHOPSS_CLOSING,  $id.'[closing]', $this->getVar('closing'));
	    	$frmobj[$cursor]['closing']->setDescription(_SHOP_FRM_SHOPSS_CLOSING_DESC);
	
	    	$frmobj[$cursor]['sales_in_store'] = new XoopsFormRadioYN(_SHOP_FRM_SHOPS_SALES_IN_STORE,  $id.'[sales_in_store]', $this->getVar('sales_in_store'));
	    	$frmobj[$cursor]['sales_in_store']->setDescription(_SHOP_FRM_SHOPS_SALES_IN_STORE_DESC);
	    	$frmobj[$cursor]['sales_online'] = new XoopsFormRadioYN(_SHOP_FRM_SHOPS_SALES_ONLINE,  $id.'[sales_online]', $this->getVar('sales_online'));
	    	$frmobj[$cursor]['sales_online']->setDescription(_SHOP_FRM_SHOPS_SALES_ONLINE_DESC);
	    	$frmobj[$cursor]['sales_with_warehouse'] = new XoopsFormRadioYN(_SHOP_FRM_SHOPS_SALES_WITH_WAREHOUSE,  $id.'[sales_with_warehouse]', $this->getVar('sales_with_warehouse'));
	    	$frmobj[$cursor]['sales_with_warehouse']->setDescription(_SHOP_FRM_SHOPS_SALES_WITH_WAREHOUSE_DESC);
	    	$frmobj[$cursor]['24hour_online'] = new XoopsFormRadioYN(_SHOP_FRM_SHOPS_24HOURS_ONLINE,  $id.'[24hour_online]', $this->getVar('24hour_online'));
	    	$frmobj[$cursor]['24hour_online']->setDescription(_SHOP_FRM_SHOPS_24HOURS_ONLINE_DESC);	    		    		    	
	    	$frmobj[$cursor]['24hour_ordering'] = new XoopsFormRadioYN(_SHOP_FRM_SHOPS_24HOUR_ORDERING,  $id.'[24hour_ordering]', $this->getVar('24hour_ordering'));
	    	$frmobj[$cursor]['24hour_ordering']->setDescription(_SHOP_FRM_SHOPS_24HOUR_ORDERING_DESC);	    		    		    	
	    	
	    	$frmobj[$cursor]['max_discount'] = new XoopsFormText(_SHOP_FRM_SHOPS_MAX_DISCOUNT, $id.'[max_discount]', 10, 25, $this->getVar('max_discount'));
	    	$frmobj[$cursor]['max_discount']->setDescription(_SHOP_FRM_SHOPS_MAX_DISCOUNT_DESC);
	    	
	    	$frmobj[$cursor]['special_product_id'] = new XoopsFormSelectProduct(_SHOP_FRM_SHOPS_FEATURED_PRODUCT, $id.'[special_product_id]', $this->getVar('special_product_id'), 1, false, true);
	    	$frmobj[$cursor]['special_product_id']->setDescription(_SHOP_FRM_SHOPS_FEATURED_PRODUCT_DESC);
	    	$frmobj[$cursor]['special_cat_id'] = new XoopsFormSelectCategory(_SHOP_FRM_SHOPS_FEATURED_CATEGORY, $id.'[special_cat_id]', $this->getVar('special_cat_id'), 1, false, true);
	    	$frmobj[$cursor]['special_cat_id']->setDescription(_SHOP_FRM_SHOPS_FEATURED_CATEGORY_DESC);
	    	$frmobj[$cursor]['special_manu_id'] = new XoopsFormSelectManufactures(_SHOP_FRM_SHOPS_FEATURED_MANUFACTURE, $id.'[special_manu_id]', $this->getVar('special_manu_id'), 1, false, true);
	    	$frmobj[$cursor]['special_manu_id']->setDescription(_SHOP_FRM_SHOPS_FEATURED_MANUFACTURE_DESC);    	
	    	
	    	$frmobj[$cursor]['logo_picture_id'] = new XoopsFormFile(_SHOP_FRM_SHOPS_UPLOAD_LOGO, $id.'[logo_picture_id]', $GLOBALS['xoopsModuleConfig']['max_file_size']);
	    	$frmobj[$cursor]['logo_picture_id']->setDescription(_SHOP_FRM_SHOPS_UPLOAD_LOGO_DESC);
	    	
		    if (!empty($index))		    
	    		$frmobj[$cursor]['shop_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('shop_id').']', 'shops');
	    	else 
	    		$frmobj[$cursor]['shop_id'] = new XoopsFormHidden('id['.$this->getVar('shop_id').']', 'shops');
	    		
	    	if ($render==false)
	    		return $frmobj;
	    		
	    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'region');
    	} else {
	    	
	    	$frmobj[$cursor]['type'] = new XoopsFormSelectShopType('', $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['admin_uids'] = new XoopsFormSelectGroupedUser('', 'admin_uids', $this->getVar('admin_uids'), 6, true, $GLOBALS['xoopsModuleConfig']['administrators']);
	    	$frmobj[$cursor]['broker_uids'] = new XoopsFormSelectGroupedUser('', 'broker_uids', $this->getVar('broker_uids'), 6, true, $GLOBALS['xoopsModuleConfig']['brokers']);
	    	$frmobj[$cursor]['sales_uids'] = new XoopsFormSelectGroupedUser('', 'sales_uids', $this->getVar('sales_uids'), 6, true, $GLOBALS['xoopsModuleConfig']['sales']);
	    	$frmobj[$cursor]['express_id'] = new XoopsFormSelectShipping('', 'express_id', $this->getVar('express_id'), 1, false, true);
	    		    	
	    	$frmobj = $digest->getForm($querystring, false, false, $id.'[item]', 'item', $frmobj);
	    	$frmobj = $address->getForm($querystring, false, false, $id.'[address]', 'address', $frmobj);
	    	$frmobj = $contact->getForm($querystring, false, false, $id.'[contact]', 'contact', $frmobj);
	    	$frmobj = $mobile->getForm($querystring, false, false, $id.'[mobile]', 'mobile', $frmobj);
	    	$frmobj = $email->getForm($querystring, false, false, $id.'[email]', 'email', $frmobj);
	    	$frmobj = $fax->getForm($querystring, false, false, $id.'[fax]', 'fax', $frmobj);
	    	$frmobj = $delivery->getForm($querystring, false, false, $id.'[delivery]', 'delivery', $frmobj);
	    	$frmobj = $sms->getForm($querystring, false, false, $id.'[sms]', 'sms', $frmobj);

	    	$days_handler = xoops_getmodulehandler('days', 'xshop');
	    	$days = $days_handler->getItem($this->getVar('days_id'));
	    	$frmobj[$cursor]['days_id'] = $days->getFormTray($querystring, true, $id.'[days]');
	    	
	    	$frmobj[$cursor]['timed'] = new XoopsFormRadioYN('',  $id.'[timed]', $this->getVar('timed'));
	    	$frmobj[$cursor]['start'] = new XoopsFormTextDateSelect('',  $id.'[start]', 15, $this->getVar('start'));
	    	$frmobj[$cursor]['end'] = new XoopsFormTextDateSelect('',  $id.'[end]', 15, $this->getVar('end'));
	    	$frmobj[$cursor]['opening'] = new XoopsFormSelectTime('',  $id.'[opening]', $this->getVar('opening'));
	    	$frmobj[$cursor]['closing'] = new XoopsFormSelectTime('',  $id.'[closing]', $this->getVar('closing'));
	    	$frmobj[$cursor]['sales_in_store'] = new XoopsFormRadioYN('',  $id.'[sales_in_store]', $this->getVar('sales_in_store'));
	    	$frmobj[$cursor]['sales_online'] = new XoopsFormRadioYN('',  $id.'[sales_online]', $this->getVar('sales_online'));
	    	$frmobj[$cursor]['sales_with_warehouse'] = new XoopsFormRadioYN('',  $id.'[sales_with_warehouse]', $this->getVar('sales_with_warehouse'));
	    	$frmobj[$cursor]['24hour_online'] = new XoopsFormRadioYN('',  $id.'[24hour_online]', $this->getVar('24hour_online'));
	    	$frmobj[$cursor]['24hour_ordering'] = new XoopsFormRadioYN('',  $id.'[24hour_ordering]', $this->getVar('24hour_ordering'));
	    	$frmobj[$cursor]['max_discount'] = new XoopsFormText('', $id.'[max_discount]', 10, 25, $this->getVar('max_discount'));
	    	$frmobj[$cursor]['special_product_id'] = new XoopsFormSelectProduct('', $id.'[special_product_id]', $this->getVar('special_product_id'), 1, false, true);
	    	$frmobj[$cursor]['special_cat_id'] = new XoopsFormSelectCategory('', $id.'[special_cat_id]', $this->getVar('special_cat_id'), 1, false, true);
	    	$frmobj[$cursor]['special_manu_id'] = new XoopsFormSelectManufactures('', $id.'[special_manu_id]', $this->getVar('special_manu_id'), 1, false, true);
	    	$frmobj[$cursor]['logo_picture_id'] = new XoopsFormFile('', $id.'[logo_picture_id]', $GLOBALS['xoopsModuleConfig']['max_file_size']);
	    	
	    	
		    if (!empty($index))		    
	    		$frmobj[$cursor]['shop_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('shop_id').']', 'shops');
	    	else 
	    		$frmobj[$cursor]['shop_id'] = new XoopsFormHidden('id['.$this->getVar('shop_id').']', 'shops');	    		
	    			    	
	    	return $frmobj;
    	}
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_SHOPS, 'shops', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_SHOPS, 'shops', $_SERVER['PHP_SELF'], 'post');
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
		
		if (defined('_PLUGIN'.$this->getVar('type'))) 
			$func = constant('_PLUGIN'.$this->getVar('type')).'PreInsert';
		
		if (function_exists($func))  {
			@$func($this);
		}

		return true;
	}
	
    function runPostInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
		if (defined('_PLUGIN'.$this->getVar('type'))) 
			$func = constant('_PLUGIN'.$this->getVar('type')).'PostInsert';
		
		if (function_exists($func))  {
			@$func($this);
		}
	
		return true;
	}
	
    function runPostGetPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
		if (defined('_PLUGIN'.$this->getVar('type'))) 
			$func = constant('_PLUGIN'.$this->getVar('type')).'PostGet';
		
		if (function_exists($func))  {
			@$func($this);
		}
		
		return true;
	}
}

class xshopShopsHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopShopsHandler($db, $type) {
	    parent::__construct($db, 'shop_shops', 'xshopShops', 'shop_id');
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
}
?>