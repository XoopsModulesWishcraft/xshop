<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopDiscounts extends XoopsObject 
{
	var $_objects = array();
	
    function __construct($type)
    {
        $this->initVar('discount_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('type', XOBJ_DTYPE_ENUM, '_SHOP_MI_DISCOUNT_GENERAL', false, false, false, array('_SHOP_MI_DISCOUNT_QUITSTOCK','_SHOP_MI_DISCOUNT_GENERAL','_SHOP_MI_DISCOUNT_WHOLESALE','_SHOP_MI_DISCOUNT_NOREORDER','_SHOP_MI_DISCOUNT_QUANITY','_SHOP_MI_DISCOUNT_OTHER'));
        $this->initVar('item_id', XOBJ_DTYPE_INT, 0);
        $this->initVar('percentage', XOBJ_DTYPE_DECIMAL, 0, false);
        $this->initVar('min_quanity', XOBJ_DTYPE_DECIMAL, 0, false);
        $this->initVar('shipping_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('timed', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('start', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('end', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('opening', XOBJ_DTYPE_INT, 60*60*9, false);
        $this->initVar('closing', XOBJ_DTYPE_INT, 60*6*17, false);
        $this->initVar('days_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, '', false, 32);
        $this->initVar('created', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('updated', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('actioned', XOBJ_DTYPE_INT, 0, false);
        
    }
    
    function toArray() {
    	$ret = parent::toArray();
    	$ret['when'] = get_when_associative($this);
    	//$ret['item'] = get_item_id($this->getVar('item_id'));
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
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array(), $const = '_SHOP_MI_DISCOUNTS') {
    
    	xoops_loadLanguage('forms', 'xshop');
    	
    	$frmobj['required'][] = 'percentage';
    	
    	$items_digest_handler =& xoops_getmodulehandler('items_digest', 'xshop');
    	$digest = $items_digest_handler->getItem($this->getVar('item_id'));
    	
    	if (!empty($index))
    		$id = $index . '['. $this->getVar('discount_id') . ']';
    	else 
    		$id = $this->getVar('discount_id');
    	
    	if ($render == true||$captions==true) {
    		if (defined($const)&&defined($const.'_LABEL')&&defined($const.'_LABEL_DESC')) {
		    	$frmobj[$cursor]['label'] = new XoopsFormLabel('<font style="font-size:1.25em;">'.constant($const).'</font>', '<font style="font-size:1.25em;">'.sprintf(constant($const.'_LABEL'), constant($const)).'</font>');
		    	$frmobj[$cursor]['label']->setDescription(constant($const.'_LABEL_DESC'));
     		}   	    	
	    	$frmobj = $digest->getForm($querystring, true, false, $id.'[item]', 'item', $frmobj);
	    	$frmobj[$cursor]['has_item'] = new XoopsFormHidden('hasItem', true);
	    	$frmobj[$cursor]['type'] = new XShopFormSelectDiscountType(_SHOP_FRM_DISCOUNTS_TYPE,  $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['type']->setDescription(_SHOP_FRM_DISCOUNTS_TYPE_DESC);
	    	$frmobj[$cursor]['percentage'] = new XoopsFormText(_SHOP_FRM_DISCOUNTS_PERCENTAGE,  $id.'[percentage]', 15, 20, $this->getVar('percentage'));
	    	$frmobj[$cursor]['percentage']->setDescription(_SHOP_FRM_DISCOUNTS_PERCENTAGE_DESC);
	    	$frmobj[$cursor]['min_quanity'] = new XoopsFormText(_SHOP_FRM_DISCOUNTS_MIN_QUANITY,  $id.'[min_quanity]', 15, 20, $this->getVar('min_quanity'));
	    	$frmobj[$cursor]['min_quanity']->setDescription(_SHOP_FRM_DISCOUNTS_MIN_QUANITY_DESC);
	    	$frmobj[$cursor]['shipping_id'] = new XShopFormSelectShipping(_SHOP_FRM_DISCOUNTS_SHIPPING,  $id.'[shipping_id]', $this->getVar('shipping_id'), 1, false, true);
	    	$frmobj[$cursor]['shipping_id']->setDescription(_SHOP_FRM_DISCOUNTS_SHIPPING_DESC);
	    	$frmobj[$cursor]['timed'] = new XoopsFormRadioYN(_SHOP_FRM_DISCOUNTS_TIMED,  $id.'[timed]', $this->getVar('timed'));
	    	$frmobj[$cursor]['timed']->setDescription(_SHOP_FRM_DISCOUNTS_TIMED_DESC);
	    	$frmobj[$cursor]['start'] = new XoopsFormTextDateSelect(_SHOP_FRM_DISCOUNTS_START,  $id.'[start]', 15, $this->getVar('start'));
	    	$frmobj[$cursor]['start']->setDescription(_SHOP_FRM_DISCOUNTS_START_DESC);
	    	$frmobj[$cursor]['end'] = new XoopsFormTextDateSelect(_SHOP_FRM_DISCOUNTS_END,  $id.'[end]', 15, $this->getVar('end'));
	    	$frmobj[$cursor]['end']->setDescription(_SHOP_FRM_DISCOUNTS_END_DESC);
	    	$frmobj[$cursor]['opening'] = new XShopFormSelectTime(_SHOP_FRM_DISCOUNTS_OPENING,  $id.'[opening]', $this->getVar('opening'));
	    	$frmobj[$cursor]['opening']->setDescription(_SHOP_FRM_DISCOUNTS_OPENING_DESC);
	    	$frmobj[$cursor]['closing'] = new XShopFormSelectTime(_SHOP_FRM_DISCOUNTS_CLOSING,  $id.'[closing]', $this->getVar('closing'));
	    	$frmobj[$cursor]['closing']->setDescription(_SHOP_FRM_DISCOUNTS_CLOSING_DESC);
	    	
	    	$days_handler = xoops_getmodulehandler('days', 'xshop');
	    	$days = $days_handler->getItem($this->getVar('days_id'));
	    	$frmobj[$cursor]['days_id'] = $days->getFormTray($querystring, true, $id.'[days]', 2);

	    	if (!empty($index))	
	    		$frmobj[$cursor]['discount_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('discount_id').']', 'discounts');
	    	else 
	    		$frmobj[$cursor]['discount_id'] = new XoopsFormHidden('id['.$this->getVar('discount_id').']', 'discounts');
	    		
	    	if ($render==false)
	    		return $frmobj;
	    	
	    	if ($_REQUEST['fct']=='discounts') {	
	    		$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    		$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'discounts');
	    	}
    	} else {
    		
	    	$frmobj = $digest->getForm($querystring, false, false, $id.'[item]', 'item', $frmobj);
	    	$frmobj[$cursor]['has_item'] = new XoopsFormHidden('hasItem', true);
	    	$frmobj[$cursor]['type'] = new XShopFormSelectDiscountType('',  $id.'[type]', $this->getVar('type'));
	    	$frmobj[$cursor]['percentage'] = new XoopsFormText('',  $id.'[percentage]', 15, 20, $this->getVar('percentage'));
	    	$frmobj[$cursor]['min_quanity'] = new XoopsFormText('',  $id.'[min_quanity]', 15, 20, $this->getVar('min_quanity'));
	    	$frmobj[$cursor]['shipping_id'] = new XShopFormSelectShipping('',  $id.'[shipping_id]', $this->getVar('shipping_id'), 1, false, true);
	    	$frmobj[$cursor]['timed'] = new XoopsFormRadioYN('',  $id.'[timed]', $this->getVar('timed'));
	    	$frmobj[$cursor]['start'] = new XoopsFormTextDateSelect('',  $id.'[start]', 15, $this->getVar('start'));
	    	$frmobj[$cursor]['end'] = new XoopsFormTextDateSelect('',  $id.'[end]', 15, $this->getVar('end'));
	    	$frmobj[$cursor]['opening'] = new XShopFormSelectTime('',  $id.'[opening]', $this->getVar('opening'));
	    	$frmobj[$cursor]['closing'] = new XShopFormSelectTime('',  $id.'[closing]', $this->getVar('closing'));
	    	
	    	$days_handler = xoops_getmodulehandler('days', 'xshop');
	    	$days = $days_handler->getItem($this->getVar('days_id'));
	    	$frmobj[$cursor]['days_id'] = $days->getFormTray($querystring, false, $id.'[days]', 2);
    			    	
	    	if (!empty($index))	
	    		$frmobj[$cursor]['discount_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('discount_id').']', 'discounts');
	    	else 
	    		$frmobj[$cursor]['discount_id'] = new XoopsFormHidden('id['.$this->getVar('discount_id').']', 'discounts');
	    			    	
    		return $frmobj;
    	}
    	
    	$frmobj['submit']['submit'] = new XoopsFormButton('', _SUBMIT, 'submit', _SUBMIT);
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_DISCOUNTS, 'discounts', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_DISCOUNTS, 'discounts', $_SERVER['PHP_SELF'], 'post');
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

class xshopDiscountsHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopDiscountsHandler($db, $type) {
	    parent::__construct($db, 'shop_discounts', 'xshopDiscounts', 'discount_id');
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