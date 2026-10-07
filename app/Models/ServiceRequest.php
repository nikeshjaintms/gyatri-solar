<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
        'customer_id',
        'project_id',
        'service_number',
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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public static function generateServiceNumber(): string
    {
        $next = (int) (static::max('id') ?? 0) + 1;

        do {
            $number = 'SRV-' . str_pad((string) $next, 4, '0', STR_PAD_LEFT);
            $next++;
        } while (static::where('service_number', $number)->exists());

        return $number;
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

    public function jobAssignments()
    {
        return $this->hasMany(JobAssignment::class);
    }
}
