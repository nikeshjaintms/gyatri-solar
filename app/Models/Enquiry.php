<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Enquiry extends Model
{
    protected $fillable = [
        'enquiry_number',
        'customer_id',
        'customer_name',
        'mobile_number',
        'email',
        'address',
        'enquiry_date',
        'service_product',
        'enquiry_source',
        'assigned_employee_id',
        'status',
        'follow_up_date',
        'remarks',
    ];

    protected $casts = [
        'enquiry_date' => 'date',
        'follow_up_date' => 'date',
    ];

    /**
     * Get the customer associated with the enquiry.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the assigned employee associated with the enquiry.
     */
    public function assignedEmployee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_employee_id');
    }

    /**
     * Get the quotation associated with the enquiry.
     */
    public function quotation(): HasOne
    {
        return $this->hasOne(Quotation::class, 'enquiry_id');
    }

    /**
     * Get site surveys associated with the enquiry.
     */
    public function siteSurveys(): HasMany
    {
        return $this->hasMany(SiteSurvey::class, 'enquiry_id');
    }
}
