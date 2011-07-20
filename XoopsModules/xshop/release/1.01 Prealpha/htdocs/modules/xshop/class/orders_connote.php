<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopOrders_connote extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('con_note_id', XOBJ_DTYPE_INT);
        $this->initVar('assigned_uid', XOBJ_DTYPE_INT);
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_CONNOTE_STANDARD', false, false, false, array('_SHOP_MI_CONNOTE_EXPRESS','_SHOP_MI_CONNOTE_STANDARD','_SHOP_MI_CONNOTE_RETURNED','_SHOP_MI_CONNOTE_BYSEA','_SHOP_MI_CONNOTE_BYROAD','_SHOP_MI_CONNOTE_BYPLANE','_SHOP_MI_CONNOTE_BYTRAIN'));
        $this->initVar('shipping_id', XOBJ_DTYPE_INT);
        $this->initVar('address_id', XOBJ_DTYPE_INT);
        $this->initVar('contact_id', XOBJ_DTYPE_INT);
        $this->initVar('dispatched', XOBJ_DTYPE_INT);
        $this->initVar('returned', XOBJ_DTYPE_INT);
        $this->initVar('number', XOBJ_DTYPE_TXTBOX, false, 128);
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

class xshopOrders_connoteHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopOrders_connoteHandler($db, $type) {
	    parent::__construct($db, 'shop_orders_connotes', 'xshopOrders_connote', 'con_note_id');
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