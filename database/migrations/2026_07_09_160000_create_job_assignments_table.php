<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_request_id');
            $table->unsignedBigInteger('technician_id');
            $table->date('assigned_date');
            $table->date('scheduled_date')->nullable();
            $table->time('scheduled_time')->nullable();
            $table->enum('status', ['Assigned', 'Accepted', 'In Progress', 'Completed', 'Cancelled'])
                  ->default('Assigned');
            $table->enum('priority', ['Low', 'Medium', 'High', 'Urgent'])
                  ->default('Medium');
            $table->text('work_notes')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('service_request_id')
                  ->references('id')->on('service_requests')
                  ->onDelete('cascade');

            $table->foreign('technician_id')
                  ->references('id')->on('technicians')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_assignments');
    }
};
