<?php

	xoops_load('xoopsformloader');
	xoops_load('pagenav');
	include_once('formselectaddress.php');
	include_once('formselectaddressremittion.php');
	include_once('formselectaddresstype.php');
	include_once('formselectcategory.php');
	include_once('formselectcontactstype.php');
	include_once('formselectcountry.php');
	include_once('formselectcurrency.php');
	include_once('formselectdays.php');
	include_once('formselectdiscount.php');
	include_once('formselectdiscounttype.php');
	include_once('formselectgallerytype.php');
	include_once('formselectitemdigesttype.php');
	include_once('formselectitems.php');
	include_once('formselectlanguage.php');
	include_once('formselectmanufactures.php');
	include_once('formselectmanufacturesordering.php');
	include_once('formselectmanufacturestype.php');
	include_once('formselectmeasurement.php');
	include_once('formselectorders.php');
	include_once('formselectordersmode.php');
	include_once('formselectordersremittion.php');
	include_once('formselectproduct.php');
	include_once('formselectproductsstock.php');
	include_once('formselectproductstype.php');
	include_once('formselectregion.php');
	include_once('formselectshipping.php');
	include_once('formselectshippingmethod.php');
	include_once('formselectshippingtype.php');
	include_once('formselectshop.php');
	include_once('formselectshoptype.php');
	include_once('formselecttime.php');
	include_once('formselecttimezone.php');
	include_once('formselectuser.php');
	
	if (file_exists($GLOBALS['xoops']->path('/modules/tag/include/formtag.php')) && $GLOBALS['xoopsModuleConfig']['tags'])
		include_once $GLOBALS['xoops']->path('/modules/tag/include/formtag.php');
	?>