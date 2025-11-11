<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 25) as $i) {
            DB::table('orders')->insert([
                'restaurant_id' => 1,
                'reservation_id'=> rand(1, 20),
                'order_type'    => $faker->randomElement(['dine-in', 'takeaway']),
                'order_date'    => $faker->dateTime,
                'status'        => $faker->randomElement(['pending', 'completed', 'cancelled']),
                'total_amount'  => $faker->randomFloat(2, 10, 500), // Tambahkan ini
            ]);
        }
    }
}
