<?php

declare(strict_types=1);

namespace App\Domains\Notifications\Jobs;

use App\Domains\Users\Models\User;
use App\Infrastructure\Mail\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly string $subject,
        public readonly string $body
    ) {}

    public function handle(EmailService $emailService): void
    {
        $emailService->sendNotification($this->user, $this->subject, $this->body);
    }
}
