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
/** @var Subscription\Helper $helper */
$helper = Subscription\Helper::getInstance();

include __DIR__ . '/../../../include/cp_header.php';
// include __DIR__ . '/../class/Utility.php';
// require_once __DIR__ . '/../class/paymentgatewayfactory.php';
// require_once __DIR__ . '/../class/paymentdata.php';
// require_once __DIR__ . '/../class/paymentgateway.php';

global $xoopsLogger, $xoopsDB, $xoopsConfig, $xoopsModule;
$gatewayConfig  = SubscriptionUtility::getGatewayConfig($helper->getConfig('gateway'));
$delayedCapture = $helper->getConfig('delayed_capture');

$void = isset($_GET['void']) ? true : false;
$txid = isset($_GET['txid']) ? $_GET['txid'] : 0;
if (empty($txid)) {
    redirect_header('transactions.php', 5, 'Transaction Id can not be ' . 'missing.');
}
$paymentData = SubscriptionUtility::getPaymentDataById($txid);

$gw = PaymentGatewayFactory::getPaymentGateway();
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
    SubscriptionUtility::updatePaymentTransaction($txid, $paymentData, $response);
    if (false === $void) {
        SubscriptionUtility::addUserSubscription($uid, $subid);
        SubscriptionUtility::sendSubscriptionEmail($uid, $subid);
        redirect_header('transactions.php', 2, 'This payment has been captured and approved.');
    } else {
        SubscriptionUtility::sendVoidEmail($uid, $subid);
        redirect_header('transactions.php', 2, 'This authorization has been voided (' . $response->referenceNumber . ').');
    }
} else {
    redirect_header('transactions.php', 5, "This payment was rejected with the message '" . $response->responseMessage . "'.");
}
