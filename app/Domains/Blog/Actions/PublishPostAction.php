<?php

declare(strict_types=1);

namespace App\Domains\Blog\Actions;

use App\Domains\Services\BlogService;
use App\Domains\Blog\Models\Post;
use App\Infrastructure\Search\SearchService;

class PublishPostAction
{
    public function __construct(
        protected BlogService $blogService,
        protected SearchService $searchService
    ) {}

    public function execute(Post $post): Post
    {
        $published = $this->blogService->publishPost($post);

        $this->searchService->index($published);

        return $published;
    }
}
