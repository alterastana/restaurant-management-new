<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * Handle payment webhook notifications.
     */
    public function handlePayment(Request $request)
    {
        // 1. Log bahwa webhook diterima
        Log::info('Webhook received', $request->all());

        // 2. Verifikasi tanda tangan (signature)
        $signature = $request->header('X-Webhook-Signature');
        $webhookSecret = config('services.payment.webhook_secret');
        $payload = $request->all();
        $expectedSignature = hash_hmac('sha256', json_encode($payload), $webhookSecret);

        // 3. Bandingkan signature
        if (!hash_equals($expectedSignature, $signature)) {
            Log::warning('Invalid webhook signature', [
                'expected' => $expectedSignature,
                'received' => $signature,
            ]);
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        // 4. Proses webhook jika signature valid
        Log::info('Webhook signature VERIFIED');
        $event = $request->input('event');
        $data = $request->input('data');

        // Handle payment success event
        if ($event === 'payment.success') {
            $orderId = $data['order_id'];
            $transactionId = $data['transaction_id'] ?? null;

            // Update payment status
            $payment = Payment::where('order_id', $orderId)
                ->where('transaction_id', $transactionId)
                ->first();

            if ($payment) {
                $payment->update([
                    'status' => 'success',
                    'payment_date' => now(),
                ]);

                // Update order status
                Order::where('order_id', $orderId)->update([
                    'status' => 'confirmed'
                ]);

                Log::info('Payment updated successfully', ['order_id' => $orderId]);
            }
        }

        return response()->json(['message' => 'Webhook received successfully'], 200);
    }
}