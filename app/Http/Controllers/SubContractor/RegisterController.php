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
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'business_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|unique:contractors,email',
            'address' => 'nullable|string',
            'support_staff_size' => 'nullable|integer',
            'years_in_business' => 'nullable|string',
            'insurances' => 'nullable|string',
            'abn' => 'nullable|string',
            'licenses' => 'nullable|string',
            'expertise_in' => 'nullable|array',
            'project_types' => 'nullable|array',
            'availability' => 'nullable|array',
            'description' => 'nullable|string',
            // 'certificates.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
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

        $validatedData['password'] = Hash::make($validatedData['email']);
        $subContractor = SubContractor::create($validatedData);

        // return [
        //     'subContractor' => $subContractor,
        //     '$request->hasFile' => !empty($request->certificates),
        //     'is_array' => is_array($request->file('certificates'))
        // ];

        if (!empty($request->certificates) || is_array($request->certificates)) {
            foreach ($request->certificates as $index => $base64File) {
                preg_match('/^data:image\/(\w+);base64,/', $base64File, $matches);
                $extension = $matches[1] ?? 'png'; // Default to PNG if no extension found

                $fileData = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $base64File));
                $fileName = 'certificate_' . time() . "_$index.$extension";
                $filePath = "certifications/$fileName";

                Storage::disk('public')->put($filePath, $fileData);

                // $path = $request->file('profile_photo')->store('profile_photos', 'public');
                // $validatedData['profile_photo'] = $path;

                Certification::create([
                    'sub_contractor_id' => $subContractor->id,
                    // 'certificate_name' => $fileName,
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
}
