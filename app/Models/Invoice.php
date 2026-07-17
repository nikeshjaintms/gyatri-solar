<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_no',
        'customer_id',
        'service_id',
        'service_request_id',
        'job_assignment_id',
        'invoice_date',
        'due_date',
        'subtotal',
        'discount',
        'tax',
        'total_amount',
        'paid_amount',
        'balance_amount',
        'payment_status',
        'payment_mode',
        'notes',
    ];

    protected $casts = [
        'invoice_date'   => 'date',
        'due_date'       => 'date',
        'subtotal'       => 'decimal:2',
        'discount'       => 'decimal:2',
        'tax'            => 'decimal:2',
        'total_amount'   => 'decimal:2',
        'paid_amount'    => 'decimal:2',
        'balance_amount' => 'decimal:2',
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

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function jobAssignment()
    {
        return $this->belongsTo(JobAssignment::class);
    }

    /* ── Auto-generate invoice number ── */
    public static function generateInvoiceNo(): string
    {
        $last = static::orderBy('id', 'desc')->first();
        $next = $last ? ((int) substr($last->invoice_no, 4)) + 1 : 1;
        return 'INV-' . str_pad($next, 4, '0', STR_PAD_LEFT);
    }
}
