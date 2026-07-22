<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if Spatie Permission class exists
        if (!class_exists(\Spatie\Permission\Models\Permission::class) || !class_exists(\Spatie\Permission\Models\Role::class)) {
            $this->command->warn('Spatie Laravel Permission package is not installed. Skipping permissions table seeding.');
            return;
        }

        $modules = [
            'Dashboard',
            'Customers',
            'Technicians',
            'Services',
            'Service Requests',
            'Job Assignments',
            'Job Status Tracking',
            'Attendance',
            'Quotations',
            'Invoices',
            'Payments',
            'Reports',
            'Settings',
            'Users',
            'Roles',
            'Permissions',
        ];

        $actions = ['view', 'create', 'update', 'delete'];
        $permissions = [];

        foreach ($modules as $module) {
            $slug = Str::slug($module, '_');
            
            // Dashboard and Reports typically only require view/access permission
            if (in_array($module, ['Dashboard', 'Reports'])) {
                $permissions[] = "view_{$slug}";
                continue;
            }

            foreach ($actions as $action) {
                $permissions[] = "{$action}_{$slug}";
            }
        }

        // Seed permissions
        foreach ($permissions as $permissionName) {
            \Spatie\Permission\Models\Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);
        }

        // Assign all permissions to Super Admin role
        $superAdminRole = \Spatie\Permission\Models\Role::where('name', 'Super Admin')->first();
        if ($superAdminRole) {
            $superAdminRole->syncPermissions($permissions);
            $this->command->info('All permissions created and assigned to Super Admin role successfully.');
        } else {
            $this->command->error('Super Admin role not found. Permissions could not be assigned.');
        }
    }
}
