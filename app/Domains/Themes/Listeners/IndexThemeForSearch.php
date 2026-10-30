<?php

declare(strict_types=1);

namespace App\Domains\Themes\Listeners;

use App\Domains\Themes\Events\ThemePublished;
use App\Infrastructure\Search\SearchService;

class IndexThemeForSearch
{
    public function __construct(
        protected SearchService $searchService
    ) {}

    public function handle(ThemePublished $event): void
    {
        $this->searchService->index($event->theme);
    }
}
