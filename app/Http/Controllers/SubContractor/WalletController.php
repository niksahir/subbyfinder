<?php

namespace App\Http\Controllers\SubContractor;

use App\Http\Controllers\Controller;
use App\Models\AdditionalPay;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $userSubcriptions = UserSubscription::where('user_id', Auth::guard('subcontractor')->user()->id)->where('user_type', 'subcontractor')->with('plan')->get();
        $userAdditionalPays = AdditionalPay::where('user_id', Auth::guard('subcontractor')->user()->id)->where('user_type', 'subcontractor')->get();

        return view("subcontractor.wallet.index", compact('userSubcriptions', 'userAdditionalPays'));
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
