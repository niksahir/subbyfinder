@extends('layouts.subcontractor')
@section("title")
Sub Contractor
@endsection

@section('content')
<div class="row">
   <div class="col-md-6">
      <div class="title">
         <h4>Settings</h4>
      </div>
   </div>

   <div class="col-md-6">
      <div class="breadcrumb">
         <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
         </ul>
      </div>
   </div>
</div>

<div class="create-account-sec pt-0">
   <div class="container">
      <div class="wrapper">
         <div class="row">
            <div class="col-12">
               <div class="label"> My Account</div>
            </div>

            <div class="col-md-3">
               <div class="profile">
                  <img src="{{ asset('assets/images/team-3.png') }}" alt="" class="img-fluid">
               </div>
            </div>

            <div class="col-md-9">
               <form>
                  <div class="row g-3">
                     <div class="col-md-6 form-inner">
                        <label class="form-label">Business Name</label>
                        <input type="text" class="form-control" placeholder="Business Name">
                     </div>
                     <div class="col-md-6 form-inner">
                        <label class="form-label">Contact Name</label>
                        <input type="text" class="form-control" placeholder="Contact Name">
                     </div>
                     <div class="col-md-6 form-inner">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" placeholder="Phone">
                     </div>
                     <div class="col-md-6 form-inner">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="Email">
                     </div>
                     <div class="col-md-6 form-inner">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" placeholder="Address">
                     </div>
                     <div class="col-md-6 form-inner">
                        <label class="form-label">Years In Business</label>
                        <input type="text" class="form-control" placeholder="5 Years">
                     </div>
                     <div class="col-md-6 form-inner">
                        <label class="form-label">Insurances</label>
                        <input type="text" class="form-control" placeholder="9876543234">
                     </div>
                     <div class="col-md-6 form-inner">
                        <label class="form-label">ABN</label>
                        <input type="text" class="form-control" placeholder="83654124106">
                     </div>
                     <div class="col-md-6 form-inner">
                        <label class="form-label">Licenses</label>
                        <input type="text" class="form-control" placeholder="3245678574635">
                     </div>
                     <div class="col-md-6 form-inner">
                        <label class="form-label">Availability</label>
                        <input type="text" class="form-control" placeholder="Immediate Joiner">
                     </div>
                     <div class="col-md-6 form-inner">
                        <label class="form-label">Expertise in</label>
                        <input type="text" class="form-control" placeholder="ABN">
                     </div>
                  </div>

                  <div class="mt-4 col-12">
                     <div class="list">
                        <ul>
                           <li>Lighting</li>
                           <li>Cabling</li>
                           <li>Decommissioning</li>
                           <li>Power</li>
                           <li>Repairs</li>
                           <li>Rough-in &amp; Fitoff</li>
                           <li>Smoke Detectors</li>
                        </ul>
                     </div>
                  </div>


                  <div class="col-md-6 form-inner">
                     <label class="form-label">Equipment Owned</label>
                     <input type="text" class="form-control" placeholder="Search">
                  </div>

                  <div class="mt-4 col-12">
                     <div class="list">
                        <ul>
                           <li>Cranes</li>
                           <li>Concrete pumps</li>
                        </ul>
                     </div>
                  </div>

                  <div class="col-12">
                     <h6>Insurance Coverage</h6>
                  </div>

                  <div class="row">
                     <div class="col-md-6 form-inner">
                        <label class="form-label">Licenses</label>
                        <input type="text" class="form-control" placeholder="3245678574635">
                     </div>

                     <div class="col-md-6 form-inner">
                        <label class="form-label">Availability</label>
                        <input type="text" class="form-control" placeholder="Immediate Joiner">
                     </div>
                  </div>

                  <div class="col-12">
                     <h6>Availability </h6>
                  </div>

                  <div class="row">
                     <div class="col-md-4 ">
                        <input type="date" class="form-control" placeholder="Start date">
                     </div>

                     <div class="col-md-4 ">
                        <input type="date" class="form-control" placeholder="End Date">
                     </div>
                  </div>

               </form>
            </div>
         </div>
      </div>


      <div class="wrapper">
         <div class="description-item">
            <h5 class="">Description</h5>
            <textarea class="form-control" rows="6" placeholder="Enter description here"></textarea>
         </div>

      </div>


      <div class="wrapper">
         <div class="values-item">
            <h5 class="">Certifications &amp; Training</h5>

            <div class="link">
               <a href="#">Add More</a>
            </div>
         </div>

         <div class="upload-cer pt-4">
            <img src="{{ asset('assets/images/certificates.png') }}" alt="" class="img-fluid">
         </div>

      </div>


      <div class="wrapper">
         <div class="values-item pb-4">
            <h5 class=""> Password &amp; Security</h5>
         </div>


         <div class="row">
            <div class="col-md-4 form-inner">
               <label for="">Current Password</label>
               <input type="text" class="form-control" placeholder="">
            </div>

            <div class="col-md-4  form-inner">
               <label for="">New Password</label>
               <input type="text" class="form-control" placeholder=" ">
            </div>
            <div class="col-md-4 form-inner ">
               <label for="">Repeat New Password</label>
               <input type="text" class="form-control" placeholder="">
            </div>

            <div class="col-12">
               <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id=" " checked="">
                  <label class="form-check-label" for="flexCheckChecked">
                     Enable Two-Step Verification via Email
                  </label>
               </div>
            </div>
         </div>

      </div>


      <div class="save-button link">
         <a href="#"> Save Changes</a>
      </div>
   </div>
</div>

@endsection
