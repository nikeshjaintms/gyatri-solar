<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if settings table exists before seeding
        if (Schema::hasTable('settings')) {
            $defaultSettings = [
                [
                    'key' => 'site_name',
                    'value' => 'Gayatri Solar Energy',
                ],
                [
                    'key' => 'contact_email',
                    'value' => 'info@gayatrisolar.com',
                ],
                [
                    'key' => 'contact_phone',
                    'value' => '+91 98765 43210',
                ],
                [
                    'key' => 'address',
                    'value' => 'Gayatri Solar Energy, Gujarat, India',
                ],
                [
                    'key' => 'currency',
                    'value' => 'INR',
                ],
            ];

            foreach ($defaultSettings as $setting) {
                DB::table('settings')->updateOrInsert(
                    ['key' => $setting['key']],
                    [
                        'value' => $setting['value'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
            $this->command->info('Default application settings seeded successfully.');
        } else {
            $this->command->warn('settings table does not exist. Skipping settings seeding.');
        }
    }
}
