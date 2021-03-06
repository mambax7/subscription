<?php namespace XoopsModules\Subscription\Gateways\Standard;

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

use  XoopsModules\Subscription;

defined('XOOPS_ROOT_PATH') || die('Restricted access');
if (!defined('SUB_DIR_NAME')) {
    die('SUB_DIR_NAME not defined');
}
//require_once XOOPS_ROOT_PATH . '/modules/' . SUB_DIR_NAME . '/class/paymentgateway.php';
//require_once XOOPS_ROOT_PATH . '/modules/' . SUB_DIR_NAME . '/class/paymentdata.php';
//require_once XOOPS_ROOT_PATH . '/modules/' . SUB_DIR_NAME . '/class/paymentresponse.php';

/**
 * base class
 */
class StandardPaymentGateway extends Subscription\PaymentGateway
{
    /**
     * @return bool
     */
    public function isDirect()
    {
        return true;
    }

    /**
     * @param $details
     * @return  \XoopsModules\Subscription\PaymentResponse
     */
    public function submitPayment($details)
    {
        $this->logger->addExtra('DEFAULT', $details->toString());

        $response = $this->processCard($details);

        return $response;
    }

    /**
     * @param $details
     * @return \XoopsModules\Subscription\PaymentResponse
     */
    public function processCard($details)
    {
        if (true) {
            return new Subscription\PaymentResponse(0, '000-RES', 'SUCCESS', 'Default Payment Gateway Info');
        } else {
            return new Subscription\PaymentResponse(10, '010-RES', 'DECLINED', 'Default Payment Gateway Info');
        }
    }

    public function test()
    {
        $this->logger->addExtra('DEFAULT', 'test');
    }
}
