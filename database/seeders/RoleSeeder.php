<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $customerRole = Role::create(['name' => 'customer']);

        // Create permissions
        $manageProducts = \Spatie\Permission\Models\Permission::create(['name' => 'manage products']);
        $viewDashboard = \Spatie\Permission\Models\Permission::create(['name' => 'view dashboard']);
        $placeOrders = \Spatie\Permission\Models\Permission::create(['name' => 'place orders']);

        // Assign permissions to admin role
        $adminRole->givePermissionTo([
            $manageProducts,
            $viewDashboard,
        ]);

        // Assign permissions to customer role
        $customerRole->givePermissionTo([
            $placeOrders,
        ]);

        // Create a default admin user
        $admin = \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        // Create a default customer
        $customer = \App\Models\User::create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
        ]);
        $customer->assignRole('customer');
    }
}
