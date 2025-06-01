<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    // You can add custom methods here if needed
    protected $fillable = ['name', 'guard_name', 'description'];
}