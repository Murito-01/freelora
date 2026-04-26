<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceMail extends Mailable {
    public $invoice;

    public function __construct(Invoice $invoice) {
        $this->invoice = $invoice;
    }

    public function build() {
        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $this->invoice
        ]);

        return $this->subject('Your Invoice ' . $this->invoice->number)
            ->view('emails.invoice')
            ->attachData(
                $pdf->output(),
                $this->invoice->number . '.pdf'
            );
    }
}
