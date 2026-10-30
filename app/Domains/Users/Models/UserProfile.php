<?php

declare(strict_types=1);

namespace App\Domains\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'location', 'company', 'position', 'bio_html',
        'social_links', 'preferences', 'theme', 'language', 'timezone',
    ];

    protected $casts = [
        'social_links' => 'array',
        'preferences' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
