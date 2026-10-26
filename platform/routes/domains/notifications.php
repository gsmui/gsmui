<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Notifications\NotificationsIndex;

// Notification routes
Route::middleware('auth')->group(function () {
    Route::get('/notifications', NotificationsIndex::class)->name('notifications.index');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
});
