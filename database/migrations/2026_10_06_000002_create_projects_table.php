<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->foreignId('customer_id')->constrained()->restrictOnDelete();
            $table->string('customer_type')->default('Residential');
            $table->decimal('solar_capacity', 8, 2);
            $table->text('installation_address');
            $table->enum('status', ['New', 'In Progress', 'Completed', 'Cancelled'])->default('New');
            $table->date('start_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['status', 'customer_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};