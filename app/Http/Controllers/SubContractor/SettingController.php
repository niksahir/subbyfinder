<?php

namespace App\Http\Controllers\SubContractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expertise;
use App\Models\SubContractor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ProjectType;
use App\Models\Certification;
use App\Models\Location;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller {
   /**
    * Display a listing of the resource.
    */
   public function index() {
        $userId = Auth::guard('subcontractor')->id();
        $subcontractor = SubContractor::where('id', $userId)->first();
        $expertise_in = Expertise::all();
        $locations = Location::all();
        return view("subcontractor.setting.index", compact('subcontractor', 'expertise_in', 'locations'));
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

        // Validate the input data
        $validatedData = $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'business_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|unique:sub_contractors,email,' . $id,
            'password' => 'nullable|string|max:255|confirmed',
            'address' => 'required|string',
            'support_staff_size' => 'required|integer',
            'years_in_business' => 'required|integer',
            'insurances' => 'required|string',
            'abn' => 'required|string',
            'licenses' => 'required|string',
            'location' => 'required|string',
            'availability' => 'required|string',
            'trade_category' => 'required|array',
            'description' => 'required|string',
            'certificates.*' => 'mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ], [
            'certificates.*.mimes' => 'Only JPEG, PNG, JPG, GIF, and PDF files are allowed for certificates.',
            'certificates.*.max' => 'Each certificate must not exceed 2MB in size.',
        ]);

        // Find the subcontractor
        $subContractor = SubContractor::findOrFail($id);

        // Handle profile photo update
        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if exists
            if ($subContractor->profile_photo) {
                Storage::disk('public')->delete($subContractor->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $validatedData['profile_photo'] = $path;
        }

        // Handle password update
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
        $locationName = ucwords(strtolower(trim($request->location)));

        // Check if location exists
        $location = Location::firstOrCreate(['name' => $locationName]);

        // Set location ID to validated data
        $validatedData['location'] = $locationName;
        // Update subcontractor details
        $subContractor->update($validatedData);

        // Handle certificate uploads
        if ($request->hasFile('certificates')) {
            foreach ($request->file('certificates') as $file) {
                $extension = $file->getClientOriginalExtension(); // Get the file extension
                $fileName = 'certificate_' . time() . '.' . $extension;
                $filePath = $file->storeAs('certifications', $fileName, 'public'); // Store the file

                Certification::create([
                    'sub_contractor_id' => $subContractor->id,
                    'file_path' => $filePath,
                ]);
            }
        }

        // Handle certificate deletions
        if ($request->filled('deleted_certificates')) {
            $deletedCertificates = json_decode($request->deleted_certificates, true);
            if (!empty($deletedCertificates) && is_array($deletedCertificates)) {
                foreach ($deletedCertificates as $certificate) {
                    if (!empty($certificate)) {
                        // Delete file from storage
                        Storage::disk('public')->delete($certificate);

                        // Remove certificate from the database
                        Certification::where('file_path', $certificate)->delete();
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Profile updated successfully!');
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id) {
      //
   }
}
