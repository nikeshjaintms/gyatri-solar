<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['view_projects', 'create_projects', 'update_projects', 'delete_projects', 'view_payments', 'create_payments', 'update_payments', 'delete_payments'] as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }
    }

    public function down(): void
    {
        Permission::whereIn('name', ['view_projects', 'create_projects', 'update_projects', 'delete_projects', 'view_payments', 'create_payments', 'update_payments', 'delete_payments'])
            ->where('guard_name', 'web')
            ->delete();
    }
};