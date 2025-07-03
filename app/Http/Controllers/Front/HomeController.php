<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\SendEnquireMail;
use App\Models\AdditionalPay;
use App\Models\ReviewContractor;
use App\Models\ReviewSubContractor;
use App\Models\UnlockedProject;
use App\Models\UnlockSubcontractorProject;
use Illuminate\Http\Request;
use App\Models\Expertise;
use App\Models\ProjectType;
use App\Models\Contractor;
use App\Models\Plan;
use App\Models\Location;
use App\Models\SubContractor;
use App\Models\ContractorProject;
use App\Models\ProfileView;
use App\Models\SubcontractorProtfolio;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\Stripe;

use function Illuminate\Log\log;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $userLogin;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::guard('contractor')->check()) {
                $this->userLogin = Auth::guard('contractor')->user();
            } elseif (Auth::guard('subcontractor')->check()) {
                $this->userLogin = Auth::guard('subcontractor')->user();
            }
            return $next($request);
        });
    }

    protected function getLoggedInUser()
    {
        if (Auth::guard('subcontractor')->check()) {
            return Auth::guard('subcontractor')->user();
        } elseif (Auth::guard('contractor')->check()) {
            return Auth::guard('contractor')->user();
        }
        return null;
    }

    protected function getUserType()
    {
        if (Auth::guard('subcontractor')->check()) {
            return 'subcontractor';
        } elseif (Auth::guard('contractor')->check()) {
            return 'contractor';
        }
        return null;
    }

    public function index(Request $request)
    {
        $userType = null;
        $userType = $this->getUserType();

        $projects = ContractorProject::latest()->take(2)->get();
        $subcontractors = SubContractor::count();
        $contractors = Contractor::count();
        $projectsCount = ContractorProject::count();
        $monthlyPlans = Plan::where('billing_type', 'monthly')->get();
        $yearlyPlans = Plan::where('billing_type', 'yearly')->get();
        $locations = Location::all();
        $categories = Expertise::latest()->take(8)->get();

        $subcontractorsReviews = reviewContractor::with('user')
            ->latest()
            ->get()
            ->where('project_type', 'subcontractor_project')
            ->map(function ($review) {
                // Calculate average rating for each review
                $average = collect([
                    $review->workmanship,
                    $review->integrity,
                    $review->presentation,
                    $review->communication,
                ])->avg();

                // Attach average to the review
                $review->average_rating = round($average, 2);
                return $review;
            })
            ->sortByDesc('average_rating') // sort by average descending
            ->values();

        return view(
            'front.home',
            ['userLogin' => $this->userLogin],
            compact(
                'projects',
                'subcontractors',
                'contractors',
                'projectsCount',
                'monthlyPlans',
                'yearlyPlans',
                'locations',
                'userType',
                'subcontractorsReviews',
                'categories'
            )
        );
    }

    public function showPlans()
    {
        $monthlyPlans = Plan::where('billing_type', 'monthly')->get();
        $yearlyPlans = Plan::where('billing_type', 'yearly')->get();
        $userLogin = $this->userLogin;
        return view('front.plans', compact('monthlyPlans', 'yearlyPlans', 'userLogin'));
    }

    private function convertBudgetToOrder($budget)
    {
        switch ($budget) {
            case '5K under':
                return 1;
            case '10K':
                return 2;
            case '25K':
                return 3;
            case '50K':
                return 4;
            case '100K':
                return 5;
            case '100K above':
                return 6;
            default:
                return 0;
        }
    }

    public function projectSearch(Request $request)
    {

        $query = ContractorProject::query();
        $userEmailAlerts = 0;
        $sortBy = $request->sort_by ? $request->sort_by : 'latest';
        $userLogin = null;

        $radiusKm = 5;

        $lat = $request->input('lat');
        $lng = $request->input('lng');

        $lat = $request->filled('lat') ? $request->input('lat') : null;
        $lng = $request->filled('lng') ? $request->input('lng') : null;

        // normalise empty strings / 'null'
        if ($lat === '' || $lat === 'null') $lat = null;
        if ($lng === '' || $lng === 'null') $lng = null;

        $isPaginationOrAjax = $request->ajax() || $request->has('page');

        // 1) Fresh coords were supplied in this request → save & use
        if (is_numeric($lat) && is_numeric($lng)) {
            session(['lat' => $lat, 'lng' => $lng]);
        }
        // 2) No coords in this request:
        else {
            if ($isPaginationOrAjax) {
                // follow‑up request: fall back to what we stored earlier
                $lat = session('lat');
                $lng = session('lng');
            } else {
                // brand‑new visit: wipe any stale coords
                session()->forget(['lat', 'lng']);
                $lat = $lng = null;
            }
        }

        if (Auth::guard('contractor')->check()) {
            $userEmailAlerts = Auth::guard('contractor')->user()->email_alerts;
            $userLogin = Auth::guard('contractor')->user();
        } elseif (Auth::guard('subcontractor')->check()) {
            $userEmailAlerts = Auth::guard('subcontractor')->user()->email_alerts;
            $userLogin = Auth::guard('subcontractor')->user();
        }

        if (is_numeric($lat) && is_numeric($lng)) {
            Log::info("Radius filter ON  |  lat=$lat lng=$lng r={$radiusKm}km");
            $query->withinRadius($lat, $lng, $radiusKm);
        } else {
            Log::info("Radius filter OFF |  plain listing");
        }

        // Search by Location
        if ($request->has('location') && !empty($request->location)) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }

        // Filter by Category
        if ($request->has('trade_category') && !empty($request->trade_category)) {
            $query->whereJsonContains('trade_category', $request->trade_category);
        }

        // Filter by Project type
        if ($request->has('project_type') && !empty($request->project_type)) {
            $query->whereJsonContains('project_type', $request->project_type);
        }

        if ($request->has('project') && !empty($request->project)) {
            $query->where('project_name', 'LIKE', '%' . $request->project . '%');
        }
        $tradeCategory = null;
        if ($request->has('trade_category') && !empty($request->trade_category)) {
            $tradeCategory = $request->trade_category;
            $query->whereJsonContains('trade_category', $request->trade_category);
        }

        // Filter by sorting
        if ($request->sort_by == 'price_asc') {
            $query->orderByRaw("
                CASE
                    WHEN budget = '5K under' THEN 1
                    WHEN budget = '10K' THEN 2
                    WHEN budget = '25K' THEN 3
                    WHEN budget = '50K' THEN 4
                    WHEN budget = '100K' THEN 5
                    WHEN budget = '100K above' THEN 6
                    ELSE 7
                END
            ");
        } elseif ($request->sort_by == 'price_desc') {
            $query->orderByRaw("
                CASE
                    WHEN budget = '5K under' THEN 1
                    WHEN budget = '10K' THEN 2
                    WHEN budget = '25K' THEN 3
                    WHEN budget = '50K' THEN 4
                    WHEN budget = '100K' THEN 5
                    WHEN budget = '100K above' THEN 6
                    ELSE 7
                END DESC
            ");
        } else {
            // Default to created_at sorting
            $query->orderBy('created_at', $request->sort_by == 'latest' ? 'desc' : 'asc');
        }

        // Filter by Budget
        if ($request->has('budget') && !empty($request->budget)) {
            $budgets = $request->budget;

            $query->where(function ($q) use ($budgets) {
                foreach ($budgets as $budget) {
                    $q->orWhere('budget', $budget);
                }
            });
        }
        // Get Paginated Results
        $projects = $query->latest()->paginate(10);

        // AJAX Request Handling
        if ($request->ajax()) {
            $html = view('front.project_partial', compact('projects', 'userEmailAlerts', 'sortBy'))->render();
            return response()->json(['html' => $html, 'param' => $request->all()]);
        }

        $expertise_in = Expertise::all();
        $project_types = ProjectType::all();
        // $projects = ContractorProject::latest()->paginate(10);
        $locations = Location::all();
        return view('front.projectSearch', compact('tradeCategory', 'expertise_in', 'projects', 'project_types', 'userEmailAlerts', 'sortBy', 'locations', 'userLogin'));
    }



    public function projectDetails($id)
    {
        $userId = $this->userLogin;
        $userType = $this->getUserType();

        $project = ContractorProject::with('contractor')->findOrFail($id);
        $projectTypes = $project->project_type_models;
        $portfolio = SubcontractorProtfolio::get();
        $projectCount = ContractorProject::where('contractor_id', $project->contractor_id)->count();
        $contractorProjects = ContractorProject::with('contractor')->where('contractor_id', $project->contractor_id)->latest()->take(5)->get();

        $profileCount = new ProfileView();
        $profileCount->user_id = $userId->id;
        $profileCount->user_type = $userType;
        $profileCount->profile_id = $project->contractor_id;
        $profileCount->profile_type = 'contractor_project';
        $profileCount->save();

        // Fetch and merge reviews
        $contractorReviews = ReviewContractor::where('project_id', $id)
            ->where('project_type', 'contractor_project')
            ->with('user')
            ->get();

        $subcontractorReviews = ReviewSubContractor::where('project_id', $id)
            ->where('project_type', 'contractor_project')
            ->with('user')
            ->get();

        $mergedReviews = $contractorReviews->merge($subcontractorReviews);

        // Calculate average rating
        $ratings = collect();
        foreach ($contractorReviews as $review) {
            $ratings = $ratings->merge([
                $review->workmanship,
                $review->integrity,
                $review->presentation,
                $review->communication,
            ]);
        }
        foreach ($subcontractorReviews as $review) {
            $ratings = $ratings->merge([
                $review->quality_of_projects,
                $review->communication_of_works,
                $review->payment_terms,
                $review->support_staff,
            ]);
        }
        $filteredRatings = $ratings->filter(fn($v) => $v !== null);
        $averageRating = $filteredRatings->isNotEmpty()
            ? round($filteredRatings->avg(), 1)
            : null;

        // If user not logged in
        if (!$userId) {
            $unlockProject = false;
            return view('front.projectdetilslock', compact(
                'userId',
                'subcontractorReviews',
                'contractorReviews',
                'averageRating',
                'userType',
                'project',
                'unlockProject',
                'projectTypes',
                'portfolio',
                'projectCount',
                'contractorProjects'
            ));
        }

        // Check if project already unlocked
        $unlockedProject = UnlockedProject::where('user_id', $userId->id)
            ->where('user_type', $userType)
            ->where('project_id', $id)
            ->first();

        // Check active subscription
        $userSubscription = UserSubscription::where('user_id', $userId->id)
            ->where('user_type', $userType)
            ->where('is_active', 1)
            ->latest()
            ->first();

        $unlockProject = false;

        if ($userSubscription) {
            $now = now();
            $startDate = $userSubscription->start_date;
            $endDate = $userSubscription->end_date;

            if ($now <= $endDate) {
                $monthsSinceStart = $startDate->diffInMonths($now);
                $currentBillingStart = $startDate->copy()->addMonths($monthsSinceStart);
                $currentBillingEnd = $currentBillingStart->copy()->addMonth();

                // Count unlocked projects this billing period
                $unlockedContractorCount = UnlockedProject::where('user_id', $userId->id)
                    ->where('user_type', $userType)
                    ->whereBetween('created_at', [$currentBillingStart, $currentBillingEnd])
                    ->count();

                $unlockedSubcontractorCount = UnlockSubcontractorProject::where('user_id', $userId->id)
                    ->where('user_type', $userType)
                    ->whereBetween('created_at', [$currentBillingStart, $currentBillingEnd])
                    ->count();

                $unlockedThisMonth = $unlockedContractorCount + $unlockedSubcontractorCount;

                // Determine unlock limit
                $planId = $userSubscription->plan_id;
                $unlockLimit = match (true) {
                    in_array($planId, [1, 2]) => 2,
                    in_array($planId, [3, 4]) => 5,
                    in_array($planId, [5, 6]) => null, // unlimited
                    default => 0,
                };

                // Decide whether user can unlock this project
                if (is_null($unlockLimit) || $unlockedThisMonth < $unlockLimit) {
                    $unlockProject = true;
                }
            }
        }

        // Final view decision
        $canView = $unlockedProject && $unlockProject;

        return view($canView ? 'front.projectdetils' : 'front.projectdetilslock', compact(
            'userId',
            'subcontractorReviews',
            'contractorReviews',
            'averageRating',
            'userType',
            'project',
            'projectTypes',
            'portfolio',
            'projectCount',
            'contractorProjects',
            'unlockProject'
        ));
    }


    public function subcontractorsearch(Request $request)
    {

        $userEmailAlerts = 0;
        $userLogin = null;

        $radiusKm = 5;

        $lat = $request->input('lat');
        $lng = $request->input('lng');

        $lat = $request->filled('lat') ? $request->input('lat') : null;
        $lng = $request->filled('lng') ? $request->input('lng') : null;

        // normalise empty strings / 'null'
        if ($lat === '' || $lat === 'null') $lat = null;
        if ($lng === '' || $lng === 'null') $lng = null;

        $isPaginationOrAjax = $request->ajax() || $request->has('page');

        // 1) Fresh coords were supplied in this request → save & use
        if (is_numeric($lat) && is_numeric($lng)) {
            session(['lat' => $lat, 'lng' => $lng]);
        }
        // 2) No coords in this request:
        else {
            if ($isPaginationOrAjax) {
                // follow‑up request: fall back to what we stored earlier
                $lat = session('lat');
                $lng = session('lng');
            } else {
                // brand‑new visit: wipe any stale coords
                session()->forget(['lat', 'lng']);
                $lat = $lng = null;
            }
        }

        // BASE QUERY
        $query = SubContractor::query();
        $sortBy = $request->sort_by ?? 'latest';

        if (is_numeric($lat) && is_numeric($lng)) {
            Log::info("Radius filter ON  |  lat=$lat lng=$lng r={$radiusKm}km");
            $query->withinRadius($lat, $lng, $radiusKm);
        } else {
            Log::info("Radius filter OFF |  plain listing");
        }

        if (Auth::guard('contractor')->check()) {
            $userEmailAlerts = Auth::guard('contractor')->user()->email_alerts;
            $userLogin = Auth::guard('contractor')->user();
        } elseif (Auth::guard('subcontractor')->check()) {
            $userEmailAlerts = Auth::guard('subcontractor')->user()->email_alerts;
            $userLogin = Auth::guard('subcontractor')->user();
        }

        // Other filters
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if ($request->filled('availability')) {
            $query->where('availability', 'like', '%' . $request->availability . '%');
        }
        if ($request->filled('project')) {
            $query->where('contact_name', 'like', '%' . $request->project . '%');
        }

        $tradeCategory = null;
        if ($request->filled('trade_category')) {
            $tradeCategory = $request->trade_category;
            $query->whereJsonContains('trade_category', $tradeCategory);
        }

        // Sort
        $query->orderBy('created_at', $sortBy === 'latest' ? 'desc' : 'asc');

        // Auth
        $userLogin = null;
        $userEmailAlerts = 0;
        if (Auth::guard('contractor')->check()) {
            $userLogin = Auth::guard('contractor')->user();
            $userEmailAlerts = $userLogin->subcontractor_email_alerts;
        } elseif (Auth::guard('subcontractor')->check()) {
            $userLogin = Auth::guard('subcontractor')->user();
            $userEmailAlerts = $userLogin->subcontractor_email_alerts;
        }

        // Final paginated results
        $subcontractors = $query->paginate(10)->withQueryString();

        // Reviews
        $subcontractorReviews = ReviewContractor::with('user')
            ->latest()
            ->where('project_type', 'subcontractor_project')
            ->get()
            ->map(function ($r) {
                $avg = collect([$r->workmanship, $r->integrity, $r->presentation, $r->communication])->avg();
                $r->average_rating = round($avg, 2);
                return $r;
            })
            ->sortByDesc('average_rating')
            ->values();

        // AJAX
        if ($request->ajax()) {
            $html = view('front.subcontractor_partial', compact(
                'subcontractorReviews',
                'subcontractors',
                'userEmailAlerts',
                'sortBy'
            ))->render();

            return response()->json(['html' => $html, 'param' => $request->all()]);
        }

        return view('front.principalContractor', [
            'subcontractorReviews' => $subcontractorReviews,
            'tradeCategory'        => $tradeCategory,
            'expertise_in'         => Expertise::all(),
            'subcontractors'       => $subcontractors,
            'userEmailAlerts'      => $userEmailAlerts,
            'sortBy'               => $sortBy,
            'userLogin'            => $userLogin,
            'locations'            => Location::all(),
        ]);
    }




    public function jobSearch(Request $request)
    {
        $userType     = $this->getUserType();
        $locationName = $request->input('location');
        $projectTerm  = $request->input('project') ?? null;
        $radius       = 50;


        $lat = $request->input('lat');
        $lng = $request->input('lng');

        $distanceSelect = '*, ST_Distance_Sphere(point(lng, lat), point(?, ?)) AS distance';
        $distanceWhere  = 'ST_Distance_Sphere(point(lng, lat), point(?, ?)) <= ?';
        $bind           = [$lng, $lat, $radius];            // used twice below

        if ($userType === 'contractor') {
            // $subcontractors = SubContractor::selectRaw($distanceSelect, [$lng, $lat])
            //     ->whereRaw($distanceWhere, $bind)
            //     ->when(
            //         $projectTerm,
            //         fn($q) =>
            //         $q->where('contact_name', 'like', "%$projectTerm%")
            //     )
            //     ->orderBy('distance')
            //     ->paginate(10);

            return redirect()->route('front.subcontractorsearch', [
                // 'location' => $locationName,
                'project'  => $projectTerm,
                'lat'      => $lat,      // ← add
                'lng'      => $lng,      // ← add
            ]);
        }

        if ($userType === 'subcontractor') {
            $projects = ContractorProject::selectRaw($distanceSelect, [$lng, $lat])
                ->whereRaw($distanceWhere, $bind)
                ->when(
                    $projectTerm,
                    fn($q) =>
                    $q->where('project_name', 'like', "%$projectTerm%")
                )
                ->orderBy('distance')
                ->paginate(10);

            return redirect()->route('front.projectSearch', [
                'project'  => $projectTerm,
                'lat'      => $lat,      // ← add
                'lng'      => $lng,      // ← add
            ]);
        }

        $projects = ContractorProject::selectRaw($distanceSelect, [$lng, $lat])
            ->whereRaw($distanceWhere, $bind)
            ->when(
                $projectTerm,
                fn($q) =>
                $q->where('project_name', 'like', "%$projectTerm%")
            )
            ->orderBy('distance')
            ->paginate(10);

        $subcontractors = SubContractor::selectRaw($distanceSelect, [$lng, $lat])
            ->whereRaw($distanceWhere, $bind)
            ->when(
                $projectTerm,
                fn($q) =>
                $q->where('contact_name', 'like', "%$projectTerm%")
            )
            ->orderBy('distance')
            ->paginate(10);

        $projCnt  = $projects->total();
        $subCnt   = $subcontractors->total();

        if ($projCnt && !$subCnt) {
            return redirect()->route('front.projectSearch', [
                'project'  => $projectTerm,
                'lat'      => $lat,      // ← add
                'lng'      => $lng,      // ← add
            ]);
        }

        if ($subCnt && !$projCnt) {
            return redirect()->route('front.subcontractorsearch', [
                'project'  => $projectTerm,
                'lat'      => $lat,      // ← add
                'lng'      => $lng,      // ← add
            ]);
        }

        // Both lists have results (or both empty) → default to project view
        return redirect()->route('front.projectSearch', [
            'project'  => $projectTerm,
            'lat'      => $lat,      // ← add
            'lng'      => $lng,      // ← add
        ]);
    }

    public function projectdetilslock($id)
    {
        $project = ContractorProject::with('contractor')->findOrFail($id);
        return view('front.projectdetilslock', compact('project'));
    }

    public function unlockproject($id)
    {
        $userId = $this->userLogin;
        $userType = $this->getUserType();
        session(['project_id' => $id, 'user_type' => $userType]);

        $unloackedProject = UnlockedProject::where('user_id', $userId->id)
            ->where('user_type', $userType)
            ->where('project_id', $id)
            ->first();

        $unlockProject = false;

        $userSubcription = UserSubscription::where('user_id', $userId->id)
            ->where('is_active', 1)
            ->where('user_type', $userType)
            ->latest()
            ->first();

        if ($userSubcription != null) {
            $unloackedProjectCount = UnlockedProject::where('user_id', $userId->id)
                ->where('user_type', $userType)
                ->count();

            $now = now();
            $startDate = $userSubcription->start_date;
            $endDate = $userSubcription->end_date;

            $monthsSinceStart = $startDate->diffInMonths($now);

            $currentBillingStart = $startDate->copy()->addMonths($monthsSinceStart);
            $currentBillingEnd = $currentBillingStart->copy()->addMonth();

            $unlockedContractorProjectThisMonth = UnlockedProject::where('user_id', $userId->id)
                ->where('user_type', $userType)
                ->whereBetween('created_at', [$currentBillingStart, $currentBillingEnd])
                ->count();

            $unlockedSubcontractorProjectThisMonth = UnlockSubcontractorProject::where('user_id', $userId->id)
                ->where('user_type', $userType)
                ->whereBetween('created_at', [$currentBillingStart, $currentBillingEnd])
                ->count();

            $unlockedThisMonth = $unlockedContractorProjectThisMonth + $unlockedSubcontractorProjectThisMonth;

            $planId = $userSubcription->plan_id;
            $unlockLimit = null;

            if (in_array($planId, [1, 2])) {
                $unlockLimit = 2;
            } elseif (in_array($planId, [3, 4])) {
                $unlockLimit = 5;
            } elseif (in_array($planId, [5, 6])) {
                $unlockLimit = null; // Unlimited
            }

            // Final decision
            if ($endDate >= $now) {
                if (is_null($unlockLimit) || $unlockedThisMonth < $unlockLimit) {
                    $unlockProject = true;
                }
            }
        }


        if ($unlockProject == false) {
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
                            'name' => 'Extra Contact Unlock',
                        ],
                        'unit_amount' => 9 * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'allow_promotion_codes' => true,
                'success_url' => route('front.handleStripePaymentProject') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe.cancel'),
                // 'metadata' => [
                //     'plan_key' => , // make sure your Plan model has a unique plan_key
                // ],
            ]);

            return redirect($session->url);
        }

        $uloackedProject = new UnlockedProject();
        $uloackedProject->user_id = $userId->id;
        $uloackedProject->project_id = $id;
        $uloackedProject->user_type = $userType;
        $uloackedProject->save();

        return redirect()->route('front.projectDetils', $id)->with([
            'userId' => $userId,
            'userType' => $userType,
        ]);
    }

    public function handleStripePaymentProject(Request $request)
    {
        $sessionId = $request->get('session_id');
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::retrieve($sessionId);

        if ($session->payment_status === 'paid') {
            // Payment is successful, unlock the project
            $userId = $this->userLogin;
            $userType = $this->getUserType();
            $projectId = session('project_id');

            $additionalPay = new AdditionalPay();
            $additionalPay->user_id = $userId->id;
            $additionalPay->user_type = $userType;
            $additionalPay->payable_type = 'unlock_contact';
            $additionalPay->is_over = 1;
            $additionalPay->price = 9;
            $additionalPay->stripe_session_id = $sessionId;
            $additionalPay->save();

            // Save the unlock information
            $uloackedProject = new UnlockedProject();
            $uloackedProject->user_id = $userId->id;
            $uloackedProject->project_id = $projectId;
            $uloackedProject->user_type = $userType;
            $uloackedProject->save();

            return redirect()->route('front.projectDetils', $projectId);
            // ->with('success', 'Project unlocked successfully!');
        } else {
            return redirect('/')->with('error', 'Payment failed. Please try again.');
        }
    }

    public function unlockSubcontractorProject($id)
    {
        $userId = $this->userLogin;
        $userType = $this->getUserType();
        session(['project_id' => $id, 'user_type' => $userType]);

        $unlockProject = false;
        $userSubcription = UserSubscription::where('user_id', $userId->id)
            ->where('is_active', 1)
            ->where('user_type', $userType)
            ->latest()
            ->first();

        if ($userSubcription != null) {
            $unloackedProjectCount = UnlockSubcontractorProject::where('user_id', $userId->id)
                ->where('user_type', $userType)
                ->count();

            $now = now();
            $startDate = $userSubcription->start_date;
            $endDate = $userSubcription->end_date;

            $monthsSinceStart = $startDate->diffInMonths($now);

            $currentBillingStart = $startDate->copy()->addMonths($monthsSinceStart);
            $currentBillingEnd = $currentBillingStart->copy()->addMonth();

            $unlockedContractorProjectThisMonth = UnlockedProject::where('user_id', $userId->id)
                ->where('user_type', $userType)
                ->whereBetween('created_at', [$currentBillingStart, $currentBillingEnd])
                ->count();

            $unlockedSubcontractorProjectThisMonth = UnlockSubcontractorProject::where('user_id', $userId->id)
                ->where('user_type', $userType)
                ->whereBetween('created_at', [$currentBillingStart, $currentBillingEnd])
                ->count();

            $unlockedThisMonth = $unlockedContractorProjectThisMonth + $unlockedSubcontractorProjectThisMonth;

            $planId = $userSubcription->plan_id;
            $unlockLimit = null;

            if (in_array($planId, [1, 2])) {
                $unlockLimit = 2;
            } elseif (in_array($planId, [3, 4])) {
                $unlockLimit = 5;
            } elseif (in_array($planId, [5, 6])) {
                $unlockLimit = null; // Unlimited
            }
            // Final decision
            if ($endDate >= $now) {
                if (is_null($unlockLimit) || $unlockedThisMonth < $unlockLimit) {
                    $unlockProject = true;
                }
            }
        }

        if ($unlockProject == false) {
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
                            'name' => 'Extra Contact Unlock',
                        ],
                        'unit_amount' => 9 * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'allow_promotion_codes' => true,
                'success_url' => route('front.handleStripePayment') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe.cancel'),
                // 'metadata' => [
                //     'plan_key' => , // make sure your Plan model has a unique plan_key
                // ],
            ]);

            return redirect($session->url);
        }


        $uloackedProject = new UnlockSubcontractorProject();
        $uloackedProject->user_id = $userId->id;
        $uloackedProject->project_id = $id;
        $uloackedProject->user_type = $userType;
        $uloackedProject->save();

        return redirect()->route('front.subcontractorprojectdetils', $id);
    }

    public function handleStripePayment(Request $request)
    {
        $sessionId = $request->get('session_id');
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::retrieve($sessionId);

        if ($session->payment_status === 'paid') {
            // Payment is successful, unlock the project
            $userId = $this->userLogin;
            $userType = $this->getUserType();
            $projectId = session('project_id');

            $additionalPay = new AdditionalPay();
            $additionalPay->user_id = $userId->id;
            $additionalPay->user_type = $userType;
            $additionalPay->payable_type = 'unlock_contact';
            $additionalPay->is_over = 1;
            $additionalPay->price = 9;
            $additionalPay->stripe_session_id = $sessionId;
            $additionalPay->save();

            // Save the unlock information
            $unlockedProject = new UnlockSubcontractorProject();
            $unlockedProject->user_id = $userId->id;
            $unlockedProject->project_id = $projectId;
            $unlockedProject->user_type = $userType;
            $unlockedProject->save();

            return redirect()->route('front.subcontractorprojectdetils', $projectId);
            // ->with('success', 'Project unlocked successfully!');
        } else {
            return redirect('/')->with('error', 'Payment failed. Please try again.');
        }
    }

    public function subcontractorprojectdetilslock($id)
    {
        $project = SubContractor::findOrfail($id);
        return view('front.subcontractorprojectdetilslock', compact('project'));
    }

    public function subcontractorprojectdetils($id)
    {
        $userId = $this->userLogin;
        $userType = $this->getUserType();
        $averageRating = null;

        $project = SubContractor::findOrFail($id);
        $projectTypes = $project->project_type_models;
        $portfolio = SubContractor::with('subContractorProtfolio', 'certifications')->find($id);
        $portfolioCount = SubContractorProtfolio::where('user_id', $id)->count();
        $contractorProjects = ContractorProject::with('contractor')->get();

        $profileCount = new ProfileView();
        $profileCount->user_id = $userId->id;
        $profileCount->user_type = $userType;
        $profileCount->profile_id = $project->id;
        $profileCount->profile_type = 'subcontractor_project';
        $profileCount->save();

        // Fetch reviews
        $contractorReviews = ReviewContractor::where('project_id', $id)
            ->where('project_type', 'subcontractor_project')
            ->with('user')
            ->get();

        $subcontractorReviews = ReviewSubContractor::where('project_id', $id)
            ->where('project_type', 'subcontractor_project')
            ->with('user')
            ->get();

        $mergedReviews = $contractorReviews->merge($subcontractorReviews);

        // Ratings for average
        $ratings = collect();
        foreach ($contractorReviews as $review) {
            $ratings = $ratings->merge([
                $review->workmanship,
                $review->integrity,
                $review->presentation,
                $review->communication,
            ]);
        }
        foreach ($subcontractorReviews as $review) {
            $ratings = $ratings->merge([
                $review->quality_of_projects,
                $review->communication_of_works,
                $review->payment_terms,
                $review->support_staff,
            ]);
        }

        $filteredRatings = $ratings->filter(fn($v) => $v !== null);
        $averageRating = $filteredRatings->isNotEmpty()
            ? round($filteredRatings->avg(), 1)
            : null;

        $reviews = ReviewSubContractor::where('project_id', $id)
            ->where('project_type', 'subcontractor_project')
            ->get();

        // If user not logged in
        if (!$userId) {
            $unlockProject = false;
            return view('front.subcontractorprojectdetilslock', compact(
                'userId',
                'userType',
                'subcontractorReviews',
                'contractorReviews',
                'averageRating',
                'mergedReviews',
                'reviews',
                'project',
                'unlockProject',
                'projectTypes',
                'portfolio',
                'portfolioCount',
                'contractorProjects'
            ));
        }

        // Check if already unlocked
        $unlockedProject = UnlockSubcontractorProject::where('user_id', $userId->id)
            ->where('user_type', $userType)
            ->where('project_id', $id)
            ->first();

        // Get active subscription
        $userSubscription = UserSubscription::where('user_id', $userId->id)
            ->where('user_type', $userType)
            ->where('is_active', 1)
            ->latest()
            ->first();

        $unlockProject = false;
        if ($userSubscription) {
            $now = now();
            $startDate = $userSubscription->start_date;
            $endDate = $userSubscription->end_date;
            $monthsSinceStart = $startDate->diffInMonths($now);
            $billingStart = $startDate->copy()->addMonths($monthsSinceStart);
            $billingEnd = $billingStart->copy()->addMonth();

            $contractorUnlocks = UnlockedProject::where('user_id', $userId->id)
                ->where('user_type', $userType)
                ->whereBetween('created_at', [$billingStart, $billingEnd])
                ->count();

            $subcontractorUnlocks = UnlockSubcontractorProject::where('user_id', $userId->id)
                ->where('user_type', $userType)
                ->whereBetween('created_at', [$billingStart, $billingEnd])
                ->count();

            $unlocksThisMonth = $contractorUnlocks + $subcontractorUnlocks;

            // Determine unlock limit
            $planId = $userSubscription->plan_id;
            $unlockLimit = match (true) {
                in_array($planId, [1, 2]) => 2,
                in_array($planId, [3, 4]) => 5,
                in_array($planId, [5, 6]) => null, // unlimited
                default => 0,
            };

            $unlockProject = false;
            if ($now <= $endDate) {
                if (is_null($unlockLimit) || $unlocksThisMonth < $unlockLimit) {
                    $unlockProject = true;
                }
            }
        }

        // Final view
        if ($unlockedProject) {
            return view('front.subcontractorprojectdetils', compact(
                'userId',
                'userType',
                'subcontractorReviews',
                'contractorReviews',
                'averageRating',
                'mergedReviews',
                'reviews',
                'project',
                'portfolio',
                'portfolioCount',
                'projectTypes',
                'contractorProjects'
            ));
        } else {
            return view('front.subcontractorprojectdetilslock', compact(
                'userId',
                'userType',
                'subcontractorReviews',
                'contractorReviews',
                'averageRating',
                'mergedReviews',
                'reviews',
                'project',
                'unlockProject',
                'portfolio',
                'portfolioCount',
                'projectTypes',
                'contractorProjects'
            ));
        }
    }


    public function contractor(Request $request)
    {
        return view('front.contractor');
    }

    public function subcontractor(Request $request)
    {
        return view('front.subcontractor');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateEmailAlerts(Request $request)
    {
        $emailAlerts = $request->email_alerts;
        if (Auth::guard('contractor')->check()) {
            $userType = 'contractor';
            $userId = Auth::guard('contractor')->id();
        } elseif (Auth::guard('subcontractor')->check()) {
            $userType = 'subcontractor';
            $userId = Auth::guard('subcontractor')->id();
        }
        if ($userType === 'contractor') {
            $user = Contractor::find($userId);
        } elseif ($userType === 'subcontractor') {
            $user = Subcontractor::find($userId);
        } else {
            return response()->json(['message' => 'Invalid user type'], 400);
        }

        if (isset($request->email_alerts)) {
            $user->email_alerts = $request->email_alerts;
        } elseif (isset($request->subcontractor_email_alerts)) {
            $user->subcontractor_email_alerts = $request->subcontractor_email_alerts;
        }

        if ($user) {
            $user->save();
            return response()->json(['message' => 'Email alert settings updated successfully!']);
        }
        return response()->json(['message' => 'User not found'], 404);
    }




    public function sendEnquiryMail(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'description' => 'required|string',
            'phone' => 'required|string|max:10',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $message = $request->input('description');  // The message from the textarea
        $url = $request->input('url');  // Or any other URL you want to pass
        try {
            Mail::to('maan81150@gmail.com')->send(new SendEnquireMail($name, $email, $phone, $message, $url));
            return redirect()->back()->with('success', 'Inquiry sent successfully!');
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function markAllAsRead()
    {
        $user = auth('contractor')->user();

        if ($user) {
            $user->unreadNotifications->markAsRead();
        }

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function subContractorMarkAllAsRead()
    {
        $user = auth('subcontractor')->user();

        if ($user) {
            $user->unreadNotifications->markAsRead();
        }

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }
}
