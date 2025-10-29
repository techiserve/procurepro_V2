<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendSampleEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $req;  // Public variable to pass data to the view

    /**
     * Create a new message instance.
     */
    public function __construct($req)
    {
        $this->req = $req; // Assign the passed data
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Zarq Requisition Update',
            // from: ['itaivincent321@gmail.com' => 'ProcurePro'] // Optional: Set a custom 'From' address
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    { 

       return new Content(
            view: 'procurement.email',  // The blade template for the email
            with: ['req' => $this->req]  // Pass data to the view
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
