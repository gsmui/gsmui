<?php

declare(strict_types=1);

namespace App\Domains\Repositories;

use App\Domains\Users\Contracts\UserRepositoryInterface;
use App\Domains\Users\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected User $model
    ) {
        $this->model = new User();
    }

    public function findById(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function findByUsername(string $username): ?User
    {
        return $this->model->where('username', $username)->first();
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user->fresh();
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                  ->orWhere('email', 'like', "%{$filters['search']}%")
                  ->orWhere('username', 'like', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['role'])) {
            $query->role($filters['role']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function search(string $query): LengthAwarePaginator
    {
        return $this->model->where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('email', 'like', "%{$query}%")
              ->orWhere('username', 'like', "%{$query}%");
        })->paginate(15);
    }
}
