<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PurchasePlan extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

     public $userName;
     public $planName;
     public $planType;
     public $planPrice;
     public $startDate;
     public $endDate;
    public $userType;

    public function __construct($userName,$planName,$planType,$planPrice,$startDate,$endDate, $userType)
    {
        $this->userName = $userName;
        $this->planName = $planName;
        $this->planType = $planType;
        $this->planPrice = $planPrice;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->userType = $userType;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subbyfinder (' . $this->planName . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.purchase_plan',
            with:[
                'userName' => $this->userName,
                'planName' => $this->planName,
                'planType' => $this->planType,
                'planPrice' => $this->planPrice,
                'startDate' => $this->startDate,
                'endDate' => $this->endDate,
                'userType' => $this->userType,
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
