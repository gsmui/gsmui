<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'quantity',
        'price', 'total', 'license_key',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'total' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    public function order() { return $this->belongsTo(\App\Domains\Marketplace\Models\Order::class); }
    public function product() { return $this->belongsTo(MarketplaceProduct::class, 'product_id'); }
}
