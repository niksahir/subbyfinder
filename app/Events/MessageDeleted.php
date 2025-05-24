<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class MessageDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $messageId;
    public $receiverId;
    public $receiverType;

    public function __construct($messageId, $receiverId, $receiverType)
    {
        $this->messageId = $messageId;
        $this->receiverId = $receiverId;
        $this->receiverType = $receiverType;
    }

    public function broadcastOn()
    {
        // Notify the receiver only on their private channel
        return new Channel('chat.' . $this->receiverId . '.' . $this->receiverType);
    }

    public function broadcastWith()
    {
        return [
            'messageId' => $this->messageId,
        ];
    }

    public function broadcastAs()
    {
        return 'MessageDeleted';
    }
}
