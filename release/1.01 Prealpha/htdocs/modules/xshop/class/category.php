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

class xshopCategory extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('cat_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('parent_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('item_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('logo_picture_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('uid', XOBJ_DTYPE_INT, 0);
        $this->initVar('rating', XOBJ_DTYPE_DECIMAL, 0);
        $this->initVar('votes', XOBJ_DTYPE_INT, 0);
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
        
    }
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array()) {
    	xoops_loadLanguage('forms', 'xshop');

    	$frmobj['required'][] = 'menu_title';
		$frmobj['required'][] = 'menu_description';
    	
    	$items_digest_handler =& xoops_getmodulehandler('items_digest', 'xshop');
    	$digest = $items_digest_handler->getItem($this->getVar('item_id'));
    	
    	if (!empty($index))
    		$id = $index . '['. $this->getVar('cat_id') . ']';
    	else 
    		$id = $this->getVar('cat_id');
    	
    	if ($render == true||$captions==true) {
	       	$frmobj[$cursor]['parent_id'] = new XoopsFormText(_SHOP_FRM_CATEGORY_PARENT_ID, $id.'[parent_id]', $this->getVar('parent_id'), 1, false, $this->getVar('cat_id'));
	    	$frmobj[$cursor]['parent_id']->setDescription(_SHOP_FRM_CATEGORY_PARENT_ID_DESC);
	    	$frmobj = $digest->getForm($querystring, true, false, $id.'[item]', 'item', $frmobj);
	    	$frmobj[$cursor]['has_item'] = new XoopsFormHidden('hasItem', true);
	    	$frmobj[$cursor]['logo_picture_id'] = new XoopsFormFile(_SHOP_FRM_CATEGORY_NEW_LOGO, $id.'[logo_picture_id]', $GLOBALS['xoopsModuleConfig']['max_upload_size']);
	    	$frmobj[$cursor]['logo_picture_id']->setDescription(_SHOP_FRM_CATEGORY_NEW_LOGO_DESC);
	    	if (!empty($index))	
	    		$frmobj[$cursor]['cat_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('cat_id').']', 'category');
	    	else 
	    		$frmobj[$cursor]['cat_id'] = new XoopsFormHidden('id['.$this->getVar('cat_id').']', 'category');
	    	
	    	if ($render==false)
	    		return $frmobj;
	    		
	    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'category');
    	} else {
    	  	$frmobj[$cursor]['parent_id'] = new XoopsFormText('', $id.'[parent_id]', $this->getVar('parent_id'), 1, false, $this->getVar('cat_id'));
	    	$frmobj = $digest->getForm($querystring, false, false, $id.'[item]', 'item', $frmobj);
	    	$frmobj[$cursor]['has_item'] = new XoopsFormHidden('hasItem', true);
	    	if (!empty($index))	
	    		$frmobj[$cursor]['cat_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('cat_id').']', 'category');
	    	else 
	    		$frmobj[$cursor]['cat_id'] = new XoopsFormHidden('id['.$this->getVar('cat_id').']', 'category');
	    	
	    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'category');
	    	return $frmobj;
    	}
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_CATEGORY, 'category', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_CATEGORY, 'category', $_SERVER['PHP_SELF'], 'post');
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

class xshopCategoryHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopCategoryHandler($db, $type) {
	    parent::__construct($db, 'shop_category', 'xshopCategory', 'cat_id');
    }   
    
    function insert($object, $force = true) {
    	
    	if ($object->isNew()) {
    		$object->setVar('created', time());
    		if (is_object($GLOBALS['xoopsUser']))
    			$object->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
    	} else {
    		$object->setVar('updated', time());
    	}
    	
    	return parent::insert($object, $force);
	}
}
?>