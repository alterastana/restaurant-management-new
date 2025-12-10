<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TableRestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $i) {
            DB::table('table_restaurants')->insert([
                'restaurant_id' => 1,
                'table_number'  => $i,
                'capacity'      => rand(2, 8),
                'status'        => $faker->randomElement(['available', 'reserved', 'occupied']),
            ]);
        }
    }
}
