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

    public function sendImage(Request $request)
    {
        $sender = auth('contractor')->user() ?? auth('subcontractor')->user();
        $senderType = auth('contractor')->check() ? 'contractor' : 'subcontractor';
        $request->validate([
            'image' => 'required|image|max:2048', // max 2MB
            'to_user_id' => 'required|integer',
            'receiver_type' => 'required|string'
        ]);
        
        $path = $request->file('image')->store('chat-images', 'public');

        $message = Message::create([
            'from_user_id' => $sender->id,
            'to_user_id' => $request->to_user_id,
            'receiver_type' => $request->receiver_type,
            'sender_type' => $senderType,
            'body' => null,
            'image' => $path,
        ]);

        // You may broadcast it here if needed
        return response()->json(['message' => $message]);
    }

    public function getMessages(Request $request)
    {
        $userId = auth('contractor')->id();
        $receiverId = $request->receiver_id;
        $receiverType = $request->receiver_type;

        $messages = Message::where(function ($q) use ($userId, $receiverId, $receiverType) {
            $q->where('from_user_id', $userId)
                ->where('to_user_id', $receiverId)
                ->where('receiver_type', $receiverType);
        })->orWhere(function ($q) use ($userId, $receiverId, $receiverType) {
            $q->where('from_user_id', $receiverId)
                ->where('to_user_id', $userId)
                ->where('receiver_type', 'contractor');
        })->orderBy('created_at')->get();

        return response()->json(['messages' => $messages]);
    }
}
