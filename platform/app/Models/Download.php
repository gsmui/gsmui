<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'product_id', 'file_path', 'file_name',
        'file_size', 'downloads_count', 'last_downloaded_at', 'created_at',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
            'downloads_count' => 'integer',
            'last_downloaded_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function user() { return $this->belongsTo(User::class); }
    public function product() { return $this->belongsTo(MarketplaceProduct::class, 'product_id'); }
}
