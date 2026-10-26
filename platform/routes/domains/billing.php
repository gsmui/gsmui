<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Billing\BillingIndex;
use App\Http\Livewire\Billing\SubscriptionCreate;
use App\Http\Livewire\Billing\SubscriptionCancel;
use App\Http\Livewire\Billing\InvoiceIndex;
use App\Http\Livewire\Billing\PaymentMethod;

// Billing routes
Route::middleware('auth')->group(function () {
    Route::get('/billing', BillingIndex::class)->name('billing.index');
    Route::get('/billing/subscribe', SubscriptionCreate::class)->name('billing.subscribe');
    Route::post('/billing/subscribe', [App\Http\Controllers\BillingController::class, 'subscribe'])->name('billing.subscribe.store');
    Route::post('/billing/cancel', SubscriptionCancel::class)->name('billing.cancel');
    Route::get('/billing/invoices', InvoiceIndex::class)->name('billing.invoices');
    Route::get('/billing/payment-method', PaymentMethod::class)->name('billing.payment-method');
});

// Webhook routes
Route::post('/webhook/stripe', [App\Http\Controllers\BillingController::class, 'webhook'])->name('webhook.stripe');
