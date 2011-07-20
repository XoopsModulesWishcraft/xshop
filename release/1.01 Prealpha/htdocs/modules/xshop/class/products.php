<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopProducts extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('product_id', XOBJ_DTYPE_INT);
        $this->initVar('stock', XOBJ_DTYPE_ENUM, '_SHOP_MI_PRODUCTS_INSTOCK', false, false, false, array('_SHOP_MI_PRODUCTS_INSTOCK','_SHOP_MI_PRODUCTS_OUTSTOCK','_SHOP_MI_PRODUCTS_NOREORDER','_SHOP_MI_PRODUCTS_QUITSTOCK','_SHOP_MI_PRODUCTS_SUPLUSSTOCK'));
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_PRODUCTS_TANGIABLEITEM', false, false, false, array('_SHOP_MI_PRODUCTS_SERVICE','_SHOP_MI_PRODUCTS_TANGIABLEITEM','_SHOP_MI_PRODUCTS_SERVICEANDITEM'));
        $this->initVar('uid', XOBJ_DTYPE_INT);
		$this->initVar('sales_uid', XOBJ_DTYPE_INT);
		$this->initVar('broker_uid', XOBJ_DTYPE_INT);
        $this->initVar('shop_id', XOBJ_DTYPE_INT);
        $this->initVar('cat_id', XOBJ_DTYPE_INT);
        $this->initVar('manu_id', XOBJ_DTYPE_INT);
        $this->initVar('item_id', XOBJ_DTYPE_INT);
        $this->initVar('currency_id', XOBJ_DTYPE_INT);
        $this->initVar('shipping_id', XOBJ_DTYPE_INT);
        $this->initVar('feature_picture_id', XOBJ_DTYPE_INT);
        $this->initVar('discount_id', XOBJ_DTYPE_INT);
        $this->initVar('wholesale_discount_id', XOBJ_DTYPE_INT);
        $this->initVar('cat_number', XOBJ_DTYPE_TXTBOX, false, 25);
        $this->initVar('sub_model', XOBJ_DTYPE_TXTBOX, false, 35);
        $this->initVar('cat_prefix', XOBJ_DTYPE_TXTBOX, false, 3);
        $this->initVar('cat_subfix', XOBJ_DTYPE_TXTBOX, false, 3);
        $this->initVar('unit_price', XOBJ_DTYPE_DECIMAL);
        $this->initVar('unit_wholesale_price', XOBJ_DTYPE_DECIMAL);
        $this->initVar('weight_per_unit', XOBJ_DTYPE_DECIMAL);
		$this->initVar('weight_measurement', XOBJ_DTYPE_ENUM, '_SHOP_MI_WEIGHT_KILOS', false, false, false, array('_SHOP_MI_WEIGHT_KILOS', '_SHOP_MI_WEIGHT_POUNDS'));
        $this->initVar('quanity_in_unit', XOBJ_DTYPE_DECIMAL);
        $this->initVar('quanity_for_wholesale', XOBJ_DTYPE_DECIMAL);
        $this->initVar('quanity_measured', XOBJ_DTYPE_TXTBOX, false, 10);
        $this->initVar('quanity_in_warehouse', XOBJ_DTYPE_INT);
        $this->initVar('quanity_to_order', XOBJ_DTYPE_INT);
        $this->initVar('tag', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('rating', XOBJ_DTYPE_DECIMAL);
        $this->initVar('votes', XOBJ_DTYPE_INT);
        $this->initVar('last_ordered', XOBJ_DTYPE_INT);
        $this->initVar('shippment_arrived', XOBJ_DTYPE_INT);
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

		if (defined('_PLUGIN'.$this->getVar('stock'))) { 
			$func = constant('_PLUGIN'.$this->getVar('stock')).'PreInsert';
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

		if (defined('_PLUGIN'.$this->getVar('stock'))) {
			$func = constant('_PLUGIN'.$this->getVar('stock')).'PostInsert';
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

    	if (defined('_PLUGIN'.$this->getVar('stock'))) {
			$func = constant('_PLUGIN'.$this->getVar('stock')).'PostGet';
			if (function_exists($func))  {
				@$func($this);
			}
		}
		return true;
	}
}

class xshopProductsHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopProductsHandler($db, $type) {
	    parent::__construct($db, 'shop_products', 'xshopProducts', 'product_id');
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
		if ($object->vars['stock']['changed']==true) {	
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