<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopOrders extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('order_id', XOBJ_DTYPE_INT, 0);
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
        $this->initVar('currency_id', XOBJ_DTYPE_INT);
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

    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array()) {
    	xoops_loadLanguage('forms', 'xshop');
    	    	
    	$addresses_handler =& xoops_getmodulehandler('addresses', 'xshop');
    	$contacts_handler =& xoops_getmodulehandler('contacts', 'xshop');

    	$billing_address = $addresses_handler->getItem($this->getVar('billing_address_id'), '_SHOP_MI_ADDRESS_ORDERBY');
    	$billing_contact = $contacts_handler->getItem($this->getVar('billing_contact_id'), '_SHOP_MI_CONTACTS_PHONE');
    	$billing_mobile = $contacts_handler->getItem($this->getVar('billing_mobile_id'), '_SHOP_MI_CONTACTS_MOBILE');
    	$billing_fax = $contacts_handler->getItem($this->getVar('billing_fax_id'), '_SHOP_MI_CONTACTS_FAX');
    	$billing_email = $contacts_handler->getItem($this->getVar('billing_email_id'), '_SHOP_MI_CONTACTS_EMAIL');

    	$shipping_address = $addresses_handler->getItem($this->getVar('shipping_address_id'), '_SHOP_MI_ADDRESS_DELIEVERY');
    	$shipping_contact = $contacts_handler->getItem($this->getVar('shipping_contact_id'), '_SHOP_MI_CONTACTS_PHONE');
    	$shipping_mobile = $contacts_handler->getItem($this->getVar('shipping_mobile_id'), '_SHOP_MI_CONTACTS_MOBILE');
    	$shipping_fax = $contacts_handler->getItem($this->getVar('shipping_fax_id'), '_SHOP_MI_CONTACTS_FAX');
    	$shipping_email = $contacts_handler->getItem($this->getVar('shipping_email_id'), '_SHOP_MI_CONTACTS_EMAIL');
    	
    	if (!empty($index))
    		$id = $index . '['. $this->getVar('order_id') . ']';
    	else 
    		$id = $this->getVar('order_id');
    	
    	if ($render = true||$captions==true) {
	    	$frmobj[$cursor]['mode'] = new XoopsFormSelectOrdersMode(_SHOP_FRM_ORDERS_MODE,  $id.'[mode]', $this->getVar('mode'));
	    	$frmobj[$cursor]['mode']->setDescription(_SHOP_FRM_ORDERS_MODE_DESC);
	    	$frmobj[$cursor]['remittion'] = new XoopsFormSelectOrdersRemittion(_SHOP_FRM_ORDERS_REMITTION,  $id.'[remittion]', $this->getVar('remittion'));
	    	$frmobj[$cursor]['remittion']->setDescription(_SHOP_FRM_ORDERS_REMITTION_DESC);
	    	$frmobj[$cursor]['total'] = new XoopsFormLabel(_SHOP_FRM_ORDERS_TOTAL,  $this->getTotal(false));
	    	$frmobj[$cursor]['total']->setDescription(_SHOP_FRM_ORDERS_TOTAL_DESC);
	    	$frmobj[$cursor]['tax'] = new XoopsFormLabel(_SHOP_FRM_ORDERS_TAX,  $this->getTax(false));
	    	$frmobj[$cursor]['tax']->setDescription(_SHOP_FRM_ORDERS_TAX_DESC);
	    	$frmobj[$cursor]['shipping'] = new XoopsFormLabel(_SHOP_FRM_ORDERS_SHIPPING,  $this->getShipping(false));
	    	$frmobj[$cursor]['shipping']->setDescription(_SHOP_FRM_ORDERS_SHIPPING_DESC);
	    	$frmobj[$cursor]['handling'] = new XoopsFormLabel(_SHOP_FRM_ORDERS_HANDLING,  $this->getHandling(false));
	    	$frmobj[$cursor]['handling']->setDescription(_SHOP_FRM_ORDERS_HANDLING_DESC);
	    	
	    	$frmobj = $billing_address->getForm($querystring, true, false, $id.'[billing_address]', 'billing_address', $frmobj);
	    	$frmobj = $billing_contact->getForm($querystring, true, false, $id.'[billing_contact]', 'billing_contact', $frmobj);
	    	$frmobj = $billing_mobile->getForm($querystring, true, false, $id.'[billing_mobile]', 'billing_mobile', $frmobj);
	    	$frmobj = $billing_fax->getForm($querystring, true, false, $id.'[billing_fax]', 'billing_fax', $frmobj);
	    	$frmobj = $billing_email->getForm($querystring, true, false, $id.'[billing_email]', 'billing_email', $frmobj);
	    	
	    	$frmobj[$cursor]['same_details'] = new XoopsFormRadioYN(_SHOP_FRM_ORDERS_SHIPPINGSAMEASBILLING, 'shipping_same', false);
	    	$frmobj[$cursor]['same_details']->setDescription(_SHOP_FRM_ORDERS_SHIPPINGSAMEASBILLING_DESC);

	    	$frmobj = $shipping_address->getForm($querystring, true, false, $id.'[shipping_address]', 'shipping_address', $frmobj);
	    	$frmobj = $shipping_contact->getForm($querystring, true, false, $id.'[shipping_contact]', 'shipping_contact', $frmobj);
	    	$frmobj = $shipping_mobile->getForm($querystring, true, false, $id.'[shipping_mobile]', 'shipping_mobile', $frmobj);
	    	$frmobj = $shipping_fax->getForm($querystring, true, false, $id.'[shipping_fax]', 'shipping_fax', $frmobj);
	    	$frmobj = $shipping_email->getForm($querystring, true, false, $id.'[shipping_email]', 'shipping_email', $frmobj);
	    	
	    	if (!empty($index))	
	    		$frmobj[$cursor]['order_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('order_id').']', 'orders');
	    	else 
	    		$frmobj[$cursor]['order_id'] = new XoopsFormHidden('id['.$this->getVar('order_id').']', 'orders');
	    	
	    	if ($render==false)
	    		return $frmobj;
	    		
	    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'orders');
    	} else {
	    	$frmobj[$cursor]['mode'] = new XoopsFormSelectOrdersMode('',  $id.'[mode]', $this->getVar('mode'));
	    	$frmobj[$cursor]['remittion'] = new XoopsFormSelectOrdersRemittion('',  $id.'[remittion]', $this->getVar('remittion'));
	    	$frmobj[$cursor]['total'] = new XoopsFormLabel('',  $this->getTotal(false));
	    	$frmobj[$cursor]['tax'] = new XoopsFormLabel('',  $this->getTax(false));
	    	$frmobj[$cursor]['shipping'] = new XoopsFormLabel('',  $this->getShipping(false));
	    	$frmobj[$cursor]['handling'] = new XoopsFormLabel('',  $this->getHandling(false));    	
	    	
	    	$frmobj = $billing_address->getForm($querystring, false, false, $id.'[billing_address]', 'billing_address', $frmobj);
	    	$frmobj = $billing_contact->getForm($querystring, false, false, $id.'[billing_contact]', 'billing_contact', $frmobj);
	    	$frmobj = $billing_mobile->getForm($querystring, false, false, $id.'[billing_mobile]', 'billing_mobile', $frmobj);
	    	$frmobj = $billing_fax->getForm($querystring, false, false, $id.'[billing_fax]', 'billing_fax', $frmobj);
	    	$frmobj = $billing_email->getForm($querystring, false, false, $id.'[billing_email]', 'billing_email', $frmobj);
	    	
	    	$frmobj[$cursor]['same_details'] = new XoopsFormRadioYN('', 'shipping_same', false);
	    	
	    	$frmobj = $shipping_address->getForm($querystring, false, false, $id.'[shipping_address]', 'shipping_address', $frmobj);
	    	$frmobj = $shipping_contact->getForm($querystring, false, false, $id.'[shipping_contact]', 'shipping_contact', $frmobj);
	    	$frmobj = $shipping_mobile->getForm($querystring, false, false, $id.'[shipping_mobile]', 'shipping_mobile', $frmobj);
	    	$frmobj = $shipping_fax->getForm($querystring, false, false, $id.'[shipping_fax]', 'shipping_fax', $frmobj);
	    	$frmobj = $shipping_email->getForm($querystring, false, false, $id.'[shipping_email]', 'shipping_email', $frmobj);	    	
	    	if (!empty($index))	
	    		$frmobj[$cursor]['order_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('order_id').']', 'orders');
	    	else 
	    		$frmobj[$cursor]['order_id'] = new XoopsFormHidden('id['.$this->getVar('order_id').']', 'orders');
	    	
    		return $frmobj;
    	}
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_ORDERS, 'orders', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_ORDERS, 'orders', $_SERVER['PHP_SELF'], 'post');
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