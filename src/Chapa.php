<?php

namespace Chapa\Chapa;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;

class Chapa
{
    /**
     * Secret key from Chapa
     * 
     * @var string|null
     */
    protected $secretKey;
    
    /**
     * Base URL for Chapa API
     * 
     * @var string
     */
    protected $baseUrl;

    /**
     * Initialize Chapa with configuration
     */
    public function __construct()
    {
        $this->secretKey = config('laravelchapa.secret_key', env('CHAPA_SECRET_KEY'));
        $this->baseUrl = config('laravelchapa.base_url', 'https://api.chapa.co/v1');
    }

    /**
     * Generates a unique reference
     * 
     * @param string|null $transactionPrefix
     * @return string
     */
    public static function generateReference(?string $transactionPrefix = null): string
    {
        if ($transactionPrefix) {
            return $transactionPrefix . '_' . uniqid(time());
        }

        return config('app.name', env('APP_NAME')) . '_' . 'chapa_' . uniqid(time());
    }

    /**
     * Create Subaccount.
     * 
     * @param array $data
     * @return array
     */
    public function createSubaccount(array $data): array
    {
        $response = Http::withToken($this->secretKey)
            ->post($this->baseUrl . '/sub-accounts', $data)
            ->throw()
            ->json();

        return $response;
    }

    /**
     * Reaches out to Chapa to initialize a payment
     * 
     * @param array $data
     * @return array
     */
    public function initializePayment(array $data): array
    {
        $payment = Http::withToken($this->secretKey)
            ->post($this->baseUrl . '/transaction/initialize', $data)
            ->throw()
            ->json();

        return $payment;
    }

    /**
     * Gets a transaction ID depending on the redirect structure
     * 
     * @return string
     */
    public function getTransactionIDFromCallback(): string
    {
        $transactionID = request()->trx_ref;

        if (!$transactionID) {
            $transactionID = json_decode(request()->resp)->data->id;
        }

        return (string) $transactionID;
    }

    /**
     * Reaches out to Chapa to verify a transaction
     * 
     * @param string $id
     * @return array
     */
    public function verifyTransaction(string $id): array
    {
        $data = Http::withToken($this->secretKey)
            ->get($this->baseUrl . "/transaction/verify/" . $id)
            ->throw()
            ->json();
            
        return $data;
    }

    /**
     * Reaches out to Chapa to create a transfer to a bank account or wallet
     * 
     * @param array $data
     * @return array
     */
    public function createTransfer(array $data): array
    {
        $transfer = Http::withToken($this->secretKey)
            ->post($this->baseUrl . '/transfers', $data)
            ->throw()
            ->json();

        return $transfer;
    }

    /**
     * Reaches out to Chapa to verify a transfer
     * 
     * @param string $id
     * @return array
     */
    public function verifyTransfer(string $id): array
    {
        $data = Http::withToken($this->secretKey)
            ->get($this->baseUrl . "/transfers/verify/" . $id)
            ->throw()
            ->json();
            
        return $data;
    }

    /**
     * Validate incoming webhook event is from Chapa.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function validateWebhook($request): bool
    {
        $signature = $request->header('x-chapa-signature');
        $expectedSignature = hash_hmac(
            'sha256', 
            $request->getContent(), 
            config('laravelchapa.webhook_secret', env('CHAPA_WEBHOOK_SECRET'))
        );

        if ($signature !== $expectedSignature) {
            return false;
        }
        
        return true;
    }

    /**
     * Initiates a bulk transfer.
     * 
     * @param array $data
     * @return array
     */
    public function bulkTransfer(array $data): array
    {
        $response = Http::withToken($this->secretKey)
            ->post($this->baseUrl . '/bulk-transfers', $data)
            ->throw()
            ->json();

        return $response;
    }

    /**
     * Gets a list of banks
     * 
     * @return array
     */
    public function getBanks(): array
    {
        $response = Http::withToken($this->secretKey)
            ->get($this->baseUrl . "/banks")
            ->throw()
            ->json();

        return $response;
    }
}