<?php

namespace App\Http\Controllers\SubContractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContractorProject;
use App\Models\SubContractorsBookmark;
use Illuminate\Support\Facades\Auth;


class BookmarkController extends Controller {
   /**
    * Display a listing of the resource.
    */
   public function index() {
    $projects = ContractorProject::whereHas('bookmarks', function ($query) {
        $query->where([
            'user_id' => Auth::guard('subcontractor')->id(),
            'type' => 'subcontractor',
        ]);
    })->latest()->paginate(10);
      return view("subcontractor.bookmark.index", compact('projects'));
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
        $subcontractor_id = $request->id;

        // Check if bookmark already exists
        $bookmark = SubContractorsBookmark::where('user_id', $userId)
            ->where('subcontractor_id', $subcontractor_id)
            ->where('type', $userType)
            ->first();

        if ($bookmark) {
            // Remove bookmark if already exists
            $bookmark->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Your project remove from bookmark!'
            ]);
        } else {
            // Add new bookmark
            SubContractorsBookmark::create([
                'user_id' => $userId,
                'subcontractor_id' => $subcontractor_id,
                'type' => $userType
            ]);
            return response()->json([
                'status' => 'added',
                'message' => 'Your project Added in bookmark!'
            ]);
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
