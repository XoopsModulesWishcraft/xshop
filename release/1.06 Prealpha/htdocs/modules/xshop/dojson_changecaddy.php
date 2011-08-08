<?php

include ('header.php');
$GLOBALS['xoopsLogger']->activated = false;

$passkey = $_GET['key'];
$uid = $_GET['uid'];
$md5 = $_GET['md5'];
$product_id = $_GET['product_id'];
$quanity = $_GET['quanity'];
$purchase_id = $_GET['purchase_id'];
$ip = $_GET['ip'];

if (!function_exists('json_encode')) {
	include ($GLOBALS['xoops']->path('/modules/xshop/include/JSON.php'));
	$json = new services_JSON();
}

xoops_load('xoopscache');
if (!class_exists('XoopsCache'))
	xoops_load('cache');

$values = array();
$submit = true;

if ($passkey!=sha1($GLOBALS['xoopsModuleConfig']['salt'].$uid.$md5.date('Ymdh')))
{
	$values['innerhtml'][$purchase_id] = _SHOP_MN_TOKEN_KEY_EXPIRED;
} else {
	$caddy = XoopsCache::read('xshop_cart_'.$uid.'_'.$md5);
	if (!is_array($caddy)) $caddy = array();
	
	$products_handler = xoops_getmodulehandler('products', 'xshop');
	$product = $products_handler->get($product_id);
	
	if ($quanity>0) {
		$caddy[$product->getVar('shop_id')][$product_id]['quanity'] = $quanity;
		$caddy[$product->getVar('shop_id')][$product_id]['added'] = time();
		$caddy[$product->getVar('shop_id')][$product_id]['shop_id'] = $product->getVar('shop_id');
		$caddy[$product->getVar('shop_id')][$product_id]['manu_id'] = $product->getVar('manu_id');
		$caddy[$product->getVar('shop_id')][$product_id]['sales_uid'] = $product->getVar('sales_uid');
		$caddy[$product->getVar('shop_id')][$product_id]['broker_uid'] = $product->getVar('broker_uid');
		$caddy[$product->getVar('shop_id')][$product_id]['shipping_id'] = $product->getVar('shipping_uid');
		$caddy[$product->getVar('shop_id')][$product_id]['cat_id'] = $product->getVar('cat_id');
		$caddy[$product->getVar('shop_id')][$product_id]['currency_id'] = $product->getVar('currency_id');
		$caddy[$product->getVar('shop_id')][$product_id]['product_id'] = $product->getVar('product_id');
		$caddy[$product->getVar('shop_id')][$product_id]['handling'] = change_money_rate($GLOBALS['xoopsModuleConfig']['payment_currency'], $product->getVar('currency_id'), $product->getHandling($caddy[$product->getVar('shop_id')][$product_id]['quanity']));
		$caddy[$product->getVar('shop_id')][$product_id]['shipping'] = change_money_rate($GLOBALS['xoopsModuleConfig']['payment_currency'], $product->getVar('currency_id'), $product->getShipping($caddy[$product->getVar('shop_id')][$product_id]['quanity']));
		$caddy[$product->getVar('shop_id')][$product_id]['total'] = change_money_rate($GLOBALS['xoopsModuleConfig']['payment_currency'], $product->getVar('currency_id'), $product->getTotal($caddy[$product->getVar('shop_id')][$product_id]['quanity']));
		$caddy[$product->getVar('shop_id')][$product_id]['tax'] = change_money_rate($GLOBALS['xoopsModuleConfig']['payment_currency'], $product->getVar('currency_id'), $product->getTax($caddy[$product->getVar('shop_id')][$product_id]['quanity'], $ip));
		$caddy[$product->getVar('shop_id')][$product_id]['discount'] = $product->getDiscount($caddy[$product->getVar('shop_id')][$product_id]['quanity']);
		$caddy[$product->getVar('shop_id')][$product_id]['rate'] = change_money_rate($GLOBALS['xoopsModuleConfig']['payment_currency'], $product->getVar('currency_id'), 1);
		$caddy[$product->getVar('shop_id')][$product_id]['money']['handling'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], change_money_rate($GLOBALS['xoopsModuleConfig']['payment_currency'], $product->getVar('currency_id'), $product->getHandling($caddy[$product->getVar('shop_id')][$product_id]['quanity'])));
		$caddy[$product->getVar('shop_id')][$product_id]['money']['shipping'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], change_money_rate($GLOBALS['xoopsModuleConfig']['payment_currency'], $product->getVar('currency_id'), $product->getShipping($caddy[$product->getVar('shop_id')][$product_id]['quanity'])));
		$caddy[$product->getVar('shop_id')][$product_id]['money']['total'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], change_money_rate($GLOBALS['xoopsModuleConfig']['payment_currency'], $product->getVar('currency_id'), $product->getTotal($caddy[$product->getVar('shop_id')][$product_id]['quanity'])));
		$caddy[$product->getVar('shop_id')][$product_id]['money']['tax'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], change_money_rate($GLOBALS['xoopsModuleConfig']['payment_currency'], $product->getVar('currency_id'), $product->getTax($caddy[$product->getVar('shop_id')][$product_id]['quanity'], $ip)));
		$caddy[$product->getVar('shop_id')][$product_id]['money']['discount'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], change_money_rate($GLOBALS['xoopsModuleConfig']['payment_currency'], $product->getVar('currency_id'), $caddy[$product->getVar('shop_id')][$product_id]['discount']['amount']));
		$caddy[$product->getVar('shop_id')][$product_id]['money']['rate'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], change_money_rate($GLOBALS['xoopsModuleConfig']['payment_currency'], $product->getVar('currency_id'), 1));
		
		$values['innerhtml']['quanity_'.$product_id] = $caddy[$product->getVar('shop_id')][$product_id]['quanity'];		
		$values['innerhtml']['handling_'.$product_id] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$product->getVar('shop_id')][$product_id]['handling']);
		$values['innerhtml']['shipping_'.$product_id] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$product->getVar('shop_id')][$product_id]['shipping']);
		$values['innerhtml']['tax_'.$product_id] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$product->getVar('shop_id')][$product_id]['tax']);
		$values['innerhtml']['total_'.$product_id] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$product->getVar('shop_id')][$product_id]['total']);
		$values['innerhtml']['discount_'.$product_id] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$product->getVar('shop_id')][$product_id]['discount']['amount']);
	}

	unset($caddy['totals']);
	foreach($caddy as $shop_id => $valuesb) {
		unset($caddy[$shop_id]['totals']);
		if (is_numeric($shop_id)) {
			foreach($valuesb as $prod_id => $value) {
				if (is_numeric($prod_id)) {
					$caddy[$shop_id]['totals']['handling'] = $caddy[$shop_id]['totals']['handling'] + $caddy[$shop_id][$prod_id]['handling'];		
					$caddy[$shop_id]['totals']['shipping'] = $caddy[$shop_id]['totals']['shipping'] + $caddy[$shop_id][$prod_id]['shipping'];
					$caddy[$shop_id]['totals']['total'] = $caddy[$shop_id]['totals']['total'] + $caddy[$shop_id][$prod_id]['total'];
					$caddy[$shop_id]['totals']['tax'] = $caddy[$shop_id]['totals']['tax'] + $caddy[$shop_id][$prod_id]['tax'];
					$caddy[$shop_id]['totals']['discount'] = $caddy[$shop_id]['totals']['discount'] + $caddy[$shop_id][$prod_id]['discount']['amount'];
					$caddy[$shop_id]['totals']['grand'] = $caddy[$shop_id]['totals']['grand'] + ($caddy[$shop_id]['totals']['handling'] + $caddy[$shop_id]['totals']['shipping'] + $caddy[$shop_id]['totals']['total'] - $caddy[$shop_id]['totals']['discount'] + $caddy[$shop_id][$prod_id]['tax']);
					$caddy[$shop_id]['money']['handling'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['handling']);		
					$caddy[$shop_id]['money']['shipping'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['shipping']);
					$caddy[$shop_id]['money']['total'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['total']);
					$caddy[$shop_id]['money']['tax'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['tax']);
					$caddy[$shop_id]['money']['discount'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['discount']);
					$caddy[$shop_id]['money']['grand'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['grand']);
				} 
			}
			$values['innerhtml']['handling_total_'.$shop_id] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['handling']);
			$values['innerhtml']['shipping_total_'.$shop_id] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['shipping']);
			$values['innerhtml']['total_total_'.$shop_id] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['total']);
			$values['innerhtml']['discount_total_'.$shop_id] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['discount']);
			$values['innerhtml']['tax_total_'.$shop_id] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['tax']);
			$values['innerhtml']['grand_total_'.$shop_id] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy[$shop_id]['totals']['grand']);
			$caddy['totals']['handling'] = $caddy['totals']['handling'] + $caddy[$shop_id]['totals']['handling'];
			$caddy['totals']['shipping'] = $caddy['totals']['shipping'] + $caddy[$shop_id]['totals']['shipping'];
			$caddy['totals']['tax'] = $caddy['totals']['tax'] + $caddy[$shop_id]['totals']['tax'];
			$caddy['totals']['total'] = $caddy['totals']['total'] + $caddy[$shop_id]['totals']['total'];
			$caddy['totals']['discount'] = $caddy['totals']['discount'] + $caddy[$shop_id]['totals']['discount'];
			$caddy['totals']['grand'] = $caddy['totals']['grand'] + $caddy[$shop_id]['totals']['grand'];
			$caddy['money']['handling'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['handling']);		
			$caddy['money']['shipping'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['shipping']);
			$caddy['money']['total'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['total']);
			$caddy['money']['tax'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['tax']);
			$caddy['money']['discount'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['discount']);
			$caddy['money']['grand'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['grand']);
	
		}
	}
	
	$values['innerhtml']['handling_grand'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['handling']);
	$values['innerhtml']['shipping_grand'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['shipping']);
	$values['innerhtml']['total_grand'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['total']);
	$values['innerhtml']['tax_grand'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['tax']);
	$values['innerhtml']['discount_grand'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['discount']);
	$values['innerhtml']['grand_grand'] = get_money_format($GLOBALS['xoopsModuleConfig']['payment_currency'], $caddy['totals']['grand']);
		
	if (XoopsCache::write('xshop_cart_'.$uid.'_'.$md5, $caddy, $GLOBALS['xoopsModuleConfig']['keep'])) {
		$values['innerhtml'][$purchase_id] = _SHOP_MN_SUCCESSFUL;
	} else {
		$values['innerhtml'][$purchase_id] = _SHOP_MN_UNSUCCESSFUL;
	}
}

if (!function_exists('json_encode')) {
	print $json->encode($values);
} else {
	print json_encode($values);
}
?>