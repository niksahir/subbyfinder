<?php

namespace App\Http\Controllers\SubContractor;

use App\Http\Controllers\Controller;
use App\Models\ReviewSubContractor;
use App\Models\UnlockedProject;
use App\Models\UnlockSubcontractorProject;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::guard('contractor')->check()) {
            $userType = 'contractor';
            $userId = Auth::guard('contractor')->id();
        } elseif (Auth::guard('subcontractor')->check()) {
            $userType = 'subcontractor';
            $userId = Auth::guard('subcontractor')->id();
        } else {
            return response()->json(['status' => 'Error']);
        }

        $unlockedProjects = UnlockedProject::where('user_id', $userId)
            ->with(['project', 'project.contractor'])
            ->where('user_type', $userType)
            ->get()
            ->map(function ($unlockedProject) {
                // Include the project_type
                $unlockedProject->project_type = 'contractor_project';
                return $unlockedProject;
            });
        $unlockedSubContractorProjects = UnlockSubcontractorProject::where('user_id', $userId)
            ->with('project')
            ->where('user_type', $userType)
            ->get()
            ->map(function ($unlockedSubContractorProject) {
                // Include the project_type
                $unlockedSubContractorProject->project_type = 'subcontractor_project';
                return $unlockedSubContractorProject;
            });

        $reviewProjects = ReviewSubContractor::where('user_id',$userId)->where('user_type',$userType)->get();


        $mergedProjects = $unlockedProjects->merge($unlockedSubContractorProjects)
            ->sortByDesc('created_at')
            ->values(); // reset keys

        $mergedProjects = $unlockedProjects->merge($unlockedSubContractorProjects)
            ->sortByDesc('created_at')
            ->values();

        $currentPage = request()->get('page', 1);
        $perPage = 10;

        // This is what you will loop in Blade
        $projectsToDisplay = $mergedProjects->forPage($currentPage, $perPage);

        // For generating pagination links
        $paginatedProjects = new LengthAwarePaginator(
            $projectsToDisplay,
            $mergedProjects->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        return view("subcontractor.review.index", compact('projectsToDisplay','unlockedProjects','unlockedSubContractorProjects','reviewProjects','paginatedProjects'));
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

        if (Auth::guard('contractor')->check()) {
            $userType = 'contractor';
            $userId = Auth::guard('contractor')->id();
        } elseif (Auth::guard('subcontractor')->check()) {
            $userType = 'subcontractor';
            $userId = Auth::guard('subcontractor')->id();
        } else {
            return response()->json(['status' => 'Error']);
        }

        $subContractorReview = new ReviewSubContractor();
        $subContractorReview->user_id = $userId;
        $subContractorReview->user_type = $userType;
        $subContractorReview->project_id = $request->project_id;
        $subContractorReview->project_type = $request->project_type;
        $subContractorReview->contacted = $request->contacted;
        $subContractorReview->reason_no_contact = $request->reason_no_contact;
        $subContractorReview->agreed = $request->agreed;
        $subContractorReview->dealings_review = $request->dealings_review;
        $subContractorReview->completed = $request->completed;
        $subContractorReview->final_review = $request->final_review;
        $subContractorReview->completion_estimate = $request->completion_estimate;
        $subContractorReview->workmanship = $request->workmanship;
        $subContractorReview->integrity = $request->integrity;
        $subContractorReview->presentation = $request->presentation;
        $subContractorReview->communication = $request->communication;
        $subContractorReview->save();

        return redirect()->route('subcontractor.reviews.index')->with('success', 'Review submitted successfully.');
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
        $review = ReviewSubContractor::find($id);
        if ($review) {
            $review->delete();
            return redirect()->route('subcontractor.reviews.index')->with('success', 'Review deleted successfully.');
        } else {
            return redirect()->route('subcontractor.reviews.index')->with('error', 'Review not found.');
        }
    }
}
