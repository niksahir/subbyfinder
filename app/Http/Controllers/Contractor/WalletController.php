<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller {
   /**
    * Display a listing of the resource.
    */
   public function index() {

    $userSubcriptions = UserSubscription::where('user_id', Auth::guard('contractor')->user()->id)->where('user_type', 'contractor')->with('plan')->get();

      return view("contractor.wallet.index",compact('userSubcriptions'));
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
