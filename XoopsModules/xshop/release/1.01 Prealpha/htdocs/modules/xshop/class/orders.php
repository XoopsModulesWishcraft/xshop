<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopOrders extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('order_id', XOBJ_DTYPE_INT);
        $this->initVar('mode', XOBJ_DTYPE_ENUM, '_SHOP_MI_ORDER_OPENORDER', false, false, false, array('_SHOP_MI_ORDER_OPENORDER','_SHOP_MI_ORDER_CLOSEDORDER','_SHOP_MI_ORDER_CHECKEDOUT','_SHOP_MI_ORDER_GONETOINVOICING','_SHOP_MI_ORDER_OTHER'));
        $this->initVar('remittion', XOBJ_DTYPE_ENUM, '_SHOP_MI_ORDER_UNPAID', false, false, false, array('_SHOP_MI_ORDER_PAID','_SHOP_MI_ORDER_UNPAID','_SHOP_MI_ORDER_CANCELLED','_SHOP_MI_ORDER_FRAUDPAID','_SHOP_MI_ORDER_FRAUDUNPAID','_SHOP_MI_ORDER_FRAUDCANCELLED'));
        $this->initVar('key', XOBJ_DTYPE_TXTBOX, '00000-00000-00000-00000-00000-00000', 64);
        $this->initVar('uid', XOBJ_DTYPE_INT);
        $this->initVar('broker_uids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('sales_uids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('cat_ids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('manu_ids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('shop_ids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('product_ids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('shipping_id', XOBJ_DTYPE_INT);
        $this->initVar('total', XOBJ_DTYPE_DECIMAL);
        $this->initVar('tax', XOBJ_DTYPE_DECIMAL);
        $this->initVar('shipping', XOBJ_DTYPE_DECIMAL);
        $this->initVar('handling', XOBJ_DTYPE_DECIMAL);
        $this->initVar('billing_address_id', XOBJ_DTYPE_INT);
        $this->initVar('shipping_address_id', XOBJ_DTYPE_INT);
        $this->initVar('billing_email_id', XOBJ_DTYPE_INT);
        $this->initVar('shipping_email_id', XOBJ_DTYPE_INT);
        $this->initVar('billing_contact_id', XOBJ_DTYPE_INT);
        $this->initVar('shipping_contact_id', XOBJ_DTYPE_INT);
        $this->initVar('billing_mobile_id', XOBJ_DTYPE_INT);
        $this->initVar('shipping_mobile_id', XOBJ_DTYPE_INT);
        $this->initVar('billing_fax_id', XOBJ_DTYPE_INT);
        $this->initVar('shipping_fax_id', XOBJ_DTYPE_INT);
        $this->initVar('discount_ids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('discount_avg_percentile', XOBJ_DTYPE_DECIMAL, 0);
        $this->initVar('discount_amount', XOBJ_DTYPE_DECIMAL);
        $this->initVar('started', XOBJ_DTYPE_INT);
        $this->initVar('paid', XOBJ_DTYPE_INT);
        $this->initVar('shipped', XOBJ_DTYPE_INT);
        $this->initVar('ended', XOBJ_DTYPE_INT);
        $this->initVar('offline', XOBJ_DTYPE_INT);
        $this->initVar('ip', XOBJ_DTYPE_TXTBOX, false, 128);
        $this->initVar('netbios', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('iid', XOBJ_DTYPE_INT);
        $this->initVar('invoice_url', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('pdf_url', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
        $this->initVar('actioned', XOBJ_DTYPE_INT);                
    }
    
    function runPreInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');

		if (defined('_PLUGIN'.$this->getVar('remittion'))) 
			$func = constant('_PLUGIN'.$this->getVar('remittion'));
		
		if (defined('_PLUGIN'.$this->getVar('mode'))) 
			$func .= constant('_PLUGIN'.$this->getVar('mode'));
			
		$func .= 'PreInsert';
		
		if (function_exists($func))  {
			@$func($this);
		}

		return true;
	}
	
    function runPostInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
		if (defined('_PLUGIN'.$this->getVar('remittion'))) 
			$func = constant('_PLUGIN'.$this->getVar('remittion'));
		
		if (defined('_PLUGIN'.$this->getVar('mode'))) 
			$func .= constant('_PLUGIN'.$this->getVar('mode'));
			
		$func .= 'PostInsert';
				
		if (function_exists($func))  {
			@$func($this);
		}
	
		return true;
	}
	
    function runPostGetPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
		if (defined('_PLUGIN'.$this->getVar('remittion'))) 
			$func = constant('_PLUGIN'.$this->getVar('remittion'));
		
		if (defined('_PLUGIN'.$this->getVar('mode'))) 
			$func .= constant('_PLUGIN'.$this->getVar('mode'));
			
		$func .= 'PostGet';
				
		if (function_exists($func))  {
			@$func($this);
		}
		
		return true;
	}
	
	function setKey() {
		srand((float)str_replace(' ', '', microtime()));
		$key = substr(md5(mt_rand(1, time())), mt_rand(0,25), 6);
		$key .= '-'. substr(md5(mt_rand(1, time())), mt_rand(0,25), 6);
		$key .= '-'. substr(md5(mt_rand(1, time())), mt_rand(0,25), 6);
		$key .= '-'. substr(md5(mt_rand(1, time())), mt_rand(0,25), 6);
		$key .= '-'. substr(md5(mt_rand(1, time())), mt_rand(0,25), 6);
		$key .= '-'. substr(md5(mt_rand(1, time())), mt_rand(0,25), 6);
		$this->setVar('key', $key);
		return $key;
	}
}

class xshopOrdersHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopOrdersHandler($db, $type) {
	    parent::__construct($db, 'shop_orders', 'xshopOrders', 'order_id');
    }   
    
    function insert($object, $force = true) {
    	
    	if ($object->isNew()) {
			if (is_object($GLOBALS['xoopsUser'])) {
				$object->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
			}
			
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){ 
				$object->setVar('ip',(string)$_SERVER["HTTP_X_FORWARDED_FOR"]);  
				$object->setVar('netbios',(string)@gethostbyaddr($object->getVar('ip')));
			}else{ 
				$object->setVar('ip',(string)$_SERVER["REMOTE_ADDR"]);  
				$object->setVar('netbios',(string)@gethostbyaddr($object->getVar('ip')));
			}
			 
			$object->setVar('offline', time()+$GLOBALS['xoopsModuleConfig']['offline']);
			$object->setKey();

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
    	if ($object->vars['mode']['changed']==true) {	
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