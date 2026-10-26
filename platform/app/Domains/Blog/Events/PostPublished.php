<?php

declare(strict_types=1);

namespace App\Domains\Blog\Events;

use App\Domains\Blog\Models\Post;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostPublished
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Post $post
    ) {}
}
