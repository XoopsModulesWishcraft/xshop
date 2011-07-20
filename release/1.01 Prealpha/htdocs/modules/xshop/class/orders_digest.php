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
}
?>