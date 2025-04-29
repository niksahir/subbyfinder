<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{

    public function send(Request $request)
    {
        try {
            $sender = auth('contractor')->user() ?? auth('subcontractor')->user();
            $senderType = auth('contractor')->check() ? 'contractor' : 'subcontractor';

            $message = Message::create([
                'from_user_id' => $sender->id,
                'sender_type' => $senderType,
                'to_user_id' => $request->to_user_id,
                'receiver_type' => $request->receiver_type,
                'body' => $request->message,
            ]);

            // Log to verify that the event is being triggered
            Log::info('MessageSent event is being triggered.', [
                'from_user_id' => $sender->id,
                'to_user_id' => $request->to_user_id,
                'message_body' => $message->body
            ]);

            // Trigger the event
            broadcast(new MessageSent($message));

            return response()->json(['message' => $message]);
        } catch (\Throwable $th) {
            Log::error('Error sending message', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);

            return response()->json(['error' => 'Failed to send message'], 500);
        }
    }
}
