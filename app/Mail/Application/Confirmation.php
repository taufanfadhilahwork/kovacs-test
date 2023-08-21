<?php

namespace App\Mail\Application;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Confirmation extends Mailable
{
    use Queueable, SerializesModels;
    private $name;
    private $applicationId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $applicationId)
    {
        $this->name = $name;
        $this->applicationId = $applicationId;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'STEP 1 OF 3 - KOVACS UWC STUDENT VILLAGE CONFIRMATION OF APPLICATION RECEIVED',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.applicant.confirmation',
            with: [
                'name' => $name,
                'application_number' => 'KOV '.$this->applicationId,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
