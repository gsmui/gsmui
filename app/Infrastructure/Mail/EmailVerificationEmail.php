<?php

declare(strict_types=1);

namespace App\Infrastructure\Mail;

use App\Domains\Users\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User $user
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Email Address',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
