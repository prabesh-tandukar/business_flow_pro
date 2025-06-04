<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'company_id',
        'contact_id',
        'lead_id',
        'owner_id',
        'stage_id',
        'type_id',
        'amount',
        'currency',
        'probability',
        'expected_close_date',
        'actual_close_date',
        'description',
        'requirement',
        'competitors',
        'next_steps',
        'is_won',
        'lost_reason',
        'closed_at',
        'last_activity_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'probability' => 'decimal:2',
        'expected_close_date' => 'date',
        'actual_close_date' => 'date',
        'is_won' => 'boolean',
        'closed_at' => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    /**Deal belongs to a company */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**Deal belongs to a contact */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /**Deal originated from a lead */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    /**Deal owner (user responsible for this deal) */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }


    /**Deal stage */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(DealStage::class, 'stage_id');
    }

    /**Deal type */
    public function type(): BelongsTo
    {
        return $this->belongsTo(DealType::class, 'type_id');
    }

    /**Products/service in this deal */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'deal_products')->withPivot([
            'quantity',
            'unit_price',
            'discount_percent',
            'discount_amount',
            'line_total',
            'notes'
        ])->withTimestamps();
    }

    /**Leads that converted to this deal*/
    public function convertedFromLeads(): HasMany
    {
        return $this->hasMany(Lead::class, 'converted_to_deal_id');
    }

    /**Check if deal is closed */
    public function isClosed():bool
    {
        return !is_null($this->closed_at);
    }

    /**Check if deal is won */
    public function isWon(): bool
    {
        return $this->is_won === true;
    }

    /** Check is deal is lost */
    public function isLost(): bool
    {
        return $this->isClosed() && $this->isWon();
    }

    /**Scope for won deals */
    public function scopeWon($query)
    {
        return $query->where('is_won', true);
    }

    /**Scope for lost deals */
    public function scopeLost($query)
    {
        return $query->where('is_won', false)->whereNotNull('closed_at');
    }

    /**Scope for open deals */
    public function scopeOpen($query)
    {
        return $query->whereNull('closed_at')->whereNull('deleted_at');
    }

}
