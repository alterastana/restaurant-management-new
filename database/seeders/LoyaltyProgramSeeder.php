<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoyaltyProgramSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 15) as $i) {
            DB::table('loyalty_programs')->insert([
                'customer_id' => $i,
                'points' => rand(0, 500),
                'membership_level' => fake()->randomElement(['Silver', 'Gold', 'Platinum']),
            ]);
        }
    }
}
