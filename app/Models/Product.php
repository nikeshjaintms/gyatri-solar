<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'product_code',
        'name',
        'category',
        'brand',
        'model_number',
        'unit',
        'hsn_sac_code',
        'gst',
        'purchase_price',
        'selling_price',
        'opening_stock',
        'minimum_stock_level',
        'description',
        'image',
        'status',
    ];

    protected $casts = [
        'gst' => 'decimal:2',
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'opening_stock' => 'integer',
        'minimum_stock_level' => 'integer',
    ];

    /**
     * Get image URL fallback.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }
        return 'https://placehold.co/100x100?text=' . urlencode($this->name);
    }
}
