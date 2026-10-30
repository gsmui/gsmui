<?php

declare(strict_types=1);

namespace App\Domains\Policies;

use App\Domains\Documentation\Models\Document;
use App\Domains\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Document $document): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-documents');
    }

    public function update(User $user, Document $document): bool
    {
        return $user->id === $document->author_id || $user->hasPermissionTo('edit-documents');
    }

    public function delete(User $user, Document $document): bool
    {
        return $user->id === $document->author_id || $user->hasPermissionTo('delete-documents');
    }

    public function publish(User $user, Document $document): bool
    {
        return $user->id === $document->author_id || $user->hasPermissionTo('publish-documents');
    }
}
