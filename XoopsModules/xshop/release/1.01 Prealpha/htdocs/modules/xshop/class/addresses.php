<?php

 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopAddresses extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('address_id', XOBJ_DTYPE_INT);
        $this->initVar('manu_id', XOBJ_DTYPE_INT);
        $this->initVar('shop_id', XOBJ_DTYPE_INT);
        $this->initVar('order_id', XOBJ_DTYPE_INT);
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_ADDRESS_DELIEVERY', false, false, false, array('_SHOP_MI_ADDRESS_MANUFACTURE','_SHOP_MI_ADDRESS_SHOP','_SHOP_MI_ADDRESS_POSTAL','_SHOP_MI_ADDRESS_DELIEVERY','_SHOP_MI_ADDRESS_ORDERBY','_SHOP_MI_ADDRESS_SHOW','_SHOP_MI_ADDRESS_OTHER'));
        $this->initVar('remittion', XOBJ_DTYPE_ENUM, '_SHOP_MI_ADDRESS_NONE', false, false, false, array('_SHOP_MI_ADDRESS_RETURNEDGOODS','_SHOP_MI_ADDRESS_FRAUD','_SHOP_MI_ADDRESS_STOLENINMAIL','_SHOP_MI_ADDRESS_EXPRESSDELIEVERY','_SHOP_MI_ADDRESS_NONE'));
        $this->initVar('care_of', XOBJ_DTYPE_TXTBOX, '', 128);
        $this->initVar('address_line_1', XOBJ_DTYPE_TXTBOX, '', 128);
        $this->initVar('address_line_2', XOBJ_DTYPE_TXTBOX, '', 128);
        $this->initVar('suburb', XOBJ_DTYPE_TXTBOX, '', 128);
        $this->initVar('city', XOBJ_DTYPE_TXTBOX, '', 128);
        $this->initVar('region_id', XOBJ_DTYPE_INT);
        $this->initVar('country_id', XOBJ_DTYPE_INT);
        $this->initVar('postcode', XOBJ_DTYPE_TXTBOX, '', 15);
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, '', 32);
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

		if (defined('_PLUGIN'.$this->getVar('remittion'))) 
			$func = constant('_PLUGIN'.$this->getVar('remittion')).'PreInsert';
		
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

		if (defined('_PLUGIN'.$this->getVar('remittion'))) 
			$func = constant('_PLUGIN'.$this->getVar('remittion')).'PostInsert';
		
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

		if (defined('_PLUGIN'.$this->getVar('remittion'))) 
			$func = constant('_PLUGIN'.$this->getVar('remittion')).'PostGet';
		
		if (function_exists($func))  {
			@$func($this);
		}
		
		return true;
	}
}

class xshopAddressesHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopAddressesHandler($db, $type) {
	    parent::__construct($db, 'shop_addresses', 'xshopAddresses', 'address_id');
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
    	if ($object->vars['remittion']['changed']==true) {	
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