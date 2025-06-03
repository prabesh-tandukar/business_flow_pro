<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'contact_id',
        'status_id',
        'source_id',
        'owner_id',
        'title',
        'description',
        'estimated_value',
        'probability',
        'expected_close_date',
        'lead_score',
        'temperature',
        'requirements',
        'budget_range',
        'decision_timeframe',
        'decision_makers',
        'last_activity_at',
        'converted_at',
        'converted_to_deal_id',
    ];

    protected $casts = [
        'estimated_value' => 'decimal:2',
        'probability' => 'integer',
        'expected_clode_date' => 'date',
        'last_activity_at' => 'datetime',
        'converted_at' => 'datetime',
        'lead_score' => 'integer',
    ];

    /** Lead belongs to a contact */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    /** Lead Status */
    public function status(): BelongsTo
    {
        return $this->belongsTo(LeadStatus::class, 'status_id');
    }

    /** Lead source */
    public function source(): BelongsTo
    {
        return $this->belongsTo(LeadSource::class, 'source_id');
    }

    /**Lead Owner (user responsible for this lead) */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**Deal this lead was converted to */
    public function convertedToDeal(): BelongsTo
    {
        return $this->belongsTo(Deal::class, 'converted_to_deal_id') ;
    }

    /**check if lead is converted */
    public function isConverted(): bool
    {
        return !is_null($this->converted_at);
    }

    /**Scope for converted leads */
    public function scopeConverted($query)
    {
        return $query->whereNotNull('converted_at');
    }

    /** Scope for active leads */
    public function scopeActive($query)
    {
        return $query->whereNull('converted_at')->whereNull('deleted_at');
    }

}

