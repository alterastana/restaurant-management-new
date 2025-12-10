<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Reservation;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $firstOrder = Order::first();
        $firstReservation = Reservation::first();

        // Seeder contoh pembayaran berdasarkan Order
        Payment::create([
            'order_id' => $firstOrder?->order_id, 
            'reservation_id' => null,
            'payment_method' => 'Credit Card',
            'amount' => 250000.00,
            'payment_date' => now(),
            'status' => 'completed',
            'payment_url' => 'https://example.com/credit-card-payment',
        ]);

        // Seeder contoh pembayaran berdasarkan Reservation
        Payment::create([
            'order_id' => null,
            'reservation_id' => $firstReservation?->reservation_id,
            'payment_method' => 'Cash',
            'amount' => 500000.00,
            'payment_date' => now(),
            'status' => 'pending',
            'payment_url' => 'https://example.com/cash-payment',
        ]);
    }
}
