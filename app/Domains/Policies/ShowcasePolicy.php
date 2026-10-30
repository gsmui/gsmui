<?php

declare(strict_types=1);

namespace App\Domains\Policies;

use App\Domains\Showcase\Models\ShowcaseItem;
use App\Domains\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShowcasePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ShowcaseItem $item): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ShowcaseItem $item): bool
    {
        return $user->id === $item->user_id;
    }

    public function delete(User $user, ShowcaseItem $item): bool
    {
        return $user->id === $item->user_id || $user->isAdmin();
    }
}
