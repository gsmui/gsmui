<?php

declare(strict_types=1);

namespace App\Domains\Components\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class ComponentCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'icon', 'sort_order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function components(): MorphToMany
    {
        return $this->morphedByMany(Component::class, 'categorizable');
    }
}
