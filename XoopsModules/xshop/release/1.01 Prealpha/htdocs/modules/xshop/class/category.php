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
    
	function getForm($querystring, $render = true) {
    	xoops_loadLanguage('forms', 'xshop');
    	
    	$items_digest_handler =& xoops_getmodulehandler('items_digest', 'xshop');
    	$digest = $items_digest_handler->getItem($this->getVar('item_id'));
    	
    	$id = $this->getVar('cat_id');
    	if ($render = true) {
	    	$frmobj = array();
	    	$frmobj['parent_id'] = new XoopsFormText(_SHOP_FRM_CATEGORY_PARENT_ID, $id.'[parent_id]', $this->getVar('parent_id'), 1, false, $id);
	    	$frmobj['parent_id']->setDescription(_SHOP_FRM_CATEGORY_PARENT_ID_DESC);
	    	$frmobj = array_merge($frmobj, $digest->getForm($querystring, true, false, $id.'[item]'));
	    	$frmobj['has_item'] = new XoopsFormHidden('hasItem', true);
	    	$frmobj['logo_picture_id'] = new XoopsFormFile(_SHOP_FRM_CATEGORY_NEW_LOGO, $id.'[logo_picture_id]', $GLOBALS['xoopsModuleConfig']['max_upload_size']);
	    	$frmobj['logo_picture_id']->setDescription(_SHOP_FRM_CATEGORY_NEW_LOGO_DESC);
	    	$frmobj['cat_id'] = new XoopsFormHidden('id['.$id.']', 'category');
	    	$frmobj['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj['fct'] = new XoopsFormHidden('fct', 'category');
    	} else {
    		$frmobj = array();
	    	$frmobj['parent_id'] = new XoopsFormText('', $id.'[parent_id]', $this->getVar('parent_id'), 1, false, $id);
	    	$frmobj = array_merge($frmobj, $digest->getForm($querystring, false, false, $id.'[item]'));
	    	$frmobj['has_item'] = new XoopsFormHidden('hasItem', true);
	    	$frmobj['cat_id'] = new XoopsFormHidden('id['.$id.']', 'category');
	    	$frmobj['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj['fct'] = new XoopsFormHidden('fct', 'category');
	    	return $frmobj;
    	}
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_CATEGORY, 'category', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_CATEGORY, 'category', $_SERVER['PHP_SELF'], 'post');
    	}

    	$required = array('menu_title', 'menu_description');
    	
    	foreach($frmobj as $key => $value) {
    		if (!in_array($key, $required)) {
    			$form->addElement($frmobj[$key], false);
    		} else {
    			$form->addElement($frmobj[$key], true);
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