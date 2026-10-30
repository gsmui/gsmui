<?php

declare(strict_types=1);

namespace App\Infrastructure\Mail;

use App\Domains\Users\Models\User;
use App\Domains\Billing\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly User $user,
        public readonly Invoice $invoice
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Invoice',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
