<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contractor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
   /**
    * Display a listing of the resource.
    */
   public function index() {
      return view('contractor.login.index');
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

        $contractor = Contractor::where('email', $request->email)->first();
        if ($contractor && Hash::check($request->password, $contractor->password)) {
            Auth::guard('contractor')->login($contractor);

            return redirect()->route('contractor.dashboard.index'); // Ensure this executes
        }

        return back()->withErrors(['email' => 'These credentials do not match our records.']);
    }catch(\Exception $e){
        return back()->withErrors(['email' => $e->getMessage()]);
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

   public function logout(Request $request)
    {
        Auth::guard('contractor')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('contractor.login.index'));
    }
}
