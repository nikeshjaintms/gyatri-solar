<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    protected $fillable = [
        'quotation_number',
        'enquiry_id',
        'customer_id',
        'quotation_date',
        'valid_until',
        'subtotal',
        'tax_percentage',
        'tax_amount',
        'discount',
        'grand_total',
        'terms_conditions',
        'notes',
        'status',
        'system_size',
        'created_by_name',
        'created_by_phone',
        'per_kw_rate',
        'rooftop_amount',
        'net_metering_cost',
        'mnre_subsidy',
        'final_effective_cost',
        'bank_name',
        'bank_account_name',
        'bank_account_no',
        'bank_ifsc',
        'bank_branch',
        'bank_gst_no',
        'panel_watt_peak',
        'panel_qty',
        'panel_type',
        'panel_make',
        'inverter_size',
        'inverter_qty',
        'inverter_make',
        'cable_ac',
        'cable_ac_qty',
        'cable_dc',
        'cable_dc_qty',
        'cable_earthing',
        'cable_earthing_qty',
        'cable_la',
        'cable_la_qty',
        'structure_height',
        'structure_material',
        'bos_acdb',
        'bos_dcdb',
        'bos_earthing',
        'bos_la',
        'bos_misc',
        'warranty_panel',
        'warranty_performance',
        'warranty_inverter',
        'warranty_system',
        'savings_payback',
        'savings_yearly_generation',
        'savings_annual_savings',
        'savings_project_cost',
        'savings_trees_saved',
        'savings_co2_reduction',
        'panel_open_circuit_voltage',
        'panel_max_voltage',
        'panel_short_circuit_current',
        'panel_max_current',
        'bos_protection_system',
        'bos_lt_ht_panels',
        'bos_metering',
    ];

    protected $casts = [
        'quotation_date' => 'date',
        'valid_until' => 'date',
    ];

    /**
     * Get the enquiry associated with the quotation.
     */
    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class, 'enquiry_id');
    }

    /**
     * Get the customer associated with the quotation.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the quotation items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id');
    }
}
