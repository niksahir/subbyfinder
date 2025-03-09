@extends('layouts.subcontractor')
@section("title")
Sub Contractor
@endsection

@section('content')
<section class="charting-section">
   <div class="row">
      <div class="col-md-5">
         <div class="left-chat">

            <div class="search">
               <input type="text" placeholder="Search messages" class="form-control">
               <i class="fa-solid fa-magnifying-glass"></i>
            </div>


            <div class="pepoles">
               <div class="inner-item">
                  <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">

                  <div class="content">
                     <h6>Jan Mayer <span>3:40 PM</span></h6>
                     <p>We want to invite you for a qui...</p>
                  </div>
               </div>
               <div class="inner-item">
                  <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">

                  <div class="content">
                     <h6>Jan Mayer <span>3:40 PM</span></h6>
                     <p>We want to invite you for a qui...</p>
                  </div>
               </div>
               <div class="inner-item">
                  <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">

                  <div class="content">
                     <h6>Jan Mayer <span>3:40 PM</span></h6>
                     <p>We want to invite you for a qui...</p>
                  </div>
               </div>
               <div class="inner-item">
                  <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">

                  <div class="content">
                     <h6>Jan Mayer <span>3:40 PM</span></h6>
                     <p>We want to invite you for a qui...</p>
                  </div>
               </div>
               <div class="inner-item">
                  <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">

                  <div class="content">
                     <h6>Jan Mayer <span>3:40 PM</span></h6>
                     <p>We want to invite you for a qui...</p>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="col-md-7">
         <div class="chat-detail">
            <div class="user-topbar">
               <div class="name-with-img">
                  <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">

                  <div class="name">
                     <h6>Jan Mayer</h6>
                     <p>Recruiter at Nomad</p>
                  </div>
               </div>


               <div class="icons">
                  <i class="fa-solid fa-thumbtack"></i>
                  <i class="fa-regular fa-star"></i>
                  <i class="fa-solid fa-ellipsis-vertical"></i>
               </div>

            </div>


            <div class="center-user-info">
               <img src="{{ asset('assets/images/team-2.jpg') }}" alt="">
               <h6>Jan Mayer</h6>
               <p>Recruiter at <span>Nomad</span> </p>
               <p>This is the very beginning of your direct message with <b>Jan Mayer</b></p>

               <div class="today">
                  <p><i class="fa-solid fa-angle-down"></i> Today</p>
               </div>
            </div>



            <div class="send-box-item">
               <input type="text" class="form-control" placeholder="Reply message">
               <i class="fa-solid fa-paperclip"></i>
               <img src="{{ asset('assets/images/smile.png') }}" alt="">
               <button> <i class="fa-solid fa-paper-plane"></i></button>
            </div>

         </div>
      </div>
   </div>



</section>


@endsection
