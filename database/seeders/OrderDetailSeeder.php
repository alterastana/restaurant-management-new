<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Ambil UUID orders
        $orderIds = json_decode(file_get_contents(database_path('seeders/order_ids.json')), true);

        foreach ($orderIds as $orderId) {
            DB::table('order_details')->insert([
                'order_id' => $orderId,       // UUID
                'menu_id'  => rand(1, 10),
                'quantity' => rand(1, 5),
                'price'    => rand(10, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
