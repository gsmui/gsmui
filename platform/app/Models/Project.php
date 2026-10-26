<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'slug', 'description', 'is_public',
        'settings', 'components_used', 'theme_id',
    ];

    protected function casts(): array
    {
        return ['is_public' => 'boolean', 'settings' => 'array', 'components_used' => 'array'];
    }

    public function user() { return $this->belongsTo(User::class); }
    public function theme() { return $this->belongsTo(Theme::class); }
}
