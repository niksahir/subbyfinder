<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expertise;
use App\Models\ContractorProject;

class HomeController extends Controller {
   /**
    * Display a listing of the resource.
    */
   public function index(Request $request) {
      return view('front.home');
   }

   public function projectSearch(Request $request) {

        $query = ContractorProject::query();

        // Search by Location
        if ($request->has('location') && !empty($request->location)) {
            $query->where('location', 'LIKE', '%' . $request->location . '%');
        }

        // Filter by Category
        if ($request->has('trade_category') && !empty($request->trade_category)) {
            $query->whereJsonContains('trade_category', $request->trade_category);
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
            $html = view('front.project_partial', compact('projects'))->render();
            return response()->json(['html' => $html, 'param' => $request->all()]);
        }

        $expertise_in = Expertise::all();
        $projects = ContractorProject::latest()->paginate(10);
        return view('front.projectSearch', compact('expertise_in', 'projects'));
   }

   public function projectDetils(Request $request) {
      return view('front.projectdetils');
   }

   public function subcontractorsearch(Request $request) {
      return view('front.principalContractor');
   }

   public function projectdetilslock($id) {
     $project = ContractorProject::findOrFail($id);
      return view('front.projectdetilslock', compact('project'));
   }

   public function subcontractorprojectdetilslock(Request $request) {
      return view('front.subcontractorprojectdetilslock');
   }

   public function subcontractorprojectdetils(Request $request) {
      return view('front.subcontractorprojectdetils'); // Desin not ready
   }

   public function contractor(Request $request) {
      return view('front.contractor');
   }

   public function subcontractor(Request $request) {
      return view('front.subcontractor');
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
      //
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
