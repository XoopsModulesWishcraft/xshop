<?php

if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class xshopOrders_digest extends XoopsObject 
{
    function __construct($type)
    {
        $this->initVar('product_order_id', XOBJ_DTYPE_INT);
        $this->initVar('order_id', XOBJ_DTYPE_INT);
        $this->initVar('con_note_id', XOBJ_DTYPE_INT);
        $this->initVar('shipping_id', XOBJ_DTYPE_INT);
        $this->initVar('shop_id', XOBJ_DTYPE_INT);
        $this->initVar('cat_id', XOBJ_DTYPE_INT);
        $this->initVar('manu_id', XOBJ_DTYPE_INT);
        $this->initVar('quanity', XOBJ_DTYPE_DECIMAL);
        $this->initVar('price', XOBJ_DTYPE_DECIMAL);
        $this->initVar('shipping', XOBJ_DTYPE_DECIMAL);
        $this->initVar('handling', XOBJ_DTYPE_DECIMAL);
        $this->initVar('tax', XOBJ_DTYPE_DECIMAL);
        $this->initVar('weight', XOBJ_DTYPE_DECIMAL);
		$this->initVar('weight_measurement', XOBJ_DTYPE_ENUM, '_SHOP_MI_WEIGHT_KILOS', false, false, false, array('_SHOP_MI_WEIGHT_KILOS', '_SHOP_MI_WEIGHT_POUNDS'));
        $this->initVar('discount_given', XOBJ_DTYPE_INT);
        $this->initVar('discount_id', XOBJ_DTYPE_INT);
        $this->initVar('discount_percentile', XOBJ_DTYPE_DECIMAL);
        $this->initVar('discount_amount', XOBJ_DTYPE_DECIMAL);
    }
}

class xshopOrders_digestHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopOrders_digestHandler($db, $type) {
	    parent::__construct($db, 'shop_orders_digest', 'xshopOrders_digest', 'product_order_id');
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