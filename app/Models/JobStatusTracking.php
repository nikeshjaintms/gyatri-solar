<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobStatusTracking extends Model
{
    protected $fillable = [
        'job_assignment_id',
        'status',
        'status_date',
        'status_time',
        'work_progress',
        'notes',
    ];

    protected $casts = [
        'status_date' => 'date',
    ];

    /* ── Relationships ── */

    public function jobAssignment()
    {
        return $this->belongsTo(JobAssignment::class);
    }
}
