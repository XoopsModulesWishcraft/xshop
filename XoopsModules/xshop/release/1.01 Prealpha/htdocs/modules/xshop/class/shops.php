<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopShops extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('shop_id', XOBJ_DTYPE_INT);
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_SHOPS_PHYSICALSTORE', false, false, false, array('_SHOP_MI_SHOPS_PHYSICALSTORE','_SHOP_MI_SHOPS_DELIVERYRUN','_SHOP_MI_SHOPS_SERVICECENTER','_SHOP_MI_SHOPS_SERVICEWAREHOUSE','_SHOP_MI_SHOPS_SERVICE','_SHOP_MI_SHOPS_OTHER'));
        $this->initVar('owner_uid', XOBJ_DTYPE_INT);
        $this->initVar('admin_uids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('broker_uids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('sales_uid', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('shop_email_id', XOBJ_DTYPE_INT);
        $this->initVar('address_id', XOBJ_DTYPE_INT);
        $this->initVar('phone_id', XOBJ_DTYPE_INT);
        $this->initVar('mobile_id', XOBJ_DTYPE_INT);
        $this->initVar('fax_id', XOBJ_DTYPE_INT);
        $this->initVar('item_id', XOBJ_DTYPE_INT);
        $this->initVar('logo_picture_id', XOBJ_DTYPE_INT);
		$this->initVar('delievery_id', XOBJ_DTYPE_INT);
        $this->initVar('express_id', XOBJ_DTYPE_INT);
        $this->initVar('sms_id', XOBJ_DTYPE_INT);
        $this->initVar('serviced_id', XOBJ_DTYPE_INT);
        $this->initVar('days_id', XOBJ_DTYPE_INT);
        $this->initVar('start', XOBJ_DTYPE_INT);
        $this->initVar('end', XOBJ_DTYPE_INT);
        $this->initVar('opening', XOBJ_DTYPE_INT, 32400);
        $this->initVar('closed', XOBJ_DTYPE_INT, 68400);
        $this->initVar('sales_in_store', XOBJ_DTYPE_INT, 1);
        $this->initVar('sales_online', XOBJ_DTYPE_INT, 1);
        $this->initVar('sales_with_warehouse', XOBJ_DTYPE_INT, 0);
        $this->initVar('max_discount', XOBJ_DTYPE_DECIMAL);
        $this->initVar('special_product_id', XOBJ_DTYPE_INT);
        $this->initVar('special_cat_id', XOBJ_DTYPE_INT);
        $this->initVar('special_manu_id', XOBJ_DTYPE_INT);
        $this->initVar('timed', XOBJ_DTYPE_INT);
        $this->initVar('24hour_online', XOBJ_DTYPE_INT);
        $this->initVar('24hour_ordering', XOBJ_DTYPE_INT);
        $this->initVar('rating', XOBJ_DTYPE_DECIMAL);
        $this->initVar('votes', XOBJ_DTYPE_INT);        
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, false, 32);
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
        $this->initVar('actioned', XOBJ_DTYPE_INT);
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
}
?>