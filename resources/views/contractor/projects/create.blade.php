@extends('layouts.contractor')
@section("title")
Create New Project
@endsection

@section('content')
<div class="row mb-3">
   <div class="col-md-6">
      <div class="title">
         <h4>
            Add New Project
         </h4>
      </div>
   </div>

   <div class="col-md-6">
      <div class="breadcrumb">
         <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Add New</a></li>
         </ul>
      </div>
   </div>
</div>

<section class="project-adding">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <form>
               <div class="wrapper">
                  <legend> <span></span> Add Project</legend>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-inner">
                           <label for="exampleInputEmail1" class="form-label">Project Name</label>
                           <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                     </div>


                     <div class="col-md-6">
                        <div class="form-inner">
                           <label for="exampleInputPassword1" class="form-label">Location</label>
                           <select class="form-select" aria-label="Default select example">
                              <option selected="">United States</option>
                              <option value="1">One</option>
                              <option value="2">Two</option>
                              <option value="3">Three</option>
                           </select>
                        </div>
                     </div>


                     <div class="col-12">
                        <div class="form-inner">
                           <label for="floatingTextarea">Description</label>
                           <div>
                              <textarea class="form-control" rows="6" id="floatingTextarea" placeholder="Enter text here"></textarea>
                           </div>
                        </div>
                     </div>

                  </div>



                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-inner">
                           <label for="exampleInputEmail1" class="form-label">ABN</label>
                           <input type="text" class="form-control" id="" placeholder="85637669305" aria-describedby="emailHelp">
                        </div>

                     </div>
                     <div class="col-md-6">
                        <div class="form-inner">
                           <label for="exampleInputEmail1" class="form-label">License</label>
                           <input type="text" class="form-control" id="" placeholder="79252" aria-describedby="emailHelp">
                        </div>
                     </div>


                     <div class="col-md-6">
                        <div class="form-inner">
                           <label for="exampleInputEmail1" class="form-label">
                              Electrician Services</label>
                           <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Search">
                        </div>
                     </div>
                  </div>

                  <div class="col-12">
                     <div class="list">
                        <ul>
                           <li>
                              <div>Lighting</div>
                           </li>
                           <li>
                              <div>Cabling</div>
                           </li>
                           <li>
                              <div>Decommissioning</div>
                           </li>
                           <li>
                              <div>Power</div>
                           </li>
                           <li>
                              <div>Repairs</div>
                           </li>
                           <li>
                              <div>Rough-in &amp; Fitoff</div>
                           </li>
                           <li>
                              <div>Smoke Detectors</div>
                           </li>
                        </ul>

                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label"> Budget</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="$400-$600">
                     </div>
                  </div>

               </div>

               <div class="form-btn">
                  <a href="#">Cancel</a>
                  <a href="#">Post</a>
               </div>

            </form>
         </div>
      </div>
   </div>
</section>



@endsection
