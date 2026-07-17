<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteSurvey extends Model
{
    protected $fillable = [
        'survey_number',
        'enquiry_id',
        'customer_id',
        'survey_date',
        'surveyor_id',
        'site_address',
        'property_type',
        'roof_type',
        'available_area',
        'required_solar_capacity',
        'existing_electricity_load',
        'average_electricity_bill',
        'meter_type',
        'shadow_condition',
        'installation_feasibility',
        'site_photos',
        'survey_notes',
        'recommendation',
        'status',
    ];

    protected $casts = [
        'survey_date' => 'date',
        'site_photos' => 'array',
    ];

    /**
     * Get the enquiry associated with the site survey.
     */
    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class, 'enquiry_id');
    }

    /**
     * Get the customer associated with the site survey.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the employee/technician surveyor.
     */
    public function surveyor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'surveyor_id');
    }
}
