<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopDays extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('days_id', XOBJ_DTYPE_INT);
        $this->initVar('item_id', XOBJ_DTYPE_INT);
        $this->initVar('monday', XOBJ_DTYPE_ENUM, '_SHOP_MI_DAYS_CLOSED', false, false, false, array('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER'));
        $this->initVar('tuesday', XOBJ_DTYPE_ENUM, '_SHOP_MI_DAYS_CLOSED', false, false, false, array('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER'));
        $this->initVar('wednesday', XOBJ_DTYPE_ENUM, '_SHOP_MI_DAYS_CLOSED', false, false, false, array('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER'));
        $this->initVar('thursday', XOBJ_DTYPE_ENUM, '_SHOP_MI_DAYS_CLOSED', false, false, false, array('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER'));
        $this->initVar('friday', XOBJ_DTYPE_ENUM, '_SHOP_MI_DAYS_CLOSED', false, false, false, array('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER'));
        $this->initVar('saturday', XOBJ_DTYPE_ENUM, '_SHOP_MI_DAYS_CLOSED', false, false, false, array('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER'));
        $this->initVar('sunday', XOBJ_DTYPE_ENUM, '_SHOP_MI_DAYS_CLOSED', false, false, false, array('_SHOP_MI_DAYS_OPEN','_SHOP_MI_DAYS_CLOSED','_SHOP_MI_DAYS_DISPLAYONLY','_SHOP_MI_DAYS_NOSALE','_SHOP_MI_DAYS_DISCOUNT','_SHOP_MI_DAYS_CALL','_SHOP_MI_DAYS_EMAIL','_SHOP_MI_DAYS_OTHER'));
        $this->initVar('md5', XOBJ_DTYPE_TXTBOX, '', 32);
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('updated', XOBJ_DTYPE_INT);
        $this->initVar('actioned', XOBJ_DTYPE_INT);
        
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
}
?>