<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bookmark;


class BookmarkController extends Controller {
   /**
    * Display a listing of the resource.
    */
   public function index() {
      return view("contractor.bookmark.index");
   }

   /**
    * Show the form for creating a new resource.
    */
   public function create() {
      //
   }

   /**
    * Store a newly created resource in storage.
    */
   public function store(Request $request) {
    try{
        if (Auth::guard('contractor')->check()) {
            $userType = 'contractor';
            $userId = Auth::guard('contractor')->id();
        } elseif (Auth::guard('subcontractor')->check()) {
            $userType = 'subcontractor';
            $userId = Auth::guard('subcontractor')->id();
        } else {
            return response()->json(['status' => 'Error']);
        }
        // Get logged-in user ID
        $projectId = $request->id;

        // Check if bookmark already exists
        $bookmark = Bookmark::where('user_id', $userId)
            ->where('project_id', $projectId)
            ->where('type', $userType)
            ->first();

        if ($bookmark) {
            // Remove bookmark if already exists
            $bookmark->delete();
            return response()->json(['status' => 'removed']);
        } else {
            // Add new bookmark
            Bookmark::create([
                'user_id' => $userId,
                'project_id' => $projectId,
                'type' => $userType
            ]);
            return response()->json(['status' => 'added']);
        }
    }catch(\Exception $e){
        return $e->getMessage();
    }
   }

   /**
    * Display the specified resource.
    */
   public function show(string $id) {
      //
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit(string $id) {
      //
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, string $id) {
      //
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id) {
      //
   }
}
