<?php
	function PaidXShopHook($invoice) {
	
		$orders_handler = xoops_getmodulehandler('orders', 'xshop');
		$vars = explode('|', $invoice->getVar('key'));
		$criteria = new CriteriaCompo(new Criteria('key', $vars[0]));
		$criteria->add(new Criteria('order_id', $vars[1]));
		
		foreach($orders_handler->getObjects($criteria, true) as $order_id => $order) {
			$order->setVar('mode', '_SHOP_MI_ORDER_CLOSEDORDER');
			if ($invoice->getVar('remittion')=='FRAUD')
				$order->setVar('remittion', '_SHOP_MI_ORDER_FRAUDPAID');
			else 
				$order->setVar('remittion', '_SHOP_MI_ORDER_PAID');
			$order->setVar('paid', time());
			$orders_handler->insert($order, true);
		}
				
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');		
		return PaidXPaymentHook($invoice);
		
	}
	
	function UnpaidXShopHook($invoice) {
		
		$orders_handler = xoops_getmodulehandler('orders', 'xshop');
		$vars = explode('|', $invoice->getVar('key'));
		$criteria = new CriteriaCompo(new Criteria('key', $vars[0]));
		$criteria->add(new Criteria('order_id', $vars[1]));
		
		foreach($orders_handler->getObjects($criteria, true) as $order_id => $order) {
			$order->setVar('mode', '_SHOP_MI_ORDER_OPENORDER');
			if ($invoice->getVar('remittion')=='FRAUD')
				$order->setVar('remittion', '_SHOP_MI_ORDER_FRAUDUNPAID');
			else 
				$order->setVar('remittion', '_SHOP_MI_ORDER_UNPAID');
			$order->setVar('paid', 0);
			$orders_handler->insert($order, true);
		}
		
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');
		return UnpaidXPaymentHook($invoice);		
	}
	
	function CancelXShopHook($invoice) {
		
		$orders_handler = xoops_getmodulehandler('orders', 'xshop');
		$vars = explode('|', $invoice->getVar('key'));
		$criteria = new CriteriaCompo(new Criteria('key', $vars[0]));
		$criteria->add(new Criteria('order_id', $vars[1]));
		
		foreach($orders_handler->getObjects($criteria, true) as $order_id => $order) {
			$order->setVar('mode', '_SHOP_MI_ORDER_CLOSEDORDER');
			if ($invoice->getVar('remittion')=='FRAUD')
				$order->setVar('remittion', '_SHOP_MI_ORDER_FRAUDCANCELLED');
			else 
				$order->setVar('remittion', '_SHOP_MI_ORDER_CANCELLED');
			$order->setVar('paid', time());
			$order->setVar('ended', time());
			$orders_handler->insert($order, true);
		}
		include_once $GLOBALS['xoops']->path('/modules/xpayment/plugin/xpayment.php');
		return CancelXPaymentHook($invoice);
	}
	
	?>