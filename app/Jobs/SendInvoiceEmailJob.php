<?php

namespace App\Jobs;

use App\Models\Order;
use App\Mail\InvoiceMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class SendInvoiceEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;
    public $sendPdf;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order, bool $sendPdf = true)
    {
        $this->order = $order;
        $this->sendPdf = $sendPdf;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $customerEmail = $this->order->customer->user->email ?? null;
        
        if (!$customerEmail) {
            return;
        }

        Mail::to($customerEmail)->send(
            new InvoiceMail($this->order, $this->sendPdf)
        );
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Failed to send invoice email', [
            'order_id' => $this->order->id,
            'error' => $exception->getMessage()
        ]);
    }
}