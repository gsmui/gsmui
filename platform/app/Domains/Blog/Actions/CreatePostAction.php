<?php

declare(strict_types=1);

namespace App\Domains\Blog\Actions;

use App\Domains\Services\BlogService;
use App\Domains\Services\NotificationService;
use App\Domains\Blog\Models\Post;
use App\Domains\Users\Models\User;

class CreatePostAction
{
    public function __construct(
        protected BlogService $blogService,
        protected NotificationService $notificationService
    ) {}

    public function execute(array $data, User $author): Post
    {
        $data['author_id'] = $author->id;

        $post = $this->blogService->createPost($data);

        $this->notificationService->send(
            $author,
            'post_created',
            'Post Created',
            "Your post \"{$post->title}\" has been created.",
            ['post_id' => $post->id],
            "/blog/{$post->slug}"
        );

        return $post;
    }
}
