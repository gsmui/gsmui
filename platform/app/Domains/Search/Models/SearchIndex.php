<?php

declare(strict_types=1);

namespace App\Domains\Search\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchIndex extends Model
{
    use HasFactory;

    protected $fillable = [
        'searchable_type', 'searchable_id', 'title', 'body',
        'keywords', 'rank', 'is_active',
    ];

    protected $casts = [
        'rank' => 'float',
        'is_active' => 'boolean',
    ];

    public function searchable()
    {
        return $this->morphTo();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
