<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
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
use App\Models\SubcontractorProtfolio;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;


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
        return view('front.home', ['userLogin' => $this->userLogin]);
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
        if (Auth::guard('contractor')->check()) {
            $userEmailAlerts = Auth::guard('contractor')->user()->email_alerts;
            $userLogin = Auth::guard('contractor')->user();
        } elseif (Auth::guard('subcontractor')->check()) {
            $userEmailAlerts = Auth::guard('subcontractor')->user()->email_alerts;
            $userLogin = Auth::guard('subcontractor')->user();
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
        $projects = ContractorProject::latest()->paginate(10);
        $locations = Location::all();
        return view('front.projectSearch', compact('expertise_in', 'projects', 'project_types', 'userEmailAlerts', 'sortBy', 'locations', 'userLogin'));
    }

    public function projectDetils($id)
    {
        $userId = $this->userLogin;
        $userType = $this->getUserType();

        $project = ContractorProject::with('contractor')->findOrFail($id);

        $projectTypes = $project->project_type_models;

        $protfolio = SubcontractorProtfolio::get();

        $unloackedProject = UnlockedProject::where('user_id', $userId->id)
            ->where('user_type', $userType)
            ->where('project_id', $id)
            ->first();

        $userSubcription = UserSubscription::where('user_id', $userId->id)
            ->where('is_active', 1)
            ->where('user_type', $userType)
            ->latest()
            ->first();

        if ($userSubcription == null) {
            $unlockProject = false;
            return view('front.projectdetilslock', compact('project', 'unlockProject','projectTypes','protfolio'));
        }
        $unloackedProjectCount = UnlockedProject::where('user_id', $userId->id)
            ->where('user_type', $userType)
            ->count();

        $unlockProject = false;
        $now = now();
        $startDate = $userSubcription->start_date;
        $endDate = $userSubcription->end_date;

        $monthsSinceStart = $startDate->diffInMonths($now);

        $currentBillingStart = $startDate->copy()->addMonths($monthsSinceStart);
        $currentBillingEnd = $currentBillingStart->copy()->addMonth();

        $unlockedThisMonth = UnlockedProject::where('user_id', $userId->id)
            ->whereBetween('created_at', [$currentBillingStart, $currentBillingEnd])
            ->count();

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

        if ($unloackedProject) {
            return view('front.projectdetils', compact('project','projectTypes','protfolio'));
        } else {
            return view('front.projectdetilslock', compact('project', 'unlockProject','projectTypes','protfolio'));
        }
    }

    public function subcontractorsearch(Request $request)
    {

        $query = SubContractor::query();
        $userEmailAlerts = 0;
        $sortBy = $request->sort_by ? $request->sort_by : 'latest';
        $userLogin = null;
        $query->orderBy('created_at', $request->sort_by == 'latest' ? 'desc' : 'asc');

        if (Auth::guard('contractor')->check()) {
            $userEmailAlerts = Auth::guard('contractor')->user()->subcontractor_email_alerts;
            $userLogin = Auth::guard('contractor')->user();
        } elseif (Auth::guard('subcontractor')->check()) {
            $userEmailAlerts = Auth::guard('subcontractor')->user()->subcontractor_email_alerts;
            $userLogin = Auth::guard('subcontractor')->user();
        }
        // Filter by Category
        if ($request->has('trade_category') && !empty($request->trade_category)) {
            $query->whereJsonContains('trade_category', $request->trade_category);
        }

        if ($request->has('location') && !empty($request->location)) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }

        if ($request->has('availability') && !empty($request->availability)) {
            $query->where('availability', 'LIKE', '%' . $request->availability . '%');
        }
        // Get Paginated Results
        $subcontractors = $query->latest()->paginate(10);

        // AJAX Request Handling
        if ($request->ajax()) {
            $html = view('front.subcontractor_partial', compact('subcontractors', 'userEmailAlerts', 'sortBy'))->render();
            return response()->json(['html' => $html, 'param' => $request->all()]);
        }

        $expertise_in = Expertise::all();
        $subcontractors = SubContractor::latest()->paginate(10);
        $locations = Location::all();
        return view('front.principalContractor', compact('expertise_in', 'subcontractors', 'userEmailAlerts', 'sortBy', 'userLogin', 'locations'));
    }

    public function projectdetilslock($id)
    {
        $project = ContractorProject::with('contractor')->findOrFail($id);
        return view('front.projectdetilslock', compact('project'));
    }

    public function unloackproject($id)
    {
        $userId = $this->userLogin;
        $userType = $this->getUserType();

        $uloackedProject = new UnlockedProject();
        $uloackedProject->user_id = $userId->id;
        $uloackedProject->project_id = $id;
        $uloackedProject->user_type = $userType;
        $uloackedProject->save();

        return redirect()->route('front.projectDetils', $id);
    }

    public function unloackSubcontractorProject($id)
    {
        $userId = $this->userLogin;
        $userType = $this->getUserType();

        $uloackedProject = new UnlockSubcontractorProject();
        $uloackedProject->user_id = $userId->id;
        $uloackedProject->project_id = $id;
        $uloackedProject->user_type = $userType;
        $uloackedProject->save();

        return redirect()->route('front.subcontractorprojectdetils', $id);
    }

    public function subcontractorprojectdetilslock($id)
    {
        $project =SubContractor::findOrfail($id);
        return view('front.subcontractorprojectdetilslock',compact('project'));
    }

    public function subcontractorprojectdetils($id)
    {

        $userId = $this->userLogin;
        $userType = $this->getUserType();

        $project = SubContractor::findOrFail($id);
        $projectTypes = $project->project_type_models;
        $protfolio = SubcontractorProtfolio::where('user_id',$id)->get();

        $unloackedProject = UnlockSubcontractorProject::where('user_id', $userId->id)
            ->where('user_type', $userType)
            ->where('project_id', $id)
            ->first();

        $userSubcription = UserSubscription::where('user_id', $userId->id)
            ->where('is_active', 1)
            ->where('user_type', $userType)
            ->latest()
            ->first();

        if ($userSubcription == null) {
            $unlockProject = false;
            return view('front.subcontractorprojectdetils', compact('project', 'unlockProject','projectTypes','protfolio'));
        }
        $unloackedProjectCount = UnlockSubcontractorProject::where('user_id', $userId->id)
            ->where('user_type', $userType)
            ->count();

        $unlockProject = false;
        $now = now();
        $startDate = $userSubcription->start_date;
        $endDate = $userSubcription->end_date;

        $monthsSinceStart = $startDate->diffInMonths($now);

        $currentBillingStart = $startDate->copy()->addMonths($monthsSinceStart);
        $currentBillingEnd = $currentBillingStart->copy()->addMonth();

        $unlockedThisMonth = UnlockSubcontractorProject::where('user_id', $userId->id)
            ->whereBetween('created_at', [$currentBillingStart, $currentBillingEnd])
            ->count();

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
        if($unloackedProject){
            return view('front.subcontractorprojectdetils', compact('project','protfolio')); // Desin not ready
        }else{
            return view('front.subcontractorprojectdetilslock', compact('project', 'unlockProject','protfolio'));
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
}
