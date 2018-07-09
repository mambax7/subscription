<?php namespace XoopsModules\Subscription;

/**
 * Class PaymentData
 */
class PaymentData
{
    public $id;
    public $uid;
    public $subid;

    public $cardNumber;
    public $nameOncard;
    public $address1;
    public $address2;
    public $city;
    public $state;
    public $zipcode;
    public $countrycode;
    public $expirationMonth;
    public $expirationYear;
    public $cvv;
    public $issuerPhone;
    public $amount;
    public $invoiceNumber;
    public $txType;

    /**
     * PaymentData constructor.
     * @param $cardNumber
     * @param $name
     * @param $address1
     * @param $address2
     * @param $city
     * @param $state
     * @param $zipcode
     * @param $countrycode
     * @param $month
     * @param $year
     * @param $cvv
     * @param $issuerphone
     * @param $amount
     * @param $invoicenumber
     * @param $txtype
     */
    public function __construct(
        $cardNumber,
        $name,
        $address1,
        $address2,
        $city,
        $state,
        $zipcode,
        $countrycode,
        $month,
        $year,
        $cvv,
        $issuerphone,
        $amount,
        $invoicenumber,
        $txtype)
    {
        $this->cardNumber      = $cardNumber;
        $this->nameOnCard      = $name;
        $this->address1        = $address1;
        $this->address2        = $address2;
        $this->city            = $city;
        $this->state           = $state;
        $this->zipcode         = $zipcode;
        $this->countrycode     = $countrycode;
        $this->cvv             = $cvv;
        $this->issuerPhone     = $issuerphone;
        $this->amount          = $amount;
        $this->invoiceNumber   = $invoicenumber;
        $this->expirationMonth = $month;
        $this->expirationYear  = $year;
        $this->txType          = $txtype;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return 'PaymentData('
               . 'cardnum='
               . $this->cardNumber
               . ','
               . 'name='
               . $this->nameOnCard
               . ','
               . 'address1='
               . $this->address1
               . ','
               . 'address2='
               . $this->address2
               . ','
               . 'city='
               . $this->city
               . ','
               . 'state='
               . $this->state
               . ','
               . 'zipcode='
               . $this->zipcode
               . ','
               . 'countrycode='
               . $this->countrycode
               . ','
               . 'cvv='
               . $this->cvv
               . ','
               . 'issuerPhone='
               . $this->issuerPhone
               . ','
               . 'invoicenumber='
               . $this->invoiceNumber
               . ','
               . 'txtype='
               . $this->txType
               . ','
               . 'id='
               . $this->id
               . ','
               . 'uid='
               . $this->uid
               . ','
               . 'subid='
               . $this->subid
               . ','
               . 'amount='
               . $this->amount
               . ')';
    }
}
