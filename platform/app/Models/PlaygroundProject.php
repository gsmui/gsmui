<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaygroundProject extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'playground_projects';

    protected $fillable = [
        'user_id', 'name', 'slug', 'description', 'files',
        'visibility', 'forked_from_id', 'forks_count', 'views_count',
    ];

    protected function casts(): array
    {
        return [
            'files' => 'array',
            'forks_count' => 'integer',
            'views_count' => 'integer',
        ];
    }

    public function getRouteKeyName(): string { return 'slug'; }
    public function user() { return $this->belongsTo(User::class); }
    public function forkedFrom() { return $this->belongsTo(PlaygroundProject::class, 'forked_from_id'); }
}
