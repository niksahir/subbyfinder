<?php

namespace App\Http\Controllers\SubContractor;

use App\Http\Controllers\Controller;
use App\Models\Message;
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

        // Step 1: Get unlocked projects
        $unlockedProjects = UnlockedProject::where('user_id', $subcontractorId)
            ->where('user_type', 'subcontractor')
            ->with('project.contractor')
            ->get()
            ->groupBy('contractor_id')
            ->map(function ($projects) {
                return $projects->first();
            });

        $unlockedContractorIds = $unlockedProjects->keys()->toArray();

        // Step 2: Contractors who have ever sent a message (locked or unlocked)
        $messageSenderIds = Message::where('to_user_id', $subcontractorId)
            ->pluck('from_user_id')
            ->unique()
            ->diff($unlockedContractorIds) // only locked ones
            ->values()
            ->all();

        // Step 3: Build contact list from unlocked projects
        $contactsFromUnlocked = $unlockedProjects->map(function ($item) use ($subcontractorId) {
            $contractor = $item->project->contractor;

            $latestMessage = Message::where(function ($q) use ($subcontractorId, $contractor) {
                $q->where('from_user_id', $subcontractorId)->where('to_user_id', $contractor->id);
            })->orWhere(function ($q) use ($subcontractorId, $contractor) {
                $q->where('from_user_id', $contractor->id)->where('to_user_id', $subcontractorId);
            })
                ->latest()
                ->first();

            $unseenCount = Message::where('from_user_id', $contractor->id)
                ->where('to_user_id', $subcontractorId)
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

        // Step 4: Build list from locked contractors who have messaged
        $lockedContacts = collect($messageSenderIds)->map(function ($contractorId) use ($subcontractorId) {
            $latestMessage = Message::where(function ($q) use ($subcontractorId, $contractorId) {
                $q->where('from_user_id', $subcontractorId)->where('to_user_id', $contractorId);
            })->orWhere(function ($q) use ($subcontractorId, $contractorId) {
                $q->where('from_user_id', $contractorId)->where('to_user_id', $subcontractorId);
            })
                ->latest()
                ->first();

            $unseenCount = Message::where('from_user_id', $contractorId)
                ->where('to_user_id', $subcontractorId)
                ->where('is_seen', false)
                ->count();

            return [
                'contractor' => $latestMessage?->sender,
                'project' => null,
                'last_message_time' => $latestMessage?->created_at,
                'last_message_body' => $latestMessage?->body,
                'last_message_image' => $latestMessage?->image,
                'unseen_count' => $unseenCount,
                'image' =>  $latestMessage?->sender->profile_photo,
            ];
        });
        // dd($lockedContacts)

        // Step 5: Merge and sort
        $allContacts = $contactsFromUnlocked->merge($lockedContacts)->filter(fn($item) => $item['contractor'] !== null);

        $sortedProjects = $allContacts
            ->sortByDesc(fn($item) => $item['last_message_time'] ?? now()->subYears(100))
            ->values();

        if ($request->ajax()) {
            return view("subcontractor.massage.contact-list", compact('sortedProjects'))->render();
        }
        // dd($sortedProjects);
        return view("subcontractor.massage.index", compact('sortedProjects'));
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
