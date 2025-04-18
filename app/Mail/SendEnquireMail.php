<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEnquireMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */


    public $name;
    public $email;
    public $phone;
    public $userMessage;
    public $url;
    public function __construct($name, $email, $phone, $userMessage, $url)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->userMessage = $userMessage;
        $this->url = $url;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Enquire Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.SendEnquire',  // Make sure you create this view
            with: [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'userMessage' => $this->userMessage,
                'url' => $this->url,
            ]
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
