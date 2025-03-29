<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contractor;
use App\Models\Expertise;
use App\Models\ProjectType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller {
   /**
    * Display a listing of the resource.
    */
   public function index() {
        $userId = Auth::guard('contractor')->id();
        $contractor = Contractor::where('id', $userId)->first();
        $expertise_in = Expertise::all();
        return view("contractor.setting.index", compact('contractor', 'expertise_in'));
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
        $contractor = Contractor::findOrFail($id);

        $validatedData = $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'business_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|unique:contractors,email,' . $contractor->id,
            'password' => 'nullable|string|confirmed',
            'address' => 'required|string',
            'support_staff_size' => 'required|integer',
            'years_in_business' => 'required|integer',
            'insurances' => 'required|string',
            'abn' => 'required|string',
            'licenses' => 'required|string',
            'trade_category' => 'required|array',
            'description' => 'required|string',
        ]);

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($contractor->profile_photo) {
                Storage::disk('public')->delete($contractor->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $validatedData['profile_photo'] = $path;
        } else {
            $validatedData['profile_photo'] = $contractor->profile_photo;
        }

        // Only update password if provided
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        // Update the contractor
        $contractor->update($validatedData);

        return redirect()->back()->with('success', 'Profile updated successfully!');
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id) {
      //
   }
}
