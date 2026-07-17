<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
        'customer_id',
        'service_id',
        'technician_id',
        'request_date',
        'service_date',
        'priority',
        'status',
        'address',
        'description',
        'remarks',
    ];

    protected $casts = [
        'request_date' => 'date',
        'service_date'  => 'date',
    ];

    /* ── Relationships ── */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function jobAssignment()
    {
        return $this->hasOne(JobAssignment::class);
    }
}
