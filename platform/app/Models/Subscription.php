<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'plan', 'status', 'paddle_subscription_id',
        'paddle_plan_id', 'quantity', 'trial_ends_at', 'ends_at', 'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer', 'trial_ends_at' => 'datetime',
            'ends_at' => 'datetime', 'cancelled_at' => 'datetime',
        ];
    }

    public function user() { return $this->belongsTo(User::class); }
    public function isActive(): bool { return $this->status === 'active' && !$this->isExpired(); }
    public function isExpired(): bool { return $this->ends_at && $this->ends_at->isPast(); }
}
