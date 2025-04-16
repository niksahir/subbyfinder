<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\ContractorProject;
use Illuminate\Http\Request;
use App\Models\Expertise;
use App\Models\ProjectType;
use App\Models\Location;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = ContractorProject::where('contractor_id', Auth::guard('contractor')->id())->latest()->paginate(10);
        return view("contractor.projects.index", compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $expertise_in = Expertise::all();
        $project_types = ProjectType::all();
        $locations = Location::all();
        $states = config('constants.states');
        $userId = Auth::guard('contractor')->id();

        $purchasedPlans = UserSubscription::where('user_id', $userId)
            ->where('is_active', 1)
            ->where('end_date', '>=', now())
            ->latest()
            ->first();

        $canPostProject = true;

        if ($purchasedPlans && in_array($purchasedPlans->plan_id, [3, 4])) {
            // Billing month start based on plan start date
            $startDate = $purchasedPlans->start_date;
            $now = now();
            $monthsSinceStart = $startDate->diffInMonths($now);
            $currentBillingStart = $startDate->copy()->addMonths($monthsSinceStart);
            $currentBillingEnd = $currentBillingStart->copy()->addMonth();

            // Count user's posted projects in this billing cycle
            $projectsThisMonth = ContractorProject::where('contractor_id', $userId)
                ->whereBetween('created_at', [$currentBillingStart, $currentBillingEnd])
                ->count();

            // Only 3 projects allowed per billing month
            if ($projectsThisMonth >= 3) {
                $canPostProject = false;
            }
        }

        return view("contractor.projects.create", compact(
            'purchasedPlans',
            'expertise_in',
            'states',
            'project_types',
            'locations',
            'canPostProject'
        ));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // try{

        $validatedData = $request->validate([
            'project_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_name' => 'required|string|max:255',
            'location' => 'required',
            'description' => 'required|string',
            'abn' => 'required|string',
            'license' => 'required|string',
            'trade_category' => 'required|array',
            'budget' => 'required',
            'project_type' => 'required|array'
        ]);

        $contractorId = Auth::guard('contractor')->id();

        $validatedData['contractor_id'] = $contractorId;

        // Format location (first letter capital, rest lowercase)
        $locationName = ucwords(strtolower(trim($request->location)));

        // Check if location exists
        $location = Location::firstOrCreate(['name' => $locationName]);

        // Set location ID to validated data
        $validatedData['location'] = $locationName;

        // Upload logo
        $logoPath = $request->file('project_logo')->store('project_logos', 'public');

        $validatedData['project_logo'] = $logoPath;
        // Create project with contractor_id
        ContractorProject::create($validatedData);
        return redirect()->route('contractor.projects.index');
        // }catch(\Exception $e){
        //         return $e->getMessage();
        //     }

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
        $project = ContractorProject::where('contractor_id', Auth::guard('contractor')->id())
            ->where('id', $id)
            ->firstOrFail();

        $expertise_in = Expertise::all(); // Fetch categories
        $locations = Location::all();
        $project_types = ProjectType::all();
        return view('contractor.projects.edit', compact('project', 'expertise_in', 'project_types', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'project_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_name' => 'required|string|max:255',
            'location' => 'required',
            'description' => 'required|string',
            'abn' => 'required|string',
            'license' => 'required|string',
            'trade_category' => 'required|array',
            'budget' => 'required',
            'project_type' => 'required|array'
        ]);

        $contractorId = Auth::guard('contractor')->id();

        // Get project
        $project = ContractorProject::where('contractor_id', $contractorId)
            ->where('id', $id)
            ->firstOrFail();

        // Check if a new logo is uploaded
        if ($request->hasFile('project_logo')) {
            // Delete old logo if it exists
            if ($project->project_logo) {
                Storage::disk('public')->delete($project->project_logo);
            }

            // Upload new logo
            $logoPath = $request->file('project_logo')->store('project_logos', 'public');
            $validatedData['project_logo'] = $logoPath;
        }
        // Format location (first letter capital, rest lowercase)
        $locationName = ucwords(strtolower(trim($request->location)));

        // Check if location exists
        $location = Location::firstOrCreate(['name' => $locationName]);

        // Set location ID to validated data
        $validatedData['location'] = $locationName;
        // Update project
        $project->update($validatedData);

        return redirect()->route('contractor.projects.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = ContractorProject::where('contractor_id', Auth::guard('contractor')->id())
            ->where('id', $id)
            ->firstOrFail();

        // Delete project logo if exists
        if ($project->project_logo) {
            Storage::disk('public')->delete($project->project_logo);
        }

        $project->delete();

        return redirect()->route('contractor.projects.index');
    }
}
