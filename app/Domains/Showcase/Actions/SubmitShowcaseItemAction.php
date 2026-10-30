<?php

declare(strict_types=1);

namespace App\Domains\Showcase\Actions;

use App\Domains\Showcase\Models\ShowcaseItem;
use App\Domains\Users\Models\User;
use App\Domains\Services\NotificationService;

class SubmitShowcaseItemAction
{
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function execute(User $user, array $data): ShowcaseItem
    {
        $item = ShowcaseItem::create([
            'user_id' => $user->id,
            'title' => $data['title'],
            'slug' => $data['slug'] ?? \Str::slug($data['title']),
            'description' => $data['description'] ?? null,
            'url' => $data['url'] ?? null,
            'screenshot' => $data['screenshot'] ?? null,
            'technologies' => $data['technologies'] ?? [],
            'status' => 'pending',
        ]);

        $this->notificationService->send(
            $user,
            'showcase_submitted',
            'Showcase Submission Received',
            "Your showcase item \"{$item->title}\" has been submitted for review.",
            ['showcase_item_id' => $item->id],
            '/dashboard/showcase'
        );

        return $item;
    }
}
