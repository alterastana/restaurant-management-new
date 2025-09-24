<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 15) as $i) {
            DB::table('customers')->insert([
                'name'  => $faker->name,
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
            ]);
        }
    }
}
