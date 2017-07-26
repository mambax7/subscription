<?php

/**
 * Class PaymentResponse
 */
class PaymentResponse
{
    public $responseMessage;
    public $responseCode;
    public $referenceNumber;
    public $authCode;

    public $CODE_SUCCESS = 0;
    public $CODE_FAILURE = 1;

    /**
     * PaymentResponse constructor.
     * @param      $responsecode
     * @param      $authcode
     * @param      $responsemessage
     * @param null $referencenumber
     * @return PaymentResponse
     */
    public function PaymentResponse(
        $responsecode,
        $authcode,
        $responsemessage,
        $referencenumber = null
    ) {
        $this->responseCode    = $responsecode;
        $this->authCode        = $authcode;
        $this->responseMessage = $responsemessage;
        $this->referenceNumber = $referencenumber;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'PaymentResponse(' . 'authcode=' . $this->authCode . ',' . 'responseCode=' . $this->responseCode . ',' . 'responseMessage=' . $this->responseMessage . ',' . 'referenceNumber=' . $this->referenceNumber . ')';
    }
}
