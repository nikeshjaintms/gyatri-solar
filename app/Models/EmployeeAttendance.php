<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeAttendance extends Model
{
    protected $fillable = [
        'employee_id',
        'attendance_date',
        'check_in_time',
        'check_out_time',
        'status',
        'work_minutes',
        'remarks',
        'punch_in_time',
        'punch_out_time',
        'punch_in_latitude',
        'punch_in_longitude',
        'punch_in_address',
        'punch_in_google_map',
        'punch_out_latitude',
        'punch_out_longitude',
        'punch_out_address',
        'punch_out_google_map',
    ];

    protected $casts = [
        'attendance_date' => 'date',
    ];

    /**
     * Get the employee associated with the attendance.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Get formatted work hours: e.g. "08 Hours 30 Minutes"
     */
    public function getFormattedWorkHoursAttribute(): string
    {
        if ($this->work_minutes === null) {
            return '—';
        }

        $hours = floor($this->work_minutes / 60);
        $minutes = $this->work_minutes % 60;

        return sprintf('%02d Hours %02d Minutes', $hours, $minutes);
    }
}
