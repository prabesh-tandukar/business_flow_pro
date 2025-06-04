<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DealType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color',
        'is_active',
        'is_default',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**Deals of this type */
    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class, 'type_id');
    }

    /**Scope for active types */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**Scope for default type */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**Scope ordered by sort order */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
