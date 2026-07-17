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
        Schema::create('site_surveys', function (Blueprint $table) {
            $table->id();
            $table->string('survey_number')->unique();
            $table->foreignId('enquiry_id')->nullable()->constrained('enquiries')->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->date('survey_date');
            $table->foreignId('surveyor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('site_address');
            $table->string('property_type')->nullable();
            $table->string('roof_type')->nullable();
            $table->string('available_area')->nullable();
            $table->string('required_solar_capacity')->nullable();
            $table->string('existing_electricity_load')->nullable();
            $table->string('average_electricity_bill')->nullable();
            $table->string('meter_type')->nullable();
            $table->string('shadow_condition')->nullable();
            $table->string('installation_feasibility')->nullable();
            $table->longText('site_photos')->nullable(); // Saved as JSON array of file paths
            $table->text('survey_notes')->nullable();
            $table->text('recommendation')->nullable();
            $table->enum('status', ['Pending', 'Scheduled', 'Completed', 'Approved', 'Rejected'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_surveys');
    }
};
