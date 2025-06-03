<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'category_id',
        'unit_price',
        'cost_price',
        'currency',
        'service_type',
        'billing_cycle',
        'estimated_hours',
        'service_duration_days',
        'setup_fee',
        'track_inventory',
        'stock_quantity',
        'low_stock_threshold',
        'has_tiered_pricing',
        'pricing_tiers',
        'required_skills',
        'complexity_level',
        'prerequisites',
        'is_taxable',
        'tax_category',
        'is_active',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'estimated_hours' => 'decimal:2',
        'setup_fee' => 'decimal:2',
        'track_inventory' => 'boolean',
        'stock_quantity' => 'integer',
        'low_stock_threshold' => 'integer',
        'has_tiered_pricing' => 'boolean',
        'pricing_tiers' => 'array',
        'required_skills' => 'array',
        'complexity_level' => 'integer',
        'is_taxable' => 'boolean',
        'is_active' => 'boolean',
        'service_duration_days' => 'integer',
    ];

    /**Product belongs to a service category */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    /**Deals that include this product */
    public function deals(): BelongsToMany
    {
        return $this->belongsToMany(Deal::class, 'deal_products')->withPivot([
            'quantity',
            'unit_price',
            'discount_percent',
            'discount_amount',
            'line_total',
            'notes'
        ])->withTimestamps();
    }

    /**check if product is a service */
    public function isService(): bool
    {
        return in_array($this->service_type, ['one_time', 'recurring', 'usage_based']);

    }

    /**Check if product is physical */
    public function isPhysical(): bool
    {
        return $this->track_inventory;
    }

    /**check if product is low stock */
    public function isLowStock(): bool
    {
        return $this->track_inventory && $this->stock_quantity <= $this->low_stock_threshold;
    }

    /**Get profit margin */
    public function getProfitMarginAttribute(): float
    {
        if ($this->unit_price <= 0 || $this->cost_price <= 0){
            return 0;
        }

        return (($this->unit_price - $this->cost_price) / $this->unit_price) * 100;
    }

    /**Scope for active products */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->whereNull('deleted_at');
    }

    /**Scope for services */
    public function scopeServices($query) {
        return $query->whereIn('service_type', ['one_time', 'recurring', 'usage_based']);
    }

    /**Scope for products */
    public function scopePhysicalProducts($query)
    {
        return $query->where('track_inventory', true);
    }
}
