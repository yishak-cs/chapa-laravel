<?php

namespace Chapa\ChapaLaravel;

use Illuminate\Support\Facades\Http;

class ChapaLaravel
{
 
    /**
     * Generates a unique reference
     * @param $transactionPrefix
     * @return string
     */

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
        $publicKey = env('CHAPA_PUBLIC_KEY');
        $secretKey = env('CHAPA_SECRET_KEY');
        $secretHash = env('CHAPA_WEBHOOK_SECRET');
        $baseUrl = 'https://api.chapa.co/v1';

        $payment = Http::withToken($secretKey)->post(
            $baseUrl . '/transaction/initialize',
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
        
    }

    public static function event()
    {

    }

}
