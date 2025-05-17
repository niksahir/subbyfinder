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
        $contractorId = Auth::guard('subcontractor')->id();

        $unlockedProjects = UnlockedProject::where('user_id', $contractorId)
            ->where('user_type', 'subcontractor')
            ->with('project')
            ->get()
            ->unique(function ($item) {
                return $item->project->id; // or use any other unique property of the project
            });

        $contacts = $unlockedProjects->map(function ($item) use ($contractorId) {
            $latestMessage = Message::where(function ($q) use ($contractorId, $item) {
                $q->where('from_user_id', $contractorId)->where('to_user_id', $item->project->contractor_id);
            })
                ->orWhere(function ($q) use ($contractorId, $item) {
                    $q->where('from_user_id', $item->project->contractor_id)->where('to_user_id', $contractorId);
                })
                ->orderByDesc('created_at')
                ->first();

            $unseenCount = Message::where('from_user_id', $item->project->contractor_id)
                ->where('to_user_id', $contractorId)
                ->where('is_seen', false)
                ->count();

            return [
                'project' => $item->project,
                'last_message_time' => $latestMessage?->created_at,
                'last_message_body' => $latestMessage?->body,
                'last_message_image' => $latestMessage?->image,
                'unseen_count' => $unseenCount,
            ];
        });

        $sortedProjects = $contacts->sortByDesc(fn($item) => $item['last_message_time'] ?? now()->subYears(100));

        if ($request->ajax()) {
            return view("subcontractor.massage.contact-list", compact('sortedProjects'))->render();
        }

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
