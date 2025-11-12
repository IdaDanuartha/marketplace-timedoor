<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VendorApprovedNotification extends Mailable
{
    use SerializesModels;

    public string $vendorName;

    /**
     * Create a new message instance.
     */
    public function __construct(string $vendorName)
    {
        $this->vendorName = $vendorName;
    }

    /**
     * Define the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Vendor Account Has Been Approved',
        );
    }

    /**
     * Define the email content.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.vendor-approved',
            with: [
                'vendorName' => $this->vendorName,
            ],
        );
    }

    /**
     * No attachments for this mail.
     */
    public function attachments(): array
    {
        return [];
    }
}