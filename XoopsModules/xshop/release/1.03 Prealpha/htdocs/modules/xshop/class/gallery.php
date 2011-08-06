<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopGallery extends XoopsObject 
{
	var $_objects = array();
	
    function __construct($type)
    {
    	$module_handler = xoops_gethandler('module');
    	$xoModule = $module_handler->getByDirname('xshop');
    	
        $this->initVar('picture_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_GALLERY_PRODUCT', false, false, false, array('_SHOP_MI_GALLERY_CAT_LOGO','_SHOP_MI_GALLERY_MANU_LOGO','_SHOP_MI_GALLERY_PRODUCT','_SHOP_MI_GALLERY_SHOP_LOGO','_SHOP_MI_GALLERY_SHIPPING_LOGO','_SHOP_MI_GALLERY_DISCOUNT_LOGO','_SHOP_MI_GALLERY_ORDER_LOGO','_SHOP_MI_GALLERY_WATERMARK'));
        $this->initVar('shipping_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('product_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('cat_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('manu_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('shop_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('item_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('weight', XOBJ_DTYPE_INT, 0);
        $this->initVar('path', XOBJ_DTYPE_TXTBOX, DS.$xoModule->getVar('dirname').DS.md5(microtime()).DS.'orginal'.DS, 255);
        $this->initVar('thumbnail_path', XOBJ_DTYPE_TXTBOX, DS.$xoModule->getVar('dirname').DS.md5(microtime()).DS.'thumbnaill'.DS, 255);
        $this->initVar('filename', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('width', XOBJ_DTYPE_INT, 0);
        $this->initVar('height', XOBJ_DTYPE_INT, 0);
        $this->initVar('extension', XOBJ_DTYPE_TXTBOX, false, 5);
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, '', 32);
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
        $this->initVar('actioned', XOBJ_DTYPE_INT);
        
    }
    
    function toArray() {
    	$ret = parent::toArray();
    	$ret['when'] = get_when_associative($this);
    	$ret['product'] = get_product_id($this->getVar('product_id'));
    	$ret['cat'] = get_cat_id($this->getVar('cat_id'));
    	$ret['manu'] = get_manufacture_id($this->getVar('manu_id'));
    	$ret['shop'] = get_shop_id($this->getVar('shop_id'));
    	$ret['item'] = get_item_id($this->getVar('item_id'));
    	$ret['picture'] = get_picture_id($this->getVar('picture_id'));
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

    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = '', $const = '_SHOP_MI_GALLERY') {
    
    	xoops_loadLanguage('forms', 'xshop');
    	    	
    	$items_digest_handler =& xoops_getmodulehandler('items_digest', 'xshop');
    	$digest = $items_digest_handler->getItem($this->getVar('item_id'));
    	    	
    	if (!empty($index))
    		$id = $index . '['. $this->getVar('picture_id') . ']';
    	else 
    		$id = $this->getVar('picture_id');
    	
    	if ($render = true||$captions==true) {
    		if (defined($const)&&defined($const.'_LABEL')&&defined($const.'_LABEL_DESC')) {
		    	$frmobj[$cursor]['label'] = new XoopsFormLabel('<font style="font-size:1.25em;">'.constant($const).'</font>', '<font style="font-size:1.25em;">'.sprintf(constant($const.'_LABEL'), constant($const)).'</font>');
		    	$frmobj[$cursor]['label']->setDescription(constant($const.'_LABEL_DESC'));
     		}   	    	
	    	$frmobj[$cursor]['type'] = new XShopFormSelectGalleryType(_SHOP_FRM_GALLERY_TYPE,  $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_GALLERY_TYPE_DESC);
	    	$frmobj[$cursor]['weight'] = new XoopsFormText(_SHOP_FRM_GALLERY_WEIGHT, $id.'[weight]', 10, 15, $this->getVar('weight'));
	    	$frmobj[$cursor]['weight']->setDescription(_SHOP_FRM_GALLERY_WEIGHT_DESC);
	    	$frmobj = $digest->getForm($querystring, true, false, $id.'[item]','item',$frmobj);
	    	$frmobj[$cursor]['path'] = new XoopsFormLabel(_SHOP_FRM_GALLERY_PATH, $this->getVar('path'));
	    	$frmobj[$cursor]['path']->setDescription(_SHOP_FRM_GALLERY_PATH_DESC);
	    	$frmobj[$cursor]['filename'] = new XoopsFormLabel(_SHOP_FRM_GALLERY_FILENAME, $this->getVar('filename'));
	    	$frmobj[$cursor]['filename']->setDescription(_SHOP_FRM_GALLERY_FILENAME_DESC);
	    	$frmobj[$cursor]['width'] = new XoopsFormLabel(_SHOP_FRM_GALLERY_WIDTH, $this->getVar('width'));
	    	$frmobj[$cursor]['width']->setDescription(_SHOP_FRM_GALLERY_WIDTH_DESC);
	    	$frmobj[$cursor]['height'] = new XoopsFormLabel(_SHOP_FRM_GALLERY_HEIGHT, $this->getVar('height'));
	    	$frmobj[$cursor]['height']->setDescription(_SHOP_FRM_GALLERY_HEIGHT_DESC);
	    	$frmobj[$cursor]['extension'] = new XoopsFormLabel(_SHOP_FRM_GALLERY_EXTENSION, $this->getVar('extension'));
	    	$frmobj[$cursor]['extension']->setDescription(_SHOP_FRM_GALLERY_EXTENSION_DESC);
	    	$frmobj[$cursor]['upload'] = new XoopsFormFile(_SHOP_FRM_GALLERY_UPLOAD_FILE, str_replace(array('[', ']'), array('_', ''), $id.'[upload]'), $GLOBALS['xoopsModuleConfig']['max_file_size']);
	    	$frmobj[$cursor]['upload']->setDescription(_SHOP_FRM_GALLERY_UPLOAD_FILE_DESC);
	    	if (!empty($index))	
	    		$frmobj[$cursor]['picture_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('picture_id').']', 'gallery');
	    	else 
	    		$frmobj[$cursor]['picture_id'] = new XoopsFormHidden('id['.$this->getVar('picture_id').']', 'gallery');
	    	
	    	if ($render==false)
	    		return $frmobj;
	    	
	    	if ($_REQUEST['fct']=='gallery') {	
	    		$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    		$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'gallery');
	    	}
    	} else {
    	
	    	$frmobj[$cursor]['type'] = new XShopFormSelectGalleryType('',  $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['weight'] = new XoopsFormText('', $id.'[weight]', 10, 15, $this->getVar('weight'));
	    	$frmobj = $digest->getForm($querystring, false, false, $id.'[item]', 'item', $frmobj);
	    	$frmobj[$cursor]['path'] = new XoopsFormLabel('', $this->getVar('path'));
	    	$frmobj[$cursor]['filename'] = new XoopsFormLabel('', $this->getVar('filename'));
	    	$frmobj[$cursor]['width'] = new XoopsFormLabel('', $this->getVar('width'));
	    	$frmobj[$cursor]['height'] = new XoopsFormLabel('', $this->getVar('height'));
	    	$frmobj[$cursor]['extension'] = new XoopsFormLabel('', $this->getVar('extension'));
	    	$frmobj[$cursor]['upload'] = new XoopsFormFile('', str_replace(array('[', ']'), array('_', ''), $id.'[upload]'), $GLOBALS['xoopsModuleConfig']['max_file_size']);
	    	if (!empty($index))	
	    		$frmobj[$cursor]['picture_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('picture_id').']', 'gallery');
	    	else 
	    		$frmobj[$cursor]['picture_id'] = new XoopsFormHidden('id['.$this->getVar('picture_id').']', 'gallery');
	    	
    		return $frmobj;
    	}
    	
    	$frmobj['submit']['submit'] = new XoopsFormButton('', _SUBMIT, 'submit', _SUBMIT);
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_GALLERY, 'gallery', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_GALLERY, 'gallery', $_SERVER['PHP_SELF'], 'post');
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
    
    function runPreInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
		if (defined('_PLUGIN'.$this->getVar('type'))) 
			$func = constant('_PLUGIN'.$this->getVar('type')).'PreInsert';
		
		if (function_exists($func))  {
			@$func($this);
		}

		return true;
	}
	
    function runPostInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
		if (defined('_PLUGIN'.$this->getVar('type'))) 
			$func = constant('_PLUGIN'.$this->getVar('type')).'PostInsert';
		
		if (function_exists($func))  {
			@$func($this);
		}
	
		return true;
	}
	
    function runPostGetPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
		if (defined('_PLUGIN'.$this->getVar('type'))) 
			$func = constant('_PLUGIN'.$this->getVar('type')).'PostGet';
		
		if (function_exists($func))  {
			@$func($this);
		}
		
		return true;
	}    
}

class xshopGalleryHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopGalleryHandler($db, $type) {
	    parent::__construct($db, 'shop_gallery', 'xshopGallery', 'picture_id');
    }   
    
    function insert($object, $force = true) {
    	
    	if ($object->isNew()) {
    		$object->setVar('created', time());
    		if (file_exists(XOOPS_UPLOAD_PATH.$this->getVar('path').$this->getVar('filename'))) {
	    		$criteria = new Criteria('md5', md5_file(XOOPS_UPLOAD_PATH.$this->getVar('path').$this->getVar('filename')));
	    		if (parent::getCount($criteria)) {
	    			foreach(parent::getObjects($criteria, true) as $id => $item)	   			
	    				return $id; 
	    		}
				$object->setVar('md5', md5_file(XOOPS_UPLOAD_PATH.$this->getVar('path').$this->getVar('filename')));
    		}    		
    	} else {
    		$object->setVar('updated', time());		
    		if (file_exists(XOOPS_UPLOAD_PATH.$this->getVar('path').$this->getVar('filename'))) {
    			$object->setVar('md5', md5_file(XOOPS_UPLOAD_PATH.$this->getVar('path').$this->getVar('filename')));
    		}
    	}
    	
    	$run_plugin = false;
    	if ($object->vars['type']['changed']==true) {	
			$object->setVar('actioned', time());
			$run_plugin = true;
		}

		if ($run_plugin == true) {
			@$object->runPreInsertPlugin();
			$id = parent::insert($object, $force);
			$object = parent::get($id);
			@$object->runPostInsertPlugin();
			return $id;
		} else {
			return parent::insert($object, $force);
		}
    }
    
	function get($id=0, $fields='*') {
    	$obj = parent::get($id, $fields);
    	@$obj->runPostGetPlugin();
    	return $obj;
    }
    
    function getObject($criteria, $id_as_key=false, $object=true) {
    	$objs = parent::getObjects($criteria, $id_as_key=false, $object=true);
    	foreach($objs as $key => $obj) {
    		@$objs[$key]->runPostGetPlugin();
    	}
    	return $objs;
    }
    
    function delete($object, $force=true) {
    	unlink(XOOPS_UPLOAD_PATH.$object->getVar('path').$object->getVar('filename'));
    	unlink(XOOPS_UPLOAD_PATH.$object->getVar('thumbnail_path').$object->getVar('filename'));
    	rmdir(XOOPS_UPLOAD_PATH.$object->getVar('thumbnail_path'));
    	rmdir(XOOPS_UPLOAD_PATH.$object->getVar('path'));
    	rmdir(basename(XOOPS_UPLOAD_PATH.$object->getVar('path')));
    	rmdir(basename(basename(XOOPS_UPLOAD_PATH.$object->getVar('path'))));
    	return parent::delete($object, $force);
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
}
?>