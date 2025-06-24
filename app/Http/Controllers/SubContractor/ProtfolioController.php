<?php

namespace App\Http\Controllers\Subcontractor;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\SubcontractorProtfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProtfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'project_name' => 'required',
                'location' => 'required',
                'protfolio_image' => 'required|array',
                'protfolio_image.*' => 'image|max:2048|mimes:jpeg,png,jpg,webp',
                'description' => 'required',
                'price' => 'required',
            ]);

            $imagePaths = [];

            foreach ($request->file('protfolio_image') as $image) {
                $imagePath = $image->store('protfolio_image', 'public');
                $imagePaths[] = $imagePath;
            }

            $validated['images'] = json_encode($imagePaths, true);
            $validated['user_id'] = Auth::guard('subcontractor')->id();

            SubcontractorProtfolio::create($validated);

            return redirect()->back()->with('success', 'Protfolio added successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $protfolio = SubcontractorProtfolio::findOrFail($id);
        $locations = Location::all();

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $protfolio->id,
                'project_name' => $protfolio->project_name,
                'location' => $protfolio->location,
                'description' => $protfolio->description,
                'price' => $protfolio->price,
                'images' => json_decode($protfolio->images, true) ?? [] // decode JSON string
            ],
            'locations' => $locations
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'project_name' => 'required',
            'location' => 'required',
            'protfolio_image' => 'nullable|array',
            'protfolio_image.*' => 'image|max:2048|mimes:jpeg,png,jpg,webp',
            'description' => 'required',
            'price' => 'required',
            'existing_images' => 'nullable|string' // hidden input from the frontend
        ]);


        $protfolio = SubcontractorProtfolio::findOrFail($id);

        // Decode existing images from hidden input (JSON string)
        $existingImages = json_decode($request->input('existing_images'), true) ?? [];

        // Store new images
        $newImagePaths = [];
        if ($request->hasFile('protfolio_image')) {
            foreach ($request->file('protfolio_image') as $image) {
                $imagePath = $image->store('protfolio_image', 'public');
                $newImagePaths[] = $imagePath;
            }
        }

        // Combine existing and new images
        $finalImageList = array_merge($existingImages, $newImagePaths);

        // Save combined image list to the database
        $validated['images'] = $finalImageList;

        $protfolio->update($validated);

        return redirect(route('subcontractor.setting.index'))->with('success', 'Portfolio updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $protfolio = SubcontractorProtfolio::findOrFail($id);
        $protfolio->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Protfolio deleted successfully!'
        ]);
    }
}
