<?php

	include('../../mainfile.php');
	include('include/functions.php');	
	include('include/forms.xshop.php');
	include('include/objects.xshop.php');

	$GLOBALS['user'] = xshop_getuser_id();
	
	$op = isset($_REQUEST['op'])?$_REQUEST['op']:"default";
	$fct = isset($_REQUEST['fct'])?$_REQUEST['fct']:"default";
	
	$limit = !empty($_REQUEST['limit'])?$_REQUEST['limit']:array('shops'=>30, 'products'=>30, 'manufactures'=>30);
	$start = !empty($_REQUEST['start'])?$_REQUEST['start']:array('shops'=>0, 'products'=>0, 'manufactures'=>0);
	$order = !empty($_REQUEST['order'])?$_REQUEST['order']:array('shops'=>'DESC', 'products'=>'DESC', 'manufactures'=>'DESC');
	$sort = !empty($_REQUEST['sort'])?$_REQUEST['sort']:array('shops'=>'created', 'products'=>'created', 'manufactures'=>'created');
	$filter = !empty($_REQUEST['filter'])?$_REQUEST['filter']:array('shops'=>'1,1', 'products'=>'1,1', 'manufactures'=>'1,1');
	
	$product_id = !empty($_REQUEST['product_id'])?intval($_REQUEST['product_id']):0;
	$cat_id = !empty($_REQUEST['cat_id'])?intval($_REQUEST['cat_id']):0;
	$manu_id = !empty($_REQUEST['manu_id'])?intval($_REQUEST['manu_id']):0;
	$shop_id = !empty($_REQUEST['shop_id'])?intval($_REQUEST['shop_id']):0;
	
?>