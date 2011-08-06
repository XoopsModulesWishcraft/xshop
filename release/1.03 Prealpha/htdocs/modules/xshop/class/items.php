<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopItems extends XoopsObject 
{
	var $_digest = array();
	
    function __construct($type)
    {
        $this->initVar('item_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('languages', XOBJ_DTYPE_ARRAY, ARRAY($GLOBALS['xoopsConfig']['language']));
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
        
    }
    
    function toArray() {
    	$ret = parent::toArray();
    	$ret['when'] = get_when_associative($this);
    	
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
    
    
    function retrieveDigest($language) {
    	$criteria = new CriteriaCompo(new Criteria('item_id', $this->getVar('item_id')));
    	if (in_array($language, $this->getVar('languages'))) {
    		$criteria->add(new Criteria('language', $language));
    	} else {
    		$criteria->add(new Criteria('language', $GLOBALS['xoopsModuleConfig']['language']));
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