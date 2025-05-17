<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\Message;
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

        $receiverId = $request->input('receiver_id');
        $receiverType = $request->input('receiver_type');

        $unlockedProjects = UnlockSubcontractorProject::where('user_id', $contractorId)
            ->where('user_type', 'contractor')
            ->with('project')
            ->get()
            ->unique(function ($item) {
                return $item->project->id; // or use any other unique property of the project
            });

        $contacts = $unlockedProjects->map(function ($item) use ($contractorId) {
            $latestMessage = Message::where(function ($q) use ($contractorId, $item) {
                $q->where('from_user_id', $contractorId)->where('to_user_id', $item->project_id);
            })
                ->orWhere(function ($q) use ($contractorId, $item) {
                    $q->where('from_user_id', $item->project_id)->where('to_user_id', $contractorId);
                })
                ->orderByDesc('created_at')
                ->first();

            $unseenCount = Message::where('from_user_id', $item->project_id)
                ->where('to_user_id', $contractorId)
                ->where('is_seen', false)
                ->count();

            $image = Contractor::where('id', $contractorId)->first();

            return [
                'project' => $item->project,
                'last_message_time' => $latestMessage?->created_at,
                'last_message_body' => $latestMessage?->body,
                'last_message_image' => $latestMessage?->image,
                'unseen_count' => $unseenCount,
                'image' => $image->profile_photo,
            ];
        });

        $sortedProjects = $contacts->sortByDesc(fn($item) => $item['last_message_time'] ?? now()->subYears(100));

        if ($request->ajax()) {
            return view("contractor.messages.contact-list", compact('sortedProjects'))->render();
        }

        return view("contractor.messages.index", compact('sortedProjects', 'receiverId', 'receiverType'));
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
