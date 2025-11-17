<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $sendPdf;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, bool $sendPdf = true)
    {
        $this->order = $order;
        $this->sendPdf = $sendPdf;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice #' . $this->order->code . ' - ' . setting('site_name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice',
            with: [
                'order' => $this->order,
                'invoiceUrl' => route('orders.public-invoice', $this->order->code),
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
        if (!$this->sendPdf) {
            return [];
        }

        $pdf = Pdf::loadView('admin.orders.invoice-pdf', ['order' => $this->order]);
        
        return [
            Attachment::fromData(fn () => $pdf->output(), 'invoice-' . $this->order->code . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}