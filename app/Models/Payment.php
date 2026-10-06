<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_number',
        'customer_id',
        'project_id',
        'payment_date',
        'amount',
        'payment_mode',
        'reference_number',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public static function generateNumber(): string
    {
        $prefix = 'PAY-' . now()->format('Ym');
        $next = (static::query()->max('id') ?? 0) + 1;

        do {
            $number = $prefix . '-' . str_pad((string) $next, 5, '0', STR_PAD_LEFT);
            $next++;
        } while (static::query()->where('payment_number', $number)->exists());

        return $number;
    }
}