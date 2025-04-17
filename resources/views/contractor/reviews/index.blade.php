@extends('layouts.contractor')
@section("title")
Contractor Review - Subby Finder
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
            <li>
               <a href="{{ route('contractor.dashboard.index') }}">Home</a>
            </li>
            <li>
               <a href="{{ route('contractor.dashboard.index') }}">Dashboard</a>
            </li>
            <li><a href="#">Reviews</a></li>
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

               <div class="star"><i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
                  <i class="fa-solid fa-star"></i>
               </div>
            </div>
         </div>
      </div>

      <div class="link">
         <a role="button" class="text-white pointer-events-auto" data-bs-toggle="modal" data-bs-target="#exampleModal">Leave a Review </a>
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
               <li> <i class="fa-solid fa-location-dot"></i> San Francisco</li>
            </ul>
            <p>Project: <b>Dylan's Mowing</b></p>

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

      <div class="delete">
         <img src="{{ asset('assets/images/delete.png') }}" alt="" class="img-fluid">
      </div>
   </div>
</section>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Project Name</label>
                        <input type="text" class="form-control" id="name" name="project_name">
                    </div>
                    {{-- <div class="form-inner">
                        <label for="exampleInputPassword1" class="form-label">Location</label>
                        <div class="@error('location') is-invalid @enderror">
                            <select class="form-control js-example-tags" name="location" id="location">
                                <option value="" selected>Select Location</option>
                                @foreach ($locations as $key => $location)
                                    <option value="{{ $location->name }}">
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('location')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> --}}
                    <div class="form-group mb-3">
                        <label for="name">Image</label>
                        <input type="file" class="form-control" id="protfolio_image" name="protfolio_image[]"
                            accept="jpg,jpeg,png" multiple>
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">Description</label>
                        <input type="text" class="form-control" id="description" name="description">
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">Price</label>
                        <input type="text" class="form-control" id="price" name="price">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary " value="Save changes" >
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
