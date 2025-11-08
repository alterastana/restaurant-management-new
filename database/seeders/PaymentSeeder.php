<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        Payment::create([
            'order_id' => 1,
            'reservation_id' => null,
            'payment_method' => 'Credit Card',
            'amount' => 250000.00,
            'payment_date' => Carbon::now(),
            'status' => 'completed',
        ]);

        Payment::create([
            'order_id' => null,
            'reservation_id' => 1,
            'payment_method' => 'Cash',
            'amount' => 500000.00,
            'payment_date' => Carbon::now(),
            'status' => 'pending',
        ]);
    }
}
