<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DealStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'probability',
        'color',
        'is_active',
        'is_default',
        'is_won',
        'is_lost',
        'sort_order',
    ];

    protected $casts = [
        'probability' => 'decimal:2',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'is_won' => 'boolean',
        'is_lost' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**Deals in this stage */
    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class, 'stage_id');
    }

    /**Check if this is a closing stage (won/last) */
    public function isClosingStage(): bool
    {
        return $this->is_won || $this->is_lost;
    }

    /**Scope for ative stages */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** Scope for winning stages */
    public function scopeWinning($query)
    {
        return $query->where('is_won', true);
    }

    /**Scope for losing stages */
    public function scopeLosing($query)
    {
        return $query->where('is_lost', true);
    }

    /**Scope ordered by sort order */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

}
