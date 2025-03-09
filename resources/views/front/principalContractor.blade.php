@extends('layouts.before')
@section("title")
Principal Contractor - Subby Finder
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
               <h6>Search Results</h6>
               <div class="top-bar">
                  <div class="form-check form-switch">
                     <input class="form-check-input" type="checkbox" role="switch"
                        id="flexSwitchCheckChecked">
                     <label class="form-check-label" for="flexSwitchCheckChecked">Turn on email alerts for
                        this search</label>
                  </div>

                  <div class="filter">
                     <div class="dropdown">
                        <span>Sort by:</span>
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                           Relevance
                        </button>
                        <ul class="dropdown-menu">
                           <li>
                              <a class="dropdown-item" href="#">Action</a>
                           </li>
                           <li>
                              <a class="dropdown-item" href="#">Another action</a>
                           </li>
                           <li>
                              <a class="dropdown-item" href="#">Something else here</a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>

               <section class="review-dash mt-5">
                  <div class="inner-slide">
                     <div class="inner-wrapper">
                        <div class="image">
                           <img src="{{ asset('assets/images/team-1.jpg')}}" alt="" class="img-fluid">

                           <div class="check">
                              <img src="{{ asset('assets/images/check.png')}}" alt="" class="img-fluid">
                           </div>
                        </div>

                        <div class="content">
                           <h6>Tom Smith </h6>

                           <ul>
                              <li>Electrician</li>
                              <li>
                                 <i class="fa-solid fa-location-dot"></i> San Francisco
                              </li>
                           </ul>

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


                           <p>Budget <small> $100 - $150</small></p>

                        </div>
                     </div>

                     <div class="buttons">
                        <div class="copy">
                           <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <a href="#">View Profile </a>
                        <a href="#">Message </a>
                     </div>
                  </div>

                  <div class="inner-slide">
                     <div class="inner-wrapper">
                        <div class="image">
                           <img src="{{ asset('assets/images/team-2.jpg')}}" alt="" class="img-fluid">

                           <div class="check">
                              <img src="{{ asset('assets/images/check.png')}}" alt="" class="img-fluid">
                           </div>
                        </div>

                        <div class="content">
                           <h6>Tom Smith </h6>

                           <ul>
                              <li>Electrician</li>
                              <li>
                                 <i class="fa-solid fa-location-dot"></i> San Francisco
                              </li>
                           </ul>

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

                           <p>Budget <small> $100 - $150</small></p>

                        </div>
                     </div>

                     <div class="buttons">
                        <div class="copy">
                           <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <a href="#">View Profile </a>
                        <a href="#">Message </a>
                     </div>
                  </div>
                  <div class="inner-slide">
                     <div class="inner-wrapper">
                        <div class="image">
                           <img src="{{ asset('assets/images/team-1.jpg')}}" alt="" class="img-fluid">

                           <div class="check">
                              <img src="{{ asset('assets/images/check.png')}}" alt="" class="img-fluid">
                           </div>
                        </div>

                        <div class="content">
                           <h6>Tom Smith </h6>

                           <ul>
                              <li>Electrician</li>
                              <li>
                                 <i class="fa-solid fa-location-dot"></i> San Francisco
                              </li>
                           </ul>

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


                           <p>Budget <small> $100 - $150</small></p>

                        </div>
                     </div>

                     <div class="buttons">
                        <div class="copy">
                           <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <a href="#">View Profile </a>
                        <a href="#">Message </a>
                     </div>
                  </div>

                  <div class="inner-slide">
                     <div class="inner-wrapper">
                        <div class="image">
                           <img src="{{ asset('assets/images/team-2.jpg')}}" alt="" class="img-fluid">

                           <div class="check">
                              <img src="{{ asset('assets/images/check.png')}}" alt="" class="img-fluid">
                           </div>
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

                           <p>Budget <small> $100 - $150</small></p>

                        </div>
                     </div>

                     <div class="buttons">
                        <div class="copy">
                           <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <a href="#">View Profile </a>
                        <a href="#">Message </a>
                     </div>
                  </div>
                  <div class="inner-slide">
                     <div class="inner-wrapper">
                        <div class="image">
                           <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">

                           <div class="check">
                              <img src="{{ asset('assets/images/check.png') }}" alt="" class="img-fluid">
                           </div>
                        </div>

                        <div class="content">
                           <h6>Tom Smith </h6>

                           <ul>
                              <li>Electrician</li>
                              <li>
                                 <i class="fa-solid fa-location-dot"></i> San Francisco
                              </li>
                           </ul>

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


                           <p>Budget <small> $100 - $150</small></p>

                        </div>
                     </div>

                     <div class="buttons">
                        <div class="copy">
                           <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <a href="#">View Profile </a>
                        <a href="#">Message </a>
                     </div>
                  </div>

                  <div class="inner-slide">
                     <div class="inner-wrapper">
                        <div class="image">
                           <img src="{{ asset('assets/images/team-2.jpg') }}" alt="" class="img-fluid">

                           <div class="check">
                              <img src="{{ asset('assets/images/check.png') }}" alt="" class="img-fluid">
                           </div>
                        </div>

                        <div class="content">
                           <h6>Tom Smith </h6>

                           <ul>
                              <li>Electrician</li>
                              <li>
                                 <i class="fa-solid fa-location-dot"></i> San Francisco
                              </li>
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

                           <p>Budget <small> $100 - $150</small></p>

                        </div>
                     </div>

                     <div class="buttons">
                        <div class="copy">
                           <i class="fa-regular fa-bookmark"></i>
                        </div>
                        <a href="#">View Profile </a>
                        <a href="#">Message </a>
                     </div>
                  </div>
               </section>


               <div class="pagination">
                  <ul>
                     <li>
                        <a href="#"><i class="fa-solid fa-angle-left"></i></a>
                     </li>
                     <li>
                        <a href="#">1</a>
                     </li>
                     <li>
                        <a href="#">2</a>
                     </li>
                     <li>
                        <a href="#">3</a>
                     </li>
                     <li>
                        <a href="#">4</a>
                     </li>
                     <li>
                        <a href="#"><i class="fa-solid fa-angle-right"></i></a>
                     </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
