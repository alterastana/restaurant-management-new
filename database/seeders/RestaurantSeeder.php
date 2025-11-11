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

        for ($i = 0; $i < 1; $i++) {
    DB::table('restaurants')->insert([
        'name'    => $faker->company,
        'address' => $faker->address,
        'phone'   => $faker->phoneNumber,
        'email'   => $faker->unique()->safeEmail,
    ]);
}
    }
}
