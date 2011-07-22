<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopCountry extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('country_id', XOBJ_DTYPE_INT);
        $this->initVar('alpha2', XOBJ_DTYPE_TXTBOX, false, 2);
        $this->initVar('alpha3', XOBJ_DTYPE_TXTBOX, false, 3);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, false, 200);
        
    }
    
	function toArray() {
    	$ret = parent::toArray();
    	return $ret;
    }
    
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array()) {
        xoops_loadLanguage('forms', 'xshop');
    	
    	$frmobj['required'][] = 'alpha2';
		$frmobj['required'][] = 'alpha3';
		$frmobj['required'][] = 'name';
        
        if (!empty($index))
    		$id = $index . '['. $this->getVar('country_id') . ']';
    	else 
    		$id = $this->getVar('country_id');
    		
    	if ($render==true||$captions==true) {
	    	
	    	$frmobj[$cursor]['alpha2'] = new XoopsFormText(_SHOP_FRM_COUNTRY_ALPHA2, $id.'[alpha2]', 2, 4, $this->getVar('alpha2'));
	    	$frmobj[$cursor]['alpha2']->setDescription(_SHOP_FRM_COUNTRY_ALPHA2_DESC);
	    	$frmobj[$cursor]['alpha3'] = new XoopsFormText(_SHOP_FRM_COUNTRY_ALPHA3, $id.'[alpha2]', 3, 4, $this->getVar('alpha3'));
	    	$frmobj[$cursor]['alpha3']->setDescription(_SHOP_FRM_COUNTRY_ALPHA3_DESC);
	    	$frmobj[$cursor]['name'] = new XoopsFormText(_SHOP_FRM_COUNTRY_NAME, $id.'[name]', 35, 200, $this->getVar('name'));
	    	$frmobj[$cursor]['name']->setDescription(_SHOP_FRM_COUNTRY_NAME_DESC);
			
		    if (!empty($index))		    
	    		$frmobj[$cursor]['country_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('country_id').']', 'country');
	    	else 
	    		$frmobj[$cursor]['country_id'] = new XoopsFormHidden('id['.$this->getVar('country_id').']', 'country');
	    		
	    	if ($render==false)
	    		return $frmobj;
	    		
	    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'country');
    	} else {
	    	
	    	$frmobj[$cursor]['alpha2'] = new XoopsFormText('', $id.'[alpha2]', 2, 4, $this->getVar('alpha2'));
	    	$frmobj[$cursor]['alpha3'] = new XoopsFormText('', $id.'[alpha2]', 3, 4, $this->getVar('alpha3'));
	    	$frmobj[$cursor]['name'] = new XoopsFormText('', $id.'[name]', 35, 200, $this->getVar('name'));
	    				
		    if (!empty($index))		    
	    		$frmobj[$cursor]['country_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('country_id').']', 'country');
	    	else 
	    		$frmobj[$cursor]['country_id'] = new XoopsFormHidden('id['.$this->getVar('country_id').']', 'country');	    	
	    	return $frmobj;
    	}
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_COUNTRY, 'contacts', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_COUNTRY, 'contacts', $_SERVER['PHP_SELF'], 'post');
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
}

class xshopCountryHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopCountryHandler($db, $type) {
	    parent::__construct($db, 'shop_country', 'xshopCountry', 'country_id');
    }   
}
?>