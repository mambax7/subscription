<?php

use XoopsModules\Subscription;

require_once __DIR__ . '/header.php';
require_once __DIR__ . '/functions.php';
//require_once XOOPS_ROOT_PATH . '/modules/subscription/config.php';
//require_once XOOPS_ROOT_PATH . '/modules/subscription/class/paymentfactory.php';

/** @var Subscription\Helper $helper */
$helper = Subscription\Helper::getInstance();

global $xoopsDB, $xoopsConfig;

/*if (!is_object($xoopsUser)) {
    redirect_header("index.php", 0, _NOPERM);
}
*/
//$uid = $xoopsUser->getVar('uid','E');
$uid = $_POST['uid'];

if (null !== $helper->getConfig('gateway')) {
    $payment = Subscription\PaymentGatewayFactory::getInstance();
}

$payment_data = [];

$agree = '';

if (isset($_POST)) {
    foreach ($_POST as $k => $v) {
        ${$k}             = $v;
        $payment_data[$k] = $v;
    }
}
if (!$agree) {
    redirect_header((string)$referer, 5, 'You must agree to the terms of this purchse.');
}

$sql    = 'select s.price, s.setupamount, s.subintervalid,t.groupid, s.name,' . 'xsi.intervalamount from ' . 'xoops_subscription s, xoops_subscription_interval xsi, ' . " xoops_subscription_type t where subid = $subid " . ' and s.subtypeid = t.subtypeid and xsi.subintervalid = s.subintervalid';
$result = $xoopsDB->query($sql);
if (!$result) {
    $error = 'Could not find the appropriate subscription.';
    redirect_header("paymenterror.php?errormessage=$error", 0, 'An error occured.');
}
list($price, $setupamt, $subintervalid, $groupid, $subname, $intervalamount) = $xoopsDB->fetchRow($result);

if (!isset($payment_data['authcode'])) {
    $payment_data['authcode'] = 'manual-' . time();
}

$subexpiration = dateadd(time(), 0, 0, 0, 0, $intervalamount, 0);

$payment->setPaymentData($payment_data);
$ret = $payment->processPayment();

if ($ret) {
    $oldgroupid = 0;
    $sql        = 'select groupid from xoops_subscriptions_users where uid = ' . (string)$uid;
    $result     = $xoopsDB->query($sql);
    list($oldgroupid) = $xoopsDB->fetchRow($result);

    if ($oldgroupid > 0) {
        $group_sql = 'delete from xoops_groups_users_link where uid = ' . "$uid and groupid = $oldgroupid";
        $xoopsDB->query($group_sql);

        $sql = 'update xoops_subscriptions_users set subintervalid = ' . "$subintervalid, expiration = $subexpiration, subid = $subid, " . "price = $price, groupid = $groupid  where uid = $uid";
    } else {
        $sql = 'insert into xoops_subscriptions_users ' . "values ($uid, $subid, $price, $subintervalid, $subexpiration, $groupid)";
    }

    $xoopsDB->query($sql);

    $sql = 'insert into xoops_groups_users_link (groupid, uid) ' . "values($groupid, $uid)";
    $xoopsDB->query($sql);

    if (!isset($unattended)) {
        $GLOBALS['xoopsOption']['template_main'] = 'payment_success.tpl';
        require_once XOOPS_ROOT_PATH . '/header.php';
        $xoopsTpl->assign('return_code', $payment->getReturnCode());
        $xoopsTpl->assign('txid', $payment->getTransactionId());
        $xoopsTpl->assign('subname', $subname);
        require_once XOOPS_ROOT_PATH . '/footer.php';
    }
} else {
    foreach ($payment->errors as $k => $v) {
        $error .= $v;
    }
    redirect_header("paymenterror.php?errormessage=$error", 0, 'An error occured while processing your payment.');
}
