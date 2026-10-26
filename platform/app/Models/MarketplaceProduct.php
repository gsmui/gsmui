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
    public function author() { return $this->belongsTo(User::class, 'user_id'); }
    public function orders() { return $this->hasMany(Order::class); }
    public function reviews() { return $this->hasMany(ProductReview::class); }
    public function licenses() { return $this->hasMany(License::class); }
    public function downloads() { return $this->hasMany(Download::class); }
}
