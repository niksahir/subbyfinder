<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Log;

class SubscriptionExpiredNotification extends Notification
{
    use Queueable;

    public $subscription;
    public $user;

    public function __construct($subscription,$user)
    {
        $this->subscription = $subscription;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your subscription has expired.',
            'expired_at' => $this->subscription->ends_at,
            'subscription_id' => $this->subscription->id ?? null,
            'image' => $this->user->profile_photo,
        ];
    }
}

