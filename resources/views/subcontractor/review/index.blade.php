@extends('layouts.subcontractor')
@section("title")
Sub Contractor
@endsection

@section('content')
<div class="row mb-5">
   <div class="col-md-6">
      <div class="title">
         <h4>Reviews</h4>
      </div>
   </div>

   <div class="col-md-6">
      <div class="breadcrumb">
         <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Manage Tasks</a></li>
         </ul>
      </div>
   </div>
</div>


<section class="review-dash">
   <div class="inner-slide">
      <div class="top-label">
         <img src="{{ asset('assets/images/order.png') }}" alt="">
         <p>Rate Subcontractor</p>
      </div>

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

            <p>Project: <b>Dylan's Mowing</b></p>


            <div class="ratimg">
               <div class="number">
                  5.0
               </div>

               <div class="star">
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="link">
         <a href="#">Leave a Review </a>
      </div>
   </div>
   <div class="inner-slide">
      <div class="inner-wrapper">
         <div class="image">
            <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">
         </div>

         <div class="content">
            <h6>Tom Smith </h6>

            <ul>
               <li>Electrician</li>
               <li>
                  <i class="fa-solid fa-location-dot"></i> San Francisco
               </li>
            </ul>
            <p>Project: <b>Dylan's Mowing</b></p>

            <div class="ratimg">
               <div class="number">
                  5.0
               </div>

               <div class="star">
                  <i class="fa-solid fa-star"></i>
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

      <div class="delete">
         <img src="{{ asset('assets/images/delete.png') }}" alt="" class="img-fluid">
      </div>
   </div>
</section>


@endsection
