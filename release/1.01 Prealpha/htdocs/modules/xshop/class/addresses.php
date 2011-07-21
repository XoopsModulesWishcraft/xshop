<?php

 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopAddresses extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('address_id', XOBJ_DTYPE_INT);
        $this->initVar('manu_id', XOBJ_DTYPE_INT);
        $this->initVar('shop_id', XOBJ_DTYPE_INT);
        $this->initVar('order_id', XOBJ_DTYPE_INT);
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_ADDRESS_DELIEVERY', false, false, false, array('_SHOP_MI_ADDRESS_MANUFACTURE','_SHOP_MI_ADDRESS_SHOP','_SHOP_MI_ADDRESS_POSTAL','_SHOP_MI_ADDRESS_DELIEVERY','_SHOP_MI_ADDRESS_ORDERBY','_SHOP_MI_ADDRESS_SHOW','_SHOP_MI_ADDRESS_OTHER'));
        $this->initVar('remittion', XOBJ_DTYPE_ENUM, '_SHOP_MI_ADDRESS_NONE', false, false, false, array('_SHOP_MI_ADDRESS_RETURNEDGOODS','_SHOP_MI_ADDRESS_FRAUD','_SHOP_MI_ADDRESS_STOLENINMAIL','_SHOP_MI_ADDRESS_EXPRESSDELIEVERY','_SHOP_MI_ADDRESS_NONE'));
        $this->initVar('care_of', XOBJ_DTYPE_TXTBOX, '', 128);
        $this->initVar('address_line_1', XOBJ_DTYPE_TXTBOX, '', 128);
        $this->initVar('address_line_2', XOBJ_DTYPE_TXTBOX, '', 128);
        $this->initVar('suburb', XOBJ_DTYPE_TXTBOX, '', 128);
        $this->initVar('city', XOBJ_DTYPE_TXTBOX, '', 128);
        $this->initVar('region_id', XOBJ_DTYPE_INT);
        $this->initVar('country_id', XOBJ_DTYPE_INT);
        $this->initVar('postcode', XOBJ_DTYPE_TXTBOX, '', 15);
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, '', 32);
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
        $this->initVar('actioned', XOBJ_DTYPE_INT);
    }
	
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array()) {
    	xoops_loadLanguage('forms', 'xshop');
    	
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
	    	$frmobj[$cursor]['type'] = new XoopsFormSelectAddressType(_SHOP_FRM_ADDRESSES_TYPE, $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_ADDRESSES_TYPE_DESC);
	    	$frmobj[$cursor]['remittion'] = new XoopsFormSelectAddressRemittion(_SHOP_FRM_ADDRESSES_REMITTION, $id.'[remittion]', $this->getVar('remittion'));
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
	    	$frmobj[$cursor]['region_id'] = new XoopsFormSelectRegion(_SHOP_FRM_ADDRESSES_REGION, $id.'[region_id]', $this->getVar('region_id'));
	    	$frmobj[$cursor]['region_id']->setDescription(_SHOP_FRM_ADDRESSES_REGION_DESC);
	    	$frmobj[$cursor]['country_id'] = new XoopsFormSelectCountry(_SHOP_FRM_ADDRESSES_COUNTRY, $id.'[country_id]', $this->getVar('country_id'));
	    	$frmobj[$cursor]['country_id']->setDescription(_SHOP_FRM_ADDRESSES_COUNTRY_DESC);
		    $frmobj[$cursor]['manu_id'] = new XoopsFormHidden($id.'[manu_id]', $this->getVar('manu_id'));
		    $frmobj[$cursor]['shop_id'] = new XoopsFormHidden($id.'[shop_id]', $this->getVar('shop_id'));
		    $frmobj[$cursor]['order_id'] = new XoopsFormHidden($id.'[order_id]', $this->getVar('order_id'));
		    
		   	if (!empty($index))	
	    		$frmobj[$cursor]['address_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('address_id').']', 'addressses');
	    	else 
	    		$frmobj[$cursor]['address_id'] = new XoopsFormHidden('id['.$this->getVar('address_id').']', 'addressses');
	    	
	    	if ($render==false)
	    		return $frmobj;
	    	
	    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'addressses');
    	} else {
	    	$frmobj[$cursor]['type'] = new XoopsFormSelectAddressType('', $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['remittion'] = new XoopsFormSelectAddressRemittion('', $id.'[remittion]', $this->getVar('remittion'));
	    	$frmobj[$cursor]['care_of'] = new XoopsFormText('', $id.'[care_of]', 35, 128, $this->getVar('care_of'));
	    	$frmobj[$cursor]['address_line_1'] = new XoopsFormText('', $id.'[address_line_1]', 35, 128, $this->getVar('address_line_1'));
	    	$frmobj[$cursor]['address_line_2'] = new XoopsFormText('', $id.'[address_line_2]', 35, 128, $this->getVar('address_line_2'));
	    	$frmobj[$cursor]['suburb'] = new XoopsFormText('', $id.'[suburb]', 35, 128, $this->getVar('suburb'));
	    	$frmobj[$cursor]['city'] = new XoopsFormText('', $id.'[city]', 35, 128, $this->getVar('city'));
	    	$frmobj[$cursor]['postcode'] = new XoopsFormText('', $id.'[postcode]', 15, 15, $this->getVar('postcode'));
	    	$frmobj[$cursor]['region_id'] = new XoopsFormSelectRegion('', $id.'[region_id]', $this->getVar('region_id'));
	    	$frmobj[$cursor]['country_id'] = new XoopsFormSelectCountry('', $id.'[country_id]', $this->getVar('country_id'));
		    $frmobj[$cursor]['manu_id'] = new XoopsFormHidden($id.'[manu_id]', $this->getVar('manu_id'));
		    $frmobj[$cursor]['shop_id'] = new XoopsFormHidden($id.'[shop_id]', $this->getVar('shop_id'));
		    $frmobj[$cursor]['order_id'] = new XoopsFormHidden($id.'[order_id]', $this->getVar('order_id'));
	    	if (!empty($index))	
	    		$frmobj[$cursor]['address_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('address_id').']', 'addressses');
	    	else 
	    		$frmobj[$cursor]['address_id'] = new XoopsFormHidden('id['.$this->getVar('address_id').']', 'addressses');
	    	
	    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'addressses');
	    	return $frmobj;
    	}
    	
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
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
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
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
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
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
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

class xshopAddressesHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopAddressesHandler($db, $type) {
	    parent::__construct($db, 'shop_addresses', 'xshopAddresses', 'address_id');
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
    	if ($address_id=0) {
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
}
?>