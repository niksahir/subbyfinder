<?php

namespace App\Http\Controllers;

use App\Events\MessageDeleted;
use App\Events\MessageSent;
use App\Models\Contractor;
use App\Models\Message;
use App\Models\SubContractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{

    public function send(Request $request)
    {
        try {
            $sender = auth('contractor')->user() ?? auth('subcontractor')->user();
            $senderType = auth('contractor')->check() ? 'contractor' : 'subcontractor';

            if ($sender->id == $request->to_user_id) {
                return response()->json(['error' => 'You cannot send a message to yourself'], 400);
            }

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

    public function unseenCount()
    {
        $sender = auth('contractor')->user() ?? auth('subcontractor')->user();
        $senderType = auth('contractor')->check() ? 'contractor' : 'subcontractor';

        $count = Message::where('to_user_id', $sender->id)
            ->where('receiver_type', $senderType)
            ->where('is_seen', 0)
            ->select('from_user_id')
            ->distinct()
            ->count('from_user_id');

        return response()->json(['count' => $count]);
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
            // 'chat_id' => $request->chat_id,
        ]);

        broadcast(new MessageSent($message));

        // You may broadcast it here if needed
        return response()->json(['message' => $message]);
    }

    public function getMessages(Request $request)
    {
        $userId = auth('contractor')->id() ?? auth('subcontractor')->id();
        $usertype = auth('contractor')->check() ? 'contractor' : 'subcontractor';

        $receiverId = $request->receiver_id;
        $receiverType = $request->receiver_type;

        if ($usertype === 'contractor') {
            $image = Contractor::find($userId)->profile_photo;
        } else {
            $image = SubContractor::find($userId)->profile_photo;
        }

        $messages = Message::where(function ($q) use ($userId, $receiverId, $receiverType) {
            $q->where('from_user_id', $userId)
                ->where('to_user_id', $receiverId)
                ->where('receiver_type', $receiverType)
                ->with('sender');
        })->orWhere(function ($q) use ($userId, $receiverId, $usertype) {
            $q->where('from_user_id', $receiverId)
                ->where('to_user_id', $userId)
                ->where('receiver_type', $usertype)
                ->with('sender');
        })->orderBy('created_at')->get();

        return response()->json(['messages' => $messages, 'image' => $image]);
    }

    public function markAsSeen(Request $request)
    {
        $request->validate([
            'from_user_id' => 'required|integer',
            'receiver_type' => 'required|string|in:contractor,subcontractor',
        ]);

        // Determine current authenticated user ID and type
        $sender = auth('contractor')->user() ?? auth('subcontractor')->user();
        $toUserType = auth('contractor')->check() ? 'contractor' : 'subcontractor';

        if (!isset($sender->id)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Mark messages from `from_user_id` to authenticated user as seen
        Message::where('from_user_id', $request->from_user_id)
            ->where('to_user_id', $sender->id)
            ->where('receiver_type', $toUserType)
            ->where('sender_type', $request->receiver_type)
            ->where('is_seen', false)
            ->update(['is_seen' => true]);

        return response()->json(['status' => 'success']);
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        $receiverId = $message->to_user_id;       // adjust to your column
        $receiverType = $message->receiver_type;

        $userId = auth('contractor')->id() ?? auth('subcontractor')->id();
        $usertype = auth('contractor')->check() ? 'contractor' : 'subcontractor';
        // Optional: Restrict delete to sender only
        if ($message->from_user_id !== $userId || $message->sender_type !== $usertype) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->delete();

        broadcast(new MessageDeleted($id, $receiverId, $receiverType))->toOthers();

        return response()->json(['success' => true]);
    }
}
