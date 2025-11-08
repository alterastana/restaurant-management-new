<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loyalty;
use App\Models\Customer;

class LoyaltyProgramSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan sudah ada data customer terlebih dahulu
        $customers = Customer::all();

        if ($customers->isEmpty()) {
            $this->command->info('Tidak ada data customer. Jalankan CustomerSeeder terlebih dahulu.');
            return;
        }

        foreach ($customers as $customer) {
            // Random poin antara 500 - 3000
            $points = rand(500, 3000);

            // Tentukan level dan diskon berdasarkan poin
            if ($points >= 3000) {
                $level = 'Platinum';
                $discount = 10000;
            } elseif ($points >= 2000) {
                $level = 'Gold';
                $discount = 5000;
            } else {
                $level = 'Silver';
                $discount = 2000;
            }

            Loyalty::create([
                'customer_id' => $customer->customer_id,
                'points' => $points,
                'membership_level' => $level,
                'discount_amount' => $discount,
            ]);
        }
    }
}
