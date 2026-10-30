<?php

declare(strict_types=1);

namespace App\Domains\Policies;

use App\Domains\Blog\Models\Post;
use App\Domains\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Post $post): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-posts');
    }

    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->author_id || $user->hasPermissionTo('edit-posts');
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->author_id || $user->hasPermissionTo('delete-posts');
    }

    public function publish(User $user, Post $post): bool
    {
        return $user->id === $post->author_id || $user->hasPermissionTo('publish-posts');
    }
}
