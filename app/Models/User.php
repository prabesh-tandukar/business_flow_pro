<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\RElations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Traits\HasRoles;




class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, SoftDeletes, HasRoles;

    protected $guard_name = 'web';

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
        'last_login_at',
        'email_verified_at'
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

    // API Token abilities/permissions for CRM
    public function createApiToken(string $name = 'CRM API Token', array $abilities = ['*']): \Laravel\Sanctum\NewAccessToken
    {
        // Get user's actual permissions from Spatie
        $userPermissions = $this->getAllPermissions()->pluck('name')->toArray();
        
        // If user has specific permissions, use those. Otherwise, use provided abilities
        $tokenAbilities = !empty($userPermissions) ? $userPermissions : $abilities;
        
        return $this->createToken($name, $tokenAbilities);
    }

     // Check if user can access specific CRM ability
    public function canAccessCrm(string $ability): bool
    {
        return $this->tokenCan($ability) || $this->can($ability);
    }

    // Check if user can access specific ability
    public function canAccessApi(string $ability): bool
    {
        return $this->tokenCan($ability);
    }

    /**companies owned by this user */
    public function companies():HasMany
    {
        return $this->hasMany(Company::class, 'owner_id');
    }

    /**Contacts owned by this user */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'owner_id');
    }

    /**Lead owned by this user */
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'owner_id');

    }
    /**
     * Deals owned by this user
     */
    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class, 'owner_id');
    }

    // // Simple role relationship for Week 2 testing
    // public function roles(): BelongsToMany
    // {
    //     return $this->belongsToMany(Role::class, 'user_roles');
    // }

    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function assignRole($roleName)
    {
        $role = \App\Models\Role::where('name', $roleName)->first();
        if ($role && !$this->hasRole($roleName)) {
            $this->roles()->attach($role->id);
        }
        return $this;
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function isActive()
    {
        return $this->is_active;
    }

    // Get user's CRM dashboard data
    public function getCrmStats(): array
    {
        return [
            'leads_count' => $this->leads()->count(),
            'deals_count' => $this->deals()->count(),
            'contacts_count' => $this->contacts()->count(),
            'deals_value' => $this->deals()->sum('amount'),
            'recent_activity' => $this->getRecentActivity(),
        ];
    }

    private function getRecentActivity(): array
    {
        // Get recent leads and deals
        $recentLeads = $this->leads()->latest()->limit(5)->get(['id', 'title', 'created_at']);
        $recentDeals = $this->deals()->latest()->limit(5)->get(['id', 'name', 'amount', 'created_at']);

        return [
            'recent_leads' => $recentLeads,
            'recent_deals' => $recentDeals,
        ];

    }
}