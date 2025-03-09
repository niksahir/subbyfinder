@extends('layouts.subcontractor')
@section("title")
Sub Contractor
@endsection

@section('content')
<div class="row mb-3">
   <div class="col-md-6">
      <div class="title">
         <h4>
            Wallet
         </h4>
      </div>
   </div>

   <div class="col-md-6">
      <div class="breadcrumb">
         <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Dashboard</a></li>
         </ul>
      </div>
   </div>
</div>

<section class="chart-sec">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-7">
            <div class="chart-wrapper">
               <div class="top-bar">
                  <h6>
                     <img src="{{ asset('assets/images/develop.png') }}" alt=""> Earning Analysis
                  </h6>
                  <div class="dropdown">
                     <a class="btn    dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Last 6 Months
                     </a>

                     <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Last 1 Months</a></li>
                        <li><a class="dropdown-item" href="#">Last 3 Months</a></li>
                        <li><a class="dropdown-item" href="#">last 1 year</a></li>
                     </ul>
                  </div>
               </div>

               <div class="col-12">
                  <div class="chart-image">
                     <img src="{{ asset('assets/images/chart.png') }}" alt="" class="img-fluid">
                  </div>
               </div>
            </div>
         </div>

         <div class="col-md-5">
            <div class="blance">
               <h6>Withdrawal Balance</h6>
               <h3>$2880</h3>

               <div class="button-full">
                  <a href="#">Withdrawal</a>
               </div>
            </div>


            <div class="blance">
               <h6>Total Earning</h6>
               <h3>$4000</h3>
            </div>
         </div>

         <div class="col-12">
            <div class="table-wrapper table-responsive w-100 pb-5 mb-5  ">
               <h5>Payment History</h5>

               <table class="table table-bordered">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Transaction Id</th>
                        <th>Date</th>
                        <th>Company Name</th>
                        <th>Project Name</th>
                        <th>Amount</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>1</td>
                        <td>T234567865</td>
                        <td>24 Jan 2025</td>
                        <td><img src="{{ asset('assets/images/company-name.png') }}" alt="" class="img-fluid"></td>
                        <td>Dylan's Mowing</td>
                        <td>$100 </td>
                     </tr>
                     <tr>
                        <td>2</td>
                        <td>T234567865</td>
                        <td>24 Jan 2025</td>
                        <td><img src="{{ asset('assets/images/company-name.png') }}" alt="" class="img-fluid"></td>
                        <td>Dylan's Mowing</td>
                        <td>$100 </td>
                     </tr>

                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</section>


@endsection
