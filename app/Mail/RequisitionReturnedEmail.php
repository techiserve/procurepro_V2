<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequisitionReturnedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $requisitionNumber;
    public ?string $returnReason;

    public function __construct(string $requisitionNumber, ?string $returnReason = null)
    {
        $this->requisitionNumber = $requisitionNumber;
        $this->returnReason = $returnReason;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Purchase Requisition Returned'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'procurement.requisition-returned-email',
            with: [
                'requisitionNumber' => $this->requisitionNumber,
                'returnReason' => $this->returnReason,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
