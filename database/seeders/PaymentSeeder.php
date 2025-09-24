<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 25) as $i) {
            DB::table('payments')->insert([
                'order_id' => $i,
                'payment_date' => $faker->dateTime,
                'payment_method' => $faker->randomElement(['cash', 'credit_card', 'ewallet']),
                'amount' => $faker->randomFloat(2, 20, 500),
                'status' => $faker->randomElement(['paid', 'pending', 'failed']),
            ]);
        }
    }
}
