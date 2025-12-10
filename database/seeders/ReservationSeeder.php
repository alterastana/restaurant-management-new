<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 25) as $i) {
            DB::table('reservations')->insert([
                'table_id' => rand(1, 20),
                'customer_id' => rand(1, 15),
                'reservation_date' => $faker->date(),
                'reservation_time' => $faker->time(),
                
            ]);
        }
    }
}
