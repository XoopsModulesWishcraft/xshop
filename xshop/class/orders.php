<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopOrders extends XoopsObject 
{
	var $_objects = array();
	
    function __construct()
    {
        $this->initVar('order_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('mode', XOBJ_DTYPE_ENUM, '_SHOP_MI_ORDER_OPENORDER', false, false, false, array('_SHOP_MI_ORDER_OPENORDER','_SHOP_MI_ORDER_CLOSEDORDER','_SHOP_MI_ORDER_CHECKEDOUT','_SHOP_MI_ORDER_GONETOINVOICING','_SHOP_MI_ORDER_OTHER'));
        $this->initVar('remittion', XOBJ_DTYPE_ENUM, '_SHOP_MI_ORDER_UNPAID', false, false, false, array('_SHOP_MI_ORDER_PAID','_SHOP_MI_ORDER_UNPAID','_SHOP_MI_ORDER_CANCELLED','_SHOP_MI_ORDER_FRAUDPAID','_SHOP_MI_ORDER_FRAUDUNPAID','_SHOP_MI_ORDER_FRAUDCANCELLED'));
        $this->initVar('key', XOBJ_DTYPE_TXTBOX, '00000-00000-00000-00000-00000-00000', false, 64);
        $this->initVar('user_key', XOBJ_DTYPE_TXTBOX, md5(NULL), false, 32);
        $this->initVar('uid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('broker_uids', XOBJ_DTYPE_ARRAY, array(), false);
        $this->initVar('sales_uids', XOBJ_DTYPE_ARRAY, array(), false);
        $this->initVar('cat_ids', XOBJ_DTYPE_ARRAY, array(), false);
        $this->initVar('manu_ids', XOBJ_DTYPE_ARRAY, array(), false);
        $this->initVar('shop_ids', XOBJ_DTYPE_ARRAY, array(), false);
        $this->initVar('product_ids', XOBJ_DTYPE_ARRAY, array(), false);
        $this->initVar('shipping_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('currency_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('total', XOBJ_DTYPE_DECIMAL, 0, false);
        $this->initVar('tax', XOBJ_DTYPE_DECIMAL, 0, false);
        $this->initVar('shipping', XOBJ_DTYPE_DECIMAL, 0, false);
        $this->initVar('handling', XOBJ_DTYPE_DECIMAL, 0, false);
        $this->initVar('billing_address_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('shipping_address_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('billing_email_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('shipping_email_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('billing_contact_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('shipping_contact_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('billing_mobile_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('shipping_mobile_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('billing_fax_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('shipping_fax_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('discount_ids', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('discount_avg_percentile', XOBJ_DTYPE_DECIMAL, 0, false);
        $this->initVar('discount_amount', XOBJ_DTYPE_DECIMAL, 0, false);
        $this->initVar('started', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('paid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('shipped', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('ended', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('offline', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('ip', XOBJ_DTYPE_TXTBOX, false, false, 128);
        $this->initVar('netbios', XOBJ_DTYPE_TXTBOX, false, false, 255);
        $this->initVar('iid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('invoice_url', XOBJ_DTYPE_TXTBOX, false, false, 255);
        $this->initVar('pdf_url', XOBJ_DTYPE_TXTBOX, false, false, 255);
        $this->initVar('user_ipdb_country_code', XOBJ_DTYPE_TXTBOX, null, false, 3);
		$this->initVar('user_ipdb_country_name', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('user_ipdb_region_name', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('user_ipdb_city_name', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('user_ipdb_postcode', XOBJ_DTYPE_TXTBOX, null, false, 15);
		$this->initVar('user_ipdb_latitude', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('user_ipdb_longitude', XOBJ_DTYPE_DECIMAL, null, false);
		$this->initVar('user_ipdb_time_zone', XOBJ_DTYPE_TXTBOX, null, false, 6);
		$this->initVar('fraud_ipdb_errors', XOBJ_DTYPE_TXTBOX, null, false, 1000);
		$this->initVar('fraud_ipdb_warnings', XOBJ_DTYPE_TXTBOX, null, false, 1000);
		$this->initVar('fraud_ipdb_messages', XOBJ_DTYPE_TXTBOX, null, false, 1000);
		$this->initVar('fraud_ipdb_districtcity', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('fraud_ipdb_ipcountrycode', XOBJ_DTYPE_TXTBOX, null, false, 3);
		$this->initVar('fraud_ipdb_ipcountry', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('fraud_ipdb_ipregioncode', XOBJ_DTYPE_TXTBOX, null, false, 3);
		$this->initVar('fraud_ipdb_ipregion', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('fraud_ipdb_ipcity', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('fraud_ipdb_score', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('fraud_ipdb_accuracyscore', XOBJ_DTYPE_INT, 0, false);
		$this->initVar('fraud_ipdb_scoredetails', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('created', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('updated', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('actioned', XOBJ_DTYPE_INT, 0, false);    
		
    }
    
    function getGrandTotal(){
    	return ($this->getVar('total')+$this->getVar('tax')+$this->getVar('shipping')+$this->getVar('handling')-$this->getVar('discount_amount'));
    }
   
    function toArray() {
    	$ret = parent::toArray();
    	$orders_digest = xoops_getmodulehandler('orders_digest', 'xshop');
    	$ret['items'] = $orders_digest->getCount(new Criteria('order_id', $this->getVar('order_id')));
    	$ret['when'] = get_when_associative($this);
    	$ret['user']['assigned'] = get_users_id($this->getVar('uid'));
    	$ret['user']['broker'] = get_users_id($this->getVar('broker_uids'));
    	$ret['user']['sales'] = get_users_id($this->getVar('sales_uids'));
    	$ret['shipping'] = get_shipping_id($this->getVar('shipping_id'));
    	$ret['currency'] = get_currency_id($this->getVar('currency_id'));
    	$ret['address']['shipping'] = get_address_id($this->getVar('shipping_address_id'));
    	$ret['contact']['shipping'] = get_contact_id($this->getVar('shipping_contact_id'));
    	$ret['mobile']['shipping'] = get_contact_id($this->getVar('shipping_mobile_id'));
    	$ret['email']['shipping'] = get_contact_id($this->getVar('shipping_email_id'));
    	$ret['fax']['shipping'] = get_contact_id($this->getVar('shipping_fax_id'));
    	$ret['address']['billing'] = get_address_id($this->getVar('billing_address_id'));
    	$ret['contact']['billing'] = get_contact_id($this->getVar('billing_contact_id'));
    	$ret['mobile']['billing'] = get_contact_id($this->getVar('billing_mobile_id'));
    	$ret['email']['billing'] = get_contact_id($this->getVar('billing_email_id'));
    	$ret['fax']['billing'] = get_contact_id($this->getVar('billing_fax_id'));
    	$ret['money']['shipping'] = get_money_format($this->getVar('currency_id'), $this->getVar('shipping'));
    	$ret['money']['handling'] = get_money_format($this->getVar('currency_id'), $this->getVar('handling'));
    	$ret['money']['tax'] = get_money_format($this->getVar('currency_id'), $this->getVar('tax'));
    	$ret['money']['discount'] = get_money_format($this->getVar('currency_id'), $this->getVar('discount_amount'));
    	$ret['money']['total'] = get_money_format($this->getVar('currency_id'), $this->getVar('total'));
    	$ret['money']['grand'] = get_money_format($this->getVar('currency_id'), $this->getGrandTotal());
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
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = '', $const = '_SHOP_MI_ORDERS') {
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
    	
    	if ($render == true||$captions==true) {
    		if (defined($const)&&defined($const.'_LABEL')&&defined($const.'_LABEL_DESC')) {
		    	$frmobj[$cursor]['label'] = new XoopsFormLabel('<font style="font-size:1.25em;">'.constant($const).'</font>', '<font style="font-size:1.25em;">'.sprintf(constant($const.'_LABEL'), constant($const)).'</font>');
		    	$frmobj[$cursor]['label']->setDescription(constant($const.'_LABEL_DESC'));
     		}   
     		if (is_object($GLOBALS['xoopsUser'])) {
     			if (is_object($GLOBALS['xoopsUser']->isAdmin())) {
		    		$frmobj[$cursor]['mode'] = new XShopFormSelectOrdersMode(_SHOP_FRM_ORDERS_MODE,  $id.'[mode]', $this->getVar('mode'));
			    	$frmobj[$cursor]['mode']->setDescription(_SHOP_FRM_ORDERS_MODE_DESC);
			    	$frmobj[$cursor]['remittion'] = new XShopFormSelectOrdersRemittion(_SHOP_FRM_ORDERS_REMITTION,  $id.'[remittion]', $this->getVar('remittion'));
			    	$frmobj[$cursor]['remittion']->setDescription(_SHOP_FRM_ORDERS_REMITTION_DESC);
     			} else {
     				$frmobj[$cursor]['mode'] = new XoopsFormHidden($id.'[mode]', $this->getVar('mode'));
			    	$frmobj[$cursor]['remittion'] = new XoopsFormHidden($id.'[remittion]', $this->getVar('remittion'));
			    }
     		} else {
     			$frmobj[$cursor]['mode'] = new XoopsFormHidden($id.'[mode]', $this->getVar('mode'));
		    	$frmobj[$cursor]['remittion'] = new XoopsFormHidden($id.'[remittion]', $this->getVar('remittion'));
		    }
		  	$frmobj[$cursor]['total'] = new XoopsFormLabel(_SHOP_FRM_ORDERS_TOTAL,  get_money_format($this->getVar('currency_id'),$this->getVar('total')));
	    	$frmobj[$cursor]['total']->setDescription(_SHOP_FRM_ORDERS_TOTAL_DESC);
	    	$frmobj[$cursor]['tax'] = new XoopsFormLabel(_SHOP_FRM_ORDERS_TAX,  get_money_format($this->getVar('currency_id'),$this->getVar('tax')));
	    	$frmobj[$cursor]['tax']->setDescription(_SHOP_FRM_ORDERS_TAX_DESC);
	    	$frmobj[$cursor]['shipping'] = new XoopsFormLabel(_SHOP_FRM_ORDERS_SHIPPING,  get_money_format($this->getVar('currency_id'),$this->getVar('shipping')));
	    	$frmobj[$cursor]['shipping']->setDescription(_SHOP_FRM_ORDERS_SHIPPING_DESC);
	    	$frmobj[$cursor]['handling'] = new XoopsFormLabel(_SHOP_FRM_ORDERS_HANDLING,  get_money_format($this->getVar('currency_id'),$this->getVar('handling')));
	    	$frmobj[$cursor]['handling']->setDescription(_SHOP_FRM_ORDERS_HANDLING_DESC);
	    	$frmobj[$cursor]['discount'] = new XoopsFormLabel(_SHOP_FRM_ORDERS_DISCOUNT,  get_money_format($this->getVar('currency_id'),$this->getVar('discount_amount')));
	    	$frmobj[$cursor]['discount']->setDescription(_SHOP_FRM_ORDERS_DISCOUNT_DESC);
		  	$frmobj[$cursor]['grand'] = new XoopsFormLabel(_SHOP_FRM_ORDERS_GRAND,  get_money_format($this->getVar('currency_id'),$this->getGrandTotal(false)));
	    	$frmobj[$cursor]['grand']->setDescription(_SHOP_FRM_ORDERS_GRAND_DESC);
	    	
	    	$frmobj = $billing_address->getForm($querystring, true, false, $id.'[billing_address]', 'billing_address', $frmobj, '_SHOP_MI_ADDRESS_ORDERBY');
	    	$frmobj = $billing_contact->getForm($querystring, true, false, $id.'[billing_contact]', 'billing_contact', $frmobj, '_SHOP_MI_CONTACTS_OTHER');
	    	$frmobj = $billing_mobile->getForm($querystring, true, false, $id.'[billing_mobile]', 'billing_mobile', $frmobj, '_SHOP_MI_CONTACTS_MOBILE');
	    	$frmobj = $billing_fax->getForm($querystring, true, false, $id.'[billing_fax]', 'billing_fax', $frmobj, '_SHOP_MI_CONTACTS_FAX');
	    	$frmobj = $billing_email->getForm($querystring, true, false, $id.'[billing_email]', 'billing_email', $frmobj, '_SHOP_MI_CONTACTS_EMAIL');
	    	
	    	//$frmobj[$cursor]['same_details'] = new XoopsFormRadioYN(_SHOP_FRM_ORDERS_SHIPPINGSAMEASBILLING, 'shipping_same', false);
	    	//$frmobj[$cursor]['same_details']->setDescription(_SHOP_FRM_ORDERS_SHIPPINGSAMEASBILLING_DESC);

	    	$frmobj = $shipping_address->getForm($querystring, true, false, $id.'[shipping_address]', 'shipping_address', $frmobj, '_SHOP_MI_ADDRESS_DELIEVERY');
	    	$frmobj = $shipping_contact->getForm($querystring, true, false, $id.'[shipping_contact]', 'shipping_contact', $frmobj, '_SHOP_MI_CONTACTS_OTHER');
	    	$frmobj = $shipping_mobile->getForm($querystring, true, false, $id.'[shipping_mobile]', 'shipping_mobile', $frmobj, '_SHOP_MI_CONTACTS_MOBILE');
	    	$frmobj = $shipping_fax->getForm($querystring, true, false, $id.'[shipping_fax]', 'shipping_fax', $frmobj, '_SHOP_MI_CONTACTS_FAX');
	    	$frmobj = $shipping_email->getForm($querystring, true, false, $id.'[shipping_email]', 'shipping_email', $frmobj, '_SHOP_MI_CONTACTS_EMAIL');
	    	
	    	if (!empty($index))	
	    		$frmobj[$cursor]['order_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('order_id').']', 'orders');
	    	else 
	    		$frmobj[$cursor]['order_id'] = new XoopsFormHidden('id['.$this->getVar('order_id').']', 'orders');
	    	
	    	if ($render==false)
	    		return $frmobj;

	    	if ($_REQUEST['fct']=='orders') {
	    		$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    		$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'orders');
	    	}
    	} else {
    		if (is_object($GLOBALS['xoopsUser'])) {
     			if (is_object($GLOBALS['xoopsUser']->isAdmin())) {
		    		$frmobj[$cursor]['mode'] = new XShopFormSelectOrdersMode('',  $id.'[mode]', $this->getVar('mode'));
			    	$frmobj[$cursor]['remittion'] = new XShopFormSelectOrdersRemittion('',  $id.'[remittion]', $this->getVar('remittion'));
     			} else {
     				$frmobj[$cursor]['mode'] = new XoopsFormLabel('', constant($this->getVar('mode')));
		    		$frmobj[$cursor]['remittion'] = new XoopsFormLabel('', constant($this->getVar('remittion')));
			    }
     		} else {
     			$frmobj[$cursor]['mode'] = new XoopsFormLabel('', constant($this->getVar('mode')));
		    	$frmobj[$cursor]['remittion'] = new XoopsFormLabel('', constant($this->getVar('remittion')));
		    }
		    $frmobj[$cursor]['total'] = new XoopsFormLabel('',  get_money_format($this->getVar('currency_id'),$this->getVar('total')));
	    	$frmobj[$cursor]['tax'] = new XoopsFormLabel('',  get_money_format($this->getVar('currency_id'),$this->getVar('tax')));
	    	$frmobj[$cursor]['shipping'] = new XoopsFormLabel('',  get_money_format($this->getVar('currency_id'),$this->getVar('shipping')));
	    	$frmobj[$cursor]['handling'] = new XoopsFormLabel('',  get_money_format($this->getVar('currency_id'),$this->getVar('handling')));
	    	$frmobj[$cursor]['discount'] = new XoopsFormLabel('',  get_money_format($this->getVar('currency_id'),$this->getVar('discount_amount')));
		  	$frmobj[$cursor]['grand'] = new XoopsFormLabel('',  get_money_format($this->getVar('currency_id'),$this->getGrandTotal(false)));
    	
	    	$frmobj = $billing_address->getForm($querystring, false, false, $id.'[billing_address]', 'billing_address', $frmobj, '_SHOP_MI_ADDRESS_ORDERBY');
	    	$frmobj = $billing_contact->getForm($querystring, false, false, $id.'[billing_contact]', 'billing_contact', $frmobj, '_SHOP_MI_CONTACTS_OTHER');
	    	$frmobj = $billing_mobile->getForm($querystring, false, false, $id.'[billing_mobile]', 'billing_mobile', $frmobj, '_SHOP_MI_CONTACTS_MOBILE');
	    	$frmobj = $billing_fax->getForm($querystring, false, false, $id.'[billing_fax]', 'billing_fax', $frmobj, '_SHOP_MI_CONTACTS_FAX');
	    	$frmobj = $billing_email->getForm($querystring, false, false, $id.'[billing_email]', 'billing_email', $frmobj, '_SHOP_MI_CONTACTS_EMAIL');
	    	
	    	//$frmobj[$cursor]['same_details'] = new XoopsFormRadioYN(_SHOP_FRM_ORDERS_SHIPPINGSAMEASBILLING, 'shipping_same', false);
	    	//$frmobj[$cursor]['same_details']->setDescription(_SHOP_FRM_ORDERS_SHIPPINGSAMEASBILLING_DESC);

	    	$frmobj = $shipping_address->getForm($querystring, false, false, $id.'[shipping_address]', 'shipping_address', $frmobj, '_SHOP_MI_ADDRESS_DELIEVERY');
	    	$frmobj = $shipping_contact->getForm($querystring, false, false, $id.'[shipping_contact]', 'shipping_contact', $frmobj, '_SHOP_MI_CONTACTS_OTHER');
	    	$frmobj = $shipping_mobile->getForm($querystring, false, false, $id.'[shipping_mobile]', 'shipping_mobile', $frmobj, '_SHOP_MI_CONTACTS_MOBILE');
	    	$frmobj = $shipping_fax->getForm($querystring, false, false, $id.'[shipping_fax]', 'shipping_fax', $frmobj, '_SHOP_MI_CONTACTS_FAX');
	    	$frmobj = $shipping_email->getForm($querystring, false, false, $id.'[shipping_email]', 'shipping_email', $frmobj, '_SHOP_MI_CONTACTS_EMAIL');

	    	if (!empty($index))	
	    		$frmobj[$cursor]['order_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('order_id').']', 'orders');
	    	else 
	    		$frmobj[$cursor]['order_id'] = new XoopsFormHidden('id['.$this->getVar('order_id').']', 'orders');
	    	
    		return $frmobj;
    	}
    	
    	$frmobj['submit']['submit'] = new XoopsFormButton('', _SUBMIT, 'submit', _SUBMIT);
    	
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
		$key = date('ymd');
		$key .= '-'. date('his');
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
    	
        if ($object->vars['ip']['changed']==true) {	
    		if (strlen($GLOBALS['xoopsModuleConfig']['ipdb_apikey'])>0) {
    			set_time_limit(120);
    			include_once($GLOBALS['xoops']->path('/modules/xshop/class/ip2locationlite.class.php'));
	    		$ipLite = new ip2location_lite;
				$ipLite->setKey($GLOBALS['xoopsModuleConfig']['ipdb_apikey']);
	 			//Get errors and locations
				$locations = $ipLite->getCity($object->getVar('ip'));
	    		$object->setVar('user_ipdb_country_code', strtoupper($locations['countryCode']));
	    		$object->setVar('user_ipdb_country_name', ucfirst($locations['countryName']));
	    		$object->setVar('user_ipdb_region_name', ucfirst($locations['regionName']));
	    		$object->setVar('user_ipdb_city_name', ucfirst($locations['cityName']));
	    		$object->setVar('user_ipdb_postcode', $locations['zipCode']);
	    		$object->setVar('user_ipdb_latitude', $locations['latitude']);
	    		$object->setVar('user_ipdb_longitude', $locations['longitude']);
	    		$object->setVar('user_ipdb_time_zone', $locations['timeZone']);
	    		try {
		    		$mail = explode('@', $object->getVar('drawto_email'));
		    		$fraud = fraudQuery($object->getVar('ip'), $GLOBALS['xoopsModuleConfig']['countrycode'], $GLOBALS['xoopsModuleConfig']['district'], $GLOBALS['xoopsModuleConfig']['city'], '', $mail[1], $GLOBALS['xoopsModuleConfig']['ipdb_apikey']);
		    		$object->setVars($fraud);
		    		if (floor($fraud['fraud_ipdb_score']/$fraud['fraud_ipdb_accuracyscore']*100)<$GLOBALS['xoopsModuleConfig']['ipdb_fraud_knockoff']) {
		    			if ($object->getVar('remittion')=='_SHOP_MI_ORDER_UNPAID')
		    				$object->setVar('remittion', '_SHOP_MI_ORDER_FRAUDUNPAID');
		    			elseif ($object->getVar('remittion')=='_SHOP_MI_ORDER_PAID')
		    				$object->setVar('remittion', '_SHOP_MI_ORDER_FRAUDPAID');
		    				
		    			if ($GLOBALS['xoopsModuleConfig']['ipdb_fraud_kill'])
		    				$object->setVar('mode', '_SHOP_MI_ORDER_OTHER');
		    		}
	    		}
    			catch(Exception $e){
				
				}
    		}
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