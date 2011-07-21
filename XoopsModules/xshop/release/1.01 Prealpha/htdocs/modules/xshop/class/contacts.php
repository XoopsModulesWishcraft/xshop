<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

/**
 * A handler for Addresses/unAddresses handling
 * 
 * @package     xforum/X-Forum
 * 
 * @author	    S.A.R. (wishcraft, http://www.chronolabs.org)
 * @copyright	copyright (c) 2005 XOOPS.org
 */

class xshopContacts extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('contact_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('manu_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('shipping_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('order_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_CONTACTS_OTHER', false, false, false, array('_SHOP_MI_CONTACTS_EMAIL','_SHOP_MI_CONTACTS_PHONE','_SHOP_MI_CONTACTS_MOBILE','_SHOP_MI_CONTACTS_FAX','_SHOP_MI_CONTACTS_PAGER','_SHOP_MI_CONTACTS_OTHER'));
        $this->initVar('citation', XOBJ_DTYPE_TXTBOX, '', 35);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, '', 128);
        $this->initVar('value', XOBJ_DTYPE_TXTBOX, '', 255);
        $this->initVar('days_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('opening', XOBJ_DTYPE_INT, 0);
        $this->initVar('closing', XOBJ_DTYPE_INT, 0);
        $this->initVar('timezone', XOBJ_DTYPE_INT, 0);
        $this->initVar('country_code', XOBJ_DTYPE_TXTBOX, '+61', 5);
        $this->initVar('area_code', XOBJ_DTYPE_TXTBOX, '(0)2', 5);
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, '', 32);
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
        $this->initVar('actioned', XOBJ_DTYPE_INT);
    }
    
 	function getForm($querystring, $captions = true, $render = true, $index = '', $prefix = '') {
        xoops_loadLanguage('forms', 'xshop');
    	
        if (!empty($index))
    		$id = $index . '['. $this->getVar('contact_id') . ']';
    	else 
    		$id = $this->getVar('contact_id');
    		
    	if ($render==true||$captions==true) {
	    	$frmobj = array();
	    	$frmobj['type'] = new XoopsFormSelectContactsType(_SHOP_FRM_CONTACTS_TYPE, $id.'[type]', $this->getVar('type'));
	    	$frmobj['type']->setDescription(_SHOP_FRM_CONTACTS_TYPE_DESC);
	    	$frmobj['citation'] = new XoopsFormText(_SHOP_FRM_CONTACTS_CITATION, $id.'[citation]', 35, 35, $this->getVar('citation'));
	    	$frmobj['citation']->setDescription(_SHOP_FRM_CONTACTS_CITATION_DESC);
	    	if (in_array($this->getVar('type'), array('_SHOP_MI_CONTACTS_PHONE','_SHOP_MI_CONTACTS_MOBILE','_SHOP_MI_CONTACTS_FAX'))) {
		    	$frmobj['country_code'] = new XoopsFormText(_SHOP_FRM_CONTACTS_COUNTRY_CODE, $id.'[country_code]', 5, 5, $this->getVar('country_code'));
		    	$frmobj['country_code']->setDescription(_SHOP_FRM_CONTACTS_COUNTRY_CODE_DESC);
		    	$frmobj['area_code'] = new XoopsFormText(_SHOP_FRM_CONTACTS_AREA_CODE, $id.'[area_code]', 5, 5, $this->getVar('area_code'));
		    	$frmobj['area_code']->setDescription(_SHOP_FRM_CONTACTS_AREA_CODE_DESC);
	    	}
	    	$frmobj['value'] = new XoopsFormText(_SHOP_FRM_CONTACTS_VALUE, $id.'[value]', 35, 255, $this->getVar('value'));
	    	$frmobj['value']->setDescription(_SHOP_FRM_CONTACTS_VALUE_DESC);
	    	$frmobj['name'] = new XoopsFormText(_SHOP_FRM_CONTACTS_NAME, $id.'[name]', 35, 128, $this->getVar('name'));
	    	$frmobj['name']->setDescription(_SHOP_FRM_CONTACTS_NAME_DESC);
	    	$frmobj['opening'] = new XoopsFormSelectTime(_SHOP_FRM_CONTACTS_OPENING, $id.'[opening]', $this->getVar('opening'));
	    	$frmobj['opening']->setDescription(_SHOP_FRM_CONTACTS_OPENING_DESC);
	    	$frmobj['closing'] = new XoopsFormSelectTime(_SHOP_FRM_CONTACTS_CLOSING, $id.'[closing]', $this->getVar('closing'));
	    	$frmobj['closing']->setDescription(_SHOP_FRM_CONTACTS_CLOSING_DESC);
	    	$frmobj['timezone'] = new XoopsFormSelectTimezone(_SHOP_FRM_CONTACTS_TIMEZONE, $id.'[timezone]', $this->getVar('timezone'));
	    	$frmobj['timezone']->setDescription(_SHOP_FRM_CONTACTS_TIMEZONE_DESC);
	    	
	    	$days_handler = xoops_getmodulehandler('days', 'xshop');
	    	$days = $days_handler->getItem($this->getVar('days_id'));
	    	$frmobj['days_id'] = $days->getFormTray($querystring);
	    	$frmobj['days_id']->setDescription(_SHOP_FRM_CONTACTS_DAYS_DESC);    	

	    	$frmobj['manu_id'] = new XoopsFormHidden($id.'[manu_id]', $this->getVar('manu_id'));
			$frmobj['shipping_id'] = new XoopsFormHidden($id.'[shipping_id]', $this->getVar('shipping_id'));
			$frmobj['order_id'] = new XoopsFormHidden($id.'[order_id]', $this->getVar('order_id'));
			
		    if (!empty($index))		    
	    		$frmobj['contact_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('contact_id').']', 'contacts');
	    	else 
	    		$frmobj['contact_id'] = new XoopsFormHidden('id['.$this->getVar('contact_id').']', 'contacts');
	    		
	    	if ($render==false)
	    		return $frmobj;
	    		
	    	$frmobj['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj['fct'] = new XoopsFormHidden('fct', 'contacts');
    	} else {
	    	$frmobj = array();
	    	$frmobj['type'] = new XoopsFormSelectContactsType('', $id.'[type]', $this->getVar('type'));
	    	$frmobj['citation'] = new XoopsFormText('', $id.'[citation]', 35, 35, $this->getVar('citation'));
	    	if (in_array($this->getVar('type'), array('_SHOP_MI_CONTACTS_PHONE','_SHOP_MI_CONTACTS_MOBILE','_SHOP_MI_CONTACTS_FAX'))) {
		    	$frmobj['country_code'] = new XoopsFormText('', $id.'[country_code]', 5, 5, $this->getVar('country_code'));
		    	$frmobj['area_code'] = new XoopsFormText('', $id.'[area_code]', 5, 5, $this->getVar('area_code'));
		    }
	    	$frmobj['value'] = new XoopsFormText('', $id.'[value]', 35, 255, $this->getVar('value'));
	    	$frmobj['name'] = new XoopsFormText('', $id.'[name]', 35, 128, $this->getVar('name'));
	    	$frmobj['opening'] = new XoopsFormSelectTime('', $id.'[opening]', $this->getVar('opening'));
	    	$frmobj['closing'] = new XoopsFormSelectTime('', $id.'[closing]', $this->getVar('closing'));
	    	$frmobj['timezone'] = new XoopsFormSelectTimezone('', $id.'[timezone]', $this->getVar('timezone'));
	    	
	    	$days_handler = xoops_getmodulehandler('days', 'xshop');
	    	$days = $days_handler->getItem($this->getVar('days_id'));
	    	$frmobj['days_id'] = $days->getFormTray($querystring);

	    	$frmobj['manu_id'] = new XoopsFormHidden($id.'[manu_id]', $this->getVar('manu_id'));
			$frmobj['shipping_id'] = new XoopsFormHidden($id.'[shipping_id]', $this->getVar('shipping_id'));
			$frmobj['order_id'] = new XoopsFormHidden($id.'[order_id]', $this->getVar('order_id'));
	    	
			if (!empty($index))		    
	    		$frmobj['contact_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('contact_id').']', 'contacts');
	    	else 
	    		$frmobj['contact_id'] = new XoopsFormHidden('id['.$this->getVar('contact_id').']', 'contacts');
	    	
	    	return $frmobj;
    	}
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_ITEM, 'items_digest', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_ITEM, 'items_digest', $_SERVER['PHP_SELF'], 'post');
    	}

    	$required = array('name', 'value');
    	
    	foreach($frmobj as $key => $value) {
    		if (!in_array($key, $required)) {
    			$form->addElement($frmobj[$key], false);
    		} else {
    			$form->addElement($frmobj[$key], true);
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

class xshopContactsHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopContactsHandler($db, $type) {
	    parent::__construct($db, 'shop_contacts', 'xshopContacts', 'contact_id');
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