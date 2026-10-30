<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Billing\BillingIndex;
use App\Http\Livewire\Billing\SubscriptionCreate;
use App\Http\Livewire\Billing\SubscriptionCancel;
use App\Http\Livewire\Billing\InvoiceIndex;
use App\Http\Livewire\Billing\PaymentMethod;

// Billing routes
Route::middleware('auth')->group(function () {
// Route::get('/billing', BillingIndex::class)->name('billing.index');  // TODO: App\Http\Livewire\Billing\BillingIndex does not exist yet
// Route::get('/billing/subscribe', SubscriptionCreate::class)->name('billing.subscribe');  // TODO: App\Http\Livewire\Billing\SubscriptionCreate does not exist yet
    Route::post('/billing/subscribe', [App\Http\Controllers\BillingController::class, 'subscribe'])->name('billing.subscribe.store');
// Route::post('/billing/cancel', SubscriptionCancel::class)->name('billing.cancel');  // TODO: App\Http\Livewire\Billing\SubscriptionCancel does not exist yet
// Route::get('/billing/invoices', InvoiceIndex::class)->name('billing.invoices');  // TODO: App\Http\Livewire\Billing\InvoiceIndex does not exist yet
// Route::get('/billing/payment-method', PaymentMethod::class)->name('billing.payment-method');  // TODO: App\Http\Livewire\Billing\PaymentMethod does not exist yet
});

// Webhook routes
Route::post('/webhook/stripe', [App\Http\Controllers\BillingController::class, 'webhook'])->name('webhook.stripe');
