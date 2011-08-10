<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopDays extends XoopsObject 
{
	var $_objects = array();
	
    function __construct()
    {
        $this->initVar('days_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('item_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('shop_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('product_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('contact_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('address_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('discount_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('order_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('shipping_id', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('monday', XOBJ_DTYPE_ENUM, '', false, false, false, array('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER'));
        $this->initVar('tuesday', XOBJ_DTYPE_ENUM, '', false, false, false, array('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER'));
        $this->initVar('wednesday', XOBJ_DTYPE_ENUM, '', false, false, false, array('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER'));
        $this->initVar('thursday', XOBJ_DTYPE_ENUM, '', false, false, false, array('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER'));
        $this->initVar('friday', XOBJ_DTYPE_ENUM, '', false, false, false, array('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER'));
        $this->initVar('saturday', XOBJ_DTYPE_ENUM, '', false, false, false, array('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER'));
        $this->initVar('sunday', XOBJ_DTYPE_ENUM, '', false, false, false, array('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER'));
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
    
    
    function getFormTray($querystring, $captions=true, $index='', $mode=false) {
    	xoops_loadLanguage('forms', 'xshop');
   		if (!empty($index))
    		$id = $index . '['. $this->getVar('days_id') . ']';
    	else 
    		$id = $this->getVar('days_id');
    		
    	if ($captions==true) {
    		$frmobj = new XoopsFormElementTray(_SHOP_FRM_DAYS);
    		$frmobj->setDescription(_SHOP_FRM_DAYS_DESC);
    	} else {
    		$frmobj = new XoopsFormElementTray();
    	}	
    	
    	$frmobj->addElement(new XoopsFormHidden($id.'[days_id]', $this->getVar('days_id')));
    	$frmobj->addElement(new XoopsFormHidden($id.'[item_id]', $this->getVar('item_id')));
    	$frmobj->addElement(new XoopsFormHidden($id.'[shop_id]', $this->getVar('shop_id')));
    	$frmobj->addElement(new XoopsFormHidden($id.'[product_id]', $this->getVar('product_id')));
    	$frmobj->addElement(new XoopsFormHidden($id.'[contact_id]', $this->getVar('contact_id')));
    	$frmobj->addElement(new XoopsFormHidden($id.'[address_id]', $this->getVar('address_id')));
    	$frmobj->addElement(new XoopsFormHidden($id.'[discount_id]', $this->getVar('discount_id')));
    	$frmobj->addElement(new XoopsFormHidden($id.'[order_id]', $this->getVar('order_id')));
    	$frmobj->addElement(new XoopsFormHidden($id.'[shipping_id]', $this->getVar('shipping_id')));
    	$frmobj->addElement(new XShopFormSelectDays(_SHOP_FRM_DAYS_MONDAY, $id.'[monday]', $this->getVar('monday'), 1, false, $mode));
    	$frmobj->addElement(new XShopFormSelectDays(_SHOP_FRM_DAYS_TUESDAY, $id.'[tuesday]', $this->getVar('tuesday'), 1, false, $mode));
    	$frmobj->addElement(new XShopFormSelectDays(_SHOP_FRM_DAYS_WEDNESDAY, $id.'[wednesday]', $this->getVar('wednesday'), 1, false, $mode));
    	$frmobj->addElement(new XShopFormSelectDays(_SHOP_FRM_DAYS_THURSDAY, $id.'[thursday]', $this->getVar('thursday'), 1, false, $mode));
    	$frmobj->addElement(new XShopFormSelectDays(_SHOP_FRM_DAYS_FRIDAY, $id.'[friday]', $this->getVar('friday'), 1, false, $mode));
    	$frmobj->addElement(new XShopFormSelectDays(_SHOP_FRM_DAYS_SATURDAY, $id.'[saturday]', $this->getVar('saturday'), 1, false, $mode));
    	$frmobj->addElement(new XShopFormSelectDays(_SHOP_FRM_DAYS_SUNDAY, $id.'[sunday]', $this->getVar('sunday'), 1, false, $mode));
    	return $frmobj;
    }
    
    function runPreInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
		if (defined('_PLUGIN'.$this->getVar('monday'))&&$this->vars['monday']['changed']) { 
			$func = constant('_PLUGIN'.$this->getVar('monday')).'MondayPreInsert';
			if (function_exists($func))  {
				@$func($this);
			}
    	}

    	if (defined('_PLUGIN'.$this->getVar('tuesday'))&&$this->vars['tuesday']['changed']) { 
			$func = constant('_PLUGIN'.$this->getVar('tuesday')).'TuesdayPreInsert';
			if (function_exists($func))  {
				@$func($this);
			}
    	}

    	if (defined('_PLUGIN'.$this->getVar('wednesday'))&&$this->vars['wednesday']['changed']) { 
			$func = constant('_PLUGIN'.$this->getVar('wednesday')).'WednesdayPreInsert';
			if (function_exists($func))  {
				@$func($this);
			}
    	}

    	if (defined('_PLUGIN'.$this->getVar('thursday'))&&$this->vars['thursday']['changed']) { 
			$func = constant('_PLUGIN'.$this->getVar('thursday')).'ThursdayPreInsert';
			if (function_exists($func))  {
				@$func($this);
			}
    	}
    	
    	if (defined('_PLUGIN'.$this->getVar('friday'))&&$this->vars['friday']['changed']) { 
			$func = constant('_PLUGIN'.$this->getVar('friday')).'FridayPreInsert';
			if (function_exists($func))  {
				@$func($this);
			}
    	}
    	
    	if (defined('_PLUGIN'.$this->getVar('saturday'))&&$this->vars['saturday']['changed']) { 
			$func = constant('_PLUGIN'.$this->getVar('saturday')).'SaturdayPreInsert';
			if (function_exists($func))  {
				@$func($this);
			}
    	}
    	
    	if (defined('_PLUGIN'.$this->getVar('sunday'))&&$this->vars['sunday']['changed']) { 
			$func = constant('_PLUGIN'.$this->getVar('sunday')).'SundayPreInsert';
			if (function_exists($func))  {
				@$func($this);
			}
    	}
    	
    	return true;
	}
	
    function runPostInsertPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
		if (defined('_PLUGIN'.$this->getVar('monday'))) {
			$func = constant('_PLUGIN'.$this->getVar('monday')).'MondayPostInsert';
			if (function_exists($func))  {
				@$func($this);
			}
		}
    	if (defined('_PLUGIN'.$this->getVar('tuesday'))) {
			$func = constant('_PLUGIN'.$this->getVar('tuesday')).'TuesdayPostInsert';
			if (function_exists($func))  {
				@$func($this);
			}
		}
    	if (defined('_PLUGIN'.$this->getVar('wednesday'))) {
			$func = constant('_PLUGIN'.$this->getVar('wednesday')).'WednesdayPostInsert';
			if (function_exists($func))  {
				@$func($this);
			}
		}
    	if (defined('_PLUGIN'.$this->getVar('thursday'))) {
			$func = constant('_PLUGIN'.$this->getVar('thursday')).'ThursdayPostInsert';
			if (function_exists($func))  {
				@$func($this);
			}
		}
    	if (defined('_PLUGIN'.$this->getVar('friday'))) {
			$func = constant('_PLUGIN'.$this->getVar('friday')).'FridayPostInsert';
			if (function_exists($func))  {
				@$func($this);
			}
		}
    	if (defined('_PLUGIN'.$this->getVar('saturday'))) {
			$func = constant('_PLUGIN'.$this->getVar('saturday')).'SaturdayPostInsert';
			if (function_exists($func))  {
				@$func($this);
			}
		}
    	if (defined('_PLUGIN'.$this->getVar('sunday'))) {
			$func = constant('_PLUGIN'.$this->getVar('sunday')).'SundayPostInsert';
			if (function_exists($func))  {
				@$func($this);
			}
		}	
		return true;
	}
	
    function runPostGetPlugin() {
		
		include_once($GLOBALS['xoops']->path('/modules/xshop/plugin/'.basename(__FILE__)));
		
		xoops_loadLanguage('plugin', 'xshop');
		
		if (defined('_PLUGIN'.$this->getVar('monday'))) {
			$func = constant('_PLUGIN'.$this->getVar('monday')).'MondayPostGet';
			if (function_exists($func))  {
				@$func($this);
			}
		}
    	if (defined('_PLUGIN'.$this->getVar('tuesday'))) {
			$func = constant('_PLUGIN'.$this->getVar('tuesday')).'TuesdayPostGet';
			if (function_exists($func))  {
				@$func($this);
			}
		}
    	if (defined('_PLUGIN'.$this->getVar('wednesday'))) {
			$func = constant('_PLUGIN'.$this->getVar('wednesday')).'WednesdayPostGet';
			if (function_exists($func))  {
				@$func($this);
			}
		}
    	if (defined('_PLUGIN'.$this->getVar('thursday'))) {
			$func = constant('_PLUGIN'.$this->getVar('thursday')).'ThursdayPostGet';
			if (function_exists($func))  {
				@$func($this);
			}
		}
    	if (defined('_PLUGIN'.$this->getVar('friday'))) {
			$func = constant('_PLUGIN'.$this->getVar('friday')).'FridayPostGet';
			if (function_exists($func))  {
				@$func($this);
			}
		}
    	if (defined('_PLUGIN'.$this->getVar('saturday'))) {
			$func = constant('_PLUGIN'.$this->getVar('saturday')).'SaturdayPostGet';
			if (function_exists($func))  {
				@$func($this);
			}
		}
    	if (defined('_PLUGIN'.$this->getVar('sunday'))) {
			$func = constant('_PLUGIN'.$this->getVar('sunday')).'SundayPostGet';
			if (function_exists($func))  {
				@$func($this);
			}
		}
		return true;
	}
}

class xshopDaysHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopDaysHandler($db, $type) {
	    parent::__construct($db, 'shop_days', 'xshopDays', 'days_id');
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
    	if ($object->vars['monday']['changed']==true) {	
			$object->setVar('actioned', time());
			$run_plugin = true;
		}
    	if ($object->vars['tuesday']['changed']==true) {	
			$object->setVar('actioned', time());
			$run_plugin = true;
		}
    	if ($object->vars['wednesday']['changed']==true) {	
			$object->setVar('actioned', time());
			$run_plugin = true;
		}
    	if ($object->vars['thursday']['changed']==true) {	
			$object->setVar('actioned', time());
			$run_plugin = true;
		}
    	if ($object->vars['friday']['changed']==true) {	
			$object->setVar('actioned', time());
			$run_plugin = true;
		}
    	if ($object->vars['saturday']['changed']==true) {	
			$object->setVar('actioned', time());
			$run_plugin = true;
		}
    	if ($object->vars['sunday']['changed']==true) {	
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
    
    function getItem($days_id=0) {
    	if ($days_id==0)
    		return $this->create();
    	else 
    		return $this->get($days_id);
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