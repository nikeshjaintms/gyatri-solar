<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Super Admin',
            'Admin',
            'Manager',
            'Technician',
            'Employee',
        ];

        // Seed Spatie roles if the package is installed
        if (class_exists(\Spatie\Permission\Models\Role::class)) {
            foreach ($roles as $roleName) {
                \Spatie\Permission\Models\Role::firstOrCreate([
                    'name' => $roleName,
                    'guard_name' => 'web',
                ]);
            }
            $this->command->info('Roles seeded successfully using Spatie Permission package.');
        } else {
            $this->command->warn('Spatie Laravel Permission package is not installed. Skipping roles table seeding.');
        }
    }
}
