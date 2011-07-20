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
}

class xshopRegionHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopRegionHandler($db, $type) {
	    parent::__construct($db, 'shop_regions', 'xshopRegion', 'region_id');
    }   
}
?>