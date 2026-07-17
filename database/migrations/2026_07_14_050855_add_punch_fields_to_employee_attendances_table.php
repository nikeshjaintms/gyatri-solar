<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('employee_attendances', function (Blueprint $table) {
            $table->time('punch_in_time')->nullable();
            $table->time('punch_out_time')->nullable();
            $table->string('punch_in_latitude')->nullable();
            $table->string('punch_in_longitude')->nullable();
            $table->text('punch_in_address')->nullable();
            $table->text('punch_in_google_map')->nullable();
            $table->string('punch_out_latitude')->nullable();
            $table->string('punch_out_longitude')->nullable();
            $table->text('punch_out_address')->nullable();
            $table->text('punch_out_google_map')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_attendances', function (Blueprint $table) {
            $table->dropColumn([
                'punch_in_time',
                'punch_out_time',
                'punch_in_latitude',
                'punch_in_longitude',
                'punch_in_address',
                'punch_in_google_map',
                'punch_out_latitude',
                'punch_out_longitude',
                'punch_out_address',
                'punch_out_google_map',
            ]);
        });
    }
};
