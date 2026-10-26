<?php

declare(strict_types=1);

namespace App\Domains\Components\Listeners;

use App\Domains\Components\Events\ComponentPublished;
use App\Infrastructure\Search\SearchService;

class IndexComponentForSearch
{
    public function __construct(
        protected SearchService $searchService
    ) {}

    public function handle(ComponentPublished $event): void
    {
        $this->searchService->index($event->component);
    }
}
