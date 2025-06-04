<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ContactTag extends Pivot
{
    protected $table = 'contact_tags';

    protected $fillable = [
        'contact_id',
        'tag_id',
    ];

    public $timestamps = true;
}
