<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\AdditionalPay;
use App\Models\Contractor;
use App\Models\ContractorProject;
use App\Models\Note;
use App\Models\ProfileView;
use App\Models\ReviewContractor;
use App\Models\ReviewSubContractor;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $userId = auth::guard('contractor')->user()->id ?? auth::guard('subcontractor')->user()->id;
        $userType = auth::guard('contractor')->user() ? 'contractor' : 'subcontractor';

        $Contractor = Contractor::where('id', $userId)->first();

        $projects = ContractorProject::where('contractor_id', $userId)->count();

        $ContractorProjects = ContractorProject::where('contractor_id', $userId)->get();

        $reviewedContractor = 0;
        $reviewedSubContractor = 0;

        foreach ($ContractorProjects as $project) {
            if (ReviewContractor::where('project_id', $project->id)
                ->where('project_type', 'contractor_project')
                ->exists()
            ) {
                $reviewedContractor++;
            }

            if (ReviewSubContractor::where('project_id', $project->id)
                ->where('project_type', 'contractor_project')
                ->exists()
            ) {
                $reviewedSubContractor++;
            }
        }

        $reviewedProjects = $reviewedContractor + $reviewedSubContractor;

        $completedProjects = ReviewContractor::where('user_id', $userId)->where('user_type', $userType)->count();
        $completedSubContractorProjects = ReviewSubContractor::where('user_id', $userId)->where('user_type', $userType)->count();
        $completedProjects = $completedProjects + $completedSubContractorProjects;

        $userSubcriptions = UserSubscription::where('user_id', $userId)->where('user_type', $userType)->with('plan')->get();
        $userAdditionalPays = AdditionalPay::where('user_id', $userId)->where('user_type', $userType)->get();

        $notes = Note::where('user_id', $userId)->where('user_type', $userType)->get();


        $period = request()->get('period', '6_months');

        switch ($period) {
            case '1_month':
                $fromDate = Carbon::now()->subMonth();
                $groupFormat = '%Y-%m-%d'; // group by day
                break;
            case '3_months':
                $fromDate = Carbon::now()->subMonths(3);
                $groupFormat = '%Y-%m';
                break;
            case '1_year':
                $fromDate = Carbon::now()->subYear();
                $groupFormat = '%Y-%m';
                break;
            default:
                $fromDate = Carbon::now()->subMonths(6);
                $groupFormat = '%Y-%m';
        }

        $chartViews = ProfileView::select(
            DB::raw("DATE_FORMAT(created_at, '{$groupFormat}') as period"),
            DB::raw('COUNT(*) as count')
        )
            ->where('profile_type', 'contractor_project')
            ->where('profile_id', $userId)
            ->where('created_at', '>=', $fromDate)
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $chartLabels = $chartViews->pluck('period');
        $chartData = $chartViews->pluck('count');


        return view("contractor.dashboard.index", compact(
            'Contractor',
            'userType',
            'projects',
            'reviewedProjects',
            'userSubcriptions',
            'completedProjects',
            'userAdditionalPays',
            'notes',
            'chartLabels',
            'chartData',
            'period'
        ));
    }


    public function profileViewsData(Request $request)
    {
        $period = $request->get('period', '6_months');

        $userId = auth::guard('contractor')->user()->id ?? auth::guard('subcontractor')->user()->id;
        $userType = auth::guard('contractor')->user() ? 'contractor' : 'subcontractor';

        // choose date range + grouping format
        [$fromDate, $groupFmt] = match ($period) {
            '1_month'   => [Carbon::now()->subMonth(),  '%Y-%m-%d'],
            '3_months'  => [Carbon::now()->subMonths(3), '%Y-%m'],
            '1_year'    => [Carbon::now()->subYear(),   '%Y-%m'],
            default     => [Carbon::now()->subMonths(6), '%Y-%m'],
        };

        $views = ProfileView::select(
            DB::raw("DATE_FORMAT(created_at,'$groupFmt') as period"),
            DB::raw('COUNT(*) as count')
        )
            ->where('profile_type', 'contractor_project')
            ->where('profile_id', $userId)           // << your fixed project id
            ->where('created_at', '>=', $fromDate)
            ->groupBy('period')
            ->orderBy('period')
            ->get();
        $labels = $views->pluck('period')->map(function ($date) use ($groupFmt) {
            return strlen($date) === 7
                ? Carbon::createFromFormat('Y-m', $date)->format('F')   // "May"
                : Carbon::createFromFormat('Y-m-d', $date)->format('d M'); // "22 May"
        });

        return response()->json([
            'labels' => $labels,
            'data'   => $views->pluck('count'),
        ]);
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
}
