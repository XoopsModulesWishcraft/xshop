<?php

function xoops_module_uninstall_xshop(&$module) {

	xoops_loadLanguage('modinfo', 'xshop');
	
	$sql = "DELETE FROM ".$GLOBALS['xoopsDB']->prefix('groups'). " WHERE `group_type` IN ('"._SHOP_MI_GROUP_TYPE_BROKER."','"._SHOP_MI_GROUP_TYPE_SALES."')";
	$GLOBALS['xoopsDB']->queryF($sql);
	
	return true;
	
}
	
?>