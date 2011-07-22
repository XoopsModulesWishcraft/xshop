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
    
    function toArray() {
    	$ret = parent::toArray();
    	$ret['when'] = get_when_associative($this);
       	$frms = $this->getForm($_SERVER['QUERY_STRING'], false, false, 'base', array());
    	foreach($frms as $key => $value) {
    		if ($key!='required') {
   	 			foreach($value as $field => $valueb) {
	    		    $ret['forms'][$key][$field] = $frms[$key][$field]->render();
    			}
    		}
    	}
    	return $ret;
    }
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array()) {
    
    	xoops_loadLanguage('forms', 'xshop');
    	    	
    	if (!empty($index))
    		$id = $index . '['. $this->getVar('download_id') . ']';
    	else 
    		$id = $this->getVar('download_id');
    	
    	if ($render = true||$captions==true) {
	    	
	    	$frmobj[$cursor]['product_id'] = new XoopsFormSelectProduct(_SHOP_FRM_DOWNLOADS_PRODUCT,  $id.'[product_id]', $this->getVar('product_id'));
	    	$frmobj[$cursor]['product_id']->setDescription(_SHOP_FRM_DOWNLOADS_PRODUCT_DESC);
	    	$frmobj[$cursor]['path'] = new XoopsFormLabel(_SHOP_FRM_DOWNLOADS_PATH, $this->getVar('path'));
	    	$frmobj[$cursor]['path']->setDescription(_SHOP_FRM_DOWNLOADS_PATH_DESC);
	    	$frmobj[$cursor]['filename'] = new XoopsFormLabel(_SHOP_FRM_DOWNLOADS_FILENAME, $this->getVar('filename'));
	    	$frmobj[$cursor]['filename']->setDescription(_SHOP_FRM_DOWNLOADS_FILENAME_DESC);
	    	$frmobj[$cursor]['mimetype'] = new XoopsFormLabel(_SHOP_FRM_DOWNLOADS_MIMETYPE, $this->getVar('mimetype'));
	    	$frmobj[$cursor]['mimetype']->setDescription(_SHOP_FRM_DOWNLOADS_MIMETYPE_DESC);
	    	$frmobj[$cursor]['hits'] = new XoopsFormLabel(_SHOP_FRM_DOWNLOADS_HITS, $this->getVar('hits'));
	    	$frmobj[$cursor]['hits']->setDescription(_SHOP_FRM_DOWNLOADS_HITS_DESC);
	    	$frmobj[$cursor]['upload'] = new XoopsFormFile(_SHOP_FRM_DOWNLOADS_UPLOAD_FILE, $id.'[upload]', $GLOBALS['xoopsModuleConfig']['max_file_size']);
	    	$frmobj[$cursor]['upload']->setDescription(_SHOP_FRM_DOWNLOADS_UPLOAD_FILE_DESC);
	    	if (!empty($index))	
	    		$frmobj[$cursor]['download_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('download_id').']', 'downloads');
	    	else 
	    		$frmobj[$cursor]['download_id'] = new XoopsFormHidden('id['.$this->getVar('download_id').']', 'downloads');
	    	
	    	if ($render==false)
	    		return $frmobj;
	    		
	    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'downloads');
    	} else {
    		
	    	$frmobj[$cursor]['product_id'] = new XoopsFormSelectProduct('',  $id.'[product_id]', $this->getVar('product_id'));
	    	$frmobj[$cursor]['path'] = new XoopsFormLabel('', $this->getVar('path'));
	    	$frmobj[$cursor]['filename'] = new XoopsFormLabel('', $this->getVar('filename'));
	    	$frmobj[$cursor]['mimetype'] = new XoopsFormLabel('', $this->getVar('mimetype'));
	    	$frmobj[$cursor]['hits'] = new XoopsFormLabel('', $this->getVar('hits'));
	    	$frmobj[$cursor]['upload'] = new XoopsFormFile('', $id.'[upload]', $GLOBALS['xoopsModuleConfig']['max_file_size']);
	    	if (!empty($index))	
	    		$frmobj[$cursor]['download_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('download_id').']', 'downloads');
	    	else 
	    		$frmobj[$cursor]['download_id'] = new XoopsFormHidden('id['.$this->getVar('download_id').']', 'downloads');
	    	
    		return $frmobj;
    	}
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_DOWNLOAD, 'download', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_DOWNLOAD, 'download', $_SERVER['PHP_SELF'], 'post');
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