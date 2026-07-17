<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobAssignment extends Model
{
    protected $fillable = [
        'service_request_id',
        'technician_id',
        'assigned_date',
        'scheduled_date',
        'scheduled_time',
        'status',
        'priority',
        'work_notes',
        'remarks',
    ];

    protected $casts = [
        'assigned_date'  => 'date',
        'scheduled_date' => 'date',
    ];

    /* ── Relationships ── */

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function jobStatusTrackings()
    {
        return $this->hasMany(JobStatusTracking::class);
    }
}
