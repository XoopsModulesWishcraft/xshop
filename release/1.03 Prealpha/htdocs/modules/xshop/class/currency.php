<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopCurrency extends XoopsObject 
{
	var $_objects = array();
	
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
    
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj = array(), $const = '_SHOP_MI_CURRENCY') {
    
    	xoops_loadLanguage('forms', 'xshop');
    	
    	$items_digest_handler =& xoops_getmodulehandler('items_digest', 'xshop');
    	$digest = $items_digest_handler->getItem($this->getVar('item_id'));
    	
    	if (!empty($index))
    		$id = $index . '['. $this->getVar('currency_id') . ']';
    	else 
    		$id = $this->getVar('currency_id');
    	
    	if ($render==true||$captions==true) {
    		if (defined($const)&&defined($const.'_LABEL')&&defined($const.'_LABEL_DESC')) {
		    	$frmobj[$cursor]['label'] = new XoopsFormLabel('<font style="font-size:1.25em;">'.constant($const).'</font>', '<font style="font-size:1.25em;">'.sprintf(constant($const.'_LABEL'), constant($const)).'</font>');
		    	$frmobj[$cursor]['label']->setDescription(constant($const.'_LABEL_DESC'));
     		}   	    	
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
	    	if ($_REQUEST['fct']=='currency') {	
	    		$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    		$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'currency');
	    	}
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
    	
    	$frmobj['submit']['submit'] = new XoopsFormButton('', _SUBMIT, 'submit', _SUBMIT);
    	
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