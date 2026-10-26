<?php

declare(strict_types=1);

namespace App\Domains\Policies;

use App\Domains\Themes\Models\Theme;
use App\Domains\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThemePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Theme $theme): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-themes');
    }

    public function update(User $user, Theme $theme): bool
    {
        return $user->id === $theme->author_id || $user->hasPermissionTo('edit-themes');
    }

    public function delete(User $user, Theme $theme): bool
    {
        return $user->id === $theme->author_id || $user->hasPermissionTo('delete-themes');
    }

    public function publish(User $user, Theme $theme): bool
    {
        return $user->id === $theme->author_id || $user->hasPermissionTo('publish-themes');
    }

    public function download(User $user, Theme $theme): bool
    {
        if ($theme->is_free) {
            return true;
        }

        return $user->isPro();
    }
}
