<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller {
   /**
    * Display a listing of the resource.
    */
   public function index() {

    $userId = auth::guard('contractor')->user()->id ?? auth::guard('subcontractor')->user()->id;
    $userType = auth::guard('contractor')->user() ? 'contractor' : 'subcontractor';

      $Contractor = Contractor::where('id', $userId)->first();
      return view("contractor.dashboard.index", compact('Contractor', 'userType'));
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
