<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopItems extends XoopsObject 
{
	var $_digest = array();
	
    function __construct($type)
    {
        $this->initVar('item_id', XOBJ_DTYPE_INT);
        $this->initVar('languages', XOBJ_DTYPE_ARRAY, ARRAY($GLOBALS['xoopsConfig']['language']));
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
        
    }
    
    function retrieveDigest($language) {
    	$criteria = new CriteriaCompo(new Criteria('item_id', $this->getVar('item_id')));
    	if (in_array($language, $this->getVar('languages'))) {
    		$criteria->getVar('language', $language);
    	} else {
    		$criteria->getVar('language', $GLOBALS['xoopsModuleConfig']['default_language']);
    	}
    	$itemdigest_handler =& xoops_getmodulehandler('items_digest', 'xshop');
    	$obj = $itemdigest_handler->getObjects($criteria, false);
    	if (is_object($obj[0])) {
    		$this->_digest = $obj[0]; 
    	}
    	return $this->_digest;
    }
}

class xshopItemsHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopItemsHandler($db, $type) {
	    parent::__construct($db, 'shop_items', 'xshopItems', 'item_id');
    }   
    
    function insert($object, $language = '', $force = true) {
    	
    	if ($object->isNew()) {
    		$object->setVar('created', time());
    	} else {
    		$object->setVar('updated', time());
    	}
    	return parent::insert($object, $force);
	}
}
?>