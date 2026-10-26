<?php

declare(strict_types=1);

namespace App\Domains\Charts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChartFavorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'chart_id', 'user_id',
    ];

    public function chart(): BelongsTo
    {
        return $this->belongsTo(Chart::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
