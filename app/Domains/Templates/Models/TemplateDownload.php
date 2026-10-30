<?php

declare(strict_types=1);

namespace App\Domains\Templates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplateDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id', 'user_id', 'ip_address', 'user_agent',
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
