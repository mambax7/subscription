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

require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
// require_once dirname(__DIR__) . '/class/Utility.php';
// require_once  dirname(__DIR__) . '/class/paymentgatewayfactory.php';
// require_once  dirname(__DIR__) . '/class/paymentdata.php';
// require_once  dirname(__DIR__) . '/class/paymentgateway.php';

/** @var Subscription\Helper $helper */
$helper = Subscription\Helper::getInstance();

global $xoopsLogger, $xoopsDB, $xoopsConfig, $xoopsModule;
$gatewayConfig  = Subscription\Utility::getGatewayConfig($helper->getConfig('gateway'));
$delayedCapture = $helper->getConfig('delayed_capture');

$void = isset($_GET['void']) ? true : false;
$txid = \Xmf\Request::getInt('txid', 0, 'GET');
if (empty($txid)) {
    redirect_header('transactions.php', 5, 'Transaction Id can not be ' . 'missing.');
}
$paymentData = Subscription\Utility::getPaymentDataById($txid);

$gw = Subscription\PaymentGatewayFactory::getPaymentGateway();
$gw->setLogger($xoopsLogger);
$gw->setConfig($gatewayConfig);
$gw->setDelayedCapture($delayedCapture);

if (true === $void) {
    $paymentData->txType = 'V';
} else {
    $paymentData->txType = 'D';
}
$response = $gw->submitPayment($paymentData);
$uid      = $paymentData->uid;
$subid    = $paymentData->subid;

if (0 == $response->responseCode) {
    Subscription\Utility::updatePaymentTransaction($txid, $paymentData, $response);
    if (false === $void) {
        Subscription\Utility::addUserSubscription($uid, $subid);
        Subscription\Utility::sendSubscriptionEmail($uid, $subid);
        redirect_header('transactions.php', 2, 'This payment has been captured and approved.');
    } else {
        Subscription\Utility::sendVoidEmail($uid, $subid);
        redirect_header('transactions.php', 2, 'This authorization has been voided (' . $response->referenceNumber . ').');
    }
} else {
    redirect_header('transactions.php', 5, "This payment was rejected with the message '" . $response->responseMessage . "'.");
}
