<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update the default Super Admin user
        $user = User::updateOrCreate(
            ['email' => 'gayatrisolar@gmail.com'],
            [
                'name' => 'Gayatri Solar',
                'password' => Hash::make('12345678'),
                'role' => 'Super Admin', // Seeding the role enum field directly
                'status' => 'Active',
            ]
        );

        $this->command->info("Super Admin user '{$user->email}' created or updated successfully.");

        // Automatically assign the Spatie Role if the relationship/method is available
        if (method_exists($user, 'assignRole') && class_exists(\Spatie\Permission\Models\Role::class)) {
            $roleExists = \Spatie\Permission\Models\Role::where('name', 'Super Admin')->exists();
            if ($roleExists) {
                $user->assignRole('Super Admin');
                $this->command->info("Super Admin role assigned to user via Spatie Permission.");
            }
        }
    }
}
