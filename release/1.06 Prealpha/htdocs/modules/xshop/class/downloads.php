<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopDownloads extends XoopsObject 
{
	var $_objects = array();
	
    function __construct()
    {
    	$module_handler = xoops_gethandler('module');
    	$xoModule = $module_handler->getByDirname('xshop');
    	
        $this->initVar('download_id', XOBJ_DTYPE_INT);
        $this->initVar('product_id', XOBJ_DTYPE_INT);
        $this->initVar('path', XOBJ_DTYPE_TXTBOX, DS.$xoModule->getVar('dirname').DS.md5(microtime()).DS, 255);
        $this->initVar('filename', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('mimetype', XOBJ_DTYPE_TXTBOX, false, 128);
        $this->initVar('hits', XOBJ_DTYPE_INT);
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, '', 32);
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
    }
    
    function createFolders() {
    	$this->createPath(XOOPS_VAR_PATH.$this->getVar('path'));
       	return true;	
    }
    
    private function createPath($path){
    	foreach(explode(DS, $path) as $folder) {
    		$folders .= DS.$folder;
    		mkdir($folder, 0777);
    	}
    }
    
    function toArray() {
    	$ret = parent::toArray();
    	$ret['when'] = get_when_associative($this);
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
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = '', $const = '_SHOP_MI_DOWNLOADS') {
    
    	xoops_loadLanguage('forms', 'xshop');
    	    	
    	if (!empty($index))
    		$id = $index . '['. $this->getVar('download_id') . ']';
    	else 
    		$id = $this->getVar('download_id');
    	
    	if ($render == true||$captions==true) {
	    	if (defined($const)&&defined($const.'_LABEL')&&defined($const.'_LABEL_DESC')) {
		    	$frmobj[$cursor]['label'] = new XoopsFormLabel('<font style="font-size:1.25em;">'.constant($const).'</font>', '<font style="font-size:1.25em;">'.sprintf(constant($const.'_LABEL'), constant($const)).'</font>');
		    	$frmobj[$cursor]['label']->setDescription(constant($const.'_LABEL_DESC'));
     		}   
	    	$frmobj[$cursor]['product_id'] = new XShopFormSelectProduct(_SHOP_FRM_DOWNLOADS_PRODUCT,  $id.'[product_id]', $this->getVar('product_id'));
	    	$frmobj[$cursor]['product_id']->setDescription(_SHOP_FRM_DOWNLOADS_PRODUCT_DESC);
	    	$frmobj[$cursor]['path'] = new XoopsFormLabel(_SHOP_FRM_DOWNLOADS_PATH, $this->getVar('path'));
	    	$frmobj[$cursor]['path']->setDescription(_SHOP_FRM_DOWNLOADS_PATH_DESC);
	    	$frmobj[$cursor]['filename'] = new XoopsFormLabel(_SHOP_FRM_DOWNLOADS_FILENAME, $this->getVar('filename'));
	    	$frmobj[$cursor]['filename']->setDescription(_SHOP_FRM_DOWNLOADS_FILENAME_DESC);
	    	$frmobj[$cursor]['mimetype'] = new XoopsFormLabel(_SHOP_FRM_DOWNLOADS_MIMETYPE, $this->getVar('mimetype'));
	    	$frmobj[$cursor]['mimetype']->setDescription(_SHOP_FRM_DOWNLOADS_MIMETYPE_DESC);
	    	$frmobj[$cursor]['hits'] = new XoopsFormLabel(_SHOP_FRM_DOWNLOADS_HITS, $this->getVar('hits'));
	    	$frmobj[$cursor]['hits']->setDescription(_SHOP_FRM_DOWNLOADS_HITS_DESC);
	    	$frmobj[$cursor]['upload'] = new XoopsFormFile(_SHOP_FRM_DOWNLOADS_UPLOAD_FILE, str_replace(']', '', str_replace('[', '_', $id.'[upload]')), $GLOBALS['xoopsModuleConfig']['max_file_size']);
	    	$frmobj[$cursor]['upload']->setDescription(_SHOP_FRM_DOWNLOADS_UPLOAD_FILE_DESC);
	    	if (!empty($index))	
	    		$frmobj[$cursor]['download_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('download_id').']', 'downloads');
	    	else 
	    		$frmobj[$cursor]['download_id'] = new XoopsFormHidden('id['.$this->getVar('download_id').']', 'downloads');
	    	
	    	if ($render==false)
	    		return $frmobj;
	    	if ($_REQUEST['fct']=='downloads') {	
	    		$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    		$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'downloads');
	    	}
    	} else {
    		
	    	$frmobj[$cursor]['product_id'] = new XShopFormSelectProduct('',  $id.'[product_id]', $this->getVar('product_id'));
	    	$frmobj[$cursor]['path'] = new XoopsFormLabel('', $this->getVar('path'));
	    	$frmobj[$cursor]['filename'] = new XoopsFormLabel('', $this->getVar('filename'));
	    	$frmobj[$cursor]['mimetype'] = new XoopsFormLabel('', $this->getVar('mimetype'));
	    	$frmobj[$cursor]['hits'] = new XoopsFormLabel('', $this->getVar('hits'));
	    	$frmobj[$cursor]['upload'] = new XoopsFormFile('', str_replace(']', '', str_replace('[', '_', $id.'[upload]')), $GLOBALS['xoopsModuleConfig']['max_file_size']);
	    	if (!empty($index))	
	    		$frmobj[$cursor]['download_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('download_id').']', 'downloads');
	    	else 
	    		$frmobj[$cursor]['download_id'] = new XoopsFormHidden('id['.$this->getVar('download_id').']', 'downloads');
	    	
    		return $frmobj;
    	}
    	
    	$frmobj['submit']['submit'] = new XoopsFormButton('', _SUBMIT, 'submit', _SUBMIT);
    	
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
	
    function delete($object, $force=true) {
    	unlink(XOOPS_VAR_PATH.$object->getVar('path').$object->getVar('filename'));
    	rmdir(XOOPS_VAR_PATH.$object->getVar('path'));
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