<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopShipping extends XoopsObject 
{
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
}
?>