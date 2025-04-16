@extends('layouts.before')
@section('title')
    Project Detils Lock - Subby Finder
@endsection

@section('content')
    <section class="basic-banner-sec">
        <div class="bg-img">
            <div class="basic-content">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="bplogo-wrwppr">
                                <div class="b-logo">
                                    <img src="{{ asset('storage/' . $project->project_logo) }}" alt="Project Logo"
                                        class="img-fluid">
                                </div>

                                <div class="text">
                                    <div class="content">
                                        <h6>{{ $project->project_name }} </h6>

                                        <ul>
                                            <li> <i class="fa-solid fa-location-dot"></i> {{ $project->location }}</li>
                                            <li><span>
                                                    @if (is_array($project->trade_category))
                                                        {{ implode(', ', $project->expertise_names) }}
                                                    @else
                                                        {{ $project->trade_category }}
                                                    @endif
                                                </span></li>
                                        </ul>

                                        <div class="ratimg">
                                            <div class="ratimg-inner">
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
                                            <div class="verified"> <i class="fa-solid fa-check"></i> Verified</div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="bookmark"><span><i class="fa-regular fa-bookmark"></i> Bookmark</span> </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="description-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="left-content">
                        <h5>Description</h5>
                        <p>{{ $project->description }}
                        </p>

                        <div class="info">
                            <div class="lock-button">
                                <a href="{{ '/unloack-project/' . $project->id }}" class="text-decoration-none @if ($unlockProject == false) pe-none @else pe-auto @endif"
                                   >Unlock Contact</a>
                            </div>

                            <div class="info-inner">
                                <div class="item">
                                    <p>Business Name: <span>Dylan's Mowing</span></p>
                                    <p>Contact Name: <span>Jhon jacy</span></p>
                                </div>
                                <div class="item">
                                    <p>Phone: <span>9876543210</span></p>
                                    <p>Email: <span>jhonjack@gmail.com</span></p>
                                </div>
                                <div class="item">
                                    <p>Address: <span>San Francisco</span></p>
                                    <p>Support staff size: <span>Jhon jacy</span></p>
                                </div>
                                <div class="item">
                                    <p>Years In Business: <span>10 Years</span></p>
                                    <p>Insurances: <span>67543156 <small>Verified</small></span></p>

                                </div>
                                <div class="item">
                                    <p>ABN: <span>98765432567 </span></p>
                                    <p>License: <span>79252 <small>Verified</small></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="list mt-5">
                            <h6>Expertise in</h6>
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

                            </ul>
                        </div>

                        <div class="detail-info">
                            <div class="full-label">
                                <h6>Current Opportunities:</h6>
                            </div>

                            <div class="full-list">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="content">
                                                <h6>A2 Electrical Services Pty Ltd</h6>
                                                <ul>
                                                    <li><i class="fa-solid fa-location-dot"></i> San Francisco</li>
                                                    <li><i class="fa-regular fa-clock"></i> 2 minutes ago</li>
                                                </ul>

                                                <p>Capitalize on low hanging fruit to identify a ballpark value added
                                                    activity to beta test. Override the digital divide with additional
                                                    clickthroughs from .....</p>

                                                <div class="gender">
                                                    <span>Electrician</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
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
                                        <div class="col-md-8">
                                            <div class="content">
                                                <h6>Dylan's Mowing</h6>
                                                <ul>
                                                    <li><i class="fa-solid fa-location-dot"></i> San Francisco</li>
                                                    <li><i class="fa-regular fa-clock"></i> 2 minutes ago</li>
                                                </ul>

                                                <p>Capitalize on low hanging fruit to identify a ballpark value added
                                                    activity to beta test. Override the digital divide with additional
                                                    clickthroughs from .....</p>

                                                <div class="gender">
                                                    <span>Electrician</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
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

                            <div class="full-label">
                                <h6>Past Project Completed : </h6>
                            </div>

                            <div class="prject-with-images mb-5 pb-3">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="img-with-text">
                                            <h6>Project Name</h6>

                                            <ul class="list-unstyled">
                                                <li><i class="fa-solid fa-location-dot"></i> San Francisco</li>
                                            </ul>

                                            <p>Capitalize on low hanging fruit to identify a ballpark value added
                                                activity to beta test. Override the digital divide with additional
                                                clickthroughs from .....</p>

                                            <div class="img-wrapper">
                                                <img src="{{ asset('assets/images/project-1.png') }}" alt=""
                                                    class="img-fluid">
                                                <img src="{{ asset('assets/images/project-2.png') }}" alt=""
                                                    class="img-fluid">
                                                <img src="{{ asset('assets/images/project-3.png') }}" alt=""
                                                    class="img-fluid">
                                                <img src="{{ asset('assets/images/project-4.png') }}" alt=""
                                                    class="img-fluid">
                                                <img src="{{ asset('assets/images/project-5.png') }}" alt=""
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="price">
                                            <h6>$100 - $150 </h6>
                                            <p>outcomes</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="prject-with-images mb-5 pb-3">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="img-with-text">
                                            <h6>Project Name</h6>

                                            <ul class="list-unstyled">
                                                <li><i class="fa-solid fa-location-dot"></i> San Francisco</li>
                                            </ul>

                                            <p>Capitalize on low hanging fruit to identify a ballpark value added
                                                activity to beta test. Override the digital divide with additional
                                                clickthroughs from .....</p>

                                            <div class="img-wrapper">
                                                <img src="{{ asset('assets/images/project-1.png') }}" alt=""
                                                    class="img-fluid">
                                                <img src="{{ asset('assets/images/project-2.png') }}" alt=""
                                                    class="img-fluid">
                                                <img src="{{ asset('assets/images/project-3.png') }}" alt=""
                                                    class="img-fluid">
                                                <img src="{{ asset('assets/images/project-4.png') }}" alt=""
                                                    class="img-fluid">
                                                <img src="{{ asset('assets/images/project-5.png') }}" alt=""
                                                    class="img-fluid">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="price">
                                            <h6>$100 - $150 </h6>
                                            <p>outcomes</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="full-label">
                                <h6>Reviews </h6>
                            </div>

                            <div class="review-item">
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <p>"We’ve been using this customer
                                    support platform for six months, and
                                    our response times have improved
                                    by 40%. The analytics dashboard
                                    provides happier, and so are we!"</p>

                                <div class="client">
                                    <div class="photo">
                                        <img src="{{ asset('assets/images/client-1.png') }}" alt=""
                                            class="img-fluid">
                                    </div>

                                    <div class="name">
                                        <h6>Benny Bartlett</h6>
                                        <p>Interactive Designer</p>
                                    </div>
                                </div>
                            </div>
                            <div class="review-item">
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <p>"We’ve been using this customer
                                    support platform for six months, and
                                    our response times have improved
                                    by 40%. The analytics dashboard
                                    provides happier, and so are we!"</p>

                                <div class="client">
                                    <div class="photo">
                                        <img src="{{ asset('assets/images/client-1.png') }}" alt=""
                                            class="img-fluid">
                                    </div>

                                    <div class="name">
                                        <h6>Benny Bartlett</h6>
                                        <p>Interactive Designer</p>
                                    </div>
                                </div>
                            </div>
                            <div class="review-item">
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <p>"We’ve been using this customer
                                    support platform for six months, and
                                    our response times have improved
                                    by 40%. The analytics dashboard
                                    provides happier, and so are we!"</p>

                                <div class="client">
                                    <div class="photo">
                                        <img src="{{ asset('assets/images/client-1.png') }}" alt=""
                                            class="img-fluid">
                                    </div>

                                    <div class="name">
                                        <h6>Benny Bartlett</h6>
                                        <p>Interactive Designer</p>
                                    </div>
                                </div>
                            </div>
                            <div class="review-item">
                                <div class="star">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <p>"We’ve been using this customer
                                    support platform for six months, and
                                    our response times have improved
                                    by 40%. The analytics dashboard
                                    provides happier, and so are we!"</p>

                                <div class="client">
                                    <div class="photo">
                                        <img src="{{ asset('assets/images/client-1.png') }}" alt=""
                                            class="img-fluid">
                                    </div>

                                    <div class="name">
                                        <h6>Benny Bartlett</h6>
                                        <p>Interactive Designer</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="right-side">
                        <div class="link">
                            <a href="#">Message</a>
                        </div>

                        <div class="enquire-box">
                            <h6>Enquire</h6>

                            <form>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">EName</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Phone </label>
                                    <input type="text" class="form-control" id="exampleInputPassword1">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Email </label>
                                    <input type="text" class="form-control" id="exampleInputPassword1">
                                </div>

                                <div class="mb-3">
                                    <label for="floatingTextarea">Message</label>
                                    <textarea class="form-control" placeholder="" rows="4" floatingTextarea"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Send</button>
                            </form>
                        </div>

                        <div class="share">
                            <p> Interesting? <a href="#">Share It!</a></p>
                        </div>

                        <div class="area-map">
                            <div class="full-label">
                                <h6>Service Area Map</h6>
                            </div>

                            <img src="{{ asset('assets/images/map.png') }}" alt="" class="img-fluid">
                        </div>

                        <div class="working-hours">
                            <div class="full-label">
                                <h6>Service Area Map</h6>
                            </div>

                            <p>Mon <span>07:00 AM - 03:00 PM</span></p>
                            <p>Tue <span>07:00 AM - 03:00 PM</span></p>
                            <p>Wed <span>07:00 AM - 03:00 PM</span></p>
                            <p>Thu <span>07:00 AM - 03:00 PM</span></p>
                            <p>Fir <span>07:00 AM - 03:00 PM</span></p>
                            <p>Sat <span>Close</span></p>
                            <p>Sun <span>Close</span></p>
                        </div>

                        <div class="post-item">
                            <img src="{{ asset('assets/images/m-1.png') }}" alt="" class="img-fluid">
                            <h3>20+</h3>
                            <p>Project Posted</p>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
