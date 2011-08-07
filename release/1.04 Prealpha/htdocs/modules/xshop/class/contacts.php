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
	var $_objects = array();
	
    function __construct($type)
    {
        $this->initVar('contact_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('last_sales_uid', XOBJ_DTYPE_INT, 0);
        $this->initVar('last_broker_uid', XOBJ_DTYPE_INT, 0);
        $this->initVar('last_cat_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('last_product_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('last_manu_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('last_shipping_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('last_order_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_CONTACTS_OTHER', false, false, false, array('_SHOP_MI_CONTACTS_EMAIL','_SHOP_MI_CONTACTS_PHONE','_SHOP_MI_CONTACTS_MOBILE','_SHOP_MI_CONTACTS_FAX','_SHOP_MI_CONTACTS_PAGER','_SHOP_MI_CONTACTS_OTHER'));
        $this->initVar('citation', XOBJ_DTYPE_TXTBOX, '', 35);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, '', 128);
        $this->initVar('value', XOBJ_DTYPE_TXTBOX, '', 255);
        $this->initVar('days_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('opening', XOBJ_DTYPE_INT, 60*60*9);
        $this->initVar('closing', XOBJ_DTYPE_INT, 60*60*17);
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
    	//echo '<pre>';
    	//print_r($ret);
    	//echo '</pre>';
    	return $ret;
    }
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array(), $const = '_SHOP_MI_CONTACTS_EMAIL') {
        xoops_loadLanguage('forms', 'xshop');
    	
        $frmobj['required'][] = 'name';
		$frmobj['required'][] = 'value';
    	
        if (!empty($index))
    		$id = $index . '['. $this->getVar('contact_id') . ']';
    	else 
    		$id = $this->getVar('contact_id');
    		
    	if ($render==true||$captions==true) {
    		if (defined($const)&&defined($const.'_LABEL')&&defined($const.'_LABEL_DESC')) {
		    	$frmobj[$cursor]['label'] = new XoopsFormLabel('<font style="font-size:1.25em;">'.constant($const).'</font>', '<font style="font-size:1.25em;">'.sprintf(constant($const.'_LABEL'), constant($const)).'</font>');
		    	$frmobj[$cursor]['label']->setDescription(constant($const.'_LABEL_DESC'));
    			if ($this->isNew()) {
    				$frmobj[$cursor]['type'] = new XShopFormSelectContactsType(_SHOP_FRM_CONTACTS_TYPE, $id.'[type]', $const);
	    			$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_CONTACTS_TYPE_DESC);
    			} else {
			    	$frmobj[$cursor]['type'] = new XShopFormSelectContactsType(_SHOP_FRM_CONTACTS_TYPE, $id.'[type]', $this->getVar('type'));
			    	$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_CONTACTS_TYPE_DESC);
       			}
    		} else {
		    	$frmobj[$cursor]['type'] = new XShopFormSelectContactsType(_SHOP_FRM_CONTACTS_TYPE, $id.'[type]', $this->getVar('type'));
		    	$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_CONTACTS_TYPE_DESC);
     		}
    		
	    	$frmobj[$cursor]['type'] = new XShopFormSelectContactsType(_SHOP_FRM_CONTACTS_TYPE, $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_CONTACTS_TYPE_DESC);
	    	$frmobj[$cursor]['citation'] = new XoopsFormText(_SHOP_FRM_CONTACTS_CITATION, $id.'[citation]', 35, 35, $this->getVar('citation'));
	    	$frmobj[$cursor]['citation']->setDescription(_SHOP_FRM_CONTACTS_CITATION_DESC);
	    	$frmobj[$cursor]['country_code'] = new XoopsFormText(_SHOP_FRM_CONTACTS_COUNTRY_CODE, $id.'[country_code]', 5, 5, $this->getVar('country_code'));
	    	$frmobj[$cursor]['country_code']->setDescription(_SHOP_FRM_CONTACTS_COUNTRY_CODE_DESC);
	    	$frmobj[$cursor]['area_code'] = new XoopsFormText(_SHOP_FRM_CONTACTS_AREA_CODE, $id.'[area_code]', 5, 5, $this->getVar('area_code'));
	    	$frmobj[$cursor]['area_code']->setDescription(_SHOP_FRM_CONTACTS_AREA_CODE_DESC);
	    	$frmobj[$cursor]['value'] = new XoopsFormText(_SHOP_FRM_CONTACTS_VALUE, $id.'[value]', 35, 255, $this->getVar('value'));
	    	$frmobj[$cursor]['value']->setDescription(_SHOP_FRM_CONTACTS_VALUE_DESC);
	    	$frmobj[$cursor]['name'] = new XoopsFormText(_SHOP_FRM_CONTACTS_NAME, $id.'[name]', 35, 128, $this->getVar('name'));
	    	$frmobj[$cursor]['name']->setDescription(_SHOP_FRM_CONTACTS_NAME_DESC);
	    	$frmobj[$cursor]['opening'] = new XShopFormSelectTime(_SHOP_FRM_CONTACTS_OPENING, $id.'[opening]', $this->getVar('opening'));
	    	$frmobj[$cursor]['opening']->setDescription(_SHOP_FRM_CONTACTS_OPENING_DESC);
	    	$frmobj[$cursor]['closing'] = new XShopFormSelectTime(_SHOP_FRM_CONTACTS_CLOSING, $id.'[closing]', $this->getVar('closing'));
	    	$frmobj[$cursor]['closing']->setDescription(_SHOP_FRM_CONTACTS_CLOSING_DESC);
	    	$frmobj[$cursor]['timezone'] = new XShopFormSelectTimezone(_SHOP_FRM_CONTACTS_TIMEZONE, $id.'[timezone]', $this->getVar('timezone'));
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
	    	
	    	if ($_REQUEST['fct']=='contacts') {
	    		$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    		$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'contacts');
	    	}
    	} else {
	    	$frmobj[$cursor]['type'] = new XShopFormSelectContactsType('', $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['citation'] = new XoopsFormText('', $id.'[citation]', 35, 35, $this->getVar('citation'));
		    $frmobj[$cursor]['country_code'] = new XoopsFormText('', $id.'[country_code]', 5, 5, $this->getVar('country_code'));
		    $frmobj[$cursor]['area_code'] = new XoopsFormText('', $id.'[area_code]', 5, 5, $this->getVar('area_code'));
		    $frmobj[$cursor]['value'] = new XoopsFormText('', $id.'[value]', 35, 255, $this->getVar('value'));
	    	$frmobj[$cursor]['name'] = new XoopsFormText('', $id.'[name]', 35, 128, $this->getVar('name'));
	    	$frmobj[$cursor]['opening'] = new XShopFormSelectTime('', $id.'[opening]', $this->getVar('opening'));
	    	$frmobj[$cursor]['closing'] = new XShopFormSelectTime('', $id.'[closing]', $this->getVar('closing'));
	    	$frmobj[$cursor]['timezone'] = new XShopFormSelectTimezone('', $id.'[timezone]', $this->getVar('timezone'));
	    	
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
    	
    	$frmobj['submit']['submit'] = new XoopsFormButton('', _SUBMIT, 'submit', _SUBMIT);
    	
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
    	if ($contact_id==0) {
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