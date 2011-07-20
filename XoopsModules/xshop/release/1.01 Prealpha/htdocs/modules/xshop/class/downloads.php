<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopDownloads extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('download_id', XOBJ_DTYPE_INT);
        $this->initVar('product_id', XOBJ_DTYPE_INT);
        $this->initVar('path', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('filename', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('mimetype', XOBJ_DTYPE_TXTBOX, false, 128);
        $this->initVar('hits', XOBJ_DTYPE_INT);
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, '', 32);
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
        
        
    }
}

class xshopDownloadsHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopDownloadsHandler($db, $type) {
	    parent::__construct($db, 'shop_downloads', 'xshopDownloads', 'download_id');
    }   
    
    function insert($object, $force = true) {
    	
    	if ($object->isNew()) {
    		$object->setVar('created', time());
    	} else {
    		$object->setVar('updated', time());
    	}

    	if (file_exists(XOOPS_VAR_PATH.$this->getVar('path').$this->getVar('filename'))) {
			$object->setVar('md5', md5_file(XOOPS_VAR_PATH.$this->getVar('path').$this->getVar('filename')));
    	}
    	
    	return parent::insert($object, $force);
	}
}
?>