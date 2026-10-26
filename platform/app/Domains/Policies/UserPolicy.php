<?php

declare(strict_types=1);

namespace App\Domains\Policies;

use App\Domains\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->hasPermissionTo('view-users');
    }

    public function update(User $user, User $model): bool
    {
        return $user->id === $model->id || $user->hasPermissionTo('edit-users');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->hasPermissionTo('delete-users');
    }

    public function manageRoles(User $user): bool
    {
        return $user->hasPermissionTo('manage-roles');
    }
}
