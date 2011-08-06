<?php

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

class xshopAutotax extends XoopsObject
{
	
    function xshopAutotax($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('country', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('code', XOBJ_DTYPE_TXTBOX, null, false, 3);
		$this->initVar('rate', XOBJ_DTYPE_DECIMAL, 0, false);		
	}
	
	function toArray() {
		$ret = parent::toArray();
		xoops_load('xoopsformloader');
		$ret['form']['id'] = new XoopsFormHidden('id['.$this->getVar('id').']', $this->getVar('id'));
		$ret['form']['country'] = new XoopsFormText('', $this->getVar('id').'[country]', 45, 128, $this->getVar('country'));
		$ret['form']['code'] = new XoopsFormText('', $this->getVar('id').'[code]', 5, 3, $this->getVar('code'));
		$ret['form']['rate'] = new XoopsFormText('', $this->getVar('id').'[rate]', 15, 30, $this->getVar('rate'));
		$ret['form']['id'] = $ret['form']['id']->render();
		$ret['form']['country'] = $ret['form']['country']->render();
		$ret['form']['code'] = $ret['form']['code']->render();
		$ret['form']['rate'] = $ret['form']['rate']->render();
		return $ret;
	}
}


class xshopAutotaxHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'xpayment_autotax', 'xshopAutotax', "id", "country");
    }
    
    function getTaxRate($code) {
    	$criteria = new Criteria('code', $code);
    	$objects = $this->getObjects($criteria, false);
    	if (is_object($objects[0]))
    		return $objects[0]->getVar('rate');
    	else
    		return 0;
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