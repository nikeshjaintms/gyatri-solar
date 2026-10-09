<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'employee_id',
        'aadhaar_number',
        'utr_number',
        'department',
        'designation',
        'joining_date',
        'salary',
    ];

    protected $casts = [
        'joining_date' => 'date',
        'salary' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function locations(): HasMany
    {
        return $this->hasMany(EmployeeLocation::class, 'employee_id');
    }

    public function latestLocation(): HasOne
    {
        return $this->hasOne(EmployeeLocation::class, 'employee_id')->latestOfMany('tracked_at');
    }
}
