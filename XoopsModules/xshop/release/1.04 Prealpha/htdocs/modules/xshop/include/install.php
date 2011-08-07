<?php

function xoops_module_pre_install_xshop(&$module) {

	xoops_loadLanguage('modinfo', 'xshop');
	
	$groups_handler =& xoops_gethandler('group');
	$criteria = new Criteria('group_type', _SHOP_MI_GROUP_TYPE_BROKER);
	if (count($groups_handler->getObjects($criteria))==0) {
		$group = $groups_handler->create();
		$group->setVar('name', _SHOP_MI_GROUP_NAME_BROKER);
		$group->setVar('description', _SHOP_MI_GROUP_DESC_BROKER);
		$group->setVar('group_type', _SHOP_MI_GROUP_TYPE_BROKER);
		$groups_handler->insert($group, true);
	}

	$groups_handler =& xoops_gethandler('group');
	$criteria = new Criteria('group_type', _SHOP_MI_GROUP_TYPE_SALES);
	if (count($groups_handler->getObjects($criteria))==0) {
		$group = $groups_handler->create();
		$group->setVar('name', _SHOP_MI_GROUP_NAME_SALES);
		$group->setVar('description', _SHOP_MI_GROUP_DESC_SALES);
		$group->setVar('group_type', _SHOP_MI_GROUP_TYPE_SALES);
		$groups_handler->insert($group, true);
	}
	
	return true;
}
	
?>