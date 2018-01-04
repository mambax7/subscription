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

require_once __DIR__ . '/../class/Helper.php';
//require_once __DIR__ . '/../include/common.php';
$helper = subscription\Helper::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');


$adminmenu[] = [
    'title' => _MI_SUBSCRIPTION_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png'
];

$adminmenu[] = [
    'title' => _MI_SUBSCRIPTION_ADMIN_MENU_SUBSCRIPTION_INTERVALS,
    'link'  => 'admin/subscriptionintervals.php',
    'icon'  => $pathIcon32 . '/event.png'
];

$adminmenu[] = [
    'title' => _MI_SUBSCRIPTION_ADMIN_MENU_SUBSCRIPTION_TYPES,
    'link'  => 'admin/subscriptiontypes.php',
    'icon'  => $pathIcon32 . '/type.png'
];

$adminmenu[] = [
    'title' => _MI_SUBSCRIPTION_ADMIN_MENU_SUBSCRIPTIONS,
    'link'  => 'admin/subscriptions.php',
    'icon'  => $pathIcon32 . '/button_ok.png'
];

$adminmenu[] = [
    'title' => _MI_SUBSCRIPTION_ADMIN_MENU_GATEWAYS,
    'link'  => 'admin/gateways.php',
    'icon'  => $pathIcon32 . '/cash_stack.png'
];

$adminmenu[] = [
    'title' => _MI_SUBSCRIPTION_ADMIN_MENU_TRANSACTIONS,
    'link'  => 'admin/transactions.php',
    'icon'  => $pathIcon32 . '/discount.png'
];

$adminmenu[] = [
    'title' => _MI_SUBSCRIPTION_ADMIN_MENU_SUBS,
    'link'  => 'admin/currentsubs.php',
    'icon'  => $pathIcon32 . '/users.png'
];

$adminmenu[] = [
    'title' => _MI_SUBSCRIPTION_ADMIN_MENU_REMINDERS,
    'link'  => 'admin/reminders.php',
    'icon'  => $pathIcon32 . '/mail_foward.png'
];

$adminmenu[] = [
    'title' => _MI_SUBSCRIPTION_ADMIN_MENU_CRON,
    'link'  => 'admin/cron.php',
    'icon'  => $pathIcon32 . '/update.png'
];

$adminmenu[] = [
    'title' => _MI_SUBSCRIPTION_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png'
];
