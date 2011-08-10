<?php

include ('header.php');
$GLOBALS['xoopsLogger']->activated = false;

$passkey = $_GET['key'];
$uid = $_GET['uid'];
$md5 = $_GET['md5'];
$shop_id = $_GET['shop_id'];
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
	if ($ret['a'] = XoopsCache::read('xshop_cart_'.$uid.'_'.$md5)) {
		if ($uid!=0) {
			if ($ret['b'] = XoopsCache::read('xshop_cart_0_'.$md5)){
				XoopsCache::delete('xshop_cart_0_'.$md5);
				$caddy = array_merge($ret['a'], $ret['b']);
			} else {
				$caddy = $ret['a'];
			}
		} else {
			$caddy = $ret['a'];
		}
	}  else 
			$caddy = array();
	
	if (!is_array($caddy)) $caddy = array();
	
	$products_handler = xoops_getmodulehandler('products', 'xshop');
	$orders_handler = xoops_getmodulehandler('orders', 'xshop');
	$orders_digest_handler = xoops_getmodulehandler('orders_digest', 'xshop');
	
	$output = array();
	
	if ($shop_id>0) {
		foreach($caddy[$shop_id] as $product_id => $product_cart) {
			if ($product_cart['broker_uid']!=0)
				$output['broker_uids'][$product_cart['broker_uid']] = $product_cart['broker_uid'];
			if ($product_cart['sales_uid']!=0)
				$output['sales_uids'][$product_cart['sales_uid']] = $product_cart['sales_uid'];
			if ($product_cart['cat_id']!=0)
				$output['cat_ids'][$product_cart['cat_id']] = $product_cart['cat_id'];
			if ($product_cart['manu_id']!=0)
				$output['manu_ids'][$product_cart['manu_id']] = $product_cart['manu_id'];
			if ($product_cart['shop_id']!=0)
				$output['shop_ids'][$product_cart['shop_id']] = $product_cart['shop_id'];
			if ($product_cart['product_id']!=0)
				$output['product_ids'][$product_cart['product_id']] = $product_cart['product_id'];
			if ($product_cart['discount']['discount_id']!=0)
				$output['discount_ids'][$product_cart['discount']['discount_id']] = $product_cart['discount']['discount_id'];
			$output['total'] = $output['total'] + $product_cart['total'];
			$output['handling'] = $output['handling'] + $product_cart['handling'];
			$output['shipping'] = $output['shipping'] + $product_cart['shipping'];
			$output['tax'] = $output['tax'] + $product_cart['tax'];
			if (isset($product_cart['discount']['amount'])) {
				$discount_num++;
				$output['discount_amount'] = $output['discount_amount'] + $product_cart['discount']['amount'];
				$output['discount_avg_percentile'] = $output['discount_avg_percentile'] + $product_cart['discount']['percentage'];
				$output['shipping_id'] =  $product_cart['discount']['shipping_id'];
			}
		}
		if ($discount_num>0)
			$output['discount_avg_percentile'] = $output['discount_avg_percentile'] / $discount_num; 
		$output['currency_id'] = $GLOBALS['xoopsModuleConfig']['payment_currency'];
		$output['uid'] = $uid;
		$output['user_key'] = $md5;
		$output['started'] = time();
		
		$order = $orders_handler->create();
		$order->setVars($output);
		$order->setVar('mode', '_SHOP_MI_ORDER_OPENORDER');
		$order->setVar('remittion', '_SHOP_MI_ORDER_UNPAID');
		$order->setKey();
		
		if ($order_id = $orders_handler->insert($order, true)) {
			foreach($caddy[$shop_id] as $product_id => $product_cart) {
				if (is_numeric($product_id)) {
					$values['innerhtml']['product_cart_small_'.$product_id] = _SHOP_MN_ORDER_ADDED;
					$product = $products_handler->get($product_id);
					if (is_object($product)) {
						
						$order_digest = $orders_digest_handler->create();
						$order_digest->setVar('order_id', $order_id);
						if ($output['shipping_id']!=0)
							$order_digest->setVar('shipping_id', $output['shipping_id']);
						elseif ($product->getVar('shipping_id')!=0)
							$order_digest->setVar('shipping_id', $product->getVar('shipping_id'));
						$order_digest->setVar('shop_id', $product->getVar('shop_id'));
						$order_digest->setVar('cat_id', $product->getVar('cat_id'));
						$order_digest->setVar('manu_id', $product->getVar('manu_id'));
						$order_digest->setVar('product_id', $product->getVar('product_id'));
						$order_digest->setVar('quanity', $product_cart['quanity']);
						$order_digest->setVar('price', $product_cart['total']/$product_cart['quanity']);
						$order_digest->setVar('shipping', $product_cart['shipping']/$product_cart['quanity']);
						$order_digest->setVar('handling', $product_cart['handling']/$product_cart['quanity']);
						$order_digest->setVar('tax', $product_cart['tax']/$product_cart['quanity']);
						$order_digest->setVar('weight', $product->getVar('weight'));
						$order_digest->setVar('weight_measurement', $product->getVar('weight_measurement'));
						if (!empty($product_cart['discount']['amount'])) {
							$order_digest->setVar('discount_given', true);
							$order_digest->setVar('discount_id', $product_cart['discount']['discount_id']);
							$order_digest->setVar('discount_percentile', $product_cart['discount']['percentage']);
							$order_digest->setVar('discount_amount', $product_cart['discount']['amount']/$product_cart['quanity']);
						} else {
							$order_digest->setVar('discount_given', false);
						}	
						
						$orders_digest_handler->insert($order_digest, true);
					}		
				}	
			}
		}
		
		$values['innerhtml']['button_shop_'.$shop_id] = _SHOP_MN_ORDER_CREATED;
		unset($caddy[$shop_id]);
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
		
		XoopsCache::write('xshop_cart_'.$uid.'_'.$md5, $caddy, $GLOBALS['xoopsModuleConfig']['keep']);
	}
}

if (!function_exists('json_encode')) {
	print $json->encode($values);
} else {
	print json_encode($values);
}
?>