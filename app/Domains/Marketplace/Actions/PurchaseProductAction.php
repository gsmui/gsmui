<?php

declare(strict_types=1);

namespace App\Domains\Marketplace\Actions;

use App\Domains\Services\MarketplaceService;
use App\Domains\Services\NotificationService;
use App\Domains\Marketplace\Models\Product;
use App\Domains\Users\Models\User;

class PurchaseProductAction
{
    public function __construct(
        protected MarketplaceService $marketplaceService,
        protected NotificationService $notificationService
    ) {}

    public function execute(User $user, Product $product): array
    {
        $result = $this->marketplaceService->purchaseProduct($user, $product);

        $this->notificationService->send(
            $user,
            'purchase_initiated',
            'Purchase Initiated',
            "Your purchase of \"{$product->name}\" has been initiated.",
            ['product_id' => $product->id, 'order_id' => $result['order']->id],
            '/dashboard/orders'
        );

        return $result;
    }
}
