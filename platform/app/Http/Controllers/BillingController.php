<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Infrastructure\Payments\StripeService;

class BillingController extends Controller
{
    public function __construct(
        protected StripeService $stripe
    ) {}

    public function subscribe(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'plan' => 'required|string|in:free,pro,team,enterprise',
        ]);

        $user = $request->user();
        $result = $this->stripe->createSubscription($user, $validated['plan']);

        return response()->json([
            'client_secret' => $result['client_secret'],
        ]);
    }

    public function webhook(Request $request): JsonResponse
    {
        $payload = $request->all();
        $this->stripe->handleWebhook($payload);

        return response()->json(['status' => 'success']);
    }
}
