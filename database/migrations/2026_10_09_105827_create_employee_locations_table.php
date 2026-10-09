<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')
                ->constrained('employees')
                ->onDelete('cascade');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 11, 7);
            $table->decimal('accuracy', 8, 2)->nullable();
            $table->decimal('speed', 8, 2)->nullable();
            $table->unsignedTinyInteger('battery_level')->nullable();
            $table->timestamp('tracked_at')->useCurrent();
            $table->string('device_id')->nullable();
            $table->string('sync_id', 100)->nullable()->unique();
            $table->timestamps();

            $table->index(['employee_id', 'tracked_at']);
            $table->index('tracked_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_locations');
    }
};
