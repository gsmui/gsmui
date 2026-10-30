<?php

declare(strict_types=1);

namespace App\Domains\Marketplace\Actions;

use App\Domains\Marketplace\Models\Product;
use App\Domains\Marketplace\Models\ProductReview;
use App\Domains\Users\Models\User;
use App\Domains\Services\NotificationService;

class ReviewProductAction
{
    public function __construct(
        protected NotificationService $notificationService
    ) {}

    public function execute(User $user, Product $product, array $data): ProductReview
    {
        $existingReview = ProductReview::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            $existingReview->update([
                'rating' => $data['rating'],
                'title' => $data['title'] ?? null,
                'body' => $data['body'] ?? null,
            ]);

            $this->updateProductRating($product);

            return $existingReview;
        }

        $review = ProductReview::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => $data['rating'],
            'title' => $data['title'] ?? null,
            'body' => $data['body'] ?? null,
        ]);

        $this->updateProductRating($product);

        if ($product->user_id !== $user->id) {
            $this->notificationService->send(
                $product->user,
                'product_review',
                'New Review on Your Product',
                "{$user->name} left a {$data['rating']}-star review on \"{$product->name}\".",
                ['product_id' => $product->id, 'review_id' => $review->id],
                "/marketplace/{$product->slug}#review-{$review->id}"
            );
        }

        return $review;
    }

    protected function updateProductRating(Product $product): void
    {
        $stats = ProductReview::where('product_id', $product->id)
            ->selectRaw('AVG(rating) as average_rating, COUNT(*) as reviews_count')
            ->first();

        $product->update([
            'average_rating' => round($stats->average_rating, 2),
            'reviews_count' => $stats->reviews_count,
        ]);
    }
}
