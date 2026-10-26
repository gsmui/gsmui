<?php

declare(strict_types=1);

namespace App\Domains\CMS\Actions;

use App\Domains\CMS\Models\Page;
use App\Infrastructure\Cache\CacheService;
use App\Infrastructure\Search\SearchService;

class CreatePageAction
{
    public function __construct(
        protected CacheService $cache,
        protected SearchService $searchService
    ) {}

    public function execute(array $data): Page
    {
        $page = Page::create([
            'title' => $data['title'],
            'slug' => $data['slug'] ?? \Str::slug($data['title']),
            'content' => $data['content'] ?? '',
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'is_published' => $data['is_published'] ?? false,
            'published_at' => ($data['is_published'] ?? false) ? now() : null,
        ]);

        $this->cache->invalidate('pages');
        $this->searchService->index($page);

        return $page;
    }
}
