<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopProducts extends XoopsObject 
{
	var $_objects = array();
	
    function __construct($type)
    {
        $this->initVar('product_id', XOBJ_DTYPE_INT);
        $this->initVar('stock', XOBJ_DTYPE_ENUM, '_SHOP_MI_PRODUCTS_INSTOCK', false, false, false, array('_SHOP_MI_PRODUCTS_INSTOCK','_SHOP_MI_PRODUCTS_OUTSTOCK','_SHOP_MI_PRODUCTS_NOREORDER','_SHOP_MI_PRODUCTS_QUITSTOCK','_SHOP_MI_PRODUCTS_SUPLUSSTOCK'));
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_PRODUCTS_TANGIABLEITEM', false, false, false, array('_SHOP_MI_PRODUCTS_SERVICE','_SHOP_MI_PRODUCTS_TANGIABLEITEM','_SHOP_MI_PRODUCTS_SERVICEANDITEM'));
        $this->initVar('uid', XOBJ_DTYPE_INT);
		$this->initVar('sales_uid', XOBJ_DTYPE_INT);
		$this->initVar('broker_uid', XOBJ_DTYPE_INT);
        $this->initVar('shop_id', XOBJ_DTYPE_INT);
        $this->initVar('cat_id', XOBJ_DTYPE_INT);
        $this->initVar('manu_id', XOBJ_DTYPE_INT);
        $this->initVar('item_id', XOBJ_DTYPE_INT);
        $this->initVar('currency_id', XOBJ_DTYPE_INT);
        $this->initVar('shipping_id', XOBJ_DTYPE_INT);
        $this->initVar('feature_picture_id', XOBJ_DTYPE_INT);
        $this->initVar('discount_id', XOBJ_DTYPE_INT);
        $this->initVar('wholesale_discount_id', XOBJ_DTYPE_INT);
        $this->initVar('cat_number', XOBJ_DTYPE_TXTBOX, false, 25);
        $this->initVar('sub_model', XOBJ_DTYPE_TXTBOX, false, 35);
        $this->initVar('cat_prefix', XOBJ_DTYPE_TXTBOX, false, 3);
        $this->initVar('cat_subfix', XOBJ_DTYPE_TXTBOX, false, 3);
        $this->initVar('unit_price', XOBJ_DTYPE_DECIMAL);
        $this->initVar('unit_wholesale_price', XOBJ_DTYPE_DECIMAL);
        $this->initVar('weight_per_unit', XOBJ_DTYPE_DECIMAL);
		$this->initVar('weight_measurement', XOBJ_DTYPE_ENUM, '_SHOP_MI_WEIGHT_KILOS', false, false, false, array('_SHOP_MI_WEIGHT_KILOS', '_SHOP_MI_WEIGHT_POUNDS'));
        $this->initVar('quanity_in_unit', XOBJ_DTYPE_DECIMAL);
        $this->initVar('quanity_for_wholesale', XOBJ_DTYPE_DECIMAL);
        $this->initVar('quanity_measured', XOBJ_DTYPE_TXTBOX, false, 10);
        $this->initVar('quanity_in_warehouse', XOBJ_DTYPE_INT);
        $this->initVar('quanity_to_order', XOBJ_DTYPE_INT);
        $this->initVar('tag', XOBJ_DTYPE_TXTBOX, false, 255);
        $this->initVar('rating', XOBJ_DTYPE_DECIMAL);
        $this->initVar('votes', XOBJ_DTYPE_INT);
        $this->initVar('last_ordered', XOBJ_DTYPE_INT);
        $this->initVar('shippment_arrived', XOBJ_DTYPE_INT);
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, false, 32);
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
        $this->initVar('actioned', XOBJ_DTYPE_INT);
    }
    
    function toArray() {
    	$ret = parent::toArray();
    	$ret['when'] = get_when_associative($this);
    	$ret['users']['uid'] = get_users_id($this->getVar('uid'));
    	$ret['users']['broker'] = get_users_id($this->getVar('broker_uid'));
    	$ret['users']['sales'] = get_users_id($this->getVar('sales_uid'));
    	$ret['shop'] = get_shop_id($this->getVar('shop_id'));
    	$ret['cat'] = get_cat_id($this->getVar('cat_id'));
    	$ret['manu'] = get_manufacture_id($this->getVar('manu_id'));
    	$ret['item'] = get_item_id($this->getVar('item_id'));
    	$ret['shipping'] = get_shipping_id($this->getVar('shipping_id'));
    	$ret['currency'] = get_currency_id($this->getVar('currency_id'));
    	$ret['discount'] = get_discount_id($this->getVar('discount_id'));
    	$ret['picture'] = get_picture_id($this->getVar('feature_picture_id'));
    	$ret['rank'] = number_format($this->getVar('rating')/$this->getVar('votes')*100,2).'%';
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
    
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = '') {
    	xoops_loadLanguage('forms', 'xshop');
    	    	
    	$addresses_handler =& xoops_getmodulehandler('addresses', 'xshop');
    	$contacts_handler =& xoops_getmodulehandler('contacts', 'xshop');

    	$items_digest_handler =& xoops_getmodulehandler('items_digest', 'xshop');
    	$digest = $items_digest_handler->getItem($this->getVar('item_id'));
    	
    	if (!empty($index))
    		$id = $index . '['. $this->getVar('product_id') . ']';
    	else 
    		$id = $this->getVar('product_id');
    	
    	if ($render = true||$captions==true) {
	    	$frmobj[$cursor]['stock'] = new XShopFormSelectProductsStock(_SHOP_FRM_PRODUCTS_STOCK,  $id.'[stock]', $this->getVar('stock'));
	    	$frmobj[$cursor]['stock']->setDescription(_SHOP_FRM_PRODUCTS_STOCK_DESC);
	    	$frmobj[$cursor]['type'] = new XShopFormSelectProductType(_SHOP_FRM_PRODUCTS_TYPE,  $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_PRODUCTS_TYPE_DESC);
	    	$frmobj[$cursor]['sales_uid'] = new XShopFormSelectGroupedUser(_SHOP_FRM_PRODUCTS_SALES_CLERK, 'sales_uid', $this->getVar('sales_uid'), 1, false, $GLOBALS['xoopsModuleConfig']['sales']);
	    	$frmobj[$cursor]['sales_uid']->setDescription(_SHOP_FRM_PRODUCTS_SALES_CLERK_DESC);
	    	$frmobj[$cursor]['broker_uid'] = new XShopFormSelectGroupedUser(_SHOP_FRM_PRODUCTS_BROKER, 'broker_uid', $this->getVar('broker_uid'), 1, false, $GLOBALS['xoopsModuleConfig']['broker']);
	    	$frmobj[$cursor]['broker_uid']->setDescription(_SHOP_FRM_PRODUCTS_BROKER_DESC);
	    	$frmobj[$cursor]['shop_id'] = new XShopFormSelectShops(_SHOP_FRM_PRODUCTS_SHOP, 'shop_id', $this->getVar('shop_id'));
	    	$frmobj[$cursor]['shop_id']->setDescription(_SHOP_FRM_PRODUCTS_SHOP_DESC);
	    	$frmobj[$cursor]['cat_id'] = new XShopFormSelectCategory(_SHOP_FRM_PRODUCTS_CATEGORY, 'cat_id', $this->getVar('cat_id'));
	    	$frmobj[$cursor]['cat_id']->setDescription(_SHOP_FRM_PRODUCTS_CATEGORY_DESC);
	    	$frmobj[$cursor]['manu_id'] = new XShopFormSelectManufactures(_SHOP_FRM_PRODUCTS_MANUFACTURES, 'manu_id', $this->getVar('manu_id'));
	    	$frmobj[$cursor]['manu_id']->setDescription(_SHOP_FRM_PRODUCTS_MANUFACTURES_DESC);
	    	$frmobj[$cursor]['currency_id'] = new XShopFormSelectCurrency(_SHOP_FRM_PRODUCTS_CURRENCY, 'currency_id', $this->getVar('currency_id'));
	    	$frmobj[$cursor]['currency_id']->setDescription(_SHOP_FRM_PRODUCTS_CURRENCY_DESC);
	    	$frmobj[$cursor]['shipping_id'] = new XShopFormSelectShipping(_SHOP_FRM_PRODUCTS_SHIPPING, 'shipping_id', $this->getVar('shipping_id'), 1, false, true);
	    	$frmobj[$cursor]['shipping_id']->setDescription(_SHOP_FRM_PRODUCTS_SHIPPING_DESC);
	    	$frmobj[$cursor]['discount_id'] = new XShopFormSelectDiscount(_SHOP_FRM_PRODUCTS_DISCOUNT, 'discount_id', $this->getVar('discount_id'), 1, false, true);
	    	$frmobj[$cursor]['discount_id']->setDescription(_SHOP_FRM_PRODUCTS_DISCOUNT_DESC);
	    	$frmobj[$cursor]['wholesale_discount_id'] = new XShopFormSelectDiscount(_SHOP_FRM_PRODUCTS_WHOLESALEDISCOUNT, 'wholesale_discount_id', $this->getVar('wholesale_discount_id'), 1, false, true);
	    	$frmobj[$cursor]['wholesale_discount_id']->setDescription(_SHOP_FRM_PRODUCTS_WHOLESALEDISCOUNT_DESC);
	    	$frmobj = $digest->getForm($querystring, true, false, $id.'[item]', 'item', $frmobj);
	    	$frmobj[$cursor]['cat_prefix'] = new XoopsFormText(_SHOP_FRM_PRODUCTS_CATALOGUENUMBER_PREFIX, 'cat_prefix', 3, 5, $this->getVar('cat_prefix'));
	    	$frmobj[$cursor]['cat_prefix']->setDescription(_SHOP_FRM_PRODUCTS_CATALOGUENUMBER_PREFIX_DESC);
	    	$frmobj[$cursor]['cat_number'] = new XoopsFormText(_SHOP_FRM_PRODUCTS_CATALOGUENUMBER, 'cat_number', 20, 25, $this->getVar('cat_number'));
	    	$frmobj[$cursor]['cat_number']->setDescription(_SHOP_FRM_PRODUCTS_CATALOGUENUMBER_DESC);
	    	$frmobj[$cursor]['cat_subfix'] = new XoopsFormText(_SHOP_FRM_PRODUCTS_CATALOGUENUMBER_SUFFIX, 'cat_subfix', 3, 5, $this->getVar('cat_subfix'));
	    	$frmobj[$cursor]['cat_subfix']->setDescription(_SHOP_FRM_PRODUCTS_CATALOGUENUMBER_SUFFIX_DESC);
	    	$frmobj[$cursor]['sub_model'] = new XoopsFormText(_SHOP_FRM_PRODUCTS_SUBMODEL, 'sub_model', 25, 35, $this->getVar('sub_model'));
	    	$frmobj[$cursor]['sub_model']->setDescription(_SHOP_FRM_PRODUCTS_SUBMODEL_DESC);
	    	$frmobj[$cursor]['unit_price'] = new XoopsFormText(_SHOP_FRM_PRODUCTS_UNIT_PRICE, 'unit_price', 25, 35, $this->getVar('unit_price'));
	    	$frmobj[$cursor]['unit_price']->setDescription(_SHOP_FRM_PRODUCTS_UNIT_PRICE_DESC);
	    	$frmobj[$cursor]['unit_wholesale_price'] = new XoopsFormText(_SHOP_FRM_PRODUCTS_WHOLESALE_PRICE, 'unit_wholesale_price', 25, 35, $this->getVar('unit_wholesale_price'));
	    	$frmobj[$cursor]['unit_wholesale_price']->setDescription(_SHOP_FRM_PRODUCTS_WHOLESALE_PRICE_DESC);
	    	$frmobj[$cursor]['weight_per_unit'] = new XoopsFormText(_SHOP_FRM_PRODUCTS_WEIGHT_PER_UNIT, 'weight_per_unit', 25, 35, $this->getVar('weight_per_unit'));
	    	$frmobj[$cursor]['weight_per_unit']->setDescription(_SHOP_FRM_PRODUCTS_WEIGHT_PER_UNIT_DESC);
	    	$frmobj[$cursor]['weight_measurement'] = new XShopFormSelectMeasurement(_SHOP_FRM_PRODUCTS_WEIGHT_MEASUREMENT, 'weight_measurement', $this->getVar('weight_measurement'));
	    	$frmobj[$cursor]['weight_measurement']->setDescription(_SHOP_FRM_PRODUCTS_WEIGHT_MEASUREMENT_DESC);
	    	$frmobj[$cursor]['quanity_in_unit'] = new XoopsFormText(_SHOP_FRM_PRODUCTS_QUANITY_IN_UNIT, 'quanity_in_unit', 25, 35, $this->getVar('quanity_in_unit'));
	    	$frmobj[$cursor]['quanity_in_unit']->setDescription(_SHOP_FRM_PRODUCTS_QUANITY_IN_UNIT_DESC);
	    	$frmobj[$cursor]['quanity_for_wholesale'] = new XoopsFormText(_SHOP_FRM_PRODUCTS_QUANITY_FOR_WHOLESALE, 'quanity_for_wholesale', 25, 35, $this->getVar('quanity_for_wholesale'));
	    	$frmobj[$cursor]['quanity_for_wholesale']->setDescription(_SHOP_FRM_PRODUCTS_QUANITY_FOR_WHOLESALE_DESC);
	    	$frmobj[$cursor]['quanity_in_warehouse'] = new XoopsFormText(_SHOP_FRM_PRODUCTS_QUANITY_IN_WAREHOUSE, 'quanity_in_warehouse', 25, 35, $this->getVar('quanity_in_warehouse'));
	    	$frmobj[$cursor]['quanity_in_warehouse']->setDescription(_SHOP_FRM_PRODUCTS_QUANITY_IN_WAREHOUSE_DESC);
	    	$frmobj[$cursor]['quanity_to_order'] = new XoopsFormText(_SHOP_FRM_PRODUCTS_QUANITY_TO_ORDER, 'quanity_to_order', 25, 35, $this->getVar('quanity_to_order'));
	    	$frmobj[$cursor]['quanity_to_order']->setDescription(_SHOP_FRM_PRODUCTS_QUANITY_TO_ORDER_DESC);
	    	
	    	if (!empty($index))	
	    		$frmobj[$cursor]['product_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('product_id').']', 'products');
	    	else 
	    		$frmobj[$cursor]['product_id'] = new XoopsFormHidden('id['.$this->getVar('product_id').']', 'products');
	    	
	    	if ($render==false)
	    		return $frmobj;
	    		
	    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'products');
    	} else {
	    	$frmobj[$cursor]['stock'] = new XShopFormSelectProductsStock('',  $id.'[stock]', $this->getVar('stock'));
	    	$frmobj[$cursor]['type'] = new XShopFormSelectProductType('',  $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['sales_uid'] = new XShopFormSelectGroupedUser('', 'sales_uid', $this->getVar('sales_uid'), 1, false, $GLOBALS['xoopsModuleConfig']['sales']);
	    	$frmobj[$cursor]['broker_uid'] = new XShopFormSelectGroupedUser('', 'broker_uid', $this->getVar('broker_uid'), 1, false, $GLOBALS['xoopsModuleConfig']['broker']);
	    	$frmobj[$cursor]['shop_id'] = new XShopFormSelectShops('', 'shop_id', $this->getVar('shop_id'));
	    	$frmobj[$cursor]['cat_id'] = new XShopFormSelectCategory('', 'cat_id', $this->getVar('cat_id'));
	    	$frmobj[$cursor]['manu_id'] = new XShopFormSelectManufactures('', 'manu_id', $this->getVar('manu_id'));
	    	$frmobj[$cursor]['currency_id'] = new XShopFormSelectCurrency('', 'currency_id', $this->getVar('currency_id'));
	    	$frmobj[$cursor]['shipping_id'] = new XShopFormSelectShipping('', 'shipping_id', $this->getVar('shipping_id'), 1, false, true);
	    	$frmobj[$cursor]['discount_id'] = new XShopFormSelectDiscount('', 'discount_id', $this->getVar('discount_id'), 1, false, true);
	    	$frmobj[$cursor]['wholesale_discount_id'] = new XShopFormSelectDiscount('', 'wholesale_discount_id', $this->getVar('wholesale_discount_id'), 1, false, true);
	    	$frmobj = $digest->getForm($querystring, false, false, $id.'[item]', 'item', $frmobj);
	    	$frmobj[$cursor]['cat_prefix'] = new XoopsFormText('', 'cat_prefix', 3, 5, $this->getVar('cat_prefix'));
	    	$frmobj[$cursor]['cat_number'] = new XoopsFormText('', 'cat_number', 20, 25, $this->getVar('cat_number'));
	    	$frmobj[$cursor]['cat_subfix'] = new XoopsFormText('', 'cat_subfix', 3, 5, $this->getVar('cat_subfix'));
	    	$frmobj[$cursor]['sub_model'] = new XoopsFormText('', 'sub_model', 25, 35, $this->getVar('sub_model'));
	    	$frmobj[$cursor]['unit_price'] = new XoopsFormText('', 'unit_price', 25, 35, $this->getVar('unit_price'));
	    	$frmobj[$cursor]['unit_wholesale_price'] = new XoopsFormText('', 'unit_wholesale_price', 25, 35, $this->getVar('unit_wholesale_price'));
	    	$frmobj[$cursor]['weight_per_unit'] = new XoopsFormText('', 'weight_per_unit', 25, 35, $this->getVar('weight_per_unit'));
	    	$frmobj[$cursor]['weight_measurement'] = new XShopFormSelectMeasurement('', 'weight_measurement', $this->getVar('weight_measurement'));
	    	$frmobj[$cursor]['quanity_in_unit'] = new XoopsFormText('', 'quanity_in_unit', 25, 35, $this->getVar('quanity_in_unit'));
	    	$frmobj[$cursor]['quanity_for_wholesale'] = new XoopsFormText('', 'quanity_for_wholesale', 25, 35, $this->getVar('quanity_for_wholesale'));
	    	$frmobj[$cursor]['quanity_in_warehouse'] = new XoopsFormText('', 'quanity_in_warehouse', 25, 35, $this->getVar('quanity_in_warehouse'));
	    	$frmobj[$cursor]['quanity_to_order'] = new XoopsFormText('', 'quanity_to_order', 25, 35, $this->getVar('quanity_to_order'));
	    	if (!empty($index))	
	    		$frmobj[$cursor]['product_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('product_id').']', 'products');
	    	else 
	    		$frmobj[$cursor]['product_id'] = new XoopsFormHidden('id['.$this->getVar('product_id').']', 'products');
	    	
    		return $frmobj;
    	}
    	
    	$frmobj[$cursor]['submit'] = new XoopsFormButton('', _SUBMIT, 'submit', _SUBMIT);
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_PRODUCTS, 'products', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_PRODUCTS, 'products', $_SERVER['PHP_SELF'], 'post');
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
		
		if (defined('_PLUGIN'.$this->getVar('type'))) { 
			$func = constant('_PLUGIN'.$this->getVar('type')).'PreInsert';
			if (function_exists($func))  {
				@$func($this);
			}
		}

		if (defined('_PLUGIN'.$this->getVar('stock'))) { 
			$func = constant('_PLUGIN'.$this->getVar('stock')).'PreInsert';
			if (function_exists($func))  {
				@$func($this);
			}
		}
		
		return true;
	}
	
    function runPostInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
		if (defined('_PLUGIN'.$this->getVar('type'))) {
			$func = constant('_PLUGIN'.$this->getVar('type')).'PostInsert';
			if (function_exists($func))  {
				@$func($this);
			}
		}

		if (defined('_PLUGIN'.$this->getVar('stock'))) {
			$func = constant('_PLUGIN'.$this->getVar('stock')).'PostInsert';
			if (function_exists($func))  {
				@$func($this);
			}
		}
		
		return true;
	}
	
    function runPostGetPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
		if (defined('_PLUGIN'.$this->getVar('type'))) {
			$func = constant('_PLUGIN'.$this->getVar('type')).'PostGet';
			if (function_exists($func))  {
				@$func($this);
			}
		}

    	if (defined('_PLUGIN'.$this->getVar('stock'))) {
			$func = constant('_PLUGIN'.$this->getVar('stock')).'PostGet';
			if (function_exists($func))  {
				@$func($this);
			}
		}
		return true;
	}
}

class xshopProductsHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopProductsHandler($db, $type) {
	    parent::__construct($db, 'shop_products', 'xshopProducts', 'product_id');
    }   
    
    function insert($object, $force = true) {
    	
    	if ($object->isNew()) {
    		$object->setVar('created', time());
    		$criteria = new Criteria('md5', xshop_md5calc($object));
    		if (parent::getCount($criteria)) {
    			foreach(parent::getObjects($criteria, true) as $id => $item)	   			
    				return $id; 
    		}
			$object->setVar('md5', xshop_md5calc($object));    		
    	} else {
    		$object->setVar('updated', time());		
    		$object->setVar('md5', xshop_md5calc($object));
    	}
    	
    	$run_plugin = false;
    	if ($object->vars['type']['changed']==true) {	
			$object->setVar('actioned', time());
			$run_plugin = true;
		}
		if ($object->vars['stock']['changed']==true) {	
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
}
?>