<?php


use XoopsModules\Subscription;


/**
 * Class PaymentGatewayFactory
 */
class PaymentGatewayFactory
{
    /**
     * PaymentGatewayFactory constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get a reference to the only instance of gateway class
     *
     * if the class has not been instantiated yet, this will also take
     * care of that
     *
     * @static
     * @return      object  Reference to the only instance of gateway class
     */
    public static function getPaymentGateway()
    {
        /** @var Subscription\Helper $helper */
        $helper = Subscription\Helper::getInstance();

        static $instance;
        if (!isset($instance)) {
            $file = XOOPS_ROOT_PATH . '/modules/' . SUB_DIR_NAME . '/gateways/' . $helper->getConfig('gateway') . '/' . $helper->getConfig('gateway') . 'paymentgateway.php';

            require_once $file;
            $class    = ucfirst($helper->getConfig('gateway')) . 'PaymentGateway';
            $instance = new $class();
            $instance->setLogger(\XoopsLogger::getInstance());
        }

        return $instance;
    }
}
