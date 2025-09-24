<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'display_name' => 'Administrator'],
            ['name' => 'manager', 'display_name' => 'Restaurant Manager'],
            ['name' => 'waiter', 'display_name' => 'Waiter'],
            ['name' => 'cashier', 'display_name' => 'Cashier'],
            ['name' => 'customer', 'display_name' => 'Customer'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
