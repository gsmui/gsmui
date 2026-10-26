<?php

declare(strict_types=1);

namespace App\Domains\Policies;

use App\Domains\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    public function accessDashboard(User $user): bool
    {
        return $user->isAdmin();
    }

    public function manageComponents(User $user): bool
    {
        return $user->isAdmin();
    }

    public function manageThemes(User $user): bool
    {
        return $user->isAdmin();
    }

    public function manageTemplates(User $user): bool
    {
        return $user->isAdmin();
    }

    public function manageUsers(User $user): bool
    {
        return $user->isAdmin();
    }

    public function manageSettings(User $user): bool
    {
        return $user->isAdmin();
    }

    public function viewAnalytics(User $user): bool
    {
        return $user->isAdmin();
    }

    public function viewReports(User $user): bool
    {
        return $user->isAdmin();
    }
}
