<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'order_id', 'license_key', 'status',
        'activated_at', 'expires_at', 'activations_count', 'max_activations',
    ];

    protected function casts(): array
    {
        return [
            'activated_at' => 'datetime',
            'expires_at' => 'datetime',
            'activations_count' => 'integer',
            'max_activations' => 'integer',
        ];
    }

    public function user() { return $this->belongsTo(\App\Domains\Users\Models\User::class); }
    public function product() { return $this->belongsTo(MarketplaceProduct::class, 'product_id'); }
    public function order() { return $this->belongsTo(\App\Domains\Marketplace\Models\Order::class); }
    public function isExpired(): bool { return $this->expires_at && $this->expires_at->isPast(); }
}
