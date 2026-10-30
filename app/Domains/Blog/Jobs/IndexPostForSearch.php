<?php

declare(strict_types=1);

namespace App\Domains\Blog\Jobs;

use App\Domains\Blog\Models\Post;
use App\Infrastructure\Search\SearchService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IndexPostForSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Post $post
    ) {}

    public function handle(SearchService $searchService): void
    {
        $searchService->index($this->post);
    }
}
