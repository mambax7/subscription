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

include __DIR__ . '/header.php';
require_once __DIR__ . '/class/paymentgatewayfactory.php';
require_once __DIR__ . '/class/paymentdata.php';
require_once __DIR__ . '/class/paymentgateway.php';

global $xoopsLogger, $xoopsDB, $xoopsUser,  $_POST;

if (!is_object($xoopsUser)) {
    redirect_header(XOOPS_URL, 0, _NOPERM);
}

if (isset($_POST)) {
    foreach ($_POST as $k => $v) {
        ${$k} = $v;
    }
}
if ($xoopsUser->getVar('uid') != $uid) {
    redirect_header('index.php', 5, _NOPERM);
}

if (!isset($agree)) {
    redirect_header('index.php', 5, 'You must agree to the terms.');
}

$gatewayConfig  = SubscriptionUtility::getGatewayConfig($helper->getConfig('gateway'));
$delayedCapture = $helper->getConfig('delayed_capture');
if ('Y' === strtoupper($delayedCapture)) {
    $txtype = 'A';
} else {
    $txtype = 'S';
}
// create paymentdata instance
$paymentData = new PaymentData($cardnumber, $name, $address1, $address2, $city, $state, $zipcode, $country, $expirationmonth, $expirationyear, $cvv, $issuerphone, $amount, SubscriptionUtility::getNextInvoiceNumber(), $txtype);

$gw = PaymentGatewayFactory::getPaymentGateway();
$gw->setLogger($xoopsLogger);
$gw->setConfig($gatewayConfig);
$gw->setDelayedCapture($delayedCapture);

$paymentResponse = $gw->submitPayment($paymentData);

$id = SubscriptionUtility::recordPaymentTransaction($uid, $subid, $paymentData, $paymentResponse);

if (0 == $paymentResponse->responseCode) {
    if ('Y' !== strtoupper($delayedCapture)) {
        SubscriptionUtility::addUserSubscription($xoopsUser->getVar('uid'), $subid);
        SubscriptionUtility::sendSubscriptionEmail($xoopsUser->getVar('uid'), $subid);
        redirect_header("paymentsuccess.php?tid=$id", 2, 'Your payment has been accepted...');
    } else {
        //delayed capture...
        redirect_header("paymentsuccess.php?tid=$id", 2, 'Your payment has been accepted but is pending approval.  You will ' . ' receive an email when your payment has been approved.');
    }
} else {
    redirect_header('paymenterror.php?RESPMSG=' . $paymentResponse->responseMessage, 1, 'Your payment was rejected.');
}
