<?php

namespace App\Notifications;

// app/Notifications/ReceivedReviewNotification.php

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ReceivedReviewNotification extends Notification
{
    public $review;
    public $reviewer;

    public function __construct($review, $reviewer)
{
    $this->review = $review;
    $this->reviewer = $reviewer;
}

    public function via($notifiable)
    {
        return ['database']; // or add 'mail' if needed
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'You received a new review from ' . $this->reviewer->contact_name,
            'review_id' => $this->review->id,
            'reviewer' => $this->reviewer,
            'review'=> $this->review,
            'image' => $this->reviewer->profile_photo,
        ];
    }
}
