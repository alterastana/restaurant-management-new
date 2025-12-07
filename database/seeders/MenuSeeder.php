<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            ['Nasi Goreng',     20000],
            ['Bakso',           15000],
            ['Mie Ayam',        13000],
            ['Sate Ayam',       25000],
            ['Soto Ayam',       17000],
            ['Rendang',         30000],
            ['Ayam Geprek',     18000],
            ['Nasi Padang',     25000],
            ['Gado-Gado',       12000],
            ['Pempek',          15000],
            ['Nasi Uduk',       8000],
            ['Ayam Bakar',      28000],
            ['Rawon',           22000],
            ['Lontong Sayur',   10000],
            ['Tahu Tek',        12000],
        ];

        foreach ($menus as $m) {
            DB::table('menus')->insert([
                'restaurant_id' => 1,
                'name'          => $m[0],
                'description'   => 'Hidangan khas Indonesia yang populer.',
                'price'         => $m[1],
                'stock'         => 20,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
