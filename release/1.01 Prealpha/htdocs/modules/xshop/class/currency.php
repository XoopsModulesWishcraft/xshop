<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopCurrency extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('currency_id', XOBJ_DTYPE_INT);
        $this->initVar('item_id', XOBJ_DTYPE_INT);
        $this->initVar('symbol_left', XOBJ_DTYPE_TXTBOX, '$', 3);
        $this->initVar('symbol_right', XOBJ_DTYPE_TXTBOX, '', 3);
        $this->initVar('decimal_places', XOBJ_DTYPE_INT);
        $this->initVar('thousand_seperator', XOBJ_DTYPE_TXTBOX, ',', 2);
        $this->initVar('iso_code', XOBJ_DTYPE_TXTBOX, 'AUD', 3);
        $this->initVar('default', XOBJ_DTYPE_INT);
        $this->initVar('rate', XOBJ_DTYPE_DECIMAL);
        $this->initVar('exchange_currency_id', XOBJ_DTYPE_INT);
        $this->initVar('exchange_comparison_rate', XOBJ_DTYPE_DECIMAL);
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
    	
    	$items_digest_handler =& xoops_getmodulehandler('items_digest', 'xshop');
    	$digest = $items_digest_handler->getItem($this->getVar('item_id'));
    	
    	if (!empty($index))
    		$id = $index . '['. $this->getVar('currency_id') . ']';
    	else 
    		$id = $this->getVar('currency_id');
    	
    	if ($render==true||$captions==true) {
	    	
	    	$frmobj = $digest->getForm($querystring, true, false, $id.'[item]', 'item', $frmobj);
	    	$frmobj[$cursor]['has_item'] = new XoopsFormHidden('hasItem', true);
	    	$frmobj[$cursor]['symbol_left'] = new XoopsFormText(_SHOP_FRM_CURRENCY_SYMBOL_LEFT,  $id.'[symbol_left]', 3, 10, $this->getVar('symbol_left'));
	    	$frmobj[$cursor]['symbol_left']->setDescription(_SHOP_FRM_CURRENCY_SYMBOL_LEFT_DESC);
	    	$frmobj[$cursor]['symbol_right'] = new XoopsFormText(_SHOP_FRM_CURRENCY_SYMBOL_RIGHT,  $id.'[symbol_right]', 3, 10, $this->getVar('symbol_right'));
	    	$frmobj[$cursor]['symbol_right']->setDescription(_SHOP_FRM_CURRENCY_SYMBOL_RIGHT_DESC);
	    	$frmobj[$cursor]['decimal_places'] = new XoopsFormText(_SHOP_FRM_CURRENCY_DECIMAL_PLACE,  $id.'[decimal_places]', 3, 10, $this->getVar('decimal_places'));
	    	$frmobj[$cursor]['decimal_places']->setDescription(_SHOP_FRM_CURRENCY_DECIMAL_PLACE_DESC);
	    	$frmobj[$cursor]['thousand_seperator'] = new XoopsFormText(_SHOP_FRM_CURRENCY_THOUSAND_SEP,  $id.'[thousand_seperator]', 3, 10, $this->getVar('thousand_seperator'));
	    	$frmobj[$cursor]['thousand_seperator']->setDescription(_SHOP_FRM_CURRENCY_THOUSAND_SEP_DESC);
	    	$frmobj[$cursor]['iso_code'] = new XoopsFormText(_SHOP_FRM_CURRENCY_ISO_CODE,  $id.'[iso_code]', 3, 10, $this->getVar('iso_code'));
	    	$frmobj[$cursor]['iso_code']->setDescription(_SHOP_FRM_CURRENCY_ISO_CODE_DESC);
	    	$frmobj[$cursor]['default'] = new XoopsFormRadioYN(_SHOP_FRM_CURRENCY_DEFAULT,  $id.'[default]', $this->getVar('default'));
	    	$frmobj[$cursor]['default']->setDescription(_SHOP_FRM_CURRENCY_DEFAULT_DESC);
	    	$frmobj[$cursor]['rate'] = new XoopsFormText(_SHOP_FRM_CURRENCY_RATE,  $id.'[rate]', 16, 26, $this->getVar('rate'));
	    	$frmobj[$cursor]['rate']->setDescription(_SHOP_FRM_CURRENCY_RATE_DESC);
	    	
	    	if (!empty($index))		    
	    		$frmobj[$cursor]['currency_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('currency_id').']', 'currency');
	    	else 
	    		$frmobj[$cursor]['currency_id'] = new XoopsFormHidden('id['.$this->getVar('currency_id').']', 'currency');
	    		
	    	if ($render==false)
	    		return $frmobj;
	    		
	    	$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    	$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'currency');
    	} else {
    		
	    	$frmobj = $digest->getForm($querystring, false, false, $id.'[item]', 'item', $frmobj);
	    	$frmobj[$cursor]['has_item'] = new XoopsFormHidden('hasItem', true);
	    	$frmobj[$cursor]['symbol_left'] = new XoopsFormText('',  $id.'[symbol_left]', 3, 10, $this->getVar('symbol_left'));
	    	$frmobj[$cursor]['symbol_right'] = new XoopsFormText('',  $id.'[symbol_right]', 3, 10, $this->getVar('symbol_right'));
	    	$frmobj[$cursor]['decimal_places'] = new XoopsFormText('',  $id.'[decimal_places]', 3, 10, $this->getVar('decimal_places'));
	    	$frmobj[$cursor]['thousand_seperator'] = new XoopsFormText('',  $id.'[thousand_seperator]', 3, 10, $this->getVar('thousand_seperator'));
	    	$frmobj[$cursor]['iso_code'] = new XoopsFormText('',  $id.'[iso_code]', 3, 10, $this->getVar('iso_code'));
	    	$frmobj[$cursor]['default'] = new XoopsFormRadioYN('',  $id.'[default]', $this->getVar('default'));
	    	$frmobj[$cursor]['rate'] = new XoopsFormText('',  $id.'[rate]', 16, 26, $this->getVar('rate'));

	    	if (!empty($index))		    
	    		$frmobj[$cursor]['currency_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('currency_id').']', 'currency');
	    	else 
	    		$frmobj[$cursor]['currency_id'] = new XoopsFormHidden('id['.$this->getVar('currency_id').']', 'currency');
	    		
    		return $frmobj;
    	}
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_CURRENCY, 'currency', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_CURRENCY, 'currency', $_SERVER['PHP_SELF'], 'post');
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

class xshopCurrencyHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopCurrencyHandler($db, $type) {
	    parent::__construct($db, 'shop_currency', 'xshopCurrency', 'currency_id');
    }   
}
?>