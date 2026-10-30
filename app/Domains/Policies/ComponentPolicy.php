<?php

declare(strict_types=1);

namespace App\Domains\Policies;

use App\Domains\Components\Models\Component;
use App\Domains\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComponentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Component $component): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-components');
    }

    public function update(User $user, Component $component): bool
    {
        return $user->id === $component->author_id || $user->hasPermissionTo('edit-components');
    }

    public function delete(User $user, Component $component): bool
    {
        return $user->id === $component->author_id || $user->hasPermissionTo('delete-components');
    }

    public function publish(User $user, Component $component): bool
    {
        return $user->id === $component->author_id || $user->hasPermissionTo('publish-components');
    }

    public function deprecate(User $user, Component $component): bool
    {
        return $user->id === $component->author_id || $user->hasPermissionTo('deprecate-components');
    }

    public function download(User $user, Component $component): bool
    {
        if ($component->is_free) {
            return true;
        }

        return $user->isPro();
    }
}
