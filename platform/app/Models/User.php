<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    protected $fillable = [
        'name', 'email', 'password', 'username', 'avatar', 'bio',
        'website', 'github_username', 'twitter_username', 'is_public',
        'email_verified_at', 'two_factor_secret', 'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];

    protected $hidden = ['password', 'remember_token', 'two_factor_secret', 'two_factor_recovery_codes'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'password' => 'hashed',
            'is_public' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string { return 'username'; }
    public function profile() { return $this->hasOne(UserProfile::class); }
    public function favorites() { return $this->belongsToMany(Component::class, 'user_favorites')->withTimestamps(); }
    public function projects() { return $this->hasMany(Project::class); }
    public function subscription() { return $this->hasOne(Subscription::class); }
    public function invoices() { return $this->hasMany(Invoice::class); }
    public function apiKeys() { return $this->hasMany(ApiKey::class); }
    public function isAdmin(): bool { return $this->hasRole('admin'); }
    public function isPro(): bool { return $this->subscription?->plan === 'pro'; }
    public function isEnterprise(): bool { return $this->subscription?->plan === 'enterprise'; }
}
