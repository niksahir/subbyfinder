<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\AdditionalPay;
use App\Models\ContractorProject;
use Illuminate\Http\Request;
use App\Models\Expertise;
use App\Models\ProjectType;
use App\Models\Location;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = ContractorProject::where('contractor_id', Auth::guard('contractor')->id())->with('contractor')->latest()->paginate(10);
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
            ->where('end_date', '>=', value: now())
            ->latest()
            ->first();
        // dd($purchasedPlans);

        $additionalPay = AdditionalPay::where('user_id', $userId)
            ->where('user_type', 'contractor')
            ->where('payable_type', 'addtional job posting')
            ->where('is_over', 0)
            ->latest()
            ->first();

        $canPostProject = true;

        // If no active subscription, or if the plan_id is 1 or 2 (restricted plans), deny posting
        if ($purchasedPlans === null || in_array($purchasedPlans->plan_id, [1, 2])) {
            $canPostProject = false;
        } elseif (in_array($purchasedPlans->plan_id, [3, 4])) {
            // If the user has a plan allowing posting (plan_id 3 or 4), calculate the billing cycle
            $startDate = $purchasedPlans->start_date;
            $now = now();
            $monthsSinceStart = $startDate->diffInMonths($now);
            $currentBillingStart = $startDate->copy()->addMonths($monthsSinceStart);
            $currentBillingEnd = $currentBillingStart->copy()->addMonth();

            // Count the number of projects posted by the contractor in this billing cycle
            $projectsThisMonth = ContractorProject::where('contractor_id', $userId)
                ->whereBetween('created_at', [$currentBillingStart, $currentBillingEnd])
                ->count();

            // If they've already posted 3 projects this billing cycle, deny posting
            if ($projectsThisMonth >= 3) {
                $canPostProject = false;
            }
        }

        if ($additionalPay) {
            $canPostProject = true;
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

    public function unlockPostProject()
    {

        $userId = Auth::guard('contractor')->id();

        Stripe::setApiKey(config('services.stripe.secret'));

        // $planKey = $request->plan_id;

        // $plan = Plan::where('id', $planKey)->first();
        // Create a Stripe Checkout Session
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'aud',
                    'product_data' => [
                        'name' => 'additional job posting',
                    ],
                    'unit_amount' => 10 * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('contractor.handleStripePaymentProject') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
            // 'metadata' => [
            //     'plan_key' => , // make sure your Plan model has a unique plan_key
            // ],
        ]);

        return redirect($session->url);

        // return view("", compact('purchasedPlans'));
    }

    public function handleStripePaymentProject(Request $request)
    {
        $sessionId = $request->input('session_id');

        // Retrieve the session from Stripe
        Stripe::setApiKey(config('services.stripe.secret'));
        $session = Session::retrieve($sessionId);
        $canPostProject = false;
        // Check if the payment was successful
        if ($session->payment_status === 'paid') {
            // Payment was successful, unlock the project posting feature
            $userId = Auth::guard('contractor')->id();

            $additionalPay = new AdditionalPay();
            $additionalPay->user_id = Auth::guard('contractor')->id();
            $additionalPay->user_type = 'contractor';
            $additionalPay->payable_type = 'addtional job posting';
            $additionalPay->is_over = 0;
            $additionalPay->price = 10;
            $additionalPay->stripe_session_id = $sessionId;
            $additionalPay->save();

            $canPostProject = true;

            return redirect()->route('contractor.projects.create', compact('canPostProject'))->with('success', 'Project posting unlocked successfully!');
        } else {
            return redirect()->route('contractor.projects.create', compact('canPostProject'))->with('error', 'Payment failed. Please try again.');
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // try{
        $validatedData = $request->validate([
            // 'project_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_name' => 'required|string|max:255',
            'location' => 'required',
            'description' => 'required|string',
            // 'abn' => 'required|string',
            // 'license' => 'required|string',
            'trade_category' => 'required|array',
            'budget' => 'required',
            'project_type' => 'required|array',
            'place_id' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);
        // dd($validatedData);

        $contractorId = Auth::guard('contractor')->id();

        $validatedData['contractor_id'] = $contractorId;

        // Format location (first letter capital, rest lowercase)
        $locationName = ucwords(strtolower(trim($request->location)));

        // Check if location exists
        // $location = Location::firstOrCreate(['name' => $locationName]);

        // Set location ID to validated data
        $validatedData['location'] = $locationName;

        // Upload logo
        // $logoPath = $request->file('project_logo')->store('project_logos', 'public');

        // $validatedData['project_logo'] = $logoPath;
        // Create project with contractor_id
        ContractorProject::create($validatedData);

        $purchasedPlans = UserSubscription::where('user_id', Auth::guard('contractor')->id())
            ->where('is_active', 1)
            ->where('end_date', '>=', value: now())
            ->latest()
            ->first();

        if ($purchasedPlans == null ||$purchasedPlans->plan_id == 1 || $purchasedPlans->plan_id == 2 ) {

            $additionalPay = AdditionalPay::where('user_id', $contractorId)
                ->where('user_type', 'contractor')
                ->where('payable_type', 'addtional job posting')
                ->where('is_over', 0)
                ->latest()
                ->first();

            $additionalPay->is_over = 1;
            $additionalPay->save();
        }

        return redirect()->route('contractor.projects.index')->with('success', 'Project created successfully!');
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
            // 'project_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'project_name' => 'required|string|max:255',
            'location' => 'required',
            'description' => 'required|string',
            // 'abn' => 'required|string',
            // 'license' => 'required|string',
            'trade_category' => 'required|array',
            'budget' => 'required',
            'project_type' => 'required|array',
            'place_id' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
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

        return redirect()->route('contractor.projects.index')->with('success', 'Project updated successfully!');
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
