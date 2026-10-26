<?php

declare(strict_types=1);

namespace App\Domains\Blog\Actions;

use App\Domains\Blog\Models\Post;
use App\Domains\Blog\Models\PostLike;
use App\Domains\Users\Models\User;
use App\Domains\Services\NotificationService;

class LikePostAction
{
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function execute(User $user, Post $post): bool
    {
        $existingLike = PostLike::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $post->decrement('likes_count');
            return false;
        }

        PostLike::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $post->increment('likes_count');

        if ($post->author_id !== $user->id) {
            $this->notificationService->send(
                $post->author,
                'post_liked',
                'Post Liked',
                "{$user->name} liked your post \"{$post->title}\".",
                ['post_id' => $post->id],
                "/blog/{$post->slug}"
            );
        }

        return true;
    }
}
