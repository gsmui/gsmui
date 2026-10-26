<?php

declare(strict_types=1);

namespace App\Domains\Services;

use App\Domains\Users\Models\User;
use App\Domains\Users\Models\UserProfile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(
        protected \App\Domains\Users\Contracts\UserRepositoryInterface $repository
    ) {}

    public function create(array $data): User
    {
        return $this->repository->create($data);
    }

    public function update(User $user, array $data): User
    {
        return $this->repository->update($user, $data);
    }

    public function getById(int $id): ?User
    {
        return $this->repository->findById($id);
    }

    public function getByUsername(string $username): ?User
    {
        return $this->repository->findByUsername($username);
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->list($filters, $perPage);
    }

    public function getProfile(User $user): ?UserProfile
    {
        return $user->profile;
    }

    public function updateProfile(User $user, array $data): UserProfile
    {
        return $user->profile()->updateOrCreate(['user_id' => $user->id], $data);
    }

    public function addFavorite(User $user, $componentId): void
    {
        $user->favorites()->attach($componentId);
    }

    public function removeFavorite(User $user, $componentId): void
    {
        $user->favorites()->detach($componentId);
    }

    public function getFavorites(User $user)
    {
        return $user->favorites;
    }

    public function isAdmin(User $user): bool
    {
        return $user->isAdmin();
    }

    public function isPro(User $user): bool
    {
        return $user->isPro();
    }

    public function search(string $query): LengthAwarePaginator
    {
        return $this->repository->search($query);
    }
}
