<?php

namespace App\Http\Controllers\SubContractor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller {
   /**
    * Display a listing of the resource.
    */
   public function index() {
      return view('subcontractor.register.index');
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
      $request->validate([
         'business_name' => 'required|string|max:255',
         'email' => 'required|email|unique:users,email',
         'contact_name' => 'required',
         'phone' => 'required|unique:users,phone',
         'support_staff_size' => 'required',
      ]);

      $availability = "";

      if (!empty($request->availability)) {
         $availability = implode(', ', array_map(
            fn($key, $value) => "$key: " . json_encode($value),
            array_keys($request->availability),
            $request->availability
         ));
      }

      $users = new User();
      $users->business_name = $request->business_name;
      $users->contact_name = $request->contact_name;
      $users->role_id  = $request->role_id;
      $users->phone = $request->phone;
      $users->name = $request->business_name;
      $users->email = $request->email;
      $users->password = Hash::make($request->business_name);
      $users->address = $request->address;
      $users->support_staff_size = $request->support_staff_size;
      $users->years_in_business = $request->years_in_business;
      $users->insurances = $request->insurances;
      $users->abn = $request->abn;
      $users->licenses = $request->licenses;
      $users->expertise_in = $request->expertise_in;
      $users->project_type = $request->project_type;
      $users->availability = $availability;
      $users->description = $request->description;
      $users->value = $request->value;
      $users->save();

      return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
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
