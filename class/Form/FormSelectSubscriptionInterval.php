<?php namespace XoopsModules\Subscription\Form;

/**
 * lists of values
 */
//require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/class/lists.php';
/**
 * base class
 */
require_once XOOPS_ROOT_PATH . '/class/xoopsform/formselect.php';

/**
 * Class FormSelectSubscriptionInterval
 */
class FormSelectSubscriptionInterval extends \XoopsFormSelect
{
    /**
     * FormSelectSubscriptionInterval constructor.
     * @param string $caption
     * @param string $name
     * @param null   $value
     * @param int    $size
     */
    public function __construct($caption, $name, $value = null, $size = 1)
    {
        parent::__construct($caption, $name, $value, $size);
        $this->addOptionArray(\XoopsModules\Subscription\SubscriptionLists::getSubscriptionIntervalList());
    }
}
