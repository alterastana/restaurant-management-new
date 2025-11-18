<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class PaymentGatewayService
{
    protected $baseUrl = 'https://payment-dummy.doovera.com/merchant';
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.doovera.key' ?? 'services.payment.api_key');
    }

    public function createPayment(Order $order)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/create-payment', [
                'order_id' => $order->order_id,
                'amount' => $order->total_amount,
                'currency' => 'IDR',
                'customer_name' => $order->customer->name,
                'customer_email' => $order->customer->email,
                'description' => "Payment for Order #{$order->order_id}",
                'success_url' => route('payment.success'),
                'cancel_url' => route('payment.cancel'),
            ]);

            if ($response->successful()) {
                $paymentData = $response->json();
                
                // Update order with payment token
                $order->update([
                    'payment_token' => $paymentData['token'],
                    'payment_status' => 'awaiting_payment'
                ]);

                return [
                    'success' => true,
                    'payment_url' => $paymentData['payment_url'],
                    'token' => $paymentData['token']
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to create payment'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function handleWebhook($payload)
    {
        try {
            // Verify webhook signature if available
            
            $order = Order::where('payment_token', $payload['payment_token'])->firstOrFail();
            
            switch ($payload['status']) {
                case 'paid':
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'confirmed'
                    ]);
                    break;
                
                case 'failed':
                    $order->update([
                        'payment_status' => 'failed',
                        'status' => 'cancelled'
                    ]);
                    break;
                
                case 'expired':
                    $order->update([
                        'payment_status' => 'expired',
                        'status' => 'cancelled'
                    ]);
                    break;
            }

            return true;
        } catch (\Exception $e) {
            \Log::error('Payment webhook error: ' . $e->getMessage());
            return false;
        }
    }
}