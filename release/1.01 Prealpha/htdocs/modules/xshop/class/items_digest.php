<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopItems_disgest extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('lang_item_id', XOBJ_DTYPE_INT);
        $this->initVar('item_id', XOBJ_DTYPE_INT);
        $this->initVar('uid', XOBJ_DTYPE_INT);
        $this->initVar('product_id', XOBJ_DTYPE_INT);
        $this->initVar('manu_id', XOBJ_DTYPE_INT);
        $this->initVar('cat_id', XOBJ_DTYPE_INT);
        $this->initVar('discount_id', XOBJ_DTYPE_INT);
        $this->initVar('shipping_id', XOBJ_DTYPE_INT);
        $this->initVar('days_id', XOBJ_DTYPE_INT);
        $this->initVar('picture_id', XOBJ_DTYPE_INT);
        $this->initVar('order_id', XOBJ_DTYPE_INT);
        $this->initVar('currency_id', XOBJ_DTYPE_INT);
        $this->initVar('shop_id', XOBJ_DTYPE_INT);
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, false, 32);
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_ITEMS_BOTHITEMS', false, false, false, array('_SHOP_MI_ITEMS_MENUITEMS','_SHOP_MI_ITEMS_LONGITEMS','_SHOP_MI_ITEMS_BOTHITEMS','_SHOP_MI_ITEMS_RSSITEM','_SHOP_MI_ITEMS_RSSANDLONGITEM','_SHOP_MI_ITEMS_ALLITEMS'));
        $this->initVar('language', XOBJ_DTYPE_TXTBOX, $GLOBALS['xoopsConfig']['language'], 64);
        $this->initVar('menu_title', XOBJ_DTYPE_TXTBOX, false, 128);
        $this->initVar('long_title', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('rss_title', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('menu_subtitle', XOBJ_DTYPE_TXTBOX, false, 128);
        $this->initVar('long_subtitle', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('menu_description', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('long_description', XOBJ_DTYPE_TXTBOX, false);
        $this->initVar('rss_description', XOBJ_DTYPE_TXTBOX, false);
        $this->initVar('meta_description', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('meta_keywords', XOBJ_DTYPE_TXTBOX, false, 255);
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

class xshopItems_disgestHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopItems_disgestHandler($db, $type) {
	    parent::__construct($db, 'shop_items_digest', 'xshopItems_disgest', 'lang_item_id');
    }

    function insert($object, $item_id = 0, $language = '', $force = true) {
    	
    	if ($language==''||empty($language))
    		$language = $GLOBALS['xoopsConfig']['language'];
    		
    	if ($object->isNew()) {
    		$object->setVar('created', time());
    		$criteria = new Criteria('md5', xshop_md5calc($object));
    		if (parent::getCount($criteria)) {
    			foreach(parent::getObjects($criteria, true) as $id => $item)	   			
    				return $id; 
    		}
			$object->setVar('md5', xshop_md5calc($object));    		
			if ($item_id==0) {
				$items_handler =& xoops_getmodulehandler('items', 'xshop');
				$item = $items_handler->create();
				$item_id = $items_handler->insert($item);
			}
			if ($object->getVar('item_id')==0){
				$object->setVar('item_id', $item_id);
			}
			if ($object->getVar('language')!=$language){
				$object->setVar('language', $language);
			}
			$items_handler =& xoops_getmodulehandler('items', 'xshop');
			$item = $items_handler->get($object->getVar('item_id'));
			if (!in_array($language, $item->getVar('languages'))) {
				$item->setVar('languages', array_merge($item->getVar('languages'), array($language=>$language)));
				$item_id = $items_handler->insert($item);
			}
    	} else {
    		if ($object->getVar('language')!=$language) {
    			$criteria = new CriteriaCompo(new Criteria('item_id', $item_id));
    			$criteria->add(new Criteria('language', $language));
    			$obj = $this->getObjects($criteria, false);
    			if (!is_object($obj[0])) {
    				$oldobj = $object;
    				$object = $this->create();
    				$object->setVars($oldobj->toArray());
    				unset($oldobj);
    				$object->setVar('item_id', 0);
    				$object->setVar('language', $language);
	    			$object->setVar('created', time());
		    		$criteria = new Criteria('md5', xshop_md5calc($object));
		    		if (parent::getCount($criteria)) {
		    			foreach(parent::getObjects($criteria, true) as $id => $item)	   			
		    				return $id; 
		    		}
					$object->setVar('md5', xshop_md5calc($object));    		
					if ($item_id==0) {
						$items_handler =& xoops_getmodulehandler('items', 'xshop');
						$item = $items_handler->create();
						$item->setVar('languages', array($language=>$language));
						$item_id = $items_handler->insert($item);
					}
					if ($object->getVar('item_id')==0){
						$object->setVar('item_id', $item_id);
					}
					if ($object->getVar('language')!=$language){
						$object->setVar('language', $language);
					}
					$items_handler =& xoops_getmodulehandler('items', 'xshop');
					$item = $items_handler->get($object->getVar('item_id'));
					if (!in_array($language, $item->getVar('languages'))) {
						$item->setVar('languages', array_merge($item->getVar('languages'), array($language=>$language)));
						$item_id = $items_handler->insert($item);
					}
    			} else {
					$object = $obj[0];
    				$object->setVar('updated', time());		
		    		$object->setVar('md5', xshop_md5calc($object));
    			}
    		} else {
	    		$object->setVar('updated', time());		
	    		$object->setVar('md5', xshop_md5calc($object));
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