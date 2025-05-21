<?php

namespace App\Http\Controllers\SubContractor;

use App\Http\Controllers\Controller;
use App\Models\SubContractor;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth::guard('contractor')->user()->id ?? auth::guard('subcontractor')->user()->id;
        $userType = auth::guard('contractor')->user() ? 'contractor' : 'subcontractor';

        // $projects = ContractorProject::where('contractor_id', $userId)->count();

        // $reviewedProjects = ReviewContractor::where('user_id', $userId)->where('user_type', 'contractor')->count();

        $userSubcriptions = UserSubscription::where('user_id', $userId)->where('user_type', $userType)->with('plan')->get();

        $subContractor = SubContractor::where('id', Auth::guard('subcontractor')->id())->first();

        return view("subcontractor.dashboard.index", compact('subContractor','userSubcriptions'));
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
