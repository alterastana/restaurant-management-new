<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();
$orderIds = $faker->unique()->randomElements(range(1, 25), 25);

foreach ($orderIds as $orderId) {
    DB::table('order_details')->insert([
        'order_id' => $orderId,
        'menu_id'  => rand(1, 10),
        'quantity' => rand(1, 5),
        'price'    => rand(10, 100),
    ]);
}

    }
}
