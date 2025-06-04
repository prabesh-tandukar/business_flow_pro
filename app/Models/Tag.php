<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'color',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**Contacts with this tag */
    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'contact_tags');
    }

    /**Scope for active tags */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** Scope ordered by name */
    public function scopeOrdered($query)
    {
        return $query->orderBy('name');
    }
}
