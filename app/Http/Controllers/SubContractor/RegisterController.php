<?php

namespace App\Http\Controllers\SubContractor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Expertise;
use App\Models\ProjectType;
use App\Models\SubContractor;
use App\Models\Certification;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller {
   /**
    * Display a listing of the resource.
    */
   public function index() {
        $expertise_in = Expertise::all();
        $project_types = ProjectType::all();
        return view('subcontractor.register.index', compact(['expertise_in', 'project_types']));
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
    // try{

        // return $request->all();
        $validatedData = $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'business_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|unique:sub_contractors,email',
            'password' => 'required|string|max:255|confirmed',
            'address' => 'required|string',
            'support_staff_size' => 'required|integer',
            'years_in_business' => 'required|integer',
            'insurances' => 'required|string',
            'abn' => 'required|string',
            'licenses' => 'required|string',
            'trade_category' => 'required|array',
            // 'expertise_in' => 'required|string',
            // 'project_types' => 'required|array',
            // 'availability' => 'required|array',
            'description' => 'required|string',
            'certificates.*' => 'mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ], [
            'certificates.*.mimes' => 'Only JPEG, PNG, JPG, GIF, and PDF files are allowed for certificates.',
            'certificates.*.max' => 'Each certificate must not exceed 2MB in size.',
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
        $subContractor = SubContractor::create($validatedData);

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

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    // }catch(\Exception $e){
    //         return $e->getMessage();
    //     }
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

   public function checkEmail(Request $request)
    {
        $emailExists = SubContractor::where('email', $request->email)->exists();

        return response()->json(['exists' => $emailExists]);
    }
}
