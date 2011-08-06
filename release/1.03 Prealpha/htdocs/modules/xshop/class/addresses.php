<?php

 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class XShopAddresses extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('address_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('manu_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('shop_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('order_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_ADDRESS_DELIEVERY', false, false, false, array('_SHOP_MI_ADDRESS_MANUFACTURE','_SHOP_MI_ADDRESS_SHOP','_SHOP_MI_ADDRESS_POSTAL','_SHOP_MI_ADDRESS_DELIEVERY','_SHOP_MI_ADDRESS_ORDERBY','_SHOP_MI_ADDRESS_SHOW','_SHOP_MI_ADDRESS_OTHER'));
        $this->initVar('remittion', XOBJ_DTYPE_ENUM, '_SHOP_MI_ADDRESS_NONE', false, false, false, array('_SHOP_MI_ADDRESS_RETURNEDGOODS','_SHOP_MI_ADDRESS_FRAUD','_SHOP_MI_ADDRESS_STOLENINMAIL','_SHOP_MI_ADDRESS_EXPRESSDELIEVERY','_SHOP_MI_ADDRESS_NONE'));
        $this->initVar('care_of', XOBJ_DTYPE_TXTBOX, '', false, 128);
        $this->initVar('address_line_1', XOBJ_DTYPE_TXTBOX, '', false, 128);
        $this->initVar('address_line_2', XOBJ_DTYPE_TXTBOX, '', false, 128);
        $this->initVar('suburb', XOBJ_DTYPE_TXTBOX, '', false, 128);
        $this->initVar('city', XOBJ_DTYPE_TXTBOX, '', false, 128);
        $this->initVar('region_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('country_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('postcode', XOBJ_DTYPE_TXTBOX, '', false, 15);
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, '', false, 32);
        $this->initVar('created', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('updated', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('actioned', XOBJ_DTYPE_INT, 0, false);
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
    		
    	return $ret;
    }
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array(), $const='') {
    	xoops_loadLanguage('forms', 'XShop');
    	
		$frmobj['required'][] = 'address_line_1';
		$frmobj['required'][] = 'suburb';
		$frmobj['required'][] = 'city';
		$frmobj['required'][] = 'postcode';
		$frmobj['required'][] = 'country_id';
		
    	if (!empty($index))
    		$id = $index . '['. $this->getVar('address_id') . ']';
    	else 
    		$id = $this->getVar('address_id');
    	    	
    	if ($render == true||$captions==true) {
    		if (defined($const)&&defined($const.'_LABEL')&&defined($const.'_LABEL_DESC')) {
		    	$frmobj[$cursor]['label'] = new XoopsFormLabel('<font style="font-size:1.25em;">'.constant($const).'</font>', '<font style="font-size:1.25em;">'.sprintf(constant($const.'_LABEL'), constant($const)).'</font>');
		    	$frmobj[$cursor]['label']->setDescription(constant($const.'_LABEL_DESC'));
    			if ($this->isNew()) {
    				$frmobj[$cursor]['type'] = new XShopFormSelectAddressType(_SHOP_FRM_ADDRESSES_TYPE, $id.'[type]', $const);
		    		$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_ADDRESSES_TYPE_DESC);
    			} else {
    				$frmobj[$cursor]['type'] = new XShopFormSelectAddressType(_SHOP_FRM_ADDRESSES_TYPE, $id.'[type]', $this->getVar('type'));
		    		$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_ADDRESSES_TYPE_DESC);
    			}
    		} else {
	    		$frmobj[$cursor]['type'] = new XShopFormSelectAddressType(_SHOP_FRM_ADDRESSES_TYPE, $id.'[type]', $this->getVar('type'));
		    	$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_ADDRESSES_TYPE_DESC);
    		}
	    	$frmobj[$cursor]['remittion'] = new XShopFormSelectAddressRemittion(_SHOP_FRM_ADDRESSES_REMITTION, $id.'[remittion]', $this->getVar('remittion'));
	    	$frmobj[$cursor]['remittion']->setDescription(_SHOP_FRM_ADDRESSES_REMITTION_DESC);
	    	$frmobj[$cursor]['care_of'] = new XoopsFormText(_SHOP_FRM_ADDRESSES_CARE_OF, $id.'[care_of]', 35, 128, $this->getVar('care_of'));
	    	$frmobj[$cursor]['care_of']->setDescription(_SHOP_FRM_ADDRESSES_CARE_OF_DESC);
	    	$frmobj[$cursor]['address_line_1'] = new XoopsFormText(_SHOP_FRM_ADDRESSES_ADDRESS_LINE_1, $id.'[address_line_1]', 35, 128, $this->getVar('address_line_1'));
	    	$frmobj[$cursor]['address_line_1']->setDescription(_SHOP_FRM_ADDRESSES_ADDRESS_LINE_1_DESC);
	    	$frmobj[$cursor]['address_line_2'] = new XoopsFormText(_SHOP_FRM_ADDRESSES_ADDRESS_LINE_2, $id.'[address_line_2]', 35, 128, $this->getVar('address_line_2'));
	    	$frmobj[$cursor]['address_line_2']->setDescription(_SHOP_FRM_ADDRESSES_ADDRESS_LINE_2_DESC);
	    	$frmobj[$cursor]['suburb'] = new XoopsFormText(_SHOP_FRM_ADDRESSES_SUBURB, $id.'[suburb]', 35, 128, $this->getVar('suburb'));
	    	$frmobj[$cursor]['suburb']->setDescription(_SHOP_FRM_ADDRESSES_SUBURB_DESC);
	    	$frmobj[$cursor]['city'] = new XoopsFormText(_SHOP_FRM_ADDRESSES_CITY, $id.'[city]', 35, 128, $this->getVar('city'));
	    	$frmobj[$cursor]['city']->setDescription(_SHOP_FRM_ADDRESSES_CITY_DESC);
	    	$frmobj[$cursor]['postcode'] = new XoopsFormText(_SHOP_FRM_ADDRESSES_POSTCODE, $id.'[postcode]', 15, 15, $this->getVar('postcode'));
	    	$frmobj[$cursor]['postcode']->setDescription(_SHOP_FRM_ADDRESSES_POSTCODE_DESC);
	    	$frmobj[$cursor]['region_id'] = new XShopFormSelectRegion(_SHOP_FRM_ADDRESSES_REGION, $id.'[region_id]', $this->getVar('region_id'));
	    	$frmobj[$cursor]['region_id']->setDescription(_SHOP_FRM_ADDRESSES_REGION_DESC);
	    	$frmobj[$cursor]['country_id'] = new XShopFormSelectCountry(_SHOP_FRM_ADDRESSES_COUNTRY, $id.'[country_id]', $this->getVar('country_id'));
	    	$frmobj[$cursor]['country_id']->setDescription(_SHOP_FRM_ADDRESSES_COUNTRY_DESC);
		    $frmobj[$cursor]['manu_id'] = new XoopsFormHidden($id.'[manu_id]', $this->getVar('manu_id'));
		    $frmobj[$cursor]['shop_id'] = new XoopsFormHidden($id.'[shop_id]', $this->getVar('shop_id'));
		    $frmobj[$cursor]['order_id'] = new XoopsFormHidden($id.'[order_id]', $this->getVar('order_id'));
		    
		   	if (!empty($index))	
	    		$frmobj[$cursor]['address_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('address_id').']', 'addresses');
	    	else 
	    		$frmobj[$cursor]['address_id'] = new XoopsFormHidden('id['.$this->getVar('address_id').']', 'addresses');
	    	
	    	if ($render==false)
	    		return $frmobj;
	    	
	    	if ($_REQUEST['fct']=='addresses') {
		    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
		    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'addresses');
	    	}
    	} else {
	    	$frmobj[$cursor]['type'] = new XShopFormSelectAddressType('', $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['remittion'] = new XShopFormSelectAddressRemittion('', $id.'[remittion]', $this->getVar('remittion'));
	    	$frmobj[$cursor]['care_of'] = new XoopsFormText('', $id.'[care_of]', 35, 128, $this->getVar('care_of'));
	    	$frmobj[$cursor]['address_line_1'] = new XoopsFormText('', $id.'[address_line_1]', 35, 128, $this->getVar('address_line_1'));
	    	$frmobj[$cursor]['address_line_2'] = new XoopsFormText('', $id.'[address_line_2]', 35, 128, $this->getVar('address_line_2'));
	    	$frmobj[$cursor]['suburb'] = new XoopsFormText('', $id.'[suburb]', 35, 128, $this->getVar('suburb'));
	    	$frmobj[$cursor]['city'] = new XoopsFormText('', $id.'[city]', 35, 128, $this->getVar('city'));
	    	$frmobj[$cursor]['postcode'] = new XoopsFormText('', $id.'[postcode]', 15, 15, $this->getVar('postcode'));
	    	$frmobj[$cursor]['region_id'] = new XShopFormSelectRegion('', $id.'[region_id]', $this->getVar('region_id'));
	    	$frmobj[$cursor]['country_id'] = new XShopFormSelectCountry('', $id.'[country_id]', $this->getVar('country_id'));
		    $frmobj[$cursor]['manu_id'] = new XoopsFormHidden($id.'[manu_id]', $this->getVar('manu_id'));
		    $frmobj[$cursor]['shop_id'] = new XoopsFormHidden($id.'[shop_id]', $this->getVar('shop_id'));
		    $frmobj[$cursor]['order_id'] = new XoopsFormHidden($id.'[order_id]', $this->getVar('order_id'));
	    	if (!empty($index))	
	    		$frmobj[$cursor]['address_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('address_id').']', 'addresses');
	    	else 
	    		$frmobj[$cursor]['address_id'] = new XoopsFormHidden('id['.$this->getVar('address_id').']', 'addresses');
	    	
	    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'addresses');
	    	return $frmobj;
    	}
    	
    	$frmobj['submit']['submit'] = new XoopsFormButton('', _SUBMIT, 'submit', _SUBMIT);
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_ADDRESS, 'address', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_ADDRESS, 'address', $_SERVER['PHP_SELF'], 'post');
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
		
		include_once($GLOBALS['xoops']->path('/modules/XShop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'XShop');
		
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
		
		include_once($GLOBALS['xoops']->path('/modules/XShop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'XShop');
		
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
		
		include_once($GLOBALS['xoops']->path('/modules/XShop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'XShop');
		
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

class XShopAddressesHandler extends XoopsPersistableObjectHandler
{
   	
    function XShopAddressesHandler($db, $type) {
	    parent::__construct($db, 'shop_addresses', 'XShopAddresses', 'address_id');
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
    
    function getItem($address_id=0, $type = '') {
    	if ($address_id==0) {
    		$obj = $this->create();
    		if (!empty($type))
    			$obj->setVar('type', $type);
    		return $obj;
    	} else {
    		$obj = $this->get($address_id);
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