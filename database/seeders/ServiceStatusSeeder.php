<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ServiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Pending',
            'Assigned',
            'In Progress',
            'Completed',
            'Cancelled',
        ];

        // Check if the service_statuses table exists before seeding
        if (Schema::hasTable('service_statuses')) {
            foreach ($statuses as $status) {
                DB::table('service_statuses')->updateOrInsert(
                    ['name' => $status],
                    ['created_at' => now(), 'updated_at' => now()]
                );
            }
            $this->command->info('Service statuses seeded successfully.');
        } else {
            $this->command->warn('service_statuses table does not exist. Skipping service status seeding.');
        }
    }
}
