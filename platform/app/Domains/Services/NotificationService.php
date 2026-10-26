<?php

declare(strict_types=1);

namespace App\Domains\Services;

use App\Domains\Users\Models\User;
use App\Domains\Notifications\Models\UserNotification;
use App\Infrastructure\Mail\EmailService;

class NotificationService
{
    public function __construct(
        protected EmailService $emailService
    ) {}

    public function send(User $user, string $type, string $title, string $body, array $data = [], ?string $actionUrl = null): UserNotification
    {
        $notification = UserNotification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'body' => $body,
            'data' => $data,
            'action_url' => $actionUrl,
        ]);

        if ($user->notifications_enabled ?? true) {
            $this->emailService->sendNotification($user, $title, $body);
        }

        return $notification;
    }

    public function getUnread(User $user)
    {
        return $user->notifications()->unread()->get();
    }

    public function getUnreadCount(User $user): int
    {
        return $user->notifications()->unread()->count();
    }

    public function markAsRead(UserNotification $notification): void
    {
        $notification->markAsRead();
    }

    public function markAllAsRead(User $user): void
    {
        $user->notifications()->unread()->update(['read_at' => now()]);
    }

    public function delete(UserNotification $notification): void
    {
        $notification->delete();
    }
}
