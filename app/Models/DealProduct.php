<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DealProduct extends Pivot
{
    protected $table = 'deal_products';

    protected $fillable = [
        'deal_id',
        'product_id',
        'quantity',
        'unit_price',
        'discount_percent',
        'discount_amount',
        'line_total',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    public $timestamps = true;
}
