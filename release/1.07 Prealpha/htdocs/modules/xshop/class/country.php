<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopCountry extends XoopsObject 
{
    function __construct()
    {
        $this->initVar('country_id', XOBJ_DTYPE_INT);
        $this->initVar('alpha2', XOBJ_DTYPE_TXTBOX, false, 2);
        $this->initVar('alpha3', XOBJ_DTYPE_TXTBOX, false, 3);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, false, 200);
        
    }
    
	function toArray() {
    	$ret = parent::toArray();
       	$frmobj = $this->getForm($_SERVER['QUERY_STRING'], false, false, '', 'base', array());
    	foreach($frmobj as $key => $value) {
    		if ($key!='required') {
   	 			foreach($value as $field => $valueb) {
		    		$ret['forms'][$key][$field] = $frmobj[$key][$field]->render();
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
    
    
    function getForm($querystring, $captions = true, $render = true, $index = '', $cursor = 'form', $frmobj='', $const = '_SHOP_MI_COUNTRY') {
        xoops_loadLanguage('forms', 'xshop');
    	
    	$frmobj['required'][] = 'alpha2';
		$frmobj['required'][] = 'alpha3';
		$frmobj['required'][] = 'name';
        
        if (!empty($index))
    		$id = $index . '['. $this->getVar('country_id') . ']';
    	else 
    		$id = $this->getVar('country_id');
    		
    	if ($render==true||$captions==true) {
	  		if (defined($const)&&defined($const.'_LABEL')&&defined($const.'_LABEL_DESC')) {
		    	$frmobj[$cursor]['label'] = new XoopsFormLabel('<font style="font-size:1.25em;">'.constant($const).'</font>', '<font style="font-size:1.25em;">'.sprintf(constant($const.'_LABEL'), constant($const)).'</font>');
		    	$frmobj[$cursor]['label']->setDescription(constant($const.'_LABEL_DESC'));
     		}   
	    	$frmobj[$cursor]['alpha2'] = new XoopsFormText(_SHOP_FRM_COUNTRY_ALPHA2, $id.'[alpha2]', 2, 4, $this->getVar('alpha2'));
	    	$frmobj[$cursor]['alpha2']->setDescription(_SHOP_FRM_COUNTRY_ALPHA2_DESC);
	    	$frmobj[$cursor]['alpha3'] = new XoopsFormText(_SHOP_FRM_COUNTRY_ALPHA3, $id.'[alpha2]', 3, 4, $this->getVar('alpha3'));
	    	$frmobj[$cursor]['alpha3']->setDescription(_SHOP_FRM_COUNTRY_ALPHA3_DESC);
	    	$frmobj[$cursor]['name'] = new XoopsFormText(_SHOP_FRM_COUNTRY_NAME, $id.'[name]', 35, 200, $this->getVar('name'));
	    	$frmobj[$cursor]['name']->setDescription(_SHOP_FRM_COUNTRY_NAME_DESC);
			
		    if (!empty($index))		    
	    		$frmobj[$cursor]['country_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('country_id').']', 'country');
	    	else 
	    		$frmobj[$cursor]['country_id'] = new XoopsFormHidden('id['.$this->getVar('country_id').']', 'country');
	    		
	    	if ($render==false)
	    		return $frmobj;
	    	
	    	if ($_REQUEST['fct']=='country') {
	    		$frmobj[$cursor]['op'] = new XoopsFormHidden('op', 'save');
	    		$frmobj[$cursor]['fct'] = new XoopsFormHidden('fct', 'country');
	    	}
    	} else {
	    	
	    	$frmobj[$cursor]['alpha2'] = new XoopsFormText('', $id.'[alpha2]', 2, 4, $this->getVar('alpha2'));
	    	$frmobj[$cursor]['alpha3'] = new XoopsFormText('', $id.'[alpha2]', 3, 4, $this->getVar('alpha3'));
	    	$frmobj[$cursor]['name'] = new XoopsFormText('', $id.'[name]', 35, 200, $this->getVar('name'));
	    				
		    if (!empty($index))		    
	    		$frmobj[$cursor]['country_id'] = new XoopsFormHidden($index.'[id]['.$this->getVar('country_id').']', 'country');
	    	else 
	    		$frmobj[$cursor]['country_id'] = new XoopsFormHidden('id['.$this->getVar('country_id').']', 'country');	    	
	    	return $frmobj;
    	}
    	
    	if ($this->isNew()) {
    		$form = new XoopsThemeForm(_SHOP_FRM_NEW_COUNTRY, 'contacts', $_SERVER['PHP_SELF'], 'post');
    	} else {
    		$form = new XoopsThemeForm(_SHOP_FRM_EDIT_COUNTRY, 'contacts', $_SERVER['PHP_SELF'], 'post');
    	}

    	$frmobj['submit']['submit'] = new XoopsFormButton('', _SUBMIT, 'submit', _SUBMIT);
    	
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

class xshopCountryHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopCountryHandler($db, $type) {
	    parent::__construct($db, 'shop_country', 'xshopCountry', 'country_id');
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