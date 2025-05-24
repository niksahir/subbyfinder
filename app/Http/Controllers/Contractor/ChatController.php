<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Contractor;
use App\Models\Message;
use App\Models\SubContractor;
use App\Models\UnlockedProject;
use App\Models\UnlockSubcontractorProject;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $contractorId = Auth::guard('contractor')->id();
        $contractorType = 'contractor';

        $receiverId = $request->input('receiver_id');
        $receiverType = $request->input('receiver_type');

        // Step 1: Get unlocked projects of this contractor with subcontractor eager loaded
        $unlockedProjects = UnlockSubcontractorProject::where('user_id', $contractorId)
            ->where('user_type', $contractorType)
            ->with(['project'])  // assuming project has subcontractor relation
            ->get()
            ->unique(fn($item) => $item->project->id);

        $unlockedSubcontractorIds = $unlockedProjects->map(fn($item) => $item->project->id)
            ->unique()
            ->values()
            ->all();

        // Step 2: Get IDs of subcontractors who messaged the contractor (locked contacts)
        $messageSenderIds = Message::where('to_user_id', $contractorId)
            ->where('receiver_type', $contractorType)
            ->where('sender_type', 'subcontractor')
            ->pluck('from_user_id')
            ->unique()
            ->diff($unlockedSubcontractorIds)
            ->values()
            ->all();

        // Step 3: Prepare contacts from unlocked projects (subcontractors)
        $contactsFromUnlocked = $unlockedProjects->map(function ($item) use ($contractorId, $contractorType) {
            $subcontractor = $item->project;

            $latestMessage = Message::where(function ($q) use ($contractorId, $contractorType, $subcontractor) {
                $q->where('from_user_id', $contractorId)
                    ->where('sender_type', $contractorType)
                    ->where('to_user_id', $subcontractor->id)
                    ->where('receiver_type', 'subcontractor');
            })->orWhere(function ($q) use ($contractorId, $contractorType, $subcontractor) {
                $q->where('from_user_id', $subcontractor->id)
                    ->where('sender_type', 'subcontractor')
                    ->where('to_user_id', $contractorId)
                    ->where('receiver_type', $contractorType);
            })->latest()->first();

            $unseenCount = Message::where('from_user_id', $subcontractor->id)
                ->where('sender_type', 'subcontractor')
                ->where('to_user_id', $contractorId)
                ->where('receiver_type', $contractorType)
                ->where('is_seen', false)
                ->count();

            return [
                'subcontractor' => $subcontractor,
                'project' => $item->project,
                'last_message_time' => $latestMessage?->created_at,
                'last_message_body' => $latestMessage?->body,
                'last_message_image' => $latestMessage?->image,
                'unseen_count' => $unseenCount,
                'image' => $subcontractor->profile_photo,
            ];
        });

        // Step 4: Prepare contacts from locked subcontractors who messaged contractor
        $lockedContacts = collect($messageSenderIds)->map(function ($subcontractorId) use ($contractorId, $contractorType) {
            $latestMessage = Message::where(function ($q) use ($contractorId, $contractorType, $subcontractorId) {
                $q->where('from_user_id', $contractorId)
                    ->where('sender_type', $contractorType)
                    ->where('to_user_id', $subcontractorId)
                    ->where('receiver_type', 'subcontractor');
            })->orWhere(function ($q) use ($contractorId, $contractorType, $subcontractorId) {
                $q->where('from_user_id', $subcontractorId)
                    ->where('sender_type', 'subcontractor')
                    ->where('to_user_id', $contractorId)
                    ->where('receiver_type', $contractorType);
            })->latest()->first();

            $unseenCount = Message::where('from_user_id', $subcontractorId)
                ->where('sender_type', 'subcontractor')
                ->where('to_user_id', $contractorId)
                ->where('receiver_type', $contractorType)
                ->where('is_seen', false)
                ->count();

            $subcontractor = $latestMessage?->sender_type === 'subcontractor'
                ? $latestMessage->sender
                : $latestMessage->receiver;

            return [
                'subcontractor' => $subcontractor,
                'project' => null,
                'last_message_time' => $latestMessage?->created_at,
                'last_message_body' => $latestMessage?->body,
                'last_message_image' => $latestMessage?->image,
                'unseen_count' => $unseenCount,
                'image' => $subcontractor?->profile_photo,
            ];
        });

        // Step 5: Merge, filter nulls, sort contacts by latest message time
        $allContacts = $contactsFromUnlocked->merge($lockedContacts)
            ->filter(fn($item) => $item['subcontractor'] !== null)
            ->sortByDesc(fn($item) => $item['last_message_time'] ?? now()->subYears(100))
            ->values();

        $contractor = Contractor::find($contractorId);
        $profilePhoto = $contractor?->profile_photo;

        if ($request->ajax()) {
            return view("contractor.messages.contact-list", [
                'sortedProjects' => $allContacts,
                'profilePhoto' => $profilePhoto,
            ])->render();
        }

        return view("contractor.messages.index", [
            'sortedProjects' => $allContacts,
            'receiverId' => $receiverId,
            'receiverType' => $receiverType,
            'profilePhoto' => $profilePhoto,
        ]);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
