<?php

	include('header.php');

	switch($op) {
		default:
			switch($fct){
				default:
					
					$category_handler = xoops_getmodulehandler('category', 'xshop');
					$manufactures_handler = xoops_getmodulehandler('manufactures', 'xshop');
					$products_handler = xoops_getmodulehandler('products', 'xshop');
					$shops_handler = xoops_getmodulehandler('shops', 'xshop');
					
					$category_in = $category_handler->getIn($cat_id, $shop_id, $manu_id, $product_id);
					$manufactures_in = $manufactures_handler->getIn((empty($cat_id)?$category_in:$cat_id), $shop_id, $manu_id, $product_id);
					$shops_in = $shops_handler->getIn((empty($cat_id)?$category_in:$cat_id), $shop_id, (empty($manu_id)?$manufactures_in:$manu_id), $product_id, true, true);
					$products_in = $products_handler->getIn((empty($cat_id)?$category_in:$cat_id), (empty($shop_id)?$shops_in:$shop_id), (empty($manu_id)?$manufactures_in:$manu_id), $product_id); 

					$criteria = new Criteria('manu_id', '('.implode(',', $manufactures_in).')', 'IN');
					$manufactures_ttl = $manufactures_handler->getCount($criteria);
					$manufactures_pagenav = new XoopsPageNav($manufactures_ttl, $limit, $start['manufactures'], 'start[manufactures]', 'limit[manufactures]='.$limit['manufactures'].'&sort[manufactures]='.$sort['manufactures'].'&limit[products]='.$limit['products'].'&sort[products]='.$sort['products'].'&order[products]='.$order['products'].'&limit[shops]='.$limit['shops'].'&sort[shops]='.$sort['shops'].'&order[shops]='.$order['shops'].'&op='.$op.'&fct='.$fct.'&start[products]='.$start['products'].'&start[shops]='.$start['shops']);
					$criteria->setStart($start['manufactures']);
					$criteria->setLimit($limit['manufactures']);
					$criteria->setSort('`'.$sort['manufactures'].'`');
					$criteria->setOrder($order['manufactures']);
					$manufactures = $manufactures_handler->getObjects($criteria, true);

					$criteria = new Criteria('shop_id', '('.implode(',', $shops_in).')', 'IN');
					$shops_ttl = $shops_handler->getCount($criteria);
					$shops_pagenav = new XoopsPageNav($shops_ttl, $limit, $start['shops'], 'start[shops]', 'limit[manufactures]='.$limit['manufactures'].'&sort[manufactures]='.$sort['manufactures'].'&limit[products]='.$limit['products'].'&sort[products]='.$sort['products'].'&order[products]='.$order['products'].'&limit[shops]='.$limit['shops'].'&sort[shops]='.$sort['shops'].'&order[shops]='.$order['shops'].'&op='.$op.'&fct='.$fct.'&start[products]='.$start['products'].'&start[manufactures]='.$start['manufactures']);
					$criteria->setStart($start['shops']);
					$criteria->setLimit($limit['shops']);
					$criteria->setSort('`'.$sort['shops'].'`');
					$criteria->setOrder($order['shops']);
					$shops = $shops_handler->getObjects($criteria, true);
					
					$criteria = new Criteria('product_id', '('.implode(',', $products_in).')', 'IN');
					$products_ttl = $products_handler->getCount($criteria);
					$products_pagenav = new XoopsPageNav($products_ttl, $limit, $start['products'], 'start[products]', 'limit[manufactures]='.$limit['manufactures'].'&sort[manufactures]='.$sort['manufactures'].'&limit[products]='.$limit['products'].'&sort[products]='.$sort['products'].'&order[products]='.$order['products'].'&limit[shops]='.$limit['shops'].'&sort[shops]='.$sort['shops'].'&order[shops]='.$order['shops'].'&op='.$op.'&fct='.$fct.'&start[manufactures]='.$start['manufactures'].'&start[shops]='.$start['shops']);
					$criteria->setStart($start['products']);
					$criteria->setLimit($limit['products']);
					$criteria->setSort('`'.$sort['products'].'`');
					$criteria->setOrder($order['products']);
					$products = $products_handler->getObjects($criteria, true);

					$xoopsOption['template_main'] = 'xshop_index.html';
					include($GLOBALS['xoops']->path('/header.php'));
				
					$GLOBALS['xoopsTpl']->assign('categories', $category_handler->renderSmarty($cat_id));
					$GLOBALS['xoopsTpl']->assign('php_self', $_SERVER['PHP_SELF']);
					$GLOBALS['xoopsTpl']->assign('manufactures_pagenav', $manufactures_pagenav->renderNav());
					$GLOBALS['xoopsTpl']->assign('shops_pagenav', $shops_pagenav->renderNav());
					$GLOBALS['xoopsTpl']->assign('products_pagenav', $products_pagenav->renderNav());
					$GLOBALS['xoopsTpl']->assign('limit', $limit);
					$GLOBALS['xoopsTpl']->assign('start', $start);
					$GLOBALS['xoopsTpl']->assign('order', $order);
					$GLOBALS['xoopsTpl']->assign('sort', $sort);
					$GLOBALS['xoopsTpl']->assign('user', xshop_getuser_id());
					$GLOBALS['xoopsTpl']->assign('xoConfig', $GLOBALS['xoopsModuleConfig']);
					$GLOBALS['xoopsTpl']->assign('xoopsConfig', $GLOBALS['xoopsConfig']);
					
					foreach($products as $product_id => $product) {
						$GLOBALS['xoopsTpl']->append('products', $product->toArray());
					}

					foreach($shops as $shop_id => $shop){
						$GLOBALS['xoopsTpl']->append('shops', $shop->toArray());
					}
					foreach($manufactures as $manufacture_id => $manufacture){
						$GLOBALS['xoopsTpl']->append('manufactures', $manufacture->toArray());
					}

					include($GLOBALS['xoops']->path('/footer.php'));
			}
	}
?>
