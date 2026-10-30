<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketplaceProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'marketplace_products';

    protected $fillable = [
        'user_id', 'name', 'slug', 'description', 'long_description',
        'price', 'compare_price', 'type', 'status', 'downloads_count',
        'reviews_count', 'rating_avg', 'commission_rate', 'featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_price' => 'decimal:2',
            'rating_avg' => 'decimal:2',
            'commission_rate' => 'decimal:2',
            'downloads_count' => 'integer',
            'reviews_count' => 'integer',
            'featured' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string { return 'slug'; }
    public function author() { return $this->belongsTo(\App\Domains\Users\Models\User::class, 'user_id'); }

    public function orders()
    {
        return $this->belongsToMany(\App\Domains\Marketplace\Models\Order::class, 'order_items', 'product_id', 'order_id')
            ->withPivot(['product_name', 'quantity', 'price', 'total', 'license_key'])
            ->withTimestamps();
    }

    public function reviews() { return $this->hasMany(\App\Domains\Marketplace\Models\ProductReview::class, 'product_id'); }
    public function licenses() { return $this->hasMany(License::class, 'product_id'); }
    public function downloads() { return $this->hasMany(Download::class, 'product_id'); }
}
