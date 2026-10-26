<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'company', 'location', 'timezone', 'language',
        'theme_preference', 'notification_preferences', 'social_links',
    ];

    protected function casts(): array
    {
        return ['notification_preferences' => 'array', 'social_links' => 'array'];
    }

    public function user() { return $this->belongsTo(User::class); }
}
