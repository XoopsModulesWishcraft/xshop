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
	var $_objects = array();
	
    function __construct()
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
    
    function getTitle($long=false) {
    	$item = get_item_id($this->getVar('item_id'));
    	if (!empty($item['long_title'])&&$long==true)
    		return $item['long_title'];
    	else 
    		return $item['menu_title'];
    }
    
	function toArray() {
    	$ret = parent::toArray();
    	$ret['when'] = get_when_associative($this);
    	$ret['picture'] = get_picture_id($this->getVar('logo_picture_id'));
    	$ret['item'] = get_item_id($this->getVar('item_id'));
    	$ret['user']['uid'] = get_users_id($this->getVar('uid'));
    	$ret['rank'] = number_format($this->getVar('rating')/$this->getVar('votes')*100,2).'%';
    	$frms = $this->getForm($_SERVER['QUERY_STRING'], false, false, '', 'base', array());
    	foreach($frms as $key => $value) {
    		if ($key!='required') {
   	 			foreach($value as $field => $valueb) {
	    		    $ret['forms'][$key][$field] = $frms[$key][$field]->render();
    			}
    		}
    	}
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

    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array(), $const = '_SHOP_MI_CATEGORY') {
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
    		if (defined($const)&&defined($const.'_LABEL')&&defined($const.'_LABEL_DESC')) {
		    	$frmobj[$cursor]['label'] = new XoopsFormLabel('<font style="font-size:1.25em;">'.constant($const).'</font>', '<font style="font-size:1.25em;">'.sprintf(constant($const.'_LABEL'), constant($const)).'</font>');
		    	$frmobj[$cursor]['label']->setDescription(constant($const.'_LABEL_DESC'));
     		}    		
	       	$frmobj[$cursor]['parent_id'] = new XShopFormSelectCategory(_SHOP_FRM_CATEGORY_PARENT_ID, $id.'[parent_id]', $this->getVar('parent_id'), 1, false, $this->getVar('cat_id'));
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
	    	
	    	if ($_REQUEST['fct']=='category') {	
		    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
		    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'category');
	    	}
    	} else {
    	  	$frmobj[$cursor]['parent_id'] = new XShopFormSelectCategory('', $id.'[parent_id]', $this->getVar('parent_id'), 1, false, $this->getVar('cat_id'));
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
    	
    	$frmobj['submit']['submit'] = new XoopsFormButton('', _SUBMIT, 'submit', _SUBMIT);
    	
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
	
    function getFilterCriteria($filter) {
    	$parts = explode('|', $filter);
    	$criteria = new CriteriaCompo();
    	foreach($parts as $part) {
    		$var = explode(',', $part);
    		if (!empty($var[1])&&!is_numeric($var[0])) {
    			$object = $this->create();
    			if (		$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTBOX || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_TXTAREA) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%'.$var[1].'%', (isset($var[2])?$var[2]:'LIKE')));
    			} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_INT || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_DECIMAL || 
    						$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_FLOAT ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));			
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ENUM ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', $var[1], (isset($var[2])?$var[2]:'=')));    				
				} elseif (	$object->vars[$var[0]]['data_type']==XOBJ_DTYPE_ARRAY ) 	{
    				$criteria->add(new Criteria('`'.$var[0].'`', '%"'.$var[1].'";%', (isset($var[2])?$var[2]:'LIKE')));    				
				}
    		} elseif (!empty($var[1])&&is_numeric($var[0])) {
    			$criteria->add(new Criteria("'".$var[0]."'", $var[1]));
    		}
    	}
    	return $criteria;
    }
        
	function getFilterForm($filter, $field, $sort='created', $fct = '') {
    	$ele = xshop_getFilterElement($filter, $field, $sort, $fct);
    	if (is_object($ele))
    		return $ele->render();
    	else 
    		return '&nbsp;';
    }
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array(), $id=0) {
    	if ($id==0) {
    		$object = $this->create();
    	} else { 
    		$object = $this->get($id);
    	}
    	return $object->getForm($querystring, $captions, $render, $index, $cursor, $frmobj);
    }    
    
 	function renderSmarty($cat_id) {
    	if ($cat_id>0)
    		$criteria = new CriteriaCompo(new Criteria('parent_id', $cat_id));
    	else { 
    		$criteria = new CriteriaCompo(new Criteria('parent_id', '0'));
    	}
    	$items_digest_handler = xoops_getmodulehandler('items_digest', 'xshop');
    	$objs = parent::getObjects($criteria, true);
    	$ret = array();
    	$id = array();
    	foreach($objs as $cat_id => $category) {
    		if (!in_array($cat_id, $id)) {
	    		$id[] = $cat_id;
	    		$item = $items_digest_handler->getItem($category->getVar('item_id'));
	    		$ret[$cat_id]['cat_id'] = $cat_id;
	    		$ret[$cat_id]['name'] = $item->getVar('menu_title');
	    		$ret[$cat_id]['rank'] = number_format($category->getVar('rating')/$category->getVar('votes')*100,2).'%';	
	    		$ret[$cat_id]['subitems'] = parent::getCount(new Criteria('parent_id', $cat_id));
	    		if ($ret[$cat_id]['subitems']>0) {
	    			foreach(parent::getObjects(new Criteria('parent_id', $cat_id), true) as $scat_id => $scategory) {
	    				if (!in_array($scat_id, $id)) {
	    					$id[] = $scat_id;
	    					$item = $items_digest_handler->getItem($scategory->getVar('item_id'));
		    				$ret[$cat_id]['subcategories'][$scat_id]['cat_id'] = $scat_id;
		    				$ret[$cat_id]['subcategories'][$scat_id]['name'] = $item->getVar('menu_title');
		    				$ret[$cat_id]['subcategories'][$scat_id]['rank'] = number_format($scategory->getVar('rating')/$scategory->getVar('votes')*100,2).'%';;
	    				}
	    			}
	    		}
    		}
    	}
    	return $ret;
    }
    
    function getIn($cat_id=0, $shop_id=0, $manu_id=0, $product_id=0) {
    	$products_handler = xoops_getmodulehandler('products', 'xshop');
    	$criteria = new CriteriaCompo();
        if($cat_id!=0&&!is_array($cat_id)) {
    		$criteria->add(new Criteria('cat_id', $cat_id));
    	} elseif (is_array($cat_id)) {
    		$criteria->add(new Criteria('cat_id', '('.implode(',',$cat_id).')', 'IN'));
    	}
    	if($shop_id!=0&&!is_array($shop_id)) {
    		$criteria->add(new Criteria('shop_id', $shop_id));
    	} elseif (is_array($shop_id)) {
    		$criteria->add(new Criteria('shop_id', '('.implode(',',$shop_id).')', 'IN'));
    	}
    	if($manu_id!=0&&!is_array($manu_id)) {
    		$criteria->add(new Criteria('manu_id', $manu_id));
    	} elseif (is_array($manu_id)) {
    		$criteria->add(new Criteria('manu_id', '('.implode(',',$manu_id).')', 'IN'));
    	}
    	if($product_id!=0&&!is_array($product_id)) {
    		$criteria->add(new Criteria('product_id', $product_id));
    	} elseif (is_array($product_id)) {
    		$criteria->add(new Criteria('product_id', '('.implode(',',$product_id).')', 'IN'));
    	}
    	$ret = array();
    	$groupperm_handler = xoops_gethandler('groupperm');
    	if (is_object($GLOBALS['xoopsUser']))
    		$groups = $GLOBALS['xoopsUser']->getGroups();
    	else 
    		$groups = XOOPS_GROUP_ANONYMOUS;
    		
    	foreach($products_handler->getObjects($criteria, true) as $key => $object) {
    		if ($groupperm_handler->checkRight('view_category', $object->getVar('cat_id'), $groups, $GLOBALS['xoopsModule']->getVar('mid')))
    			$ret[$object->getVar('cat_id')] = $object->getVar('cat_id');
    	}
    	return $ret;
    }
}
?>