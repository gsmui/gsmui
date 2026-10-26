<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'type', 'value', 'minimum_order_amount', 'maximum_uses',
        'used_count', 'starts_at', 'expires_at', 'active',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'minimum_order_amount' => 'decimal:2',
            'maximum_uses' => 'integer',
            'used_count' => 'integer',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'active' => 'boolean',
        ];
    }

    public function orders() { return $this->hasMany(Order::class); }
    public function isValid(): bool
    {
        return $this->active
            && (!$this->starts_at || $this->starts_at->isPast())
            && (!$this->expires_at || $this->expires_at->isFuture())
            && ($this->maximum_uses === null || $this->used_count < $this->maximum_uses);
    }
}
