<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeLocation extends Model
{
    use HasFactory;

    protected $table = 'employee_locations';

    protected $fillable = [
        'employee_id',
        'latitude',
        'longitude',
        'accuracy',
        'speed',
        'battery_level',
        'tracked_at',
        'device_id',
        'sync_id',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'accuracy' => 'float',
            'speed' => 'float',
            'battery_level' => 'integer',
            'tracked_at' => 'datetime',
        ];
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
