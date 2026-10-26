<?php

declare(strict_types=1);

namespace App\Domains\Themes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThemeDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'theme_id', 'user_id', 'ip_address', 'user_agent',
    ];

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
