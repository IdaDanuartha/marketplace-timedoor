<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enum\UserRole;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class);
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getRoleAttribute(): UserRole
    {
        if ($this->relationLoaded('admin') ? $this->admin !== null : $this->admin()->exists()) {
            return UserRole::ADMIN;
        }
        if ($this->relationLoaded('vendor') ? $this->vendor !== null : $this->vendor()->exists()) {
            return UserRole::VENDOR;
        }
        if ($this->relationLoaded('customer') ? $this->customer !== null : $this->customer()->exists()) {
            return UserRole::CUSTOMER;
        }
        return UserRole::UNKNOWN;
    }

    public function isAdmin(): bool    { 
        return $this->role === UserRole::ADMIN; 
    }

    public function isVendor(): bool   { 
        return $this->role === UserRole::VENDOR; 
    }

    public function isCustomer(): bool { 
        return $this->role === UserRole::CUSTOMER; 
    }

    public function getDisplayNameAttribute()
    {
        return $this->admin?->name
            ?? $this->vendor?->name
            ?? $this->customer?->name
            ?? 'Unknown User';
    }
}
