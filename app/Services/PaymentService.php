<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.payment.base_url');
        $this->apiKey = config('services.payment.api_key');
    }

    /**
     * Buat transaksi pembayaran
     */
    public function createTransaction($orderId, $amount, $customerName, $customerEmail = null)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/transactions', [
                'order_id' => $orderId,
                'amount' => $amount,
                'customer_name' => $customerName,
                'customer_email' => $customerEmail ?? 'guest@restaurant.com',
                'callback_url' => route('payment.callback'),
                'return_url' => route('payment.return', ['order' => $orderId]),
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Payment API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Payment Service Exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Cek status transaksi
     */
    public function checkTransactionStatus($transactionId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->baseUrl . '/transactions/' . $transactionId);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Check Transaction Exception', [
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }
}