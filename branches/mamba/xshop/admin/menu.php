<?php
$module_handler =& xoops_gethandler('module');
$xoopsModule =& XoopsModule::getByDirname('xdirectory');
$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
$pathIcon32 = $moduleInfo->getInfo('icons32');

$adminmenu = array();

$i = 1;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU0;
$adminmenu[$i]['link']  = "admin/index.php";
$adminmenu[$i]['icon']  = '../../'.$pathIcon32.'/home.png' ;
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU1;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/cart_add.png';
$adminmenu[$i]['image'] = 'images/admin/shop.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=shops";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU2;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/category.png';
$adminmenu[$i]['image'] = 'images/admin/category.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=category";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU3;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/fileshare.png';
$adminmenu[$i]['image'] = 'images/admin/products.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=products";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU4;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/folder_txt.png';
$adminmenu[$i]['image'] = 'images/admin/orders.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=orders";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU5;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/exec.png';
$adminmenu[$i]['image'] = 'images/admin/manufactures.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=manufactures";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU6;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/delivery.png';
$adminmenu[$i]['image'] = 'images/admin/shipping.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=shipping";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU7;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/discount.png';
$adminmenu[$i]['image'] = 'images/admin/discounts.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=discounts";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU8;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/user-icon.png';
$adminmenu[$i]['image'] = 'images/admin/contacts.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=contacts";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU9;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/identity.png';
$adminmenu[$i]['image'] = 'images/admin/addresses.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=addresses";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU10;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/mail_country.png';
$adminmenu[$i]['image'] = 'images/admin/country.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=country";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU11;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/globe.png';
$adminmenu[$i]['image'] = 'images/admin/region.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=region";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU12;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/languages.png';
$adminmenu[$i]['image'] = 'images/admin/items.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=items_digest";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU13;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/photo.png';
$adminmenu[$i]['image'] = 'images/admin/gallery.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=gallery";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU14;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/synchronized.png';
$adminmenu[$i]['image'] = 'images/admin/tax.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=autotax";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU15;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/download.png';
$adminmenu[$i]['image'] = 'images/admin/downloads.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=downloads";
$i++;
//$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU16;
//$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/fields.png';
//$adminmenu[$i]['image'] = 'images/admin/fields.png';
//$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=fields";
//$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU17;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/permissions.png';
$adminmenu[$i]['image'] = 'images/admin/permissions.png';
$adminmenu[$i]['link'] = "admin/main.php?op=permissions";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU18;
$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/cash_stack.png';
$adminmenu[$i]['image'] = 'images/admin/currencies.png';
$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=currency";
$i++;
//$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU19;
//$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/consignments.png';
//$adminmenu[$i]['image'] = 'images/admin/consignments.png';
//$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=consignments";
//$i++;
//$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU20;
//$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/reports.png';
//$adminmenu[$i]['image'] = 'images/admin/reports.png';
//$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=reports";
//$i++;
//$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_MENU21;
//$adminmenu[$i]['icon'] = '../../'.$pathIcon32.'/log.png';
//$adminmenu[$i]['image'] = 'images/admin/log.png';
//$adminmenu[$i]['link'] = "admin/main.php?op=list&fct=log";
$i++;
$adminmenu[$i]['title'] = _SHOP_MI_ADMIN_ABOUT;
$adminmenu[$i]['link']  = "admin/about.php";
$adminmenu[$i]['icon']  = '../../'.$pathIcon32.'/about.png';
?>