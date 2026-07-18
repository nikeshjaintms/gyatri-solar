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
            $table->string('system_size')->default('1.77 KW');
            $table->string('created_by_name')->default('GAYATRI KATARIYA');
            $table->string('created_by_phone')->default('8238340836');
            $table->string('per_kw_rate')->default('51,231');
            $table->string('rooftop_amount')->default('90,679.00');
            $table->string('net_metering_cost')->default('0.00');
            $table->string('mnre_subsidy')->default('53,100.00');
            $table->string('final_effective_cost')->default('37,579');
            
            // Bank details
            $table->string('bank_name')->default('ICICI BANK LTD');
            $table->string('bank_account_name')->default('DELICATE SOLAR PVT.LTD');
            $table->string('bank_account_no')->default('213105010871');
            $table->string('bank_ifsc')->default('ICIC0002131');
            $table->string('bank_branch')->default('KARJAN (391240)');
            $table->string('bank_gst_no')->default('24AAGCD4220Q1ZK');

            // BOM - Panel
            $table->string('panel_watt_peak')->default('590 Wp');
            $table->string('panel_qty')->default('3 Nos');
            $table->string('panel_type')->default('MonoBifacial');
            $table->string('panel_make')->default('TATA');

            // BOM - Inverter
            $table->string('inverter_size')->default('1.00 kW');
            $table->string('inverter_qty')->default('1 Nos');
            $table->string('inverter_make')->default('TATA');

            // BOM - Cables
            $table->string('cable_ac')->default('1C x 2.5Sq.mm FR PVC COPPER FLEXIBLE 1100V IS7098 part 1/1998');
            $table->string('cable_ac_qty')->default('1');
            $table->string('cable_dc')->default('1Cx 4Sq.mm SOLAR FLEXIBLE TINNED COPPER EN-TYP (EN50618)');
            $table->string('cable_dc_qty')->default('1');
            $table->string('cable_earthing')->default('1C x 2.5Sq.mm FR PVC COPPER FLEXIBLE 1100V');
            $table->string('cable_earthing_qty')->default('2');
            $table->string('cable_la')->default('1C x 16Sq.mm Flexible Alu. Cable');
            $table->string('cable_la_qty')->default('1');

            // BOM - Structure
            $table->string('structure_height')->default('Height Of Structure:');
            $table->text('structure_material')->nullable();

            // Balance of System
            $table->text('bos_acdb')->nullable();
            $table->text('bos_dcdb')->nullable();
            $table->text('bos_earthing')->nullable();
            $table->text('bos_la')->nullable();
            $table->text('bos_misc')->nullable();

            // Warranties
            $table->string('warranty_panel')->default('12 Year');
            $table->string('warranty_performance')->default('30 Year');
            $table->string('warranty_inverter')->default('10 Year');
            $table->string('warranty_system')->default('5 Year');

            // Savings
            $table->string('savings_payback')->default('1.83 Years');
            $table->string('savings_yearly_generation')->default('2584.2 Units');
            $table->string('savings_annual_savings')->default('Rs. 20,673.6');
            $table->string('savings_project_cost')->default('Rs. 90,679');
            $table->string('savings_trees_saved')->default('88');
            $table->string('savings_co2_reduction')->default('2 Tonnes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn([
                'system_size', 'created_by_name', 'created_by_phone',
                'per_kw_rate', 'rooftop_amount', 'net_metering_cost', 'mnre_subsidy', 'final_effective_cost',
                'bank_name', 'bank_account_name', 'bank_account_no', 'bank_ifsc', 'bank_branch', 'bank_gst_no',
                'panel_watt_peak', 'panel_qty', 'panel_type', 'panel_make',
                'inverter_size', 'inverter_qty', 'inverter_make',
                'cable_ac', 'cable_ac_qty', 'cable_dc', 'cable_dc_qty', 'cable_earthing', 'cable_earthing_qty', 'cable_la', 'cable_la_qty',
                'structure_height', 'structure_material',
                'bos_acdb', 'bos_dcdb', 'bos_earthing', 'bos_la', 'bos_misc',
                'warranty_panel', 'warranty_performance', 'warranty_inverter', 'warranty_system',
                'savings_payback', 'savings_yearly_generation', 'savings_annual_savings', 'savings_project_cost', 'savings_trees_saved', 'savings_co2_reduction'
            ]);
        });
    }
};
