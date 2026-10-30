<?php

declare(strict_types=1);

namespace App\Domains\Marketplace\Actions;

use App\Domains\Marketplace\Models\Product;
use App\Domains\Services\NotificationService;
use App\Infrastructure\Cache\CacheService;
use App\Infrastructure\Search\SearchService;

class ApproveProductAction
{
    public function __construct(
        protected NotificationService $notificationService,
        protected CacheService $cache,
        protected SearchService $searchService
    ) {}

    public function execute(Product $product, ?string $notes = null): Product
    {
        $product->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approval_notes' => $notes,
        ]);

        $this->cache->invalidate('marketplace');
        $this->searchService->index($product);

        $this->notificationService->send(
            $product->user,
            'product_approved',
            'Product Approved',
            "Your product \"{$product->name}\" has been approved and is now live on the marketplace.",
            ['product_id' => $product->id],
            "/marketplace/{$product->slug}"
        );

        return $product;
    }

    public function reject(Product $product, string $reason): Product
    {
        $product->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejection_reason' => $reason,
        ]);

        $this->notificationService->send(
            $product->user,
            'product_rejected',
            'Product Rejected',
            "Your product \"{$product->name}\" was not approved. Reason: {$reason}",
            ['product_id' => $product->id],
            '/dashboard/products'
        );

        return $product;
    }
}
