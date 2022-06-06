<?php

namespace Chapa\ChapaLaravel;

class ChapaLaravel
{
    protected $publicKey;
    protected $secretKey;
    protected $baseUrl;

    /**
     * Construct
     */

    function __construct()
    {
        $this->publicKey = config('config.publicKey');
        $this->secretKey = config('config.secretKey');
        $this->secretHash = config('config.secretHash');
        $this->baseUrl = 'https://api.chapa.co/v1';
    }

    /**
     * Generates a unique reference
     * @param $transactionPrefix
     * @return string
     */

    public function generateReference(String $transactionPrefix = NULL)
    {
        if ($transactionPrefix) {
            return $transactionPrefix . '_' . uniqid(time());
        }
        return 'chapa_' . uniqid(time());
    }

    /**
     * Reaches out to Chapa to initialize a payment
     * @param $data
     * @return object
     */
    public function initializePayment(array $data)
    {


    }

    /**
     * Reaches out to Chapa to verify a transaction
     * @param $id
     * @return object
     */
    public function verifyTransaction($id)
    {


    }

    public static function event()
    {

    }

}
