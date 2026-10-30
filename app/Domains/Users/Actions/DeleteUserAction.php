<?php

declare(strict_types=1);

namespace App\Domains\Users\Actions;

use App\Domains\Users\Models\User;
use App\Infrastructure\Cache\CacheService;
use Illuminate\Support\Facades\DB;

class DeleteUserAction
{
    public function __construct(
        protected CacheService $cache
    ) {}

    public function execute(User $user, ?string $password = null): bool
    {
        if ($password && !\Hash::check($password, $user->password)) {
            throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedException(
                'Incorrect password.'
            );
        }

        DB::transaction(function () use ($user) {
            $user->comments()->delete();
            $user->reviews()->delete();
            $user->favorites()->delete();
            $user->notifications()->delete();
            $user->apiKeys()->delete();

            if ($user->profile) {
                $user->profile()->delete();
            }

            $user->delete();
        });

        $this->cache->invalidate("user:{$user->id}");
        $this->cache->invalidate("user_settings:{$user->id}");

        \Auth::logout();

        return true;
    }
}
