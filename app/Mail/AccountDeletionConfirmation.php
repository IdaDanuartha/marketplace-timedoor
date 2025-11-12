<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountDeletionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public string $username;
    public string $confirmationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(string $username, string $confirmationUrl)
    {
        $this->username = $username;
        $this->confirmationUrl = $confirmationUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirm Your Account Deletion Request',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.account-deletion-confirmation',
            with: [
                'username' => $this->username,
                'url' => $this->confirmationUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}