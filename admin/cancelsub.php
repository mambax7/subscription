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

require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';

// require_once dirname(__DIR__) . '/class/Utility.php';

global $xoopsUser, $xoopsDB, $xoopsConfig;

//get sub types

$subid = \Xmf\Request::getString('subid', '', 'GET');
$uid   = \Xmf\Request::getString('uid', '', 'GET');

if (empty($subid) || empty($uid)) {
    redirect_header('currentsubs.php', 5, 'Missing values.');
}

if (\Xmf\Request::hasVar('revoke', 'GET')) {
    Subscription\Utility::revokeUserSubscription($uid, $subid);
} else {
    Subscription\Utility::cancelSubscription($uid, $subid);
}

// TO-DO: add revoke code
redirect_header('currentsubs.php', 5, 'This subscription was canceled.');

require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_footer.php';
