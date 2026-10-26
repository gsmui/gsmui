<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Infrastructure\Search\SearchService;
use Illuminate\Console\Command;

class SyncSearchIndex extends Command
{
    protected $signature = 'search:sync';
    protected $description = 'Rebuild the search index';

    public function handle(SearchService $searchService): int
    {
        $this->info('Clearing search index...');
        $searchService->clear();

        $this->info('Reindexing all content...');
        $searchService->reindexAll();

        $this->info('Search index rebuilt successfully!');

        return Command::SUCCESS;
    }
}
