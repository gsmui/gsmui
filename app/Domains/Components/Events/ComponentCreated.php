<?php

declare(strict_types=1);

namespace App\Domains\Components\Events;

use App\Domains\Components\Models\Component;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ComponentCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Component $component
    ) {}
}
