<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller {
   /**
    * Display a listing of the resource.
    */
   public function index(Request $request) {
      return view('front.home');
   }

   public function projectSearch(Request $request) {
      return view('front.projectSearch');
   }

   public function projectDetils(Request $request) {
      return view('front.projectdetils');
   }

   public function subcontractorsearch(Request $request) {
      return view('front.principalContractor');
   }

   public function projectdetilslock(Request $request) {
      return view('front.projectdetilslock');
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
