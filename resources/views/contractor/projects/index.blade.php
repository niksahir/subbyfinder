@extends('layouts.contractor')
@section("title")
Projects
@endsection

@section('content')
<div class="row mb-5">
   <div class="col-md-6">
      <div class="title">
         <h4>Projects</h4>
      </div>
   </div>

   <div class="col-md-6">
      <div class="breadcrumb">
         <ul>
            <li>
               <a href="{{ route('contractor.dashboard.index') }}">Home</a>
            </li>
            <li>
               <a href="{{ route('contractor.dashboard.index') }}">Dashboard</a>
            </li>
            <li>
               <a href="#">Bookmark</a>
            </li>
         </ul>
      </div>
   </div>
</div>


<section class="review-dash">
   <div class="inner-slide">
      <div class="top-label">
         <div class="row">
            <div class="col-md-6">
               <img src="{{ asset('assets/images/order.png') }}" alt="">
               <p>Project Listing</p>
            </div>

            <div class="col-md-6">
               <div class="link text-right">
                  <a href="{{ route('contractor.projects.create') }}">Post New</a>
               </div>
            </div>
         </div>
      </div>

      <div class="inner-wrapper">
         <div class="image not-round">
            <img src="{{ asset('assets/images/f-logo.png') }}" alt="" class="img-fluid">
         </div>

         <div class="content">
            <h6>Dylan's Mowing </h6>

            <ul class="">
               <li>Electrician</li>
               <li> <i class="fa-solid fa-location-dot"></i> San Francisco</li>
            </ul>
            <p>Lawn Mowing &amp; Gardening Services</p>

            <span>Gardener</span>


         </div>
      </div>

      <div class="buttons">
         <i class="fa-solid fa-trash"></i>
         <a href="#">View Profile</a>
         <a href="#">Messages</a>
      </div>
   </div>
   <div class="inner-slide">
      <div class="inner-wrapper">
         <div class="image not-round">
            <img src="{{ asset('assets/images/logo2.png') }}" alt="" class="img-fluid">
         </div>

         <div class="content">
            <h6>A2 Electrical Services Pty Ltd </h6>

            <ul class="">
               <li>Electrician</li>
               <li> <i class="fa-solid fa-location-dot"></i> San Francisco</li>
            </ul>
            <p>Always providing professional services, <br> regardless of how big or small the
               job is.</p>

            <span>Electrician</span>
         </div>
      </div>

      <div class="buttons">
         <i class="fa-solid fa-trash"></i>
         <a href="#">View Profile</a>
         <a href="#">Messages</a>
      </div>
   </div>
</section>
@endsection
