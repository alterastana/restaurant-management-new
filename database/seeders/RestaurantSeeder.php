<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantSeeder extends Seeder
{
    public function run()
    {
        DB::table('restaurants')->insert([
            'name' => 'Roemah Kuliner',
            'address' => 'Jl.Gunpat No. 123, Indonesia',
            'phone' => '081200000000',
            'email' => 'roemahkuliner@resto.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
