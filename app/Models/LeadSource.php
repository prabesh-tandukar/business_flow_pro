<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeadSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'color',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**Leads from this source */
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'source_id');
    }

    /**scope for active sources */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**Scope ordered by sort order */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
