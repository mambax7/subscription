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
include __DIR__ . '/header.php';
require_once __DIR__ . '/class/paymentgatewayfactory.php';
require_once __DIR__ . '/class/paymentdata.php';
require_once __DIR__ . '/class/paymentgateway.php';

global $xoopsUser, $xoopsDB, $xoopsConfig, $xoopsModuleConfig;

$gatewayConfig = SubscriptionUtility::getGatewayConfig($xoopsModuleConfig['gateway']);

//get sub types

if (!is_object($xoopsUser)) {
    redirect_header('index.php', 0, _NOPERM);
}

$sql = 'SELECT su.subid, s.name, su.cancel FROM ' . $xoopsDB->prefix('subscription_user') . ' su, ' . $xoopsDB->prefix('users') . ' u, ' . $xoopsDB->prefix('subscription') . ' s WHERE su.uid = ' . $xoopsUser->getVar('uid') . ' AND u.uid = su.uid AND ' . " s.subid = su.subid AND su.cancel = 'N'";

$result = $xoopsDB->query($sql);

$subs = [];

$i = 0;

while (list($subid, $subname, $cancel) = $xoopsDB->fetchRow($result)) {
    $subs[$i]['subid']   = $subid;
    $subs[$i]['subname'] = $subname;
    $subs[$i]['cancel']  = $cancel;
    $i++;
}
if ($i == 0) {
    redirect_header('index.php', 3, 'You are not a subscriber.');
}

if (!empty($_POST['email'])) {
    if (empty($_POST['subid'])) {
        redirect_header('cancelsubscription.php', 3, 'You must select a ' . 'subscription to cancel.');
    }

    if (strtolower($xoopsUser->getVar('email')) == strtolower($_POST['email'])) {
        SubscriptionUtility::cancelSubscription($xoopsUser->getVar('uid'), $_POST['subid']);

        $rdir = $gw->cancelUrl;
        if (isset($rdir)) {
            include __DIR__ . '/gateways/' . $xoopsModuleConfig['gateway'] . '/' . $rdir;
        } else {
            redirect_header(XOOPS_URL . '/index.php', 3, 'Your
				subscription has ' . 'been canceled.');
        }
    } else {
        redirect_header('cancelsubscription.php', 3, 'You did not enter the correct email address.');
    }
}
include __DIR__ . '/../../header.php';
$GLOBALS['xoopsOption']['template_main'] = 'subscription_cancel.tpl';
$xoopsTpl->assign('subs', $subs);
include __DIR__ . '/../../footer.php';
