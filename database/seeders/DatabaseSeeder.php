<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
        RestaurantSeeder::class,
        TableRestaurantSeeder::class,
        MenuSeeder::class,
        CustomerSeeder::class,
        ReservationSeeder::class,
        OrderSeeder::class,
        OrderDetailSeeder::class,
        PaymentSeeder::class,
        LoyaltyProgramSeeder::class,
        RoleSeeder::class,
        PermissionSeeder::class,
        RolePermissionSeeder::class,
        UserSeeder::class,
    ]);
}

}
