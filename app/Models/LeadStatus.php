<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeadStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color',
        'is_active',
        // 'is_default',
        'is_converted',
        'is_lost',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        // 'is_default' => 'boolean',
        'is_converted' => 'boolean',
        'is_lost' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**Leads with this status */
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'status_id');
    }

    /**Scope for active statuses */
    public function scopeActive($query) 
    {
        return $query->where('is_active', true);
    }

    /**scope for default status */
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
