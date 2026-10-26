<?php

declare(strict_types=1);

namespace App\Domains\Analytics\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'value', 'dimensions', 'recorded_at',
    ];

    protected $casts = [
        'dimensions' => 'array',
        'value' => 'float',
        'recorded_at' => 'datetime',
    ];

    public function scopeForName($query, string $name)
    {
        return $query->where('name', $name);
    }

    public function scopeForType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('recorded_at', $date);
    }
}
