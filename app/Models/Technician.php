<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'specialization',
        'experience',
        'address',
        'status',
    ];

    public function jobAssignments()
    {
        return $this->hasMany(JobAssignment::class);
    }
}