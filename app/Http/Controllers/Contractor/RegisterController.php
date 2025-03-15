<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Contractor;
use App\Models\Expertise;
use App\Models\ProjectType;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller {
   /**
    * Display a listing of the resource.
    */
   public function index() {
        $expertise_in = Expertise::all();
        $project_types = ProjectType::all();
        return view('contractor.register.index', compact(['expertise_in', 'project_types']));
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

        $validatedData = $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'business_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|unique:contractors,email',
            'password' => 'required|string',
            'address' => 'required|string',
            'support_staff_size' => 'required|integer',
            'years_in_business' => 'required|integer',
            'insurances' => 'required|string',
            'abn' => 'required|string',
            'licenses' => 'required|string',
            'expertise_in' => 'required|array',
            'project_types' => 'required|array',
            // 'availability' => 'required|array',
            'description' => 'required|string',
            'values' => 'required|string',
        ]);

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $validatedData['profile_photo'] = $path;
        }

        // $availability = "";

        // if (!empty($request->availability)) {
            //     $availability = implode(', ', array_map(
        //     fn($key, $value) => "$key: " . json_encode($value),
        //     array_keys($request->availability),
        //     $request->availability
        //     ));
        // }

        $validatedData['password'] = Hash::make($validatedData['password']);
        Contractor::create($validatedData);

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
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
