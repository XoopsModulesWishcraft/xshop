<?php
/**
 * XoopsPartners module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright::  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license::    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package::    XoopsPartners
 * @subpackage:: admin
 * @since::         2.5.0
 * @author::     XOOPS Team
 * @version::    $Id $
 **/
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';
require_once XOOPS_ROOT_PATH . '/include/cp_functions.php';
require '../../../include/cp_header.php';

if ( file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))){
        include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
        //return true;
    }else{
        echo xoops_error("Error: You don't use the Frameworks \"admin module\". Please install this Frameworks");
        //return false;
    }

$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
$pathImageIcon = XOOPS_URL .'/'. $moduleInfo->getInfo('icons16');
$pathImageAdmin = XOOPS_URL .'/'. $moduleInfo->getInfo('icons32');

$myts =& MyTextSanitizer::getInstance();

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
    include_once XOOPS_ROOT_PATH . "/class/template.php";
    $xoopsTpl = new XoopsTpl();
}

//xoops_cp_header();

//Load languages
if (file_exists(
    XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/language/{$xoopsConfig['language']}/admin.php"
)
) {
    include_once XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname')
        . "/language/{$xoopsConfig['language']}/admin.php";
} else {
    include_once XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/language/english/admin.php";
}
if (file_exists(
    XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/language/{$xoopsConfig['language']}/modinfo.php"
)
) {
    include_once XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname')
        . "/language/{$xoopsConfig['language']}/modinfo.php";
} else {
    include_once XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/language/english/modinfo.php";
}
if (file_exists(
    XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/language/{$xoopsConfig['language']}/main.php"
)
) {
    include_once XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname')
        . "/language/{$xoopsConfig['language']}/main.php";
} else {
    include_once XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/language/english/main.php";
}
/* replaced 'xoops_loadLanguage' since it's "not encouraged for use" by core developers in XOOPS 2.4+
xoops_loadLanguage('admin', $xoopsModule->getVar("dirname"));
xoops_loadLanguage('modinfo', $xoopsModule->getVar("dirname"));
xoops_loadLanguage('main', $xoopsModule->getVar("dirname"));
*/