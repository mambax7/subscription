<?php
//  ------------------------------------------------------------------------ //
//                		Subscription Module for XOOPS													 //
//               Copyright (c) 2005 Third Eye Software, Inc.						 		 //
//                 <http://products.thirdeyesoftware.com>									 //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

use XoopsModules\Subscription;

require_once __DIR__ . '/admin_header.php';
require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/class/template.php';
require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
xoops_cp_header();

$aboutAdmin = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));
global $xoopsDB, $xoopsConfig;

//die("access denied - under development");

$tpl = new \XoopsTpl();

if (\Xmf\Request::hasVar('start', 'GET')) {
    $startpos = $_GET['start'];
}

if (\Xmf\Request::hasVar('uname', 'GET')) {
    $uname = $_GET['uname'];
}

$sql = 'select su.id,su.uid, u.uname, s.subid, s.name, '
       . ' su.expiration_date, su.intervaltype, '
       . 'su.intervalamount, su.amount, su.cancel '
       . ' from '
       . $xoopsDB->prefix('subscription_user')
       . ' su inner join '
       . $xoopsDB->prefix('users')
       . ' u on su.uid = u.uid left join '
       . $xoopsDB->prefix('subscription')
       . ' s on su.subid = s.subid ';
if (isset($uname)) {
    $sql .= " where u.uname like '$uname%'";
}
$sql .= ' order by u.uname asc, su.cancel';

$ctsql = 'SELECT count(*) FROM ' . $xoopsDB->prefix('subscription_user');
if (isset($uname)) {
    $ctsql .= " where u.uname like '$uname%'";
}
if (!isset($startpos)) {
    $startpos = 0;
}
$result = $xoopsDB->query($ctsql);
list($txcount) = $xoopsDB->fetchRow($result);

$result = $xoopsDB->query($sql, 10, $startpos);
while (false !== (list($sid, $uid, $uname, $subid, $subname, $expdate, $inttype, $intamount, $amount, $cancel) = $xoopsDB->fetchRow($result))) {
    if ('Y' === $cancel) {
        $cancel = 'Yes';
    } else {
        $cancel = 'No';
    }
    switch ($inttype) {
        case 'd':
            $interval = 'Daily';
            break;
        case 'w':
            $interval = 'Weekly';
            break;
        case 'm':
            $interval = 'Monthly';
            break;
        case 'y':
            $interval = 'Yearly';
            break;
        case 'p':
            $interval = 'Permanent';
            break;
        case 'x':
            $interval = 'Manual';
            break;
        default:
            $interval = 'Unknown';
    }
    if (empty($subname)) {
        $subname = '<i>not available</i>';
    }
    $tpl->append('subs', [
        'sid'      => $sid,
        'uid'      => $uid,
        'subid'    => $subid,
        'uname'    => $uname,
        'subname'  => $subname,
        'expdate'  => $expdate,
        'interval' => $interval,
        'intamt'   => $intamount,
        'amount'   => $amount,
        'cancel'   => $cancel
    ]);
}

$nav = new \XoopsPageNav($txcount, 10, $startpos, 'start');
$tpl->assign('nav', $nav->renderNav());
$tpl->display(XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/templates/subscription_admin_currentsubs.tpl');

xoops_cp_footer();
