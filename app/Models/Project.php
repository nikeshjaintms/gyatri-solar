<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'project_name',
        'customer_id',
        'customer_type',
        'solar_capacity',
        'installation_address',
        'status',
        'start_date',
        'completion_date',
        'notes',
    ];

    protected $casts = [
        'solar_capacity' => 'decimal:2',
        'start_date' => 'date',
        'completion_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}