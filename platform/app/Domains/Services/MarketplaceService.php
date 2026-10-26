<?php

declare(strict_types=1);

namespace App\Domains\Services;

use App\Domains\Marketplace\Models\Product;
use App\Domains\Marketplace\Models\Order;
use App\Domains\Users\Models\User;
use App\Shared\ValueObjects\Money;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class MarketplaceService
{
    public function __construct(
        protected \App\Domains\Marketplace\Contracts\ProductRepositoryInterface $repository,
        protected \App\Infrastructure\Payments\StripeService $stripe
    ) {}

    public function createProduct(array $data): Product
    {
        return $this->repository->create($data);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        return $this->repository->update($product, $data);
    }

    public function deleteProduct(Product $product): bool
    {
        return $this->repository->delete($product);
    }

    public function getProduct(string $slug): ?Product
    {
        return $this->repository->findBySlug($slug);
    }

    public function listProducts(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->list($filters, $perPage);
    }

    public function purchaseProduct(User $user, Product $product): array
    {
        $amount = Money::fromDecimal($product->price);

        $paymentResult = $this->stripe->createPaymentIntent(
            $user,
            $amount,
            "Purchase: {$product->name}"
        );

        $order = Order::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'amount' => $product->price,
            'currency' => 'USD',
            'status' => 'pending',
            'payment_id' => $paymentResult['payment_intent_id'],
        ]);

        return [
            'order' => $order,
            'client_secret' => $paymentResult['client_secret'],
        ];
    }

    public function completeOrder(Order $order): void
    {
        $order->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        $order->product->increment('downloads_count');
    }

    public function search(string $query): LengthAwarePaginator
    {
        return $this->repository->search($query);
    }
}
