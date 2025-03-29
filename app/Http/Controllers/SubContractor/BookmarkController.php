<?php

namespace App\Http\Controllers\SubContractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContractorProject;
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
      //
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
