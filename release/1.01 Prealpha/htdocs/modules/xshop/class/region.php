<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopRegion extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('region_id', XOBJ_DTYPE_INT);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, false, 128);
        $this->initVar('longitude', XOBJ_DTYPE_DECIMAL);
        $this->initVar('latitude', XOBJ_DTYPE_DECIMAL);
        
        
    }
    
	function toArray() {
    	$ret = parent::toArray();
    	return $ret;
    }
        
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array()) {
        xoops_loadLanguage('forms', 'xshop');
    	
		$frmobj['required'][] = 'name';
        
        if (!empty($index))
    		$id = $index . '['. $this->getVar('region_id') . ']';
    	else 
    		$id = $this->getVar('region_id');
    		
    	if ($render==true||$captions==true) {
	    	
	    	$frmobj[$cursor]['name'] = new XoopsFormText(_SHOP_FRM_REGION_NAME, $id.'[name]', 35, 128, $this->getVar('name'));
	    	$frmobj[$cursor]['name']->setDescription(_SHOP_FRM_REGION_NAME_DESC);
    		$frmobj[$cursor]['longitude'] = new XoopsFormText(_SHOP_FRM_REGION_LONGITUDE, $id.'[longitude]', 10, 25, $this->getVar('longitude'));
	    	$frmobj[$cursor]['longitude']->setDescription(_SHOP_FRM_REGION_LONGITUDE_DESC);
	    	$frmobj[$cursor]['latitude'] = new XoopsFormText(_SHOP_FRM_REGION_LATITUDE, $id.'[latitude]', 10, 25, $this->getVar('latitude'));
	    	$frmobj[$cursor]['latitude']->setDescription(_SHOP_FRM_REGION_LATITUDE_DESC);
			
		    if (!empty($index))		    
	    		$frmobj[$cursor]['region_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('region_id').']', 'region');
	    	else 
	    		$frmobj[$cursor]['region_id'] = new XoopsFormHidden('id['.$this->getVar('region_id').']', 'region');
	    		
	    	if ($render==false)
	    		return $frmobj;
	    		
	    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'region');
    	} else {
	    	
	    	$frmobj[$cursor]['name'] = new XoopsFormText('', $id.'[name]', 35, 128, $this->getVar('name'));
	    	$frmobj[$cursor]['longitude'] = new XoopsFormText('', $id.'[longitude]', 10, 25, $this->getVar('longitude'));
	    	$frmobj[$cursor]['latitude'] = new XoopsFormText('', $id.'[latitude]', 10, 25, $this->getVar('latitude'));
	    	
		    if (!empty($index))		    
	    		$frmobj[$cursor]['region_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('region_id').']', 'region');
	    	else 
	    		$frmobj[$cursor]['region_id'] = new XoopsFormHidden('id['.$this->getVar('region_id').']', 'region');
	    			    	
	    	return $frmobj;
    	}
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_REGION, 'region', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_REGION, 'region', $_SERVER['PHP_SELF'], 'post');
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

class xshopRegionHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopRegionHandler($db, $type) {
	    parent::__construct($db, 'shop_regions', 'xshopRegion', 'region_id');
    }   
}
?>