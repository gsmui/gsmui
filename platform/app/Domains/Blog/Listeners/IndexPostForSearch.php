<?php

declare(strict_types=1);

namespace App\Domains\Blog\Listeners;

use App\Domains\Blog\Events\PostPublished;
use App\Infrastructure\Search\SearchService;

class IndexPostForSearch
{
    public function __construct(
        protected SearchService $searchService
    ) {}

    public function handle(PostPublished $event): void
    {
        $this->searchService->index($event->post);
    }
}
