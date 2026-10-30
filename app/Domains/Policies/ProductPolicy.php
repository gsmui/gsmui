<?php

declare(strict_types=1);

namespace App\Domains\Policies;

use App\Domains\Marketplace\Models\Product;
use App\Domains\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Product $product): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create-products');
    }

    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->author_id || $user->hasPermissionTo('edit-products');
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->author_id || $user->hasPermissionTo('delete-products');
    }
}
