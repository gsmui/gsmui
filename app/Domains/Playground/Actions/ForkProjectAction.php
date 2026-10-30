<?php

declare(strict_types=1);

namespace App\Domains\Playground\Actions;

use App\Domains\Playground\Models\Project;
use App\Domains\Users\Models\User;
use App\Domains\Services\NotificationService;

class ForkProjectAction
{
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function execute(User $user, Project $originalProject): Project
    {
        $forkedProject = Project::create([
            'user_id' => $user->id,
            'name' => "{$originalProject->name} (Fork)",
            'slug' => \Str::slug("{$originalProject->name}-fork-" . time()),
            'description' => $originalProject->description,
            'framework' => $originalProject->framework,
            'files' => $originalProject->files,
            'settings' => $originalProject->settings,
            'forked_from_id' => $originalProject->id,
        ]);

        $originalProject->increment('forks_count');

        if ($originalProject->user_id !== $user->id) {
            $this->notificationService->send(
                $originalProject->user,
                'project_forked',
                'Project Forked',
                "{$user->name} forked your project \"{$originalProject->name}\".",
                ['project_id' => $originalProject->id, 'forked_project_id' => $forkedProject->id],
                "/playground/{$forkedProject->slug}"
            );
        }

        return $forkedProject;
    }
}
