@extends('layouts.contractor')
@section("title")
Contractor Bookmark - Subby Finder
@endsection

@section('content')
<div class="row mb-5">
   <div class="col-md-6">
      <div class="title">
         <h4>Bookmark</h4>
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
            <li><a href="#">Bookmark</a></li>
         </ul>
      </div>
   </div>
</div>


<section class="review-dash">
   <div class="inner-slide">
      <div class="inner-wrapper">
         <div class="image">
            <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">
         </div>

         <div class="content">
            <h6>Tom Smith </h6>

            <ul>
               <li>Electrician</li>
               <li> <i class="fa-solid fa-location-dot"></i> San Francisco</li>
            </ul>

            <div class="ratimg">
               <div class="number">
                  5.0
               </div>

               <div class="star"><i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="buttons">
         <i class="fa-solid fa-bookmark"></i>

         <a href="#">View Profile</a>
         <a href="#">Messages</a>
      </div>
   </div>
   <div class="inner-slide">
      <div class="inner-wrapper">
         <div class="image">
            <img src="{{ asset('assets/images/team-2.jpg') }}" alt="" class="img-fluid">
         </div>

         <div class="content">
            <h6>Tom Smith </h6>

            <ul>
               <li>Electrician</li>
               <li> <i class="fa-solid fa-location-dot"></i> San Francisco</li>
            </ul>

            <div class="ratimg">
               <div class="number">
                  5.0
               </div>

               <div class="star"><i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
               </div>
            </div>

            <p>Excellent programmer - fully carried out my project in a very professional
               manner.</p>
         </div>
      </div>

      <div class="buttons">
         <i class="fa-solid fa-bookmark"></i>

         <a href="#">View Profile</a>
         <a href="#">Messages</a>
      </div>
   </div>
</section>
@endsection
