<?php

namespace Chapa\Chapa;

use Illuminate\Support\Facades\Http;

class Chapa
{
 
    /**
     * Generates a unique reference
     * @param $transactionPrefix
     * @return string
     */



    protected $publicKey;
    protected $secretKey;
    protected $baseUrl;


    function __construct()
    {

        $this->publicKey = env('CHAPA_PUBLIC_KEY');
        $this->secretKey = env('CHAPA_SECRET_KEY');
        $this->secretHash = env('CHAPA_WEBHOOK_SECRET');
        $this->baseUrl = 'https://api.chapa.co/v1';
    }    

    public static function generateReference(String $transactionPrefix = NULL)
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
    public static function initializePayment(array $data)
    {


        $payment = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/transaction/initialize',
            $data
        )->json();

       return $payment;
    }

    /**
     * Reaches out to Chapa to verify a transaction
     * @param $id
     * @return object
     */
    public function verifyTransaction($id)
    {
        $data =  Http::withToken($this->secretKey)->get($this->baseUrl . "/transaction/" . 'verify/'. $id )->json();
        return $data;
    }

    public function getTransactionIDFromCallback()
    {
        $transactionID = request()->tx_ref;

        if (!$transactionID) {
            $transactionID = json_decode(request()->resp)->data->tx_ref;
        }

        return $transactionID;
    }

}
