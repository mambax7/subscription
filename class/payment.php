<?php

/**
 * Created by PhpStorm.
 * User: mamba
 * Date: 2017-01-07
 * Time: 20:19
 */

namespace Payment;

use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;

class Payment
{
    private $pay;
    private $card;

    public function setCard($value)
    {
        try {
            $card  = [
                'number'      => $value['card'],
                'expiryMonth' => $value['expiremonth'],
                'expiryYear'  => $value['expireyear'],
                'cvv'         => $value['cvv']
            ];
            $ccard = new CreditCard($card);
            $ccard->validate();
            $this->card = $card;

            return true;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function makePayment($value)
    {
        try {

            // Setup payment Gateway
            $pay = Omnipay::create('Stripe');
            $pay->setApiKey('YOUR API KEY');
            // Send purchase request
            $response = $pay->purchase([
                                           'amount'   => $value['amount'],
                                           'currency' => $value['currency'],
                                           'card'     => $this->card
                                       ])->send();

            // Process response
            if ($response->isSuccessful()) {
                return 'Thankyou for your payment';
            } elseif ($response->isRedirect()) {

                // Redirect to offsite payment gateway
                return $response->getMessage();
            } else {
                // Payment failed
                return $response->getMessage();
            }
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
