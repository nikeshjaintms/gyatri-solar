<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_status_trackings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_assignment_id');
            $table->enum('status', [
                'Assigned', 'Accepted', 'On The Way',
                'In Progress', 'Hold', 'Completed', 'Cancelled',
            ])->default('Assigned');
            $table->date('status_date');
            $table->time('status_time')->nullable();
            $table->text('work_progress')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('job_assignment_id')
                  ->references('id')->on('job_assignments')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_status_trackings');
    }
};
