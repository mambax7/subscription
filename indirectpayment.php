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

require_once __DIR__ . '/header.php';
//require_once __DIR__ . '/class/paymentgatewayfactory.php';
//require_once __DIR__ . '/class/paymentdata.php';
//require_once __DIR__ . '/class/paymentgateway.php';

/** @var Subscription\Helper $helper */
$helper = Subscription\Helper::getInstance();

global $xoopsUser, $xoopsDB, $xoopsConfig;

if (!is_object($xoopsUser)) {
    redirect_header('index.php', 0, _NOPERM);
}

if (isset($_POST)) {
    foreach ($_POST as $k => $v) {
        ${$k} = $v;
    }
}

if (!isset($subid)) {
    die('' . $subid . '.subid');
    redirect_header('index.php', 0, 'You must select a subscription.');
}

$gw = \XoopsModules\Subscription\PaymentGatewayFactory::getPaymentGateway();

$uname = $xoopsUser->getVar('uname', 'E');

$sql = 'SELECT subid, xs.name, format(price,2) price, 
			xsi.intervaltype, xsi.intervalamount, xs.alternatesubid  FROM ' . $xoopsDB->prefix('subscription') . ' xs
			INNER JOIN ' . $xoopsDB->prefix('subscription_interval') . ' xsi ON xs.subintervalid = 
			xsi.subintervalid WHERE subid = ' . $subid;

$result = $xoopsDB->query($sql);
if (!$result) {
    redirect_header('index.php', 5, 'Could not find subscription.');
}
list($subid, $subname, $price, $intervaltype, $intervalamount, $altsubid) = $xoopsDB->fetchRow($result);
if (empty($subid)) {
    redirect_header('index.php', 5, 'Could not find subscription.');
}
$expDate = ('p' === $intervaltype) ? 'Never' : date('m/d/Y h:i:s', Subscription\Utility::getExpirationDate(time(), $intervaltype, $intervalamount));

$email = $xoopsUser->getVar('email');
$uid   = $xoopsUser->getVar('uid');
$uname = $xoopsUser->getVar('uname');

$invoiceNumber = Subscription\Utility::getNextInvoiceNumber();

$gatewayConfig = Subscription\Utility::getGatewayConfig($helper->getConfig('gateway'));

require_once __DIR__ . '/gateways/' . $helper->getConfig('gateway') . '/' . $gw->indirectUrl;

require_once dirname(dirname(__DIR__)) . '/footer.php';
