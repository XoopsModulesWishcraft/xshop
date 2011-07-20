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
}

class xshopCountryHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopCountryHandler($db, $type) {
	    parent::__construct($db, 'shop_country', 'xshopCountry', 'country_id');
    }   
}
?>