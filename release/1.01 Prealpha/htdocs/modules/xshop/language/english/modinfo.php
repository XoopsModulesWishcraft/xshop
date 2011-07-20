<?php

	// Header
	define('_SHOP_MI_DESCRIPTION', 'xShop is a shopping cart for XOOPS which uses X-payment for payment of items.');
	define('_SHOP_MI_CREDITS', 'Simon Roberts (wishcraft) - simon@chronolabs.coop');
	
	// Administrator Menus
	define('_SHOP_MI_ADMIN_MENU1', 'Shops Configuration');
	define('_SHOP_MI_ADMIN_MENU2', 'Categories Configuration');
	define('_SHOP_MI_ADMIN_MENU3', 'Products Configuration');
	define('_SHOP_MI_ADMIN_MENU4', 'Orders');
	define('_SHOP_MI_ADMIN_MENU5', 'Manufactures Configuration');
	define('_SHOP_MI_ADMIN_MENU6', 'Shipping Configuration');
	define('_SHOP_MI_ADMIN_MENU7', 'Discounts Configuration');
	define('_SHOP_MI_ADMIN_MENU8', 'Contacts');
	define('_SHOP_MI_ADMIN_MENU9', 'Addresses');
	define('_SHOP_MI_ADMIN_MENU10', 'Country\'s');
	define('_SHOP_MI_ADMIN_MENU11', 'Regions');
	define('_SHOP_MI_ADMIN_MENU12', 'Language Items Configuration');
	define('_SHOP_MI_ADMIN_MENU13', 'Gallery Configuration');
	define('_SHOP_MI_ADMIN_MENU14', 'Tax Configuration');
	define('_SHOP_MI_ADMIN_MENU15', 'Downloads');
	define('_SHOP_MI_ADMIN_MENU16', 'Extra Fields');
	define('_SHOP_MI_ADMIN_MENU17', 'Permissions');
	
	// Enumerators
	define('_SHOP_MI_ADDRESS_MANUFACTURE', 'Manufacture');
	define('_SHOP_MI_ADDRESS_SHOP', 'Shop');
	define('_SHOP_MI_ADDRESS_POSTAL', 'Postal');
	define('_SHOP_MI_ADDRESS_DELIEVERY', 'Delievery');
	define('_SHOP_MI_ADDRESS_ORDERBY', 'Order By');
	define('_SHOP_MI_ADDRESS_SHOW', 'Show');
	define('_SHOP_MI_ADDRESS_OTHER', 'Other Address');
	define('_SHOP_MI_ADDRESS_RETURNEDGOODS', 'Return Goods');
	define('_SHOP_MI_ADDRESS_FRAUD', 'Fraudulent Address');
	define('_SHOP_MI_ADDRESS_STOLENINMAIL', 'Stolen in Mail');
	define('_SHOP_MI_ADDRESS_EXPRESSDELIEVERY', 'Express Delievery');
	define('_SHOP_MI_ADDRESS_NONE', 'None');
	
	define('_SHOP_MI_CONTACTS_EMAIL', 'Email');
	define('_SHOP_MI_CONTACTS_PHONE', 'Phone');
	define('_SHOP_MI_CONTACTS_MOBILE', 'Mobile');
	define('_SHOP_MI_CONTACTS_FAX', 'Fax');
	define('_SHOP_MI_CONTACTS_PAGER', 'Pager');
	define('_SHOP_MI_CONTACTS_OTHER', 'Other');
	
	define('_SHOP_MI_DAYS_OPEN', 'Open');
	define('_SHOP_MI_DAYS_CLOSED', 'Closed');
	define('_SHOP_MI_DAYS_DISPLAYONLY', 'Display Only');
	define('_SHOP_MI_DAYS_NOSALE', 'No Sale');
	define('_SHOP_MI_DAYS_DISCOUNT', 'Discount');
	define('_SHOP_MI_DAYS_CALL', 'Call Now');
	define('_SHOP_MI_DAYS_EMAIL', 'Email Now');
	define('_SHOP_MI_DAYS_OTHER', 'Do Now');
	
	define('_SHOP_MI_DISCOUNT_QUITSTOCK', 'Discount Quit Stock');
	define('_SHOP_MI_DISCOUNT_GENERAL', 'General Discount');
	define('_SHOP_MI_DISCOUNT_WHOLESALE', 'Wholesale Discount');
	define('_SHOP_MI_DISCOUNT_NOREORDER', 'No Reorder Discount');
	define('_SHOP_MI_DISCOUNT_QUANITY', 'Quantity Discount');
	define('_SHOP_MI_DISCOUNT_OTHER', 'Other form of Discount');
	
	define('_SHOP_MI_GALLERY_CAT_LOGO', 'Catelogue Logo');
	define('_SHOP_MI_GALLERY_MANU_LOGO', 'Manufacture Logo');
	define('_SHOP_MI_GALLERY_PRODUCT', 'Product');
	define('_SHOP_MI_GALLERY_SHOP_LOGO', 'Shop Logo');
	define('_SHOP_MI_GALLERY_SHIPPING_LOGO', 'Shipping Logo');
	define('_SHOP_MI_GALLERY_DISCOUNT_LOGO', 'Discount Logo');
	define('_SHOP_MI_GALLERY_ORDER_LOGO', 'Order Logo');
	define('_SHOP_MI_GALLERY_WATERMARK', 'Watermark');
	
	define('_SHOP_MI_ITEMS_MENUITEMS', 'Menu Items');
	define('_SHOP_MI_ITEMS_LONGITEMS', 'Long Items');
	define('_SHOP_MI_ITEMS_BOTHITEMS', 'Both menu and long items');
	define('_SHOP_MI_ITEMS_RSSITEM', 'RSS Items');
	define('_SHOP_MI_ITEMS_RSSANDLONGITEM', 'RSS and Long Items');
	define('_SHOP_MI_ITEMS_ALLITEMS', 'All Items');
	
	define('_SHOP_MI_MANU_PLACESTOCKORDER', 'Place Stock Order');
	define('_SHOP_MI_MANU_DONTPLACESTOCKORDER', 'Don\'t place stock order');
	define('_SHOP_MI_MANU_MANUALORDER', 'Manual order');
	define('_SHOP_MI_MANU_RAISETOPURCHASEOFFICER', 'Raised to purchase officer');
	define('_SHOP_MI_MANU_APIORDERING', 'API Ordering');
	define('_SHOP_MI_MANU_LOCAL', 'Local Manufacture');
	define('_SHOP_MI_MANU_INTERSTATE', 'Interstate Manufacture');
	define('_SHOP_MI_MANU_OVERSEAS', 'Overseas Manufacture');
	define('_SHOP_MI_MANU_INTERNAL', 'Internal Manufacture');
	define('_SHOP_MI_MANU_UNKNOWN', 'Unknown Manufacture');
	
	define('_SHOP_MI_ORDER_OPENORDER', 'Open Order');
	define('_SHOP_MI_ORDER_CLOSEDORDER', 'Closed Order');
	define('_SHOP_MI_ORDER_CHECKEDOUT', 'Order Checked Out');
	define('_SHOP_MI_ORDER_GONETOINVOICING', 'Gone to invoice');
	define('_SHOP_MI_ORDER_OTHER', 'Other state of order');
	define('_SHOP_MI_ORDER_PAID', 'Order Paid');
	define('_SHOP_MI_ORDER_UNPAID', 'Order Unpaid');
	define('_SHOP_MI_ORDER_CANCELLED', 'Order Cancelled');
	define('_SHOP_MI_ORDER_FRAUDPAID', 'Order Fraudulent but Paid');
	define('_SHOP_MI_ORDER_FRAUDUNPAID', 'Order Fraudulent but Unpaid');
	define('_SHOP_MI_ORDER_FRAUDCANCELLED', 'Order was fraudulent and cancelled!');
	
	define('_SHOP_MI_CONNOTE_EXPRESS', 'Con Note Express Delievery');
	define('_SHOP_MI_CONNOTE_STANDARD', 'Con Note Standard Delievery');
	define('_SHOP_MI_CONNOTE_RETURNED', 'Con Note Returned Goods');
	define('_SHOP_MI_CONNOTE_BYSEA', 'Con Note Shipped by sea');
	define('_SHOP_MI_CONNOTE_BYROAD', 'Con Note Shipped by road');
	define('_SHOP_MI_CONNOTE_BYPLANE', 'Con Note Shipped by plane');
	define('_SHOP_MI_CONNOTE_BYTRAIN', 'Con Note Shippped by train');
	
	define('_SHOP_MI_WEIGHT_KILOS', 'kgs');
	define('_SHOP_MI_WEIGHT_POUNDS', 'lbs');
	define('_SHOP_MI_WEIGHT_OTHER', 'g');
	
	define('_SHOP_MI_PRODUCTS_INSTOCK', 'In Stock');
	define('_SHOP_MI_PRODUCTS_OUTSTOCK', 'Out of Stock');
	define('_SHOP_MI_PRODUCTS_NOREORDER', 'No reordering of stock');
	define('_SHOP_MI_PRODUCTS_QUITSTOCK', 'Quit line no more reordering');
	define('_SHOP_MI_PRODUCTS_SUPLUSSTOCK', 'Surplus Stock');
	define('_SHOP_MI_PRODUCTS_SERVICE', 'Service');
	define('_SHOP_MI_PRODUCTS_TANGIABLEITEM', 'Tangiable Item');
	define('_SHOP_MI_PRODUCTS_SERVICEANDITEM', 'Service & Tangiable Item');
	
	define('_SHOP_MI_SHIPPING_LOCAL', 'Local shipping');
	define('_SHOP_MI_SHIPPING_INTERSTATE', 'Interstate shipping');
	define('_SHOP_MI_SHIPPING_OVERSEAS', 'Overseas Shipping');
	define('_SHOP_MI_SHIPPING_INTERNAL', 'Internal Shipping');
	define('_SHOP_MI_SHIPPING_BYSEA', 'Shipping by Sea');
	define('_SHOP_MI_SHIPPING_BYROAD', 'Shipping by Road');
	define('_SHOP_MI_SHIPPING_BYTRAIN', 'Shipping by Train');
	define('_SHOP_MI_SHIPPING_BYPLANE', 'Shipping by Plane');
	define('_SHOP_MI_SHIPPING_EXPRESS', 'Shipping by Express');
	define('_SHOP_MI_SHIPPING_UNKNOWN', 'Shipping method Unknown');
	define('_SHOP_MI_SHIPPING_MANUALPHONECALL', 'Book shipping manually');
	define('_SHOP_MI_SHIPPING_EMAIL', 'Book shipping by email');
	define('_SHOP_MI_SHIPPING_APICALL', 'Book shipping by API Call');
	define('_SHOP_MI_SHIPPING_FAX', 'Book Shipping by Fax');
	define('_SHOP_MI_SHIPPING_OTHER', 'Book Shipping by another means');
	
	define('_SHOP_MI_SHOPS_PHYSICALSTORE', 'Physical Store');
	define('_SHOP_MI_SHOPS_DELIVERYRUN', 'Delievery run');
	define('_SHOP_MI_SHOPS_SERVICECENTER', 'Service Center');
	define('_SHOP_MI_SHOPS_SERVICEWAREHOUSE', 'Warehouse or Warehouse direct to public');
	define('_SHOP_MI_SHOPS_SERVICE', 'Services');
	define('_SHOP_MI_SHOPS_OTHER', 'Other type of shop');
?>