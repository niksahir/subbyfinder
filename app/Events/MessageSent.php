<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;

        Log::info('MessageSent event triggered', [
            'message' => $this->message,
        ]);
    }

    public function broadcastOn()
    {
        // Log the channel name for debugging
        Log::info('Broadcasting on channel', [
            'channel' => 'chat.' . $this->message->to_user_id . '.' . $this->message->receiver_type,
        ]);
        return new Channel('chat.' . $this->message->to_user_id . '.' . $this->message->receiver_type);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message
        ];
    }

    public function broadcastAs()
    {
        return 'MessageSent'; // JS will listen on this
    }
}
