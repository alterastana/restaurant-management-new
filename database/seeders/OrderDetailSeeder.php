<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 50) as $i) {
            DB::table('order_details')->insert([
                'order_id' => rand(1, 25),
                'menu_id'  => rand(1, 30),
                'quantity' => rand(1, 5),
                'price'    => rand(10, 100),
            ]);
        }
    }
}
