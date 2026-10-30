<?php

declare(strict_types=1);

namespace App\Domains\Components\Actions;

use App\Domains\Components\Models\Component;
use App\Domains\Components\Models\ComponentReview;
use App\Domains\Users\Models\User;
use App\Domains\Services\NotificationService;

class ReviewComponentAction
{
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function execute(User $user, Component $component, array $data): ComponentReview
    {
        $existingReview = ComponentReview::where('user_id', $user->id)
            ->where('component_id', $component->id)
            ->first();

        if ($existingReview) {
            $existingReview->update([
                'rating' => $data['rating'],
                'title' => $data['title'] ?? null,
                'body' => $data['body'] ?? null,
            ]);

            $this->updateComponentRating($component);

            return $existingReview;
        }

        $review = ComponentReview::create([
            'user_id' => $user->id,
            'component_id' => $component->id,
            'rating' => $data['rating'],
            'title' => $data['title'] ?? null,
            'body' => $data['body'] ?? null,
        ]);

        $this->updateComponentRating($component);

        if ($component->user_id !== $user->id) {
            $this->notificationService->send(
                $component->user,
                'component_review',
                'New Review on Your Component',
                "{$user->name} left a {$data['rating']}-star review on \"{$component->name}\".",
                ['component_id' => $component->id, 'review_id' => $review->id],
                "/components/{$component->slug}#review-{$review->id}"
            );
        }

        return $review;
    }

    protected function updateComponentRating(Component $component): void
    {
        $stats = ComponentReview::where('component_id', $component->id)
            ->selectRaw('AVG(rating) as average_rating, COUNT(*) as reviews_count')
            ->first();

        $component->update([
            'average_rating' => round($stats->average_rating, 2),
            'reviews_count' => $stats->reviews_count,
        ]);
    }
}
