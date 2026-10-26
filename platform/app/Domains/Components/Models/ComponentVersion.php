<?php

declare(strict_types=1);

namespace App\Domains\Components\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComponentVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'component_id', 'version', 'changelog', 'is_breaking',
        'min_php_version', 'min_laravel_version', 'min_livewire_version',
    ];

    protected $casts = [
        'changelog' => 'array',
        'is_breaking' => 'boolean',
    ];

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }
}
