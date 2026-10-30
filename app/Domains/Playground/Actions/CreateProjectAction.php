<?php

declare(strict_types=1);

namespace App\Domains\Playground\Actions;

use App\Domains\Playground\Models\Project;
use App\Domains\Users\Models\User;

class CreateProjectAction
{
    public function execute(User $user, array $data): Project
    {
        $project = Project::create([
            'user_id' => $user->id,
            'name' => $data['name'],
            'slug' => $data['slug'] ?? \Str::slug($data['name']),
            'description' => $data['description'] ?? null,
            'framework' => $data['framework'] ?? 'blade',
            'files' => $data['files'] ?? [],
            'settings' => $data['settings'] ?? [],
        ]);

        return $project;
    }
}
