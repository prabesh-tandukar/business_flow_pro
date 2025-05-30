<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    
    use HasApiTokens, HasFactory, Notifiable, HasUuids, SoftDeletes, HasRoles;

    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'phone',
        'position',
        'avatar_url',
        'is_active',
        'timezone',
        'language',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

   protected $casts = [
    'email_verified_at' => 'datetime',
    'last_login_at' => 'datetime',
    'is_active' => 'boolean',
    'password' => 'hashed',
   ];


    public function getFullNameAttribute() 
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function isActive() 
    {
        return $this->is_active;
    }
}
