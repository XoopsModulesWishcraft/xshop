<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopManufactures extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('manu_id', XOBJ_DTYPE_INT);
        $this->initVar('ordering', XOBJ_DTYPE_ENUM, '_SHOP_MI_MANU_PLACESTOCKORDER', false, false, false, array('_SHOP_MI_MANU_PLACESTOCKORDER','_SHOP_MI_MANU_DONTPLACESTOCKORDER','_SHOP_MI_MANU_MANUALORDER','_SHOP_MI_MANU_RAISETOPURCHASEOFFICER','_SHOP_MI_MANU_APIORDERING'));
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_MANU_UNKNOWN', false, false, false, array('_SHOP_MI_MANU_LOCAL','_SHOP_MI_MANU_INTERSTATE','_SHOP_MI_MANU_OVERSEAS','_SHOP_MI_MANU_INTERNAL','_SHOP_MI_MANU_UNKNOWN'));
        $this->initVar('item_id', XOBJ_DTYPE_INT);
        $this->initVar('address_id', XOBJ_DTYPE_INT);
        $this->initVar('contact_id', XOBJ_DTYPE_INT);
        $this->initVar('mobile_id', XOBJ_DTYPE_INT);
        $this->initVar('email_id', XOBJ_DTYPE_INT);
        $this->initVar('last_order_id', XOBJ_DTYPE_INT);
        $this->initVar('logo_picture_id', XOBJ_DTYPE_INT);
        $this->initVar('rating', XOBJ_DTYPE_DECIMAL);
        $this->initVar('votes', XOBJ_DTYPE_INT);
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, '', 32);
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
}
?>