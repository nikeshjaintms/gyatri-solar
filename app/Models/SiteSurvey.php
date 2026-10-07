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

    /**
     * Generate clean, short sequential survey number (e.g. SURV-0001)
     */
    public static function generateSurveyNumber(): string
    {
        $next = (int) (static::query()->max('id') ?? 0) + 1;

        do {
            $number = 'SURV-' . str_pad((string) $next, 4, '0', STR_PAD_LEFT);
            $next++;
        } while (static::query()->where('survey_number', $number)->exists());

        return $number;
    }
}
