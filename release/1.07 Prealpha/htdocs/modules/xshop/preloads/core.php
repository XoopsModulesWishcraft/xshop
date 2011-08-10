<?php

defined('XOOPS_ROOT_PATH') or die('Restricted access');

class XshopCorePreload extends XoopsPreloadItem
{
	
	function eventCoreIncludeCommonEnd($args)
	{
		$module_handler = xoops_gethandler('module');
		$config_handler = xoops_gethandler('config');
		$xoModule = $module_handler->getByDirname('xshop');
		if (is_object($xoModule)) {
			$_config = $config_handler->getConfigList($xoModule->getVar('mid'));
			if (!empty($_config['memory_limit']))
		 		ini_set('memory_limit', $_config['memory_limit']);
		 	else 
		 		ini_set('memory_limit', '64M');
		}
	}
	
}

?>