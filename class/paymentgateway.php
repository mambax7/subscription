<?php

/**
 * make sure this is only included once!
 */
if (!defined('XOOPS_SUB_PAYMENT_GATEWAY')) {
    define('XOOPS_SUB_PAYMENT_GATEWAY', 1);

    /**
     * Abstract base class for Database access classes
     *
     * @abstract
     *
     * @author     Kazumi Ono <onokazu@xoops.org>
     * @copyright  copyright (c) 2000-2003 XOOPS.org
     *
     * @package    kernel
     * @subpackage database
     */
    class PaymentGateway
    {

        /**
         * reference to a {@link XoopsLogger} object
         * @see XoopsLogger
         * @var object XoopsLogger
         */
        public $logger;

        public $indirectUrl;
        public $cancelUrl;
        public $config;
        public $delayedCapture;

        /**
         * constructor
         *
         * will always fail, because this is an abstract class!
         */
        public function __construct()
        {
            // exit("Cannot instantiate this class directly");
        }

        /**
         * assign a {@link XoopsLogger} object to the payment gateway
         *
         * @see XoopsLogger
         * @param object $logger reference to a {@link XoopsLogger} object
         */
        public function setLogger(&$logger)
        {
            $this->logger =& $logger;
        }

        /**
         * @param $paymentDetails
         */
        public function submitPayment($paymentDetails)
        {
        }

        public function isDirect()
        {
        }

        /**
         * @param $cfg
         */
        public function setConfig($cfg)
        {
            $this->config = $cfg;
        }

        /**
         * @param $dc
         */
        public function setDelayedCapture($dc)
        {
            $this->delayedCapture = $dc;
        }
    }
}
