<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopGallery extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('picture_id', XOBJ_DTYPE_INT);
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_GALLERY_PRODUCT', false, false, false, array('_SHOP_MI_GALLERY_CAT_LOGO','_SHOP_MI_GALLERY_MANU_LOGO','_SHOP_MI_GALLERY_PRODUCT','_SHOP_MI_GALLERY_SHOP_LOGO','_SHOP_MI_GALLERY_SHIPPING_LOGO','_SHOP_MI_GALLERY_DISCOUNT_LOGO','_SHOP_MI_GALLERY_ORDER_LOGO','_SHOP_MI_GALLERY_WATERMARK'));
        $this->initVar('shipping_id', XOBJ_DTYPE_INT);
        $this->initVar('product_id', XOBJ_DTYPE_INT);
        $this->initVar('cat_id', XOBJ_DTYPE_INT);
        $this->initVar('manu_id', XOBJ_DTYPE_INT);
        $this->initVar('shop_id', XOBJ_DTYPE_INT);
        $this->initVar('item_id', XOBJ_DTYPE_INT);
        $this->initVar('weight', XOBJ_DTYPE_INT);
        $this->initVar('path', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('filename', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('width', XOBJ_DTYPE_INT);
        $this->initVar('height', XOBJ_DTYPE_INT);
        $this->initVar('extension', XOBJ_DTYPE_TXTBOX, false, 5);
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, '', 32);
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
        $this->initVar('actioned', XOBJ_DTYPE_INT);
        
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
}
?>