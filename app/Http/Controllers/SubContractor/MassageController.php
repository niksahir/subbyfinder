<?php

namespace App\Http\Controllers\SubContractor;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Contractor;
use App\Models\Message;
use App\Models\SubContractor;
use App\Models\UnlockedProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MassageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subcontractorId = Auth::guard('subcontractor')->id();
        $subcontractorType = 'subcontractor';

        // Step 1: Get unlocked projects for this subcontractor, eager load contractor
        $unlockedProjects = UnlockedProject::where('user_id', $subcontractorId)
            ->where('user_type', $subcontractorType)
            ->with('project.contractor')
            ->get()
            ->unique(fn($item) => $item->project->contractor->id);

        // Get unlocked contractor IDs from projects
        $unlockedContractorIds = $unlockedProjects->map(fn($item) => $item->project->contractor->id)
            ->unique()
            ->values()
            ->all();

        // Step 2: Get contractors who messaged subcontractor but are NOT unlocked (locked contacts)
        $messageSenderIds = Message::where('to_user_id', $subcontractorId)
            ->where('receiver_type', $subcontractorType)
            ->where('sender_type', 'contractor')
            ->pluck('from_user_id')
            ->unique()
            ->diff($unlockedContractorIds)
            ->values()
            ->all();

        // Step 3: Build contacts from unlocked projects
        $contactsFromUnlocked = $unlockedProjects->map(function ($item) use ($subcontractorId, $subcontractorType) {
            $contractor = $item->project->contractor;

            $latestMessage = Message::where(function ($q) use ($subcontractorId, $subcontractorType, $contractor) {
                $q->where('from_user_id', $subcontractorId)
                    ->where('sender_type', $subcontractorType)
                    ->where('to_user_id', $contractor->id)
                    ->where('receiver_type', 'contractor');
            })->orWhere(function ($q) use ($subcontractorId, $subcontractorType, $contractor) {
                $q->where('from_user_id', $contractor->id)
                    ->where('sender_type', 'contractor')
                    ->where('to_user_id', $subcontractorId)
                    ->where('receiver_type', $subcontractorType);
            })->latest()->first();

            $unseenCount = Message::where('from_user_id', $contractor->id)
                ->where('sender_type', 'contractor')
                ->where('to_user_id', $subcontractorId)
                ->where('receiver_type', $subcontractorType)
                ->where('is_seen', false)
                ->count();

            return [
                'contractor' => $contractor,
                'project' => $item->project,
                'last_message_time' => $latestMessage?->created_at,
                'last_message_body' => $latestMessage?->body,
                'last_message_image' => $latestMessage?->image,
                'unseen_count' => $unseenCount,
                'image' => $contractor->profile_photo,
            ];
        });

        // Step 4: Build contacts from locked contractors who messaged subcontractor
        $lockedContacts = collect($messageSenderIds)->map(function ($contractorId) use ($subcontractorId, $subcontractorType) {
            $latestMessage = Message::where(function ($q) use ($subcontractorId, $subcontractorType, $contractorId) {
                $q->where('from_user_id', $subcontractorId)
                    ->where('sender_type', $subcontractorType)
                    ->where('to_user_id', $contractorId)
                    ->where('receiver_type', 'contractor');
            })->orWhere(function ($q) use ($subcontractorId, $subcontractorType, $contractorId) {
                $q->where('from_user_id', $contractorId)
                    ->where('sender_type', 'contractor')
                    ->where('to_user_id', $subcontractorId)
                    ->where('receiver_type', $subcontractorType);
            })->latest()->first();

            $unseenCount = Message::where('from_user_id', $contractorId)
                ->where('sender_type', 'contractor')
                ->where('to_user_id', $subcontractorId)
                ->where('receiver_type', $subcontractorType)
                ->where('is_seen', false)
                ->count();

            // Determine the contractor from polymorphic sender/receiver
            $contractor = null;
            if ($latestMessage) {
                $contractor = $latestMessage->sender_type === 'contractor'
                    ? $latestMessage->sender
                    : $latestMessage->receiver;
            }

            return [
                'contractor' => $contractor,
                'project' => null,
                'last_message_time' => $latestMessage?->created_at,
                'last_message_body' => $latestMessage?->body,
                'last_message_image' => $latestMessage?->image,
                'unseen_count' => $unseenCount,
                'image' => $contractor?->profile_photo,
            ];
        });

        // Step 5: Merge, filter nulls, sort by last message time desc
        $allContacts = $contactsFromUnlocked->merge($lockedContacts)
            ->filter(fn($item) => $item['contractor'] !== null)
            ->sortByDesc(fn($item) => $item['last_message_time'] ?? now()->subYears(100))
            ->values();

        if ($request->ajax()) {
            return view("subcontractor.massage.contact-list", ['sortedProjects' => $allContacts])->render();
        }

        return view("subcontractor.massage.index", ['sortedProjects' => $allContacts]);
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
