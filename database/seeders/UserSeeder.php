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
            'phone' => '08123456789',
            'password' => Hash::make('password'),
            'role_id' => $roles['admin'],
        ]);

        User::create([
            'name' => 'Manager Resto',
            'email' => 'manager@resto.com',
            'phone' => '08123456789',
            'password' => Hash::make('password'),
            'role_id' => $roles['manager'],
        ]);

    }
}
