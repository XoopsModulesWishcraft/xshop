<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopItems_disgest extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('lang_item_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('item_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('uid', XOBJ_DTYPE_INT, 0);
        $this->initVar('product_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('manu_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('cat_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('discount_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('shipping_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('days_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('picture_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('order_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('currency_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('shop_id', XOBJ_DTYPE_INT, 0);
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
    
    function toArray() {
    	$ret = parent::toArray();
    	$ret['when'] = get_when_associative($this);
    	$ret['item'] = get_item_id($this->getVar('item_id'));
    	$ret['users']['uid'] = get_users_id($this->getVar('uid'));
    	$ret['product'] = get_product_id($this->getVar('product_id'));
    	$ret['manu'] = get_manufacture_id($this->getVar('manu_id'));
    	$ret['cat'] = get_cat_id($this->getVar('cat_id'));
    	$ret['discount'] = get_discount_id($this->getVar('discount_id'));
    	$ret['shipping'] = get_shipping_id($this->getVar('shipping_id'));
    	$ret['picture'] = get_picture_id($this->getVar('picture_id'));
    	$ret['order'] = get_order_id($this->getVar('order_id'));
    	$ret['currency'] = get_currency_id($this->getVar('currency_id'));
    	$ret['shop'] = get_shop_id($this->getVar('shop_id'));
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
    	
        $frmobj['required'][] = 'menu_title';
		$frmobj['required'][] = 'menu_description';
        
        if (!empty($index))
    		$id = $index . '['. $this->getVar('lang_item_id') . ']';
    	else 
    		$id = $this->getVar('lang_item_id');
    		
    	if ($render==true||$captions==true) {
	    	
	    	$frmobj[$cursor]['type'] = new XoopsFormSelectItemDigestType(_SHOP_FRM_ITEM_DIGEST_TYPE, $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_ITEM_DIGEST_TYPE_DESC);
	    	if ($render==false) {
		    	$frmobj[$cursor]['language'] = new XoopsFormSelectLanguage('_SHOP_FRM_ITEM_DIGEST_LANGUAGE', $id.'[language]', $this->getVar('language'));
		    	$frmobj[$cursor]['language']->setDescription(_SHOP_FRM_ITEM_DIGEST_LANGUAGE_DESC);
		    	$frmobj[$cursor]['language']->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.filter_querystring($querystring, 'language').'&language=\'+this.options[this.selectedIndex].value,\'_self\')"');
	    	} else {
	    		$frmobj[$cursor]['language'] = new XoopsFormLabel('_SHOP_FRM_ITEM_DIGEST_LANGUAGE', $this->getVar('language'));
	    		$frmobj[$cursor]['language']->setDescription(_SHOP_FRM_ITEM_DIGEST_LANGUAGE_DESC);
	    	}
	    	$frmobj[$cursor]['menu_title'] = new XoopsFormText(_SHOP_FRM_ITEM_DIGEST_MENU_TITLE, $id.'[menu_title]', 35, 128, $this->getVar('menu_title'));
	    	$frmobj[$cursor]['menu_title']->setDescription(_SHOP_FRM_ITEM_DIGEST_MENU_TITLE_DESC);
	    	$frmobj[$cursor]['long_title'] = new XoopsFormText(_SHOP_FRM_ITEM_DIGEST_LONG_TITLE, $id.'[long_title]', 35, 255, $this->getVar('long_title'));
	    	$frmobj[$cursor]['long_title']->setDescription(_SHOP_FRM_ITEM_DIGEST_LONG_TITLE_DESC);
	    	$frmobj[$cursor]['rss_title'] = new XoopsFormText(_SHOP_FRM_ITEM_DIGEST_RSS_TITLE, $id.'[rss_title]', 35, 255, $this->getVar('rss_title'));
	    	$frmobj[$cursor]['rss_title']->setDescription(_SHOP_FRM_ITEM_DIGEST_RSS_TITLE_DESC);
	    	$frmobj[$cursor]['menu_subtitle'] = new XoopsFormText(_SHOP_FRM_ITEM_DIGEST_MENU_SUBTITLE, $id.'[menu_subtitle]', 35, 128, $this->getVar('menu_subtitle'));
	    	$frmobj[$cursor]['menu_subtitle']->setDescription(_SHOP_FRM_ITEM_DIGEST_MENU_SUBTITLE_DESC);
	    	$frmobj[$cursor]['long_subtitle'] = new XoopsFormText(_SHOP_FRM_ITEM_DIGEST_LONG_SUBTITLE, $id.'[long_subtitle]', 35, 255, $this->getVar('long_subtitle'));
	    	$frmobj[$cursor]['long_subtitle']->setDescription(_SHOP_FRM_ITEM_DIGEST_LONG_SUBTITLE_DESC);
	    	$frmobj[$cursor]['menu_description'] = new XoopsFormText(_SHOP_FRM_ITEM_DIGEST_MENU_DESCRIPTION, $id.'[menu_description]', 35, 255, $this->getVar('menu_description'));
	    	$frmobj[$cursor]['menu_description']->setDescription(_SHOP_FRM_ITEM_DIGEST_MENU_DESCRIPTION_DESC);
	    	$frmobj[$cursor]['meta_description'] = new XoopsFormText(_SHOP_FRM_ITEM_DIGEST_META_DESCRIPTION, $id.'[meta_description]', 35, 255, $this->getVar('meta_description'));
	    	$frmobj[$cursor]['meta_description']->setDescription(_SHOP_FRM_ITEM_DIGEST_META_DESCRIPTION_DESC);
	    	$frmobj[$cursor]['meta_keywords'] = new XoopsFormText(_SHOP_FRM_ITEM_DIGEST_META_KEYWORDS, $id.'[meta_keywords]', 35, 255, $this->getVar('meta_keywords'));
	    	$frmobj[$cursor]['meta_keywords']->setDescription(_SHOP_FRM_ITEM_DIGEST_META_KEYWORDS_DESC);
			$long_description_configs = array();
			$long_description_configs['name'] = $id.'[long_description]';
			$long_description_configs['value'] = $this->getVar('long_description');
			$long_description_configs['rows'] = 35;
			$long_description_configs['cols'] = 60;
			$long_description_configs['width'] = "100%";
			$long_description_configs['height'] = "400px";
			$long_description_configs['editor'] = $GLOBALS['xoopsModuleConfig']['editor'];
			$frmobj[$cursor]['long_description'] = new XoopsFormEditor(_SHOP_FRM_ITEM_DIGEST_LONG_DESCRIPTION, $long_description_configs['name'], $long_description_configs);
			$frmobj[$cursor]['long_description']->setDescription(_SHOP_FRM_ITEM_DIGEST_LONG_DESCRIPTION_DESC);
			$rss_description_configs = array();
			$rss_description_configs['name'] = $id.'[rss_description]';
			$rss_description_configs['value'] = $this->getVar('rss_description');
			$rss_description_configs['rows'] = 35;
			$rss_description_configs['cols'] = 60;
			$rss_description_configs['width'] = "100%";
			$rss_description_configs['height'] = "400px";
			$rss_description_configs['editor'] = $GLOBALS['xoopsModuleConfig']['editor'];
			$frmobj[$cursor]['rss_description'] = new XoopsFormEditor(_SHOP_FRM_ITEM_DIGEST_RSS_DESCRIPTION, $rss_description_configs['name'], $rss_description_configs);
			$frmobj[$cursor]['rss_description']->setDescription(_SHOP_FRM_ITEM_DIGEST_RSS_DESCRIPTION_DESC);				
		    $frmobj[$cursor]['uid'] = new XoopsFormHidden($id.'[uid]', $this->getVar('uid'));
			$frmobj[$cursor]['product_id'] = new XoopsFormHidden($id.'[product_id]', $this->getVar('product_id'));
			$frmobj[$cursor]['manu_id'] = new XoopsFormHidden($id.'[manu_id]', $this->getVar('manu_id'));
	        $frmobj[$cursor]['cat_id'] = new XoopsFormHidden($id.'[cat_id]', $this->getVar('cat_id'));
			$frmobj[$cursor]['discount_id'] = new XoopsFormHidden($id.'[discount_id]', $this->getVar('discount_id'));
			$frmobj[$cursor]['shipping_id'] = new XoopsFormHidden($id.'[shipping_id]', $this->getVar('shipping_id'));
	        $frmobj[$cursor]['days_id'] = new XoopsFormHidden($id.'[days_id]', $this->getVar('days_id'));
			$frmobj[$cursor]['picture_id'] = new XoopsFormHidden($id.'[picture_id]', $this->getVar('picture_id'));
			$frmobj[$cursor]['order_id'] = new XoopsFormHidden($id.'[order_id]', $this->getVar('order_id'));
	        $frmobj[$cursor]['currency_id'] = new XoopsFormHidden($id.'[currency_id]', $this->getVar('currency_id'));
			$frmobj[$cursor]['shop_id'] = new XoopsFormHidden($id.'[shop_id]', $this->getVar('shop_id'));
			
		    if (!empty($index))		    
	    		$frmobj[$cursor]['lang_item_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('lang_item_id').']', 'items_digest');
	    	else 
	    		$frmobj[$cursor]['lang_item_id'] = new XoopsFormHidden('id['.$this->getVar('lang_item_id').']', 'items_digest');
	    		
	    	if ($render==false)
	    		return $frmobj;
	    		
	    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'items_disgest');
    	} else {
	    	
	    	$frmobj[$cursor]['type'] = new XoopsFormSelectItemDigestType('', $id.'[type]', $this->getVar('type'));
    		$frmobj[$cursor]['language'] = new XoopsFormLabel('', $this->getVar('language'));
	    	$frmobj[$cursor]['menu_title'] = new XoopsFormText('', $id.'[menu_title]', 35, 128, $this->getVar('menu_title'));
	    	$frmobj[$cursor]['long_title'] = new XoopsFormText('', $id.'[long_title]', 35, 255, $this->getVar('long_title'));
	    	$frmobj[$cursor]['rss_title'] = new XoopsFormText('', $id.'[rss_title]', 35, 255, $this->getVar('rss_title'));
	    	$frmobj[$cursor]['menu_subtitle'] = new XoopsFormText('', $id.'[menu_subtitle]', 35, 128, $this->getVar('menu_subtitle'));
	    	$frmobj[$cursor]['long_subtitle'] = new XoopsFormText('', $id.'[long_subtitle]', 35, 255, $this->getVar('long_subtitle'));
	    	$frmobj[$cursor]['menu_description'] = new XoopsFormText('', $id.'[menu_description]', 35, 255, $this->getVar('menu_description'));
	    	$frmobj[$cursor]['meta_description'] = new XoopsFormText('', $id.'[meta_description]', 35, 255, $this->getVar('meta_description'));
	    	$frmobj[$cursor]['meta_keywords'] = new XoopsFormText('', $id.'[meta_keywords]', 35, 255, $this->getVar('meta_keywords'));
			$long_description_configs = array();
			$long_description_configs['name'] = $id.'[long_description]';
			$long_description_configs['value'] = $this->getVar('long_description');
			$long_description_configs['rows'] = 35;
			$long_description_configs['cols'] = 60;
			$long_description_configs['width'] = "100%";
			$long_description_configs['height'] = "400px";
			$long_description_configs['editor'] = $GLOBALS['xoopsModuleConfig']['editor'];
			$frmobj[$cursor]['long_description'] = new XoopsFormEditor('', $long_description_configs['name'], $long_description_configs);
			$rss_description_configs = array();
			$rss_description_configs['name'] = $id.'[rss_description]';
			$rss_description_configs['value'] = $this->getVar('rss_description');
			$rss_description_configs['rows'] = 35;
			$rss_description_configs['cols'] = 60;
			$rss_description_configs['width'] = "100%";
			$rss_description_configs['height'] = "400px";
			$rss_description_configs['editor'] = $GLOBALS['xoopsModuleConfig']['editor'];
			$frmobj[$cursor]['rss_description'] = new XoopsFormEditor('', $rss_description_configs['name'], $rss_description_configs);
			$frmobj[$cursor]['uid'] = new XoopsFormHidden($id.'[uid]', $this->getVar('uid'));
			$frmobj[$cursor]['product_id'] = new XoopsFormHidden($id.'[product_id]', $this->getVar('product_id'));
			$frmobj[$cursor]['manu_id'] = new XoopsFormHidden($id.'[manu_id]', $this->getVar('manu_id'));
	        $frmobj[$cursor]['cat_id'] = new XoopsFormHidden($id.'[cat_id]', $this->getVar('cat_id'));
			$frmobj[$cursor]['discount_id'] = new XoopsFormHidden($id.'[discount_id]', $this->getVar('discount_id'));
			$frmobj[$cursor]['shipping_id'] = new XoopsFormHidden($id.'[shipping_id]', $this->getVar('shipping_id'));
	        $frmobj[$cursor]['days_id'] = new XoopsFormHidden($id.'[days_id]', $this->getVar('days_id'));
			$frmobj[$cursor]['picture_id'] = new XoopsFormHidden($id.'[picture_id]', $this->getVar('picture_id'));
			$frmobj[$cursor]['order_id'] = new XoopsFormHidden($id.'[order_id]', $this->getVar('order_id'));
	        $frmobj[$cursor]['currency_id'] = new XoopsFormHidden($id.'[currency_id]', $this->getVar('currency_id'));
			$frmobj[$cursor]['shop_id'] = new XoopsFormHidden($id.'[shop_id]', $this->getVar('shop_id'));
			$frmobj[$cursor]['language_id'] = new XoopsFormHidden($id.'[language]', $this->getVar('language'));
		    
			if (!empty($index))		    
	    		$frmobj[$cursor]['lang_item_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('lang_item_id').']', 'items_digest');
	    	else 
	    		$frmobj[$cursor]['lang_item_id'] = new XoopsFormHidden('id['.$this->getVar('lang_item_id').']', 'items_digest');
	    	
	    	return $frmobj;
    	}
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_ITEM, 'items_digest', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_ITEM, 'items_digest', $_SERVER['PHP_SELF'], 'post');
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
			if ($item_id==0&&$object->getVar('item_id')==0) {
				$items_handler =& xoops_getmodulehandler('items', 'xshop');
				$item = $items_handler->create();
				$item_id = $items_handler->insert($item);
			}
			if ($object->getVar('item_id')==0){
				$object->setVar('item_id', $item_id);
			}
			if ($object->getVar('language')!=$language&&$object->getVar('language')==''){
				$object->setVar('language', $language);
			}
			$items_handler =& xoops_getmodulehandler('items', 'xshop');
			$item = $items_handler->get($object->getVar('item_id'));
			if (!in_array($language, $item->getVar('languages'))) {
				$item->setVar('languages', array_unique(array_merge($item->getVar('languages'), array($language=>$language))));
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
    
    function getItem($item_id) {
    	
    	if (!empty($_GET['language'])) {
    		$criteria = new CriteriaCompo(new Criteria('item_id', $item_id));
	    	$criteria->add(new Criteria('language', $_GET['language']));
	    	if ($this->getCount($criteria)>0) {
	    		$objs = $this->getObjects($criteria, false);
	    		if (is_object($obj[0]))
	    			return $obj[0];
	    		else { 
	    			$obj = $this->create();
	    			$obj->setVar('language', $_GET['language']);
	    			$obj->setVar('item_id', $item_id);
	    			return $obj;
	    		}
	    	} else {
    			$obj = $this->create();
    			$obj->setVar('language', $_GET['language']);
    			$obj->setVar('item_id', $item_id);
    			return $obj;
	    	}
    	}
    	
    	$criteria = new CriteriaCompo(new Criteria('item_id', $item_id));
    	$criteria->add(new Criteria('language', $GLOBALS['xoopsConfig']['language']));
    	if ($this->getCount($criteria)>0) {
    		$objs = $this->getObjects($criteria, false);
    		if (is_object($obj[0]))
    			return $obj[0];
    		else {
    			$obj = $this->create();
    			$obj->setVar('language', $GLOBALS['xoopsConfig']['language']);
    			$obj->setVar('item_id', $item_id);
    			return $obj;
    		}
    	} else {
	    	$criteria = new CriteriaCompo(new Criteria('item_id', $item_id));
	    	$criteria->add(new Criteria('language', $GLOBALS['xoopsModuleConfig']['language']));
	    	if ($this->getCount($criteria)>0) {
	    		$objs = $this->getObjects($criteria, false);
	    		if (is_object($obj[0]))
	    			return $obj[0];
	    		else { 
	    			$obj = $this->create();
	    			$obj->setVar('language', $GLOBALS['xoopsConfig']['language']);
	    			$obj->setVar('item_id', $item_id);
	    			return $obj;
	    		}
	    	} else {
    			$obj = $this->create();
    			$obj->setVar('language', $GLOBALS['xoopsConfig']['language']);
    			$obj->setVar('item_id', $item_id);
    			return $obj;
	    	}
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
}
?>