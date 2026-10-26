<?php

declare(strict_types=1);

namespace App\Domains\Policies;

use App\Domains\Templates\Models\Template;
use App\Domains\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TemplatePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Template $template): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-templates');
    }

    public function update(User $user, Template $template): bool
    {
        return $user->id === $template->author_id || $user->hasPermissionTo('edit-templates');
    }

    public function delete(User $user, Template $template): bool
    {
        return $user->id === $template->author_id || $user->hasPermissionTo('delete-templates');
    }

    public function download(User $user, Template $template): bool
    {
        if ($template->is_free) {
            return true;
        }

        return $user->isPro();
    }
}
