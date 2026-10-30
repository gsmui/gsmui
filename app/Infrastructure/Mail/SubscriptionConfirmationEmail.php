<?php

declare(strict_types=1);

namespace App\Infrastructure\Mail;

use App\Domains\Users\Models\User;
use App\Domains\Billing\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly Subscription $subscription
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscription Confirmed',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription-confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
