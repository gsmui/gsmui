<?php

declare(strict_types=1);

namespace App\Domains\Themes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThemeVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'theme_id', 'name', 'slug', 'tokens', 'is_dark',
    ];

    protected $casts = [
        'tokens' => 'array',
        'is_dark' => 'boolean',
    ];

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }
}
