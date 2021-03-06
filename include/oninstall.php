<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 */

use Xmf\Language;
use XoopsModules\Subscription;

/**
 *
 * Prepares system prior to attempting to install module
 * @param XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_install_subscription(\XoopsModule $module)
{
    /** @var \XoopsModules\Subscription\Utility $utility */
    $utility = new \XoopsModules\Subscription\Utility();

    //check for minimum XOOPS version
    if (!$utility::checkVerXoops($module)) {
        return false;
    }

    // check for minimum PHP version
    if (!$utility::checkVerPhp($module)) {
        return false;
    }

    $mod_tables = $module->getInfo('tables');
    foreach ($mod_tables as $table) {
        $GLOBALS['xoopsDB']->queryF('DROP TABLE IF EXISTS ' . $GLOBALS['xoopsDB']->prefix($table) . ';');
    }

    return true;
}

/**
 *
 * Performs tasks required during installation of the module
 * @param XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if installation successful, false if not
 */
function xoops_module_install_subscription(\XoopsModule $module)
{
    require_once dirname(dirname(dirname(__DIR__))) . '/mainfile.php';

    //    $moduleDirName = $xoopsModule->getVar('dirname');
    $moduleDirName = basename(dirname(__DIR__));
    xoops_loadLanguage('admin', $moduleDirName);
    xoops_loadLanguage('modinfo', $moduleDirName);

    $configurator = require __DIR__ . '/config.php';
    /** @var \XoopsModules\Subscription\Utility $utility */
    $utility = new \XoopsModules\Subscription\Utility();

    //  ---  CREATE FOLDERS ---------------
    if (count($configurator['uploadFolders']) > 0) {
        //    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
        foreach (array_keys($configurator['uploadFolders']) as $i) {
            $utility::createFolder($configurator['uploadFolders'][$i]);
        }
    }

    //  ---  COPY blank.png FILES ---------------
    if (count($configurator['blankFiles']) > 0) {
        $file = dirname(__DIR__) . '/assets/images/blank.png';
        foreach (array_keys($configurator['blankFiles']) as $i) {
            $dest = $configurator['blankFiles'][$i] . '/blank.png';
            $utility::copyFile($file, $dest);
        }
    }

    return true;
}
