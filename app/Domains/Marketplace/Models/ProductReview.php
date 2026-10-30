<?php

declare(strict_types=1);

namespace App\Domains\Marketplace\Models;

use App\Domains\Users\Models\User;
use App\Models\MarketplaceProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'order_id', 'rating', 'title',
        'body', 'helpful_count', 'status',
    ];

    protected $casts = [
        'rating' => 'integer',
        'helpful_count' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(MarketplaceProduct::class, 'product_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getIsApprovedAttribute(): bool
    {
        return $this->status === 'approved';
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
