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
        Schema::table('quotations', function (Blueprint $table) {
            // Electrical specs for panel
            $table->string('panel_open_circuit_voltage')->default('52.31');
            $table->string('panel_max_voltage')->default('43.71');
            $table->string('panel_short_circuit_current')->default('14.11');
            $table->string('panel_max_current')->default('13.27');

            // Additional BOS fields
            $table->string('bos_protection_system')->default('Schneider + Elmex | Surge Protecting Devices, MCCBs, Relays etc.');
            $table->string('bos_lt_ht_panels')->default('Tata Power Approved | Air Circuit Breakers, Switching Devices, Bus Bars etc.');
            $table->string('bos_metering')->default('SECURE/HPL/L&T | As per Solar Policy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn([
                'panel_open_circuit_voltage',
                'panel_max_voltage',
                'panel_short_circuit_current',
                'panel_max_current',
                'bos_protection_system',
                'bos_lt_ht_panels',
                'bos_metering'
            ]);
        });
    }
};
