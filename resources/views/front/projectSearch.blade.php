@extends('layouts.before')
@section("title")
Project Search - Subby Finder
@endsection

@section("content")

<section class="job-info">
   <div class="container">
      <div class="row">
         <div class="col-md-4">
            <div class="left-sidebar">
               <form>
                  <fieldset>
                     <div class="inner-form">
                        <label for="" class="form-label">Location</label>
                        <input type="text" id="" class="form-control" placeholder="input">
                     </div>
                     <div class="inner-form">
                        <label for="disabledSelect" class="form-label">Category</label>
                        <select id="disabledSelect" class="form-select">
                           <option>All Category</option>
                        </select>
                     </div>
                     <div class="inner-form">
                        <span>$50 - $2,500</span>
                        <label for="customRange2" class="form-label">Budget Range</label>
                        <input type="range" class="form-range" min="0" max="5" id="customRange2">
                     </div>


                     <div class="inner-form">
                        <label for="disabledSelect" class="form-label">Project Type</label>
                        <select id="disabledSelect" class="form-select">
                           <option>Select</option>
                        </select>
                     </div>

                     <div class="inner-form">
                        <label for="disabledSelect" class="form-label">Availability</label>
                        <select id="disabledSelect" class="form-select">
                           <option>Immediate</option>
                        </select>
                     </div>

                     <div class="inner-form">
                        <label for="disabledSelect" class="form-label">Certifications</label>
                        <select id="disabledSelect" class="form-select">
                           <option>OSHA</option>
                        </select>
                     </div>
                     <div class="inner-form">
                        <label for="disabledSelect" class="form-label">Language Proficiency</label>
                        <select id="disabledSelect" class="form-select">
                           <option>Select</option>
                        </select>
                     </div>
                  </fieldset>
               </form>
            </div>
         </div>

         <div class="col-md-8">
            <div class="result">

               <div class="top-bar">
                  <div class="form-check form-switch">
                     <input class="form-check-input" type="checkbox" role="switch"
                        id="flexSwitchCheckChecked">
                     <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox
                        input</label>
                  </div>

                  <div class="filter">
                     <div class="dropdown">
                        <span>Sort by:</span>
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                           Dropdown button
                        </button>
                        <ul class="dropdown-menu">
                           <li><a class="dropdown-item" href="#">Action</a></li>
                           <li><a class="dropdown-item" href="#">Another action</a></li>
                           <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                     </div>
                  </div>
               </div>

               <section class="featured-projects pt-5">
                  <div class="container">
                     <div class="row">
                        <div class="full-list">
                           <div class="col-12">
                              <div class="row">
                                 <div class="col-sm-3">
                                    <div class="p-logo">
                                       <img src="assets/images/f-logo.png" alt="" class="img-fluid">
                                    </div>
                                 </div>

                                 <div class="col-sm-5">
                                    <div class="content">
                                       <h6>Dylan's Mowing</h6>
                                       <ul>
                                          <li><i class="fa-solid fa-location-dot"></i> San Francisco
                                          </li>
                                          <li><i class="fa-regular fa-clock"></i> 2 minutes ago</li>
                                       </ul>

                                       <p>Lawn Mowing &amp; Gardening Services</p>

                                       <div class="gender">
                                          <span>Gardener</span>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-sm-4">
                                    <div class="budget">
                                       <div class="copy"> <i class="fa-regular fa-bookmark"></i></div>
                                       <h5>$100 - $150</h5>
                                       <p>Budget</p>

                                       <div class="link-light">
                                          <a href="#">View Profile</a>
                                       </div>

                                       <div class="link">
                                          <a href="#">Message</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="full-list">
                           <div class="col-12">
                              <div class="row">
                                 <div class="col-sm-3">
                                    <div class="p-logo">
                                       <img src="assets/images/logo2.png" alt="" class="img-fluid">
                                    </div>
                                 </div>

                                 <div class="col-sm-5">
                                    <div class="content">
                                       <h6>A2 Electrical Services Pty Ltd</h6>
                                       <ul>
                                          <li><i class="fa-solid fa-location-dot"></i> San Francisco
                                          </li>
                                          <li><i class="fa-regular fa-clock"></i> 2 minutes ago</li>
                                       </ul>

                                       <p>Always providing professional services, regardless of how big
                                          or small the job is.</p>

                                       <div class="gender">
                                          <span>Electrician</span>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-sm-4">
                                    <div class="budget">
                                       <div class="copy"><i class="fa-regular fa-bookmark"></i></div>

                                       <h5>$100 - $150</h5>
                                       <p>Budget</p>

                                       <div class="link-light">
                                          <a href="#">View Profile</a>
                                       </div>

                                       <div class="link">
                                          <a href="#">Message</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="full-list">
                           <div class="col-12">
                              <div class="row">
                                 <div class="col-sm-3">
                                    <div class="p-logo">
                                       <img src="assets/images/f-logo.png" alt="" class="img-fluid">
                                    </div>
                                 </div>

                                 <div class="col-sm-5">
                                    <div class="content">
                                       <h6>Dylan's Mowing</h6>
                                       <ul>
                                          <li><i class="fa-solid fa-location-dot"></i> San Francisco
                                          </li>
                                          <li><i class="fa-regular fa-clock"></i> 2 minutes ago</li>
                                       </ul>

                                       <p>Lawn Mowing &amp; Gardening Services</p>

                                       <div class="gender">
                                          <span>Gardener</span>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-sm-4">
                                    <div class="budget">
                                       <div class="copy"> <i class="fa-regular fa-bookmark"></i></div>
                                       <h5>$100 - $150</h5>
                                       <p>Budget</p>

                                       <div class="link-light">
                                          <a href="#">View Profile</a>
                                       </div>

                                       <div class="link">
                                          <a href="#">Message</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="full-list">
                           <div class="col-12">
                              <div class="row">
                                 <div class="col-sm-3">
                                    <div class="p-logo">
                                       <img src="assets/images/logo2.png" alt="" class="img-fluid">
                                    </div>
                                 </div>

                                 <div class="col-sm-5">
                                    <div class="content">
                                       <h6>A2 Electrical Services Pty Ltd</h6>
                                       <ul>
                                          <li><i class="fa-solid fa-location-dot"></i> San Francisco
                                          </li>
                                          <li><i class="fa-regular fa-clock"></i> 2 minutes ago</li>
                                       </ul>

                                       <p>Always providing professional services, regardless of how big
                                          or small the job is.</p>

                                       <div class="gender">
                                          <span>Electrician</span>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-sm-4">
                                    <div class="budget">
                                       <div class="copy"><i class="fa-regular fa-bookmark"></i></div>

                                       <h5>$100 - $150</h5>
                                       <p>Budget</p>

                                       <div class="link-light">
                                          <a href="#">View Profile</a>
                                       </div>

                                       <div class="link">
                                          <a href="#">Message</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="full-list">
                           <div class="col-12">
                              <div class="row">
                                 <div class="col-sm-3">
                                    <div class="p-logo">
                                       <img src="assets/images/f-logo.png" alt="" class="img-fluid">
                                    </div>
                                 </div>

                                 <div class="col-sm-5">
                                    <div class="content">
                                       <h6>Dylan's Mowing</h6>
                                       <ul>
                                          <li><i class="fa-solid fa-location-dot"></i> San Francisco
                                          </li>
                                          <li><i class="fa-regular fa-clock"></i> 2 minutes ago</li>
                                       </ul>

                                       <p>Lawn Mowing &amp; Gardening Services</p>

                                       <div class="gender">
                                          <span>Gardener</span>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-sm-4">
                                    <div class="budget">
                                       <div class="copy"> <i class="fa-regular fa-bookmark"></i></div>
                                       <h5>$100 - $150</h5>
                                       <p>Budget</p>

                                       <div class="link-light">
                                          <a href="#">View Profile</a>
                                       </div>

                                       <div class="link">
                                          <a href="#">Message</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <div class="full-list">
                           <div class="col-12">
                              <div class="row">
                                 <div class="col-sm-3">
                                    <div class="p-logo">
                                       <img src="assets/images/logo2.png" alt="" class="img-fluid">
                                    </div>
                                 </div>

                                 <div class="col-sm-5">
                                    <div class="content">
                                       <h6>A2 Electrical Services Pty Ltd</h6>
                                       <ul>
                                          <li><i class="fa-solid fa-location-dot"></i> San Francisco
                                          </li>
                                          <li><i class="fa-regular fa-clock"></i> 2 minutes ago</li>
                                       </ul>

                                       <p>Always providing professional services, regardless of how big
                                          or small the job is.</p>

                                       <div class="gender">
                                          <span>Electrician</span>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-sm-4">
                                    <div class="budget">
                                       <div class="copy"><i class="fa-regular fa-bookmark"></i></div>

                                       <h5>$100 - $150</h5>
                                       <p>Budget</p>

                                       <div class="link-light">
                                          <a href="#">View Profile</a>
                                       </div>

                                       <div class="link">
                                          <a href="#">Message</a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                     </div>
                  </div>
               </section>


               <div class="pagination">
                  <ul>
                     <li><a href="#"><i class="fa-solid fa-angle-left"></i></a></li>
                     <li><a href="#">1</a></li>
                     <li><a href="#">2</a></li>
                     <li><a href="#">3</a></li>
                     <li><a href="#">4</a></li>
                     <li><a href="#"><i class="fa-solid fa-angle-right"></i></a></li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

@endsection
