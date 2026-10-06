<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public const CATEGORIES = [
        'Residential',
        'Commercial',
        'Other',
    ];

    protected $fillable = [
        'service_name',
        'service_code',
        'category',
        'price',
        'duration',
        'description',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }
}
