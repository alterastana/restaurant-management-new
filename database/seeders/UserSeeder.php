<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Role::all()->pluck('id', 'name');

        User::create([
            'name' => 'Admin Restaurant',
            'email' => 'admin@resto.com',
            'password' => Hash::make('password'),
            'role_id' => $roles['admin'],
        ]);

        User::create([
            'name' => 'Manager Resto',
            'email' => 'manager@resto.com',
            'password' => Hash::make('password'),
            'role_id' => $roles['manager'],
        ]);

        User::create([
            'name' => 'Waiter A',
            'email' => 'waiter@resto.com',
            'password' => Hash::make('password'),
            'role_id' => $roles['waiter'],
        ]);

        User::create([
            'name' => 'Cashier A',
            'email' => 'cashier@resto.com',
            'password' => Hash::make('password'),
            'role_id' => $roles['cashier'],
        ]);

        User::create([
            'name' => 'Customer Test',
            'email' => 'customer@resto.com',
            'password' => Hash::make('password'),
            'role_id' => $roles['customer'],
        ]);
    }
}
