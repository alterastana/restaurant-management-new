<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $allPermissions = Permission::all();

        // Admin -> semua permission
        $admin = Role::where('name', 'admin')->first();
        $admin->permissions()->attach($allPermissions);

        // Manager
        $manager = Role::where('name', 'manager')->first();
        $manager->permissions()->attach(Permission::whereIn('name', [
            'manage_menu', 'view_menu',
            'view_reservation',
            'view_order',
            'view_payment',
            'view_reports'
        ])->get());

        // Waiter
        $waiter = Role::where('name', 'waiter')->first();
        $waiter->permissions()->attach(Permission::whereIn('name', [
            'create_order', 'view_order', 'update_order_status',
            'create_reservation', 'view_reservation'
        ])->get());

        // Cashier
        $cashier = Role::where('name', 'cashier')->first();
        $cashier->permissions()->attach(Permission::whereIn('name', [
            'process_payment', 'view_payment'
        ])->get());

        // Customer
        $customer = Role::where('name', 'customer')->first();
        $customer->permissions()->attach(Permission::whereIn('name', [
            'view_menu', 'create_order', 'view_order',
            'create_reservation', 'view_reservation', 'cancel_reservation',
            'process_payment',
            'view_loyalty', 'redeem_points'
        ])->get());
    }
}
