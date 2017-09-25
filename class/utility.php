<?php

/**
 * Class SubscriptionUtility
 */
class SubscriptionUtility extends XoopsObject
{
    /**
     * Function responsible for checking if a directory exists, we can also write in and create an index.html file
     *
     * @param string $folder The full path of the directory to check
     *
     * @return void
     */
    public static function createFolder($folder)
    {
        try {
            if (!file_exists($folder)) {
                if (!mkdir($folder) && !is_dir($folder)) {
                    throw new \RuntimeException(sprintf('Unable to create the %s directory', $folder));
                } else {
                    file_put_contents($folder . '/index.html', '<script>history.go(-1);</script>');
                }
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n", '<br>';
        }
    }

    /**
     * @param $file
     * @param $folder
     * @return bool
     */
    public static function copyFile($file, $folder)
    {
        return copy($file, $folder);
        //        try {
        //            if (!is_dir($folder)) {
        //                throw new \RuntimeException(sprintf('Unable to copy file as: %s ', $folder));
        //            } else {
        //                return copy($file, $folder);
        //            }
        //        } catch (Exception $e) {
        //            echo 'Caught exception: ', $e->getMessage(), "\n", "<br>";
        //        }
        //        return false;
    }

    /**
     * @param $src
     * @param $dst
     */
    public static function recurseCopy($src, $dst)
    {
        $dir = opendir($src);
        //    @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (('.' !== $file) && ('..' !== $file)) {
                if (is_dir($src . '/' . $file)) {
                    self::recurseCopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    /**
     *
     * Verifies XOOPS version meets minimum requirements for this module
     * @static
     * @param XoopsModule $module
     *
     * @param null|string $requiredVer
     * @return bool true if meets requirements, false if not
     */
    public static function checkVerXoops(XoopsModule $module = null, $requiredVer = null)
    {
        $moduleDirName = basename(dirname(__DIR__));
        if (null === $module) {
            $module = XoopsModule::getByDirname($moduleDirName);
        }
        xoops_loadLanguage('admin', $moduleDirName);
        //check for minimum XOOPS version
        $currentVer = substr(XOOPS_VERSION, 6); // get the numeric part of string
        $currArray  = explode('.', $currentVer);
        if (null === $requiredVer) {
            $requiredVer = '' . $module->getInfo('min_xoops'); //making sure it's a string
        }
        $reqArray = explode('.', $requiredVer);
        $success  = true;
        foreach ($reqArray as $k => $v) {
            if (isset($currArray[$k])) {
                if ($currArray[$k] > $v) {
                    break;
                } elseif ($currArray[$k] == $v) {
                    continue;
                } else {
                    $success = false;
                    break;
                }
            } else {
                if ((int)$v > 0) { // handles versions like x.x.x.0_RC2
                    $success = false;
                    break;
                }
            }
        }

        if (false === $success) {
            $module->setErrors(sprintf(_AM_SUBSCRIPTION_ERROR_BAD_XOOPS, $requiredVer, $currentVer));
        }

        return $success;
    }

    /**
     *
     * Verifies PHP version meets minimum requirements for this module
     * @static
     * @param XoopsModule $module
     *
     * @return bool true if meets requirements, false if not
     */
    public static function checkVerPhp(XoopsModule $module)
    {
        xoops_loadLanguage('admin', $module->dirname());
        // check for minimum PHP version
        $success = true;
        $verNum  = PHP_VERSION;
        $reqVer  = $module->getInfo('min_php');
        if (false !== $reqVer && '' !== $reqVer) {
            if (version_compare($verNum, $reqVer, '<')) {
                $module->setErrors(sprintf(_AM_SUBSCRIPTION_ERROR_BAD_PHP, $reqVer, $verNum));
                $success = false;
            }
        }

        return $success;
    }

    /**
     * @param $tm
     * @param $type
     * @param $number
     * @return false|int
     */
    public static function getExpirationDate($tm, $type, $number)
    {
        if ('x' == $type) {
            return $tm;
        }

        $date_time_array = getdate($tm);

        $hours   = $date_time_array['hours'];
        $minutes = $date_time_array['minutes'];
        $seconds = $date_time_array['seconds'];
        $month   = $date_time_array['mon'];
        $day     = $date_time_array['mday'];
        $year    = $date_time_array['year'];

        switch ($type) {
            case 'y':   // add year
                $year += $number;
                break;
            case 'w':
                $day += ($number * 7);
                break;
            case 'd':
                $day += $number;
                break;
            case 'm':
                $month += $number;
                break;
        }
        $timestamp = mktime($hours, $minutes, $seconds, $month, $day, $year);

        return $timestamp;
    }

    /**
     * @param      $uid
     * @param      $subid
     * @param null $expDate
     */
    public static function addUserSubscription($uid, $subid, $expDate = null)
    {
        $db = XoopsDatabaseFactory::getDatabaseConnection();

        $sql = 'select si.intervalamount, si.intervaltype, s.price, t.groupid from '
               . XOOPS_DB_PREFIX
               . '_subscription_interval si, '
               . XOOPS_DB_PREFIX
               . '_subscription s, '
               . XOOPS_DB_PREFIX
               . '_subscription_type t where si.subintervalid = '
               . " s.subintervalid  and s.subid = $subid"
               . ' and t.subtypeid = s.subtypeid';

        $res =& $GLOBALS['xoopsDB']->queryF($sql, $db);
        list($intamt, $inttype, $amount, $gid) = @$GLOBALS['xoopsDB']->fetchRow($res);
        if (!isset($expDate)) {
            $dt      = static::getExpirationDate(time(), $inttype, $intamt);
            $expDate = date('Y-m-d h:i:s', $dt);
        }

        $sql = 'insert into ' . XOOPS_DB_PREFIX . '_subscription_user' . ' (subid, uid, expiration_date, intervaltype, intervalamount, amount) ' . " values ($subid, $uid, '$expDate', '$inttype', $intamt, '$amount')";

        $GLOBALS['xoopsDB']->queryF($sql, $db);

        $linkid = static::addUserGroup($db, $gid, $uid);
        //$GLOBALS['xoopsDB']->close($db);
    }

    /**
     * @param $db
     * @param $gid
     * @param $uid
     * @return mixed
     */
    public static function addUserGroup($db, $gid, $uid)
    {
        $sql = 'insert into ' . XOOPS_DB_PREFIX . '_groups_users_link ' . "(groupid, uid) values ($gid, $uid)";
        $GLOBALS['xoopsDB']->queryF($sql, $db);
        $linkid = $GLOBALS['xoopsDB']->getInsertId($db);

        return $linkid;
    }

    /**
     * record payment transaction
     * @param user     $uid
     * @param the      $subid
     * @param instance $data
     * @param instance $response
     * @return
     * @internal param user $uid making the payment
     * @internal param the $subid subid for the subscription being paid for
     * @internal param instance $data of paymentdata containing the payment details
     * @internal param instance $response of paymentresponse containing the payment
     *                                    gateway response.
     */
    public static function recordPaymentTransaction($uid, $subid, $data, $response)
    {
        $db  = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = '';

        $sql = sprintf(
            ' INSERT INTO %s '
                       . '(id, subid, uid, cardnumber, cvv, issuerphone, expirationmonth, '
                       . ' expirationyear, '
                       . ' nameoncard, address, city, state, zipcode, country, amount, '
                       . ' authcode, response, '
                       . ' responsecode, referencenumber, transactiondate, transactiontype) '
                       . ' VALUES(%u, %u, '
                       . " %u, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', "
                       . " '%s', '%s', '%s', '%s', '%s', '%s', now(), '%s')",
            XOOPS_DB_PREFIX . '_subscription_transaction',
            $data->invoiceNumber,
            $subid,
            $uid,
            $data->cardNumber,
            $data->cvv,
            $data->issuerPhone,
            $data->expirationMonth,
            $data->expirationYear,
            $data->nameOnCard,
            $data->address1,
                       $data->city,
            $data->state,
            $data->zipcode,
            $data->countrycode,
            $data->amount,
            $response->authCode,
            $response->responseMessage,
            $response->responseCode,
            $response->referenceNumber,
            $data->txType
        );
        $GLOBALS['xoopsDB']->queryF($sql, $db) || exit(@$GLOBALS['xoopsDB']->error());

        return $data->invoiceNumber;
    }

    /**
     * @param $txid
     * @param $paymentData
     * @param $response
     */
    public static function updatePaymentTransaction($txid, $paymentData, $response)
    {
        $db  = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = '';
        $sql = sprintf(
            "UPDATE %s SET referencenumber = '%s', " . "responsecode = %u, response = '%s', transactiondate = now(), " . "transactiontype = '%s' WHERE id = %u",
            XOOPS_DB_PREFIX . '_subscription_transaction',
            $response->referenceNumber,
            $response->responseCode,
            $response->responseMessage,
                       $paymentData->txType,
            $txid
        );
        $GLOBALS['xoopsDB']->queryF($sql, $db);
    }

    /**
     * @param $uid
     * @param $subid
     */
    public static function revokeUserSubscription($uid, $subid)
    {
        $db  = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = 'select groupid from ' . XOOPS_DB_PREFIX . '_subscription_type t, ' . XOOPS_DB_PREFIX . '_subscription s WHERE s.subtypeid = t.subtypeid and ' . " s.subid = $subid";
        $res = $GLOBALS['xoopsDB']->queryF($sql, $db);
        if ($res) {
            list($gid) = $GLOBALS['xoopsDB']->fetchRow($res);
            if (!empty($gid)) {
                $sql = 'delete from ' . XOOPS_DB_PREFIX . '_groups_users_link ' . " where uid = $uid and groupid = $gid";
                $GLOBALS['xoopsDB']->queryF($sql, $db);
            }
            $sql = 'update ' . XOOPS_DB_PREFIX . '_subscription_user set ' . "cancel = 'Y' where subid = $subid and uid = $uid";
            $GLOBALS['xoopsDB']->queryF($sql, $db);
        }
        //$GLOBALS['xoopsDB']->close($db);
    }

    /**
     * @param $uid
     * @param $subid
     * @param $expdate
     */
    public static function renewUserSubscription($uid, $subid, $expdate)
    {
        $db  = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = 'update ' . XOOPS_DB_PREFIX . '_subscription_user ' . " set expiration_date = '$expdate'" . ", cancel = 'N' where uid = $uid and subid = $subid";
        $GLOBALS['xoopsDB']->queryF($sql, $db);
        //$GLOBALS['xoopsDB']->close($db);
    }

    /**
     * @param $txid
     * @return null|PaymentData
     */
    public static function getPaymentDataById($txid)
    {
        $db  = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = 'select id, uid, subid, cardnumber, cvv, issuerphone, ' . 'expirationmonth, expirationyear, nameoncard, address, city, state, ' . 'zipcode,  country, amount, referencenumber,transactiontype  from ' . XOOPS_DB_PREFIX . '_subscription_transaction ' . " where id = $txid";

        $data = null;

        $res = $GLOBALS['xoopsDB']->queryF($sql, $db);
        if ($res) {
            list($id, $uid, $subid, $cardnumber, $cvv, $issuerphone, $expmonth, $expyear, $name, $address, $city, $state, $zip, $ctry, $amount, $refnum, $txtype) = $GLOBALS['xoopsDB']->fetchRow($res);
            if (!empty($id)) {
                $data        = new PaymentData($cardnumber, $name, $address, '', $city, $state, $zip, $ctry, $expmonth, $expyear, $cvv, $issuerphone, $amount, $refnum, $txtype);
                $data->id    = $id;
                $data->subid = $subid;
                $data->uid   = $uid;
            }
        }

        return $data;
    }

    /**
     * @param $uid
     * @param $pnref
     * @return null|PaymentData
     */
    public static function getPaymentByReferenceNumber($uid, $pnref)
    {
        $db  = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = 'select id, uid, subid, cardnumber, cvv, issuerphone, '
               . 'expirationmonth, expirationyear, nameoncard, address, city, state, '
               . 'zipcode,  country, amount, referencenumber, transactiontype from '
               . XOOPS_DB_PREFIX
               . '_subscription_transaction '
               . " where referencenumber = '$pnref' and uid = $uid order by transactiondate desc";

        $data = null;

        $res = $GLOBALS['xoopsDB']->queryF($sql, $db);
        if ($res) {
            list($id, $uid, $subid, $cardnumber, $cvv, $issuerphone, $expmonth, $expyear, $name, $address, $city, $state, $zip, $ctry, $amount, $refnum, $txtype) = $GLOBALS['xoopsDB']->fetchRow($res);
            if (!empty($id)) {
                $data = new PaymentData($cardnumber, $name, $address, '', $city, $state, $zip, $ctry, $expmonth, $expyear, $cvv, $issuerphone, $amount, $refnum, $txtype);
            }
        }

        return $data;
    }

    /**
     * @param $uid
     * @return null|PaymentData
     */
    public static function getLastPaymentData($uid)
    {
        $db  = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = 'select id, uid, subid, cardnumber, cvv, issuerphone, '
               . 'expirationmonth, expirationyear, nameoncard, address, city, state, '
               . 'zipcode,  country, amount, referencenumber,transactiontype from '
               . XOOPS_DB_PREFIX
               . '_subscription_transaction '
               . " where uid = $uid order by transactiondate desc";

        $data = null;

        $res = $GLOBALS['xoopsDB']->queryF($sql, $db);
        if ($res) {
            list($id, $uid, $subid, $cardnumber, $cvv, $issuerphone, $expmonth, $expyear, $name, $address, $city, $state, $zip, $ctry, $amount, $refnum, $txtype) = $GLOBALS['xoopsDB']->fetchRow($res);
            if (!empty($id)) {
                if (empty($txtype)) {
                    $txtype = 'S';
                }
                $data        = new PaymentData($cardnumber, $name, $address, '', $city, $state, $zip, $ctry, $expmonth, $expyear, $cvv, $issuerphone, $amount, $refnum, $txtype);
                $data->subid = $subid;
                $data->uid   = $uid;
            }
        }

        return $data;
    }

    //    public static function getDatabaseConnection()
    //    {
    //        $db = @mysql_connect(XOOPS_DB_HOST, XOOPS_DB_USER, XOOPS_DB_PASS);
    //        mysqli_select_db($GLOBALS['xoopsDB']->conn, XOOPS_DB_NAME);
    //        return $db;
    //    }
    public static function runRenewals()
    {
        global $xoopsModuleConfig;

        $db  = XoopsDatabaseFactory::getDatabaseConnection();
        $now = date('Y-m-d H:i:s', time());

        $sql           = 'select uid, subid, intervaltype, intervalamount, amount, cancel ' . 'from ' . XOOPS_DB_PREFIX . '_subscription_user where expiration_date ' . " <= '$now' and intervaltype not in ('x', 'p')  and cancel = 'N'";
        $res           = $GLOBALS['xoopsDB']->queryF($sql, $db);
        $gw            = PaymentGatewayFactory::getPaymentGateway();
        $gatewayConfig = static::getGatewayConfig($xoopsModuleConfig['gateway']);
        $gw->setConfig($gatewayConfig);

        while (list($uid, $subid, $intervaltype, $intervalamount, $amt, $cancel) = $GLOBALS['xoopsDB']->fetchRow($res)) {
            $disable = false;
            switch ($intervaltype) {
                case 'p':
                    // do nothing
                    break;
                case 'x': //manual payment entry
                    $disable = true;
                    break;
                default:
                    if ($gw->isDirect()) {
                        $paymentData                = static::getLastPaymentData($uid);
                        $paymentData->invoiceNumber = static::getNextInvoiceNumber();
                        $paymentData->amount        = $amt;
                        $paymentData->txType        = 'S';
                        $response                   = $gw->submitPayment($paymentData);
                        $id                         = static::recordPaymentTransaction($uid, $subid, $paymentData, $response);
                        if (0 == $response->responseCode) {
                            $expDate = date('Y-m-d h:i:s', static::getExpirationDate(time(), $intervaltype, $intervalamount));
                            static::renewUserSubscription($uid, $subid, $expDate);
                        } else {
                            static::revokeUserSubscription($uid, $subid);
                        }
                    }
            }
        }
    } //end runRenewals

    /**
     * @param $uid
     * @param $uname
     * @param $subname
     * @param $expdate
     */
    public static function sendReminderEmail($uid, $uname, $subname, $expdate)
    {
        global $xoopsConfig;

        $mailer =& getMailer();
        $mailer->useMail();
        $mailer->setTemplateDir(XOOPS_ROOT_PATH . '/modules/' . SUB_DIR_NAME . '/language/' . $xoopsConfig['language'] . '/mail');
        $mailer->setTemplate('subscription_reminder.tpl');
        $mailer->setToUsers(new XoopsUser($uid));
        $mailer->assign('SUBNAME', $subname);
        $mailer->assign('USERNAME', $uname);
        $mailer->assign('EXPDATE', $expdate);
        $mailer->assign('ADMINMAIL', $xoopsConfig['adminmail']);
        $mailer->assign('SITEURL', $xoopsConfig['xoops_url']);
        $mailer->assign('SITENAME', $xoopsConfig['sitename']);
        $mailer->setFromEmail($xoopsConfig['adminmail']);
        $mailer->setFromName($xoopsConfig['sitename']);
        $mailer->setSubject('Subscription Reminder');
        $mailer->send();
    }

    /**
     * @param $uid
     * @param $subid
     */
    public static function sendCancelEmail($uid, $subid)
    {
        global $xoopsConfig;
        $db = XoopsDatabaseFactory::getDatabaseConnection();

        $sql = 'select uname, s.name from ' . XOOPS_DB_PREFIX . '_subscription_transaction t, ' . XOOPS_DB_PREFIX . '_users u, ' . XOOPS_DB_PREFIX . '_subscription s  where ' . 's.subid = t.subid and u.uid = t.uid and ' . "t.uid = $uid and t.subid = $subid";
        $res = $GLOBALS['xoopsDB']->queryF($sql, $db);
        list($uname, $subname) = @$GLOBALS['xoopsDB']->fetchRow($res);
        $mailer =& getMailer();
        $mailer->useMail();
        $mailer->setTemplateDir(XOOPS_ROOT_PATH . '/modules/' . SUB_DIR_NAME . '/language/' . $xoopsConfig['language'] . '/mail');
        $mailer->setTemplate('subscription_admin_cancel.tpl');
        $mailer->setToEmails($xoopsConfig['adminmail']);
        $mailer->assign('SUBNAME', $subname);
        $mailer->assign('USERNAME', $uname);
        $mailer->assign('ADMINMAIL', $xoopsConfig['adminmail']);
        $mailer->assign('SITEURL', $xoopsConfig['xoops_url']);
        $mailer->assign('SITENAME', $xoopsConfig['sitename']);
        $mailer->setFromEmail($xoopsConfig['adminmail']);
        $mailer->setFromName($xoopsConfig['sitename']);
        $mailer->setSubject('Subscription Cancellation');
        $mailer->send();
    }

    /**
     * @param $uid
     * @param $subid
     */
    public static function sendSubscriptionEmail($uid, $subid)
    {
        global $xoopsConfig;
        $user = new XoopsUser($uid);

        $db  = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = 'select s.name, si.intervalamount, si.intervaltype, s.price, '
               . ' t.groupid from '
               . XOOPS_DB_PREFIX
               . '_subscription_interval si, '
               . XOOPS_DB_PREFIX
               . '_subscription s, '
               . XOOPS_DB_PREFIX
               . '_subscription_type t where si.subintervalid = '
               . " s.subintervalid  and s.subid = $subid"
               . ' and t.subtypeid = s.subtypeid';

        $res = $GLOBALS['xoopsDB']->queryF($sql, $db);
        list($subname, $intamt, $inttype, $amount, $gid) = @$GLOBALS['xoopsDB']->fetchRow($res);

        if ('p' == $inttype) {
            $expDate = 'Permanent - Does Not Expire';
        } else {
            $dt      = static::getExpirationDate(time(), $inttype, $intamt);
            $expDate = date('Y-m-d h:i:s', $dt);
        }

        $mailer =& getMailer();
        $mailer->useMail();
        $mailer->setTemplateDir(XOOPS_ROOT_PATH . '/modules/' . SUB_DIR_NAME . '/language/' . $xoopsConfig['language'] . '/mail');
        $mailer->setTemplate('subscription_new.tpl');
        $mailer->setToUsers($user);
        $mailer->assign('SUBNAME', $subname);
        $mailer->assign('EXPDATE', $expDate);
        $mailer->assign('ADMINMAIL', $xoopsConfig['adminmail']);
        $mailer->assign('SITEURL', $xoopsConfig['xoops_url']);
        $mailer->assign('SITENAME', $xoopsConfig['sitename']);
        $mailer->setFromEmail($xoopsConfig['adminmail']);
        $mailer->setFromName($xoopsConfig['sitename']);
        $mailer->setSubject(SUB_EMAIL_SUBJECT);
        $mailer->send();

        $mailer =& getMailer();
        $mailer->useMail();
        $mailer->setTemplateDir(XOOPS_ROOT_PATH . '/modules/' . SUB_DIR_NAME . '/language/' . $xoopsConfig['language'] . '/mail');
        $mailer->setTemplate('subscription_admin_new.tpl');
        $mailer->setToEmails($xoopsConfig['adminmail']);
        $mailer->setSubject(SUB_EMAIL_SUBJECT);
        $mailer->assign('SUBNAME', $subname);
        $mailer->assign('UNAME', $user->getVar('uname'));
        $mailer->send();
    }

    /**
     * @param $uid
     * @param $subid
     */
    public static function sendVoidEmail($uid, $subid)
    {
        global $xoopsConfig;

        $db  = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = 'select s.name, si.intervalamount, si.intervaltype, s.price, '
               . ' t.groupid from '
               . XOOPS_DB_PREFIX
               . '_subscription_interval si, '
               . XOOPS_DB_PREFIX
               . '_subscription s, '
               . XOOPS_DB_PREFIX
               . '_subscription_type t where si.subintervalid = '
               . " s.subintervalid  and s.subid = $subid"
               . ' and t.subtypeid = s.subtypeid';

        $res = $GLOBALS['xoopsDB']->queryF($sql, $db);
        list($subname, $intamt, $inttype, $amount, $gid) = @$GLOBALS['xoopsDB']->fetchRow($res);

        if ('p' == $inttype) {
            $expDate = 'Permanent - Does Not Expire';
        } else {
            $dt      = static::getExpirationDate(time(), $inttype, $intamt);
            $expDate = date('Y-m-d h:i:s', $dt);
        }

        $mailer =& getMailer();
        $mailer->useMail();
        $user = new XoopsUser($uid);

        $mailer->setTemplateDir(XOOPS_ROOT_PATH . '/modules/' . SUB_DIR_NAME . '/language/' . $xoopsConfig['language'] . '/mail');
        $mailer->setTemplate('subscription_void.tpl');
        $mailer->setToUsers($user);
        $mailer->assign('SUBNAME', $subname);
        $mailer->assign('ADMINMAIL', $xoopsConfig['adminmail']);
        $mailer->assign('SITEURL', $xoopsConfig['xoops_url']);
        $mailer->assign('SITENAME', $xoopsConfig['sitename']);
        $mailer->setFromEmail($xoopsConfig['adminmail']);
        $mailer->setFromName($xoopsConfig['sitename']);
        $mailer->setSubject(SUB_EMAIL_VOID_SUBJECT);
        $mailer->send();

        /*$mailer =& getMailer();
        $mailer->useMail();
        $mailer->setTemplateDir(XOOPS_ROOT_PATH . "/modules/" . SUB_DIR_NAME .
            "/language/" . $xoopsConfig['language'] . "/mail");
        $mailer->setToEmails($xoopsConfig['adminmail']);
        $mailer->setTemplate("subscription_admin_void.tpl");
        $mailer->setSubject(SUB_EMAIL_VOID_SUBJECT);
        $mailer->assign("SUBNAME", $subname);
        $mailer->assign("UNAME", $user->getVar('uname'));
        $mailer->send();
        */
    }

    /**
     * @return mixed
     */
    public static function getNextInvoiceNumber()
    {
        $db  = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = 'update ' . XOOPS_DB_PREFIX . '_sequences set nextval = ';
        $sql .= "nextval + 1 where sequencename = 'subscription_transaction_seq'";

        $GLOBALS['xoopsDB']->queryF($sql, $db);

        $sql = 'SELECT nextval FROM ' . XOOPS_DB_PREFIX . '_sequences ' . 'WHERE sequencename = ' . "'subscription_transaction_seq'";
        $res = $GLOBALS['xoopsDB']->queryF($sql, $db);
        list($val) = @$GLOBALS['xoopsDB']->fetchRow($res);

        //$GLOBALS['xoopsDB']->close($db);

        return $val;
    }

    /**
     * returns the gateway config as an array
     * @param $gateway
     * @return array
     */
    public static function getGatewayConfig($gateway)
    {
        $db  = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = 'select name, value from ' . XOOPS_DB_PREFIX . "_subscription_gateway_config where gateway = '$gateway'";
        $GLOBALS['xoopsDB']->queryF($sql, $db);

        $res    = $GLOBALS['xoopsDB']->queryF($sql, $db);
        $config = [];

        while (list($name, $value) = @$GLOBALS['xoopsDB']->fetchRow($res)) {
            $config[$name] = $value;
        }

        return $config;
    }

    /**
     * @param $uid
     * @param $subid
     */
    public static function cancelSubscription($uid, $subid)
    {
        $db  = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = 'update ' . XOOPS_DB_PREFIX . '_subscription_user' . " set cancel = 'Y' where uid = $uid " . " and cancel = 'N' and subid = $subid ";
        $GLOBALS['xoopsDB']->queryF($sql, $db);
    }

    /**
     * @param $cur
     * @return string
     */
    public static function getCurrencySymbol($cur)
    {
        switch ($cur) {
            case 'USD':
                return "$";
                break;
            case 'GBP':
                return '&pound;';
                break;
            case 'EUR':
                return '&euro;';
                break;
            case 'JPY':
                return '&yen;';
                break;
            case 'CAD':
                return 'CAD';
                break;
            default:
                return "$";
        }
    }
}
