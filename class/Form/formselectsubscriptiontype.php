?php
/**
* lists of values
*/
require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/class/lists.php';
/**
* base class
*/
require_once XOOPS_ROOT_PATH . '/class/xoopsform/formselect.php';

/**
* Class XoopsFormSelectSubscriptionType
*/
class XoopsFormSelectSubscriptionType extends \XoopsFormSelect
{
/**
* XoopsFormSelectSubscriptionType constructor.
* @param string $caption
* @param string $name
* @param null   $value
* @param int    $size
* @param null   $psid
*/
public function __construct($caption, $name, $value=null,
$size=1, $psid = null)
{
parent::__construct($caption, $name, $value, $size);
if (isset($psid)) {
$this->addOptionArray(SubscriptionLists::getSubscriptionTypeList($psid));
} else {
$this->addOptionArray(SubscriptionLists::getSubscriptionTypeList(null));
}
}
}
