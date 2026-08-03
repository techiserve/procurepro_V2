<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequisitionLifecycleEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $title;
    public string $message;
    public string $requisitionNumber;
    public ?string $reason;

    public function __construct(string $title, string $message, string $requisitionNumber, ?string $reason = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->requisitionNumber = $requisitionNumber;
        $this->reason = $reason;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->title
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'procurement.requisition-lifecycle-email',
            with: [
                'title' => $this->title,
                'message' => $this->message,
                'requisitionNumber' => $this->requisitionNumber,
                'reason' => $this->reason,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
