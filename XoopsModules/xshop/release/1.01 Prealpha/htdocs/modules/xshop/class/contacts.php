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
    
	function toArray() {
    	$ret = parent::toArray();
    	$ret['when'] = get_when_associative($this);
    	$frms = $this->getForm($_SERVER['QUERY_STRING'], false, false, 'base', array());
    	foreach($frms as $key => $value) {
    		if ($key!='required') {
   	 			foreach($value as $field => $valueb) {
	    		    $ret['forms'][$key][$field] = $frms[$key][$field]->render();
    			}
    		}
    	}
    	return $ret;
    }
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array()) {
        xoops_loadLanguage('forms', 'xshop');
    	
        $frmobj['required'][] = 'name';
		$frmobj['required'][] = 'value';
    	
        if (!empty($index))
    		$id = $index . '['. $this->getVar('contact_id') . ']';
    	else 
    		$id = $this->getVar('contact_id');
    		
    	if ($render==true||$captions==true) {
	    	$frmobj[$cursor]['type'] = new XoopsFormSelectContactsType(_SHOP_FRM_CONTACTS_TYPE, $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_CONTACTS_TYPE_DESC);
	    	$frmobj[$cursor]['citation'] = new XoopsFormText(_SHOP_FRM_CONTACTS_CITATION, $id.'[citation]', 35, 35, $this->getVar('citation'));
	    	$frmobj[$cursor]['citation']->setDescription(_SHOP_FRM_CONTACTS_CITATION_DESC);
	    	if (in_array($this->getVar('type'), array('_SHOP_MI_CONTACTS_PHONE','_SHOP_MI_CONTACTS_MOBILE','_SHOP_MI_CONTACTS_FAX'))) {
		    	$frmobj[$cursor]['country_code'] = new XoopsFormText(_SHOP_FRM_CONTACTS_COUNTRY_CODE, $id.'[country_code]', 5, 5, $this->getVar('country_code'));
		    	$frmobj[$cursor]['country_code']->setDescription(_SHOP_FRM_CONTACTS_COUNTRY_CODE_DESC);
		    	$frmobj[$cursor]['area_code'] = new XoopsFormText(_SHOP_FRM_CONTACTS_AREA_CODE, $id.'[area_code]', 5, 5, $this->getVar('area_code'));
		    	$frmobj[$cursor]['area_code']->setDescription(_SHOP_FRM_CONTACTS_AREA_CODE_DESC);
	    	}
	    	$frmobj[$cursor]['value'] = new XoopsFormText(_SHOP_FRM_CONTACTS_VALUE, $id.'[value]', 35, 255, $this->getVar('value'));
	    	$frmobj[$cursor]['value']->setDescription(_SHOP_FRM_CONTACTS_VALUE_DESC);
	    	$frmobj[$cursor]['name'] = new XoopsFormText(_SHOP_FRM_CONTACTS_NAME, $id.'[name]', 35, 128, $this->getVar('name'));
	    	$frmobj[$cursor]['name']->setDescription(_SHOP_FRM_CONTACTS_NAME_DESC);
	    	$frmobj[$cursor]['opening'] = new XoopsFormSelectTime(_SHOP_FRM_CONTACTS_OPENING, $id.'[opening]', $this->getVar('opening'));
	    	$frmobj[$cursor]['opening']->setDescription(_SHOP_FRM_CONTACTS_OPENING_DESC);
	    	$frmobj[$cursor]['closing'] = new XoopsFormSelectTime(_SHOP_FRM_CONTACTS_CLOSING, $id.'[closing]', $this->getVar('closing'));
	    	$frmobj[$cursor]['closing']->setDescription(_SHOP_FRM_CONTACTS_CLOSING_DESC);
	    	$frmobj[$cursor]['timezone'] = new XoopsFormSelectTimezone(_SHOP_FRM_CONTACTS_TIMEZONE, $id.'[timezone]', $this->getVar('timezone'));
	    	$frmobj[$cursor]['timezone']->setDescription(_SHOP_FRM_CONTACTS_TIMEZONE_DESC);
	    	
	    	$days_handler = xoops_getmodulehandler('days', 'xshop');
	    	$days = $days_handler->getItem($this->getVar('days_id'));
	    	$frmobj[$cursor]['days_id'] = $days->getFormTray($querystring, true, $id.'[days]');
	    	$frmobj[$cursor]['days_id']->setDescription(_SHOP_FRM_CONTACTS_DAYS_DESC);    	

	    	$frmobj[$cursor]['manu_id'] = new XoopsFormHidden($id.'[manu_id]', $this->getVar('manu_id'));
			$frmobj[$cursor]['shipping_id'] = new XoopsFormHidden($id.'[shipping_id]', $this->getVar('shipping_id'));
			$frmobj[$cursor]['order_id'] = new XoopsFormHidden($id.'[order_id]', $this->getVar('order_id'));
			
		    if (!empty($index))		    
	    		$frmobj[$cursor]['contact_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('contact_id').']', 'contacts');
	    	else 
	    		$frmobj[$cursor]['contact_id'] = new XoopsFormHidden('id['.$this->getVar('contact_id').']', 'contacts');
	    		
	    	if ($render==false)
	    		return $frmobj;
	    		
	    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'contacts');
    	} else {
	    	$frmobj[$cursor]['type'] = new XoopsFormSelectContactsType('', $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['citation'] = new XoopsFormText('', $id.'[citation]', 35, 35, $this->getVar('citation'));
	    	if (in_array($this->getVar('type'), array('_SHOP_MI_CONTACTS_PHONE','_SHOP_MI_CONTACTS_MOBILE','_SHOP_MI_CONTACTS_FAX'))) {
		    	$frmobj[$cursor]['country_code'] = new XoopsFormText('', $id.'[country_code]', 5, 5, $this->getVar('country_code'));
		    	$frmobj[$cursor]['area_code'] = new XoopsFormText('', $id.'[area_code]', 5, 5, $this->getVar('area_code'));
		    }
	    	$frmobj[$cursor]['value'] = new XoopsFormText('', $id.'[value]', 35, 255, $this->getVar('value'));
	    	$frmobj[$cursor]['name'] = new XoopsFormText('', $id.'[name]', 35, 128, $this->getVar('name'));
	    	$frmobj[$cursor]['opening'] = new XoopsFormSelectTime('', $id.'[opening]', $this->getVar('opening'));
	    	$frmobj[$cursor]['closing'] = new XoopsFormSelectTime('', $id.'[closing]', $this->getVar('closing'));
	    	$frmobj[$cursor]['timezone'] = new XoopsFormSelectTimezone('', $id.'[timezone]', $this->getVar('timezone'));
	    	
	    	$days_handler = xoops_getmodulehandler('days', 'xshop');
	    	$days = $days_handler->getItem($this->getVar('days_id'));
	    	$frmobj[$cursor]['days_id'] = $days->getFormTray($querystring, false, $id.'[days]');

	    	$frmobj[$cursor]['manu_id'] = new XoopsFormHidden($id.'[manu_id]', $this->getVar('manu_id'));
			$frmobj[$cursor]['shipping_id'] = new XoopsFormHidden($id.'[shipping_id]', $this->getVar('shipping_id'));
			$frmobj[$cursor]['order_id'] = new XoopsFormHidden($id.'[order_id]', $this->getVar('order_id'));
	    	
			if (!empty($index))		    
	    		$frmobj[$cursor]['contact_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('contact_id').']', 'contacts');
	    	else 
	    		$frmobj[$cursor]['contact_id'] = new XoopsFormHidden('id['.$this->getVar('contact_id').']', 'contacts');
	    	
	    	return $frmobj;
    	}
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_CONTACT, 'contacts', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_CONTACT, 'contacts', $_SERVER['PHP_SELF'], 'post');
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
    
    function getItem($contact_id=0, $type = '') {
    	if ($contact_id=0) {
    		$obj = $this->create();
    		if (!empty($type))
    			$obj->setVar('type', $type);
    		return $obj;
    	} else {
    		$obj = $this->get($contact_id);
    		if (is_object($obj)) {	
    			return $obj;
    		}
    		$obj = $this->create();
    		if (!empty($type))
    			$obj->setVar('type', $type);
    		return $obj;
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
}
?>