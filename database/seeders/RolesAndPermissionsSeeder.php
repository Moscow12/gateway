<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard
            'view dashboard',

            // User management
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Role management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            // Permission management
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',

            // Client management
            'view clients',
            'create clients',
            'edit clients',
            'delete clients',

            // Invoice management
            'view invoices',
            'create invoices',
            'edit invoices',
            'delete invoices',
            'print invoices',

            // Reports
            'view reports',
            'export reports',

            // Settings
            'view settings',
            'edit settings',
            'view company details',
            'edit company details',

            // Website management
            'manage website',
            'edit hero section',
            'edit about section',
            'edit services',
            'edit testimonials',
            'edit partners',
            'edit gallery',
            'edit team',

            // SMS management
            'view sms',
            'send sms',
            'manage sms categories',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Super Admin - has all permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - has most permissions except some system settings
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            'view dashboard',
            'view users', 'create users', 'edit users', 'delete users',
            'view roles', 'create roles', 'edit roles', 'delete roles',
            'view permissions',
            'view clients', 'create clients', 'edit clients', 'delete clients',
            'view invoices', 'create invoices', 'edit invoices', 'delete invoices', 'print invoices',
            'view reports', 'export reports',
            'view settings', 'edit settings',
            'view company details', 'edit company details',
            'manage website', 'edit hero section', 'edit about section', 'edit services',
            'edit testimonials', 'edit partners', 'edit gallery', 'edit team',
            'view sms', 'send sms', 'manage sms categories',
        ]);

        // Manager - can manage clients, invoices, and view reports
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $manager->givePermissionTo([
            'view dashboard',
            'view users',
            'view clients', 'create clients', 'edit clients',
            'view invoices', 'create invoices', 'edit invoices', 'print invoices',
            'view reports', 'export reports',
            'view sms', 'send sms',
        ]);

        // Accountant - focused on financial tasks
        $accountant = Role::firstOrCreate(['name' => 'accountant']);
        $accountant->givePermissionTo([
            'view dashboard',
            'view clients',
            'view invoices', 'create invoices', 'edit invoices', 'print invoices',
            'view reports', 'export reports',
        ]);

        // Staff - basic access
        $staff = Role::firstOrCreate(['name' => 'staff']);
        $staff->givePermissionTo([
            'view dashboard',
            'view clients',
            'view invoices', 'print invoices',
        ]);

        // User - minimal access
        $user = Role::firstOrCreate(['name' => 'user']);
        $user->givePermissionTo([
            'view dashboard',
        ]);

        // Assign super-admin role to first user if exists
        $firstUser = User::first();
        if ($firstUser && !$firstUser->hasAnyRole(Role::all())) {
            $firstUser->assignRole('super-admin');
        }
    }
}
