<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->after('customer_id')->constrained()->nullOnDelete();
        });

        Schema::table('service_requests', function (Blueprint $table) {
            $table->string('service_number')->nullable()->unique()->after('id');
            $table->foreignId('project_id')->nullable()->after('customer_id')->constrained()->nullOnDelete();
        });

        DB::table('service_requests')->whereNull('service_number')->orderBy('id')->chunkById(100, function ($requests) {
            foreach ($requests as $request) {
                DB::table('service_requests')->where('id', $request->id)->update([
                    'service_number' => 'SRV-' . str_pad((string) $request->id, 6, '0', STR_PAD_LEFT),
                ]);
            }
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->foreignId('project_id')->nullable()->after('customer_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });

        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropUnique(['service_number']);
            $table->dropColumn(['project_id', 'service_number']);
        });

        Schema::table('quotations', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });
    }
};