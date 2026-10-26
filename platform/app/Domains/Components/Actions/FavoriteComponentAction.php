<?php

declare(strict_types=1);

namespace App\Domains\Components\Actions;

use App\Domains\Components\Models\Component;
use App\Domains\Users\Models\User;

class FavoriteComponentAction
{
    public function execute(User $user, Component $component): bool
    {
        $isFavorited = $user->favorites()
            ->where('favoritable_type', Component::class)
            ->where('favoritable_id', $component->id)
            ->exists();

        if ($isFavorited) {
            $user->favorites()
                ->where('favoritable_type', Component::class)
                ->where('favoritable_id', $component->id)
                ->delete();

            $component->decrement('favorites_count');

            return false;
        }

        $user->favorites()->create([
            'favoritable_type' => Component::class,
            'favoritable_id' => $component->id,
        ]);

        $component->increment('favorites_count');

        return true;
    }
}
