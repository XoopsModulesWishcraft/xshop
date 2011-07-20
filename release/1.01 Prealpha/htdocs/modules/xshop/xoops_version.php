<?php
/**
 * Invoice Transaction Gateway with Modular Plugin set
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Co-Op http://www.chronolabs.coop/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xpayment
 * @since           1.30.0
 * @author          Simon Roberts <simon@chronolabs.coop>
 * @translation     Erol Konik <aphex@aphexthemes.com>
 * @translation     Mariane <mariane_antoun@hotmail.com>
 * @translation     Voltan <voltan@xoops.ir>
 * @translation     Ezsky <ezskyyoung@gmail.com>
 * @translation     Richardo Costa <lusopoemas@gmail.com>
 * @translation     Kris_fr <kris@frxoops.org>
 */

if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}


$modversion['dirname'] 		= basename(dirname(__FILE__));
$modversion['name'] 		= ucfirst(basename(dirname(__FILE__)));
$modversion['version']     	= "1.01";
$modversion['releasedate'] 	= "2011-03-18";
$modversion['status']      	= "RC";
$modversion['description'] 	= _SHOP_MI_DESCRIPTION;
$modversion['credits']     	= _SHOP_MI_CREDITS;
$modversion['author']      	= "Wishcraft";
$modversion['help']        	= "";
$modversion['license']     	= "GPL 2.0";
$modversion['official']    	= 1;
$modversion['image']       	= "images/xshop_slogo.png";


// Mysql file
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Main
$modversion['hasMain'] = 1;

$modversion['tables'][$i++] = 'shop_addresses';
$modversion['tables'][$i++] = 'shop_category';
$modversion['tables'][$i++] = 'shop_contacts';
$modversion['tables'][$i++] = 'shop_country';
$modversion['tables'][$i++] = 'shop_currency';
$modversion['tables'][$i++] = 'shop_days';
$modversion['tables'][$i++] = 'shop_downloads';
$modversion['tables'][$i++] = 'shop_extra';
$modversion['tables'][$i++] = 'shop_field';
$modversion['tables'][$i++] = 'shop_gallery';
$modversion['tables'][$i++] = 'shop_items';
$modversion['tables'][$i++] = 'shop_items_digest';
$modversion['tables'][$i++] = 'shop_manufacturer';
$modversion['tables'][$i++] = 'shop_orders';
$modversion['tables'][$i++] = 'shop_orders_connotes';
$modversion['tables'][$i++] = 'shop_orders_digest';
$modversion['tables'][$i++] = 'shop_products';
$modversion['tables'][$i++] = 'shop_regions';
$modversion['tables'][$i++] = 'shop_shipping';
$modversion['tables'][$i++] = 'shop_shops';
$modversion['tables'][$i++] = 'shop_visibility';

// Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Install Script
//$modversion['onInstall'] = "include/install.php";

// Update Script
//$modversion['onUpdate'] = "include/onupdate.php";

// Update Script
//$modversion['onUninstall'] = "include/uninstall.php";

$i = 0;
// Config items
$options=array();
$options[_SHOP_MI_SECONDS_1DAYS] = 60*60*24*1;
$options[_SHOP_MI_SECONDS_3DAYS] = 60*60*24*3;
$options[_SHOP_MI_SECONDS_7DAYS] = 60*60*24*7;
$options[_SHOP_MI_SECONDS_14DAYS] = 60*60*24*14;
$options[_SHOP_MI_SECONDS_30DAYS] = 60*60*24*30;
$options[_SHOP_MI_SECONDS_60DAYS] = 60*60*24*60;
$options[_SHOP_MI_SECONDS_90DAYS] = 60*60*24*90;
$options[_SHOP_MI_SECONDS_180DAYS] = 60*60*24*180;
$options[_SHOP_MI_SECONDS_270DAYS] = 60*60*24*270;
$options[_SHOP_MI_SECONDS_365DAYS] = 60*60*24*365;

$i++;
$modversion['config'][$i]['name'] = 'offline';
$modversion['config'][$i]['title'] = '_SHOP_MI_OFFLINE';
$modversion['config'][$i]['description'] = '_SHOP_MI_OFFLINE_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 60*60*24*60;
$modversion['config'][$i]['options'] = $options;

$i++;
$modversion['config'][$i]['name'] = 'weightunit';
$modversion['config'][$i]['title'] = '_SHOP_MI_WEIGHTUNIT';
$modversion['config'][$i]['description'] = '_SHOP_MI_WEIGHTUNIT_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'kgs';
$modversion['config'][$i]['options'] = array('kgs'=>'kgs', 'lbs'=>'lbs');

