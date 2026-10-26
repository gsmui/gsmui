<?php

declare(strict_types=1);

namespace App\Domains\Blog\Actions;

use App\Domains\Blog\Models\Comment;
use App\Domains\Blog\Models\Post;
use App\Domains\Users\Models\User;
use App\Domains\Services\NotificationService;

class CommentOnPostAction
{
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function execute(User $user, Post $post, array $data): Comment
    {
        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'body' => $data['body'],
            'parent_id' => $data['parent_id'] ?? null,
        ]);

        if ($post->author_id !== $user->id) {
            $this->notificationService->send(
                $post->author,
                'comment_on_post',
                'New Comment on Your Post',
                "{$user->name} commented on your post \"{$post->title}\".",
                ['post_id' => $post->id, 'comment_id' => $comment->id],
                "/blog/{$post->slug}#comment-{$comment->id}"
            );
        }

        return $comment;
    }
}
