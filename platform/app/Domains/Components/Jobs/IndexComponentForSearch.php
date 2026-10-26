<?php

declare(strict_types=1);

namespace App\Domains\Components\Jobs;

use App\Domains\Components\Models\Component;
use App\Infrastructure\Search\SearchService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IndexComponentForSearch implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Component $component
    ) {}

    public function handle(SearchService $searchService): void
    {
        $searchService->index($this->component);
    }
}
