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
require_once __DIR__ . '/admin_header.php';
require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
require_once XOOPS_ROOT_PATH . '/class/template.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
//require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/class/lists.php';
//require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/class/forms/formselectsubscriptiontype.php';
//require_once XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/class/forms/formselectsubscriptioninterval.php';
xoops_cp_header();

$aboutAdmin = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));
global $xoopsDB, $xoopsConfig, $xoopsModule;

$tpl = new \XoopsTpl();

$existingSubForm = new \XoopsThemeForm('Existing Subscriptions', 'subs', 'edit_subscription.php');

$sub_select = new \XoopsFormSelect('Subscription', 'subid');

$sql    = 'SELECT s.subid, s.name FROM ' . $xoopsDB->prefix('subscription') . ' s ORDER BY s.orderbit ASC';
$result = $xoopsDB->query($sql);

while (false !== (list($subid, $subname) = $xoopsDB->fetchRow($result))) {
    $sub_select->addOption($subid, $subname);
}

$existingSubForm->addElement($sub_select);
$modifybutton = new \XoopsFormButton('', 'submit', '  Modify ', 'submit');

$existingSubForm->addElement($modifybutton);
$tpl->assign('existingsubform', $existingSubForm->render());
$tpl->assign('editinstructions', 'To modify an existing subscription, choose subscription from the dropdown.');

$createForm = new \XoopsThemeForm('Create Subscription', 'sub', 'create_subscription.php');

$altsubid = new \XoopsFormText('Alternate Subscription ID', 'altsubid', 20, 50, '');
$createForm->addElement($altsubid);

$subtypeselect = new \XoopsModules\Subscription\Form\FormSelectSubscriptionType('Subscription Type', 'subtypeid', '', 1);
$createForm->addElement($subtypeselect);

$subintervalselect = new \XoopsModules\Subscription\Form\FormSelectSubscriptionInterval('Subscription Interval', 'subintervalid', '1', 1);
$createForm->addElement($subintervalselect);

$subname = new \XoopsFormText('Subscription Name', 'subname', 20, 50, '');
$createForm->addElement($subname);

$price = new \XoopsFormText('Price (0.00)', 'price', 10, 6, '');
$createForm->addElement($price);
$order = new \XoopsFormText('Sort Order', 'orderbit', 2, 3, '0');
$createForm->addElement($order);
$createbutton = new \XoopsFormButton('', 'submit', ' Finished ', 'submit');
$createForm->addElement($createbutton);

$tpl->assign('form', $createForm->render());

$tpl->display(XOOPS_ROOT_PATH . '/modules/subscription/templates/subscription_admin_subscriptions.tpl');

xoops_cp_footer();
