<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 5) as $i) {
            DB::table('restaurants')->insert([
                'name'  => $faker->company,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
            ]);
        }
    }
}
