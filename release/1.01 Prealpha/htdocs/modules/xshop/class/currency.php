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
}

class xshopCurrencyHandler extends XoopsPersistableObjectHandler
{
   	
    function xshopCurrencyHandler($db, $type) {
	    parent::__construct($db, 'shop_currency', 'xshopCurrency', 'currency_id');
    }   
}
?>