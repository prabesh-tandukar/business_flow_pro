<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'industry',
        'website',
        'phone',
        'email',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'description',
        'employees_count',
        'annual_revenue',
        'company_size',
        'owner_id',
        'logo_url',
        'timezone',
    ];

    protected $casts = [
        'annual_revenue' => 'decimal:2',
        'employees_count' => 'integer',
    ];
    
    /**Company owner (user who manages this company) */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**All contacts associated with this company */
    public function contacts(): HasMany
    {
        return $this->hasMany(Deal::class, 'company_id');

    }

    /**Get full address as a single string */
    public function getFullAddressAttribute(): string
    {
        $address = collect([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country
        ])->filter()->implode(', ');

        return $address;
    }

}