$groups_handler =& xoops_gethandler('group');
$i++;
$modversion['config'][$i]['name'] = 'brokers';
$modversion['config'][$i]['title'] = '_SHOP_MI_BROKERS';
$modversion['config'][$i]['description'] = '_SHOP_MI_BROKERS_DESC';
$modversion['config'][$i]['formtype'] = 'group';
$modversion['config'][$i]['valuetype'] = 'int';
$criteria = new Criteria('group_type', _SHOP_MI_GROUP_TYPE_BROKER);
$group = $groups_handler->getObjects($criteria);
if (is_object($group[0]))
	$modversion['config'][$i]['default'] = $group[0]->getVar('groupid');


$i++;
$modversion['config'][$i]['name'] = 'htaccess';
$modversion['config'][$i]['title'] = "_SHOP_MI_HTACCESS";
$modversion['config'][$i]['description'] = "_SHOP_MI_HTACCESS_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'baseurl';
$modversion['config'][$i]['title'] = "_SHOP_MI_BASEURL";
$modversion['config'][$i]['description'] = "_SHOP_MI_BASEURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'payment';

$i++;
$modversion['config'][$i]['name'] = 'endofurl';
$modversion['config'][$i]['title'] = "_SHOP_MI_ENDOFURL";
$modversion['config'][$i]['description'] = "_SHOP_MI_ENDOFURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.html';

$i++;
$modversion['config'][$i]['name'] = 'endofurl_pdf';
$modversion['config'][$i]['title'] = "_SHOP_MI_ENDOFURL_PDF";
$modversion['config'][$i]['description'] = "_SHOP_MI_ENDOFURL_PDF_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.pdf';

// Templates
$i = 0;
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_help.html';
$modversion['templates'][$i]['description'] = 'payment help screen!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_invoice.html';
$modversion['templates'][$i]['description'] = 'blank invoice template!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_payment.html';
$modversion['templates'][$i]['description'] = 'Payment Invoice Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_payment_pdf.html';
$modversion['templates'][$i]['description'] = 'Payment Invoice PDF Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_return.html';
$modversion['templates'][$i]['description'] = 'Payment Return Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cancel.html';
$modversion['templates'][$i]['description'] = 'Payment Cancel Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_invoice_list.html';
$modversion['templates'][$i]['description'] = 'Payment Invoice Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_invoice_view.html';
$modversion['templates'][$i]['description'] = 'Payment Invoice Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_transactions_list.html';
$modversion['templates'][$i]['description'] = 'Transaction Return Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_transactions_view.html';
$modversion['templates'][$i]['description'] = 'Transaction Display!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_invoice_list.html';
$modversion['templates'][$i]['description'] = 'Payment Invoice Display Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_invoice_view.html';
$modversion['templates'][$i]['description'] = 'Payment Invoice Display  Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_transactions_list.html';
$modversion['templates'][$i]['description'] = 'Transaction Return Display Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_transactions_view.html';
$modversion['templates'][$i]['description'] = 'Transaction Display Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_gateways_list.html';
$modversion['templates'][$i]['description'] = 'Gateway Display Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_gateways_options.html';
$modversion['templates'][$i]['description'] = 'Gateway Options Display Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_groups.html';
$modversion['templates'][$i]['description'] = 'Groups Rules Display Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_groups_edit.html';
$modversion['templates'][$i]['description'] = 'Groups Rules Display Form Control Panel!';
$i++;
$modversion['templates'][$i]['file'] = 'xpayment_cpanel_tax_list.html';
$modversion['templates'][$i]['description'] = 'Auto Tax List Form Control Panel!';


$i=0;
if ($GLOBALS['xoopsUser']) {
	$module_handler =& xoops_gethandler('module');
	$config_handler =& xoops_gethandler('config');
	$xoMod = $module_handler->getByDirname('xpayment');
	if (is_object($xoMod)) {
		$xoConfig = $config_handler->getConfigList($xoMod->getVar('mid'));
		if (in_array($xoConfig['brokers'], $GLOBALS['xoopsUser']->getGroups())) {
			$i++;
			$modversion['sub'][$i]['name'] = _SHOP_MI_MNU_BROKER;
			$modversion['sub'][$i]['url'] = "broker.php";
		}
		if (in_array($xoConfig['accounts'], $GLOBALS['xoopsUser']->getGroups())) {
			$i++;
			$modversion['sub'][$i]['name'] = _SHOP_MI_MNU_ACCOUNTS;
			$modversion['sub'][$i]['url'] = "accounts.php";
		}
		if (in_array($xoConfig['officers'], $GLOBALS['xoopsUser']->getGroups())) {
			$i++;
			$modversion['sub'][$i]['name'] = _SHOP_MI_MNU_OFFICERS;
			$modversion['sub'][$i]['url'] = "officers.php";
		}
	}
}

?>
