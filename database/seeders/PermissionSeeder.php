<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Restaurant & Table
            ['name' => 'manage_restaurant', 'display_name' => 'Manage Restaurants'],
            ['name' => 'manage_tables', 'display_name' => 'Manage Tables'],
            ['name' => 'view_tables', 'display_name' => 'View Tables'],

            // Menu
            ['name' => 'manage_menu', 'display_name' => 'Manage Menu'],
            ['name' => 'view_menu', 'display_name' => 'View Menu'],

            // Reservation
            ['name' => 'create_reservation', 'display_name' => 'Create Reservation'],
            ['name' => 'view_reservation', 'display_name' => 'View Reservations'],
            ['name' => 'cancel_reservation', 'display_name' => 'Cancel Reservation'],

            // Order
            ['name' => 'create_order', 'display_name' => 'Create Order'],
            ['name' => 'view_order', 'display_name' => 'View Orders'],
            ['name' => 'update_order_status', 'display_name' => 'Update Order Status'],

            // Payment
            ['name' => 'process_payment', 'display_name' => 'Process Payment'],
            ['name' => 'view_payment', 'display_name' => 'View Payments'],

            // Loyalty
            ['name' => 'view_loyalty', 'display_name' => 'View Loyalty Program'],
            ['name' => 'redeem_points', 'display_name' => 'Redeem Points'],

            // Reports
            ['name' => 'view_reports', 'display_name' => 'View Reports'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
