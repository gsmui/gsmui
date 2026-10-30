<?php

declare(strict_types=1);

namespace App\Domains\Billing\Models;

use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'stripe_id', 'amount', 'total', 'line_items', 'currency', 'status',
        'description', 'invoice_number', 'pdf_url', 'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'total' => 'decimal:2',
        'line_items' => 'array',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
