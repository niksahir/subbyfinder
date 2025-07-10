@extends('layouts.before')
@section('title')
    Subby Finder
@endsection

@section('content')
    <section class="banner-sec">
        <div class="wrapper">
            <div class="bg-img">
                <img src="{{ asset('assets/images/home-page-banner.jpg') }}" alt="" class="img-fluid">
            </div>

            <div class="banner-content">
                <div class="container">
                    <h4>Hire experts or be hired for any job, any time.</h4>
                    <p> Thousands of small businesses use <span>Subby Finder</span> to turn <br>
                        their ideas into reality</p>


                    <div class="form-wrapper">
                        <form action="{{ route('front.jobsearch') }}" method="GET">
                            <div class="form-item">
                                <label for="" class="form-label">Where?</label>
                                <div class="form-control form-control">
                                    <label class="form-label">Location</label>

                                    {{-- Autocomplete text box --}}
                                    <input type="text" id="autocomplete" name="location"
                                        class="form-control @error('location') is-invalid @enderror"
                                        placeholder="Search for a location…" value="{{ old('location') }}"
                                        autocomplete="off" />

                                    {{-- These get filled automatically after the user picks a place --}}
                                    <input type="hidden" name="lat" id="lat">
                                    <input type="hidden" name="lng" id="lng">
                                    <input type="hidden" name="place_id" id="place_id">

                                    @error('location')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror

                                    <div id="place-result" class="mt-2 small text-muted"></div>
                                </div>
                            </div>

                            <div class="project form-item">
                                <label for="exampleInputPassword1" class="form-label">What project you want?</label>
                                <div class="input-with-btn">
                                    <input type="text" class="form-control" id="exampleInputPassword1"
                                        placeholder="Job Title or Keywords" name="project">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>


                    <ul>
                        <li>
                            <h3>{{ $projectsCount }}</h3><span>Project Posted</span>
                        </li>
                        <li>
                            <h3>{{ $subcontractors }}</h3><span>Sub Contractor </span>
                        </li>
                        <li>
                            <h3>{{ $contractors }}</h3><span>Principal Contractor</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="popular-sec">
        <div class="container">
            <div class="row g-3">
                <div class="title col-12">
                    <h2>Popular Categories</h2>
                </div>


                @foreach ($categories as $category)
                    <div class="col-md-3">
                        <a class="text-decoration-none text-white"
                            href="@if (!empty($userLogin) && $userLogin != null) @if ($userType == 'subcontractor')
                            {{ route('front.projectSearch', ['trade_category' => $category->id]) }}
                        @elseif($userType == 'contractor')
                            {{ route('front.subcontractorsearch', ['trade_category' => $category->id]) }} @endif
@else
{{ route('front.projectSearch', ['trade_category' => $category->id]) }}
                   @endif">
                            <div class="content d-flex justify-content-center align-items-center rounded-2"
                                style="background-color: #f77a36">
                                <h5 class="p-5 text-white m-0">{{ $category->name }}</h5>
                            </div>
                        </a>
                    </div>
                @endforeach

                {{-- <div class="col-md-3">
                    <div class="img-wrapper">
                        <img src="assets/images/p-2.png" alt="" class="img-fluid">

                        <div class="content">
                            <span>612</span>
                            <h5>Electrician</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="img-wrapper">
                        <img src="assets/images/p-3.png" alt="" class="img-fluid">

                        <div class="content">
                            <span>612</span>
                            <h5>Electrician</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="img-wrapper">
                        <img src="assets/images/p-4.png" alt="" class="img-fluid">

                        <div class="content">
                            <span>612</span>
                            <h5>Electrician</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="img-wrapper">
                        <img src="assets/images/p-5.png" alt="" class="img-fluid">

                        <div class="content">
                            <span>612</span>
                            <h5>Electrician</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="img-wrapper">
                        <img src="assets/images/p-6.png" alt="" class="img-fluid">

                        <div class="content">
                            <span>612</span>
                            <h5>Electrician</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="img-wrapper">
                        <img src="assets/images/p-7.png" alt="" class="img-fluid">

                        <div class="content">
                            <span>612</span>
                            <h5>Electrician</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="img-wrapper">
                        <img src="assets/images/p-8.png" alt="" class="img-fluid">

                        <div class="content">
                            <span>612</span>
                            <h5>Electrician</h5>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>

    <section class="feature-sec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title">
                        <h2>Features Section</h2>
                        <p>Lorem ipsum dolor sit amet consectetur. Sit ut gravida aenean potenti.
                            Metus in eu vel morbi dui nunc tellus. Non a massa maecenas massa.</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="accordion-wrapper">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        1. ⁠Project management tools
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>Lorem ipsum dolor sit amet consectetur vitae
                                            purus quis metus sed semper diam iaculis duis
                                            vitae purus amet sagittis leo elit vitae dolor.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        2. Discounted supplier rates
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Molestiae,
                                            accusamus. Illum sapiente deleniti ad assumenda sit sint consequuntur
                                            quisquam modi?</p>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            3. ⁠Industry insights and reports
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quibusdam,
                                                voluptatem aperiam, esse ratione tenetur amet tempore inventore
                                                consectetur voluptates ipsam ad! Quo, corrupti!</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapsefour"
                                            aria-expanded="false" aria-controls="collapsefour">
                                            4. Networking opportunities
                                        </button>
                                    </h2>
                                    <div id="collapsefour" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quibusdam,
                                                voluptatem aperiam, esse ratione tenetur amet tempore inventore
                                                consectetur voluptates ipsam ad! Quo, corrupti!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="img-item">
                        <img src="assets/images/feature.png" alt="" class="img-fluid">
                        <img src="assets/images/feature2.png" alt="" class="img-fluid small">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="subb-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-10">
                    <div class="content">
                        <h2>SUBBYFINDER.COM</h2>
                        <p>Trades-based businesses are undergoing a revolutionary transformation, making it easier than
                            ever for everyone to thrive in the marketplace! Major companies can effortlessly source the
                            labor they need, leveraging substantial marketing budgets to drive growth and enhance their
                            bottom lines. Small businesses, rejoice! Finding work is now just a click away, allowing you
                            to bypass traditional marketing expenses. Let the big players handle that, your only task is
                            to show up, complete your projects, and watch your earnings soar! This shift not only
                            simplifies team expansion but also allows you to travel the country, relocate or take a
                            break with the confidence that work will be easy to find afterwards.</p>

                        <div class="link wrapper">
                            <a
                                href="@if (!empty($userLogin) && $userLogin != null) @if ($userType == 'subcontractor')
                                                        {{ route('subcontractor.dashboard.index') }}
                                                    @else
                                                        {{ route('contractor.dashboard.index') }} @endif
@else
{{ route('front.createaccount') }}
                                        @endif">Register</a>
                            <a href="#">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="card-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card-inner">
                        <img src="assets/images/card-1.png" alt="" class="img-fluid">
                        <h4>UILDERS & PRINCIPLE CONTRACTORS</h4>
                        <p>Create a business listing for subcontractors to find you easily. You will also have the
                            ability to post jobs or expressions of interest for more urgent matters. You will also have
                            the ability to search the sub contractors in the area you need the work done.</p>

                        <div class="link-normal">
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-inner">
                        <img src="assets/images/card-2.png" alt="" class="img-fluid">
                        <h4>UILDERS & PRINCIPLE CONTRACTORS</h4>
                        <p>Create a business listing for subcontractors to find you easily. You will also have the
                            ability to post jobs or expressions of interest for more urgent matters. You will also have
                            the ability to search the sub contractors in the area you need the work done.</p>

                        <div class="link-normal">
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-inner">
                        <img src="assets/images/card-3.png" alt="" class="img-fluid">

                        <h4>UILDERS & PRINCIPLE CONTRACTORS</h4>
                        <p>Create a business listing for subcontractors to find you easily. You will also have the
                            ability to post jobs or expressions of interest for more urgent matters. You will also have
                            the ability to search the sub contractors in the area you need the work done.</p>

                        <div class="link-normal">
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="featured-projects">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title">
                        <h4>Featured Projects</h4>

                        <div class="link-normal-type2">
                            <a href="/project-search">Browse All Project</a>
                        </div>
                    </div>
                </div>


                @foreach ($projects as $project)
                    <div class="full-list">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="p-logo">
                                        <img src="{{ $project->project_logo ? asset('storage/' . $project->project_logo) : asset('assets/images/icons8-project-50.png') }}"
                                            alt="Project Logo" class="img-fluid">
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    <div class="content">
                                        <h6>{{ $project->project_name }}</h6>
                                        <ul>
                                            <li><i class="fa-solid fa-location-dot"></i> {{ $project->location }}</li>
                                            <li><i class="fa-regular fa-clock"></i>
                                                {{ $project->created_at->diffForHumans() }}</li>
                                        </ul>


                                        <p>{{ Str::limit($project->description, 100) }}</p>
                                        <div class="gender">
                                            @if (is_array($project->trade_category) && count($project->expertise_names))
                                                @foreach ($project->expertise_names as $expertise)
                                                    <span style="margin-bottom: 5px;">{{ $expertise }}</span>
                                                @endforeach
                                            @else
                                                <span>{{ $project->trade_category }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="budget">
                                        <div class="copy">
                                            {{-- <i class="{{ $project->is_bookmarked ? 'fa-solid' : 'fa-regular' }} fa-bookmark bookmark-icon"
                                                data-id="{{ $project->id }}" style="cursor: pointer;"></i> --}}
                                        </div>
                                        <h5>{{ $project->budget }}</h5>

                                        <div class="link-light">
                                            <a href="{{ route('front.projectDetils', $project->id) }}">View More</a>
                                        </div>

                                        {{-- <div class="link">
                                            <a href="#">Message</a>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <section class="subbyfinder-sec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title">
                        <h2>How Subbyfinder came to be.</h2>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="content">
                        <p>I had my own air conditioning company for 11 years with two employees. Searching for enough
                            work to keep all three of us busy often took me off the tools and cost thousands of dollars
                            on marketing and pages like “Hipages,” with no guarantee of winning the work. Not to mention
                            the countless hours and phone calls with everyday customers. After COVID, I sold the
                            business and worked for a major company as a project manager. We had so much commercial and
                            domestic work and not enough workers to complete it. We went through many subcontractors
                            (some truly terrible) in an effort to find the right fit, which cost us money in late fees
                            and resulted in poor workmanship, ultimately turning away additional work. If only there
                            were a resource that provided ratings of contractors, making it easier to find the right
                            subcontractors for the job. From a subcontractor’s point of view, it would also be helpful
                            to see how the company you are considering working for is rated. Do they pay on time? Are
                            they organized, etc.?
                            Well here it is subbyfinder.com Memberships available soon (early 2025)</p>

                        <p>Principle Contractors can now confidently embrace that additional project or extra work,
                            knowing they have a reliable workforce at their fingertips to seamlessly execute the tasks
                            at hand. This newfound assurance not only enhances their operational capabilities but also
                            opens doors to greater opportunities for growth and success in an increasingly competitive
                            market.</p>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="img-item">
                        <img src="assets/images/finder.png" alt="" class="img-fluid">

                        <div class="link">
                            <a href="#">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="counter-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="counter-item">
                        <img src="assets/images/m-1.png" alt="" class="img-fluid">
                        <h3>100k+</h3>
                        <p>Expected Members</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="counter-item">
                        <img src="assets/images/m-2.png" alt="" class="img-fluid">
                        <h3>70k+</h3>
                        <p>Sub-contractors</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="counter-item">
                        <img src="assets/images/m-3.png" alt="" class="img-fluid">
                        <h3>100k+</h3>
                        <p>Approval Rate </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="counter-item">
                        <img src="assets/images/m-4.png" alt="" class="img-fluid">
                        <h3>100k+</h3>
                        <p>Connection made</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contractor-sec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title-wtapper">
                        <h4>Highest Rated Sub Contractor </h4>
                        <a href="{{ route('front.subcontractorsearch') }}"> Browse All Sub Contractor </a>
                    </div>
                </div>
            </div>

            <div class="swiper highestSwiper">
                <div class="swiper-wrapper">
                    @foreach ($subcontractorsReviews as $subcontractorsReview)
                        <div class="swiper-slide">
                            <div class="inner-slide">
                                <div class="image">
                                    <img src="{{ $subcontractorsReview->project->profile_photo ? asset('storage/' . $subcontractorsReview->project->profile_photo) : asset('assets/images/icons8-person-94.png') }}"
                                        alt="" class="img-fluid">
                                </div>

                                <div class="content">
                                    <h6>{{ $subcontractorsReview->project->contact_name }} </h6>

                                    <ul>
                                        <li>Electrician</li>
                                        <li> <i class="fa-solid fa-location-dot"></i>
                                            {{ $subcontractorsReview->project->location ?? '-' }}</li>
                                    </ul>

                                    <div class="ratimg">
                                        <div class="number">
                                            {{ $subcontractorsReview->average_rating }}
                                        </div>

                                        <div class="star">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($subcontractorsReview->average_rating))
                                                    <i class="fa-solid fa-star"></i>
                                                @elseif ($i - $subcontractorsReview->average_rating < 1)
                                                    <i class="fa-solid fa-star-half-stroke"></i>
                                                @else
                                                    <i class="fa-regular fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>

                                    <div class="buttons">
                                        <a
                                            href="{{ route('front.subcontractorprojectdetils', $subcontractorsReview->project->id) }}">View
                                            Profile </a>
                                        {{-- <a href="#">Message </a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- <div class="swiper-slide">
                        <div class="inner-slide">
                            <div class="image">
                                <img src="assets/images/team-2.jpg" alt="" class="img-fluid">
                            </div>

                            <div class="content">
                                <h6>David Peterson </h6>

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

                                <div class="buttons">
                                    <a href="#">View Profile </a>
                                    <a href="#">Message </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="inner-slide">
                            <div class="image">
                                <img src="assets/images/team-3.png" alt="" class="img-fluid">
                            </div>

                            <div class="content">
                                <h6>Marcin Kowalski </h6>

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

                                <div class="buttons">
                                    <a href="#">View Profile </a>
                                    <a href="#">Message </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="inner-slide">
                            <div class="image">
                                <img src="assets/images/team-1.jpg" alt="" class="img-fluid">
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

                                <div class="buttons">
                                    <a href="#">View Profile </a>
                                    <a href="#">Message </a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="swiper-contols d-none" id="swiper-controls">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>

    <section class="plans-sec">
        <div class="container">
            <div class="col-12">
                <div class="title">
                    <h4>Membership Plans</h4>

                    <div class="radio-btn">
                        <div class="radio-item">
                            <input type="radio" id="month" name="billing" value="monthly" checked>
                            <label for="month">Billed Monthly</label>
                        </div>

                        <div class="radio-item">
                            <input type="radio" id="year" name="billing" value="yearly">
                            <label for="year">Billed Yearly <span>Save 10%</span></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row m-0" id="plans-container">
                {{-- Plans will be injected here --}}
            </div>
        </div>

        <form id="checkout-form" method="POST" action="{{ route('stripe.checkout') }}" style="display: none;">
            @csrf
            <input type="hidden" name="plan_id" id="plan-id-input">
        </form>
    </section>

    <section class="trust-building-sec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title">
                        <h2>Trust-Building </h2>
                        <p>Unlock simplicity in your job search journey – explore 'How It Works' on
                            our platform.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="iner-item">
                        <img src="assets/images/bill-list.png" alt="" class="img-fluid">
                        <h4>⁠Security </h4>
                        <p>Job seekers start by creating an
                            account on the job portal.</p>
                    </div>
                </div>
                <div class="col-md-4 mt-md-5 pt-md-3">
                    <div class="iner-item">
                        <img src="assets/images/shield.svg" alt="" class="img-fluid">
                        <h4>Money-back guarantee </h4>
                        <p>Utilize our powerful search engine to
                            find jobs that align with your career
                            goals.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="iner-item">
                        <img src="assets/images/security.png" alt="" class="img-fluid">
                        <h4>Certifications or partnerships with industry organizations.
                        </h4>
                        <p>Expand your professional network by
                            connecting with industry peers.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="blog-sec">
        <div class="container">
            <div class="col-12">
                <h2>Blogs</h2>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="blog-inner">
                        <img src="assets/images/blog-1.png" alt="" class="img-fluid">
                        <h4>The Art of Connection</h4>
                        <p>In the ever-evolving world, the art of forging genuine connections remains timeless.…</p>
                        <div class="link-normal">
                            <a href="#"> Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="blog-inner">
                        <img src="assets/images/blog-2.png" alt="" class="img-fluid">
                        <h4>Beyond the Obstacle</h4>
                        <p>Challenges in business are a given, but it’s our response to them…</p>
                        <div class="link-normal">
                            <a href="#"> Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="blog-inner">
                        <img src="assets/images/blog-3.png" alt="" class="img-fluid">
                        <h4>Growth Unlocked</h4>
                        <p>Every business has a unique potential waiting to be tapped. Recognizing the…</p>
                        <div class="link-normal">
                            <a href="#"> Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonal-sec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="title">
                        <h2>What did happy clients have <br>
                            to say about us?</h2>
                    </div>
                </div>
            </div>


            <div class="swiper testimonalSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="inner-item">



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
                                    <img src="assets/images/client-1.png" alt="" class="img-fluid">
                                </div>

                                <div class="name">
                                    <h6>Benny Bartlett</h6>
                                    <p>Interactive Designer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="inner-item">


                            <div class="star">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>

                            <p>"Switching to this CRM has been a
                                game changer for our sales team.
                                The interface is intuitive, and the
                                automation features have saved us
                                countless hours.</p>

                            <div class="client">
                                <div class="photo">
                                    <img src="assets/images/client-2.png" alt="" class="img-fluid">
                                </div>

                                <div class="name">
                                    <h6>Jaeden Reilly</h6>
                                    <p>Director</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="inner-item">


                            <div class="star">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>

                            <p>"This marketing automation tool has
                                been a lifesaver for our team. It’s
                                easy to set up campaigns, track
                                performance, and make data-driven
                                decisions made.."</p>

                            <div class="client">
                                <div class="photo">
                                    <img src="assets/images/client-3.png" alt="" class="img-fluid">
                                </div>

                                <div class="name">
                                    <h6>Adrian Murphy</h6>
                                    <p>Brokerage Manager</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="inner-item">
                            <div class="star">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>

                            <p>"Switching to this CRM has been a
                                game changer for our sales team.
                                The interface is intuitive, and the
                                automation features have saved us
                                countless hours."</p>

                            <div class="client">
                                <div class="photo">
                                    <img src="assets/images/client-3.png" alt="" class="img-fluid">
                                </div>

                                <div class="name">
                                    <h6>Jonatan Moss</h6>
                                    <p>CEO & Founder</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="inner-item">


                            <div class="star">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>

                            <p>On the other hand, we denounce with righteous indignation and dislike men who are so
                                beguiled and.</p>

                            <div class="client">
                                <div class="photo">
                                    <img src="assets/images/photo1.png" alt="" class="img-fluid">
                                </div>

                                <div class="name">
                                    <h6>Serhiy Hipskyy</h6>
                                    <p>Student</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper testimonalSwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="inner-item">



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
                                    <img src="assets/images/client-1.png" alt="" class="img-fluid">
                                </div>

                                <div class="name">
                                    <h6>Benny Bartlett</h6>
                                    <p>Interactive Designer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="inner-item">


                            <div class="star">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>

                            <p>"Switching to this CRM has been a
                                game changer for our sales team.
                                The interface is intuitive, and the
                                automation features have saved us
                                countless hours.</p>

                            <div class="client">
                                <div class="photo">
                                    <img src="assets/images/client-2.png" alt="" class="img-fluid">
                                </div>

                                <div class="name">
                                    <h6>Jaeden Reilly</h6>
                                    <p>Director</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="inner-item">


                            <div class="star">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>

                            <p>"This marketing automation tool has
                                been a lifesaver for our team. It’s
                                easy to set up campaigns, track
                                performance, and make data-driven
                                decisions made.."</p>

                            <div class="client">
                                <div class="photo">
                                    <img src="assets/images/client-3.png" alt="" class="img-fluid">
                                </div>

                                <div class="name">
                                    <h6>Adrian Murphy</h6>
                                    <p>Brokerage Manager</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="inner-item">
                            <div class="star">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>

                            <p>"Switching to this CRM has been a
                                game changer for our sales team.
                                The interface is intuitive, and the
                                automation features have saved us
                                countless hours."</p>

                            <div class="client">
                                <div class="photo">
                                    <img src="assets/images/client-3.png" alt="" class="img-fluid">
                                </div>

                                <div class="name">
                                    <h6>Jonatan Moss</h6>
                                    <p>CEO & Founder</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="inner-item">


                            <div class="star">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>

                            <p>On the other hand, we denounce with righteous indignation and dislike men who are so
                                beguiled and.</p>

                            <div class="client">
                                <div class="photo">
                                    <img src="assets/images/photo1.png" alt="" class="img-fluid">
                                </div>

                                <div class="name">
                                    <h6>Serhiy Hipskyy</h6>
                                    <p>Student</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="footer-top">
        <div class="container">
            <div class="row">
                {{-- <div class="col-md-6">
                    <div class="left">
                        <h3>Begin your new journey with us.</h3>
                        <p>We value your input and continuously strive to improve our
                            platform based on users.</p>

                        <div class="link white">
                            <a href="#"> Try It Free for 14 Days</a>
                        </div>
                    </div>
                </div> --}}

                <div class="col-md-12">
                    <div class="right">
                        <h3>24/7 Customer support</h3>
                        <p>Our dedicated support team is available around the clock to
                            assist you with any inquiries or issues.</p>

                        <div class="link">
                            <a href="#">Contact now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @php
        $userCurrentPlan = null;
        if ($userLogin != null) {
            $userCurrentPlan = \App\Models\UserSubscription::where('user_id', $userLogin->id)
                ->where('user_type', $userType)
                ->where('is_active', 1)
                ->first();
        }
    @endphp
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_places.key') }}&libraries=places"
        defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('autocomplete');
            const resultBox = document.getElementById('place-result');
            const latField = document.getElementById('lat');
            const lngField = document.getElementById('lng');
            const idField = document.getElementById('place_id');

            function init() {
                const ac = new google.maps.places.Autocomplete(input, {
                    types: ['geocode'],
                    componentRestrictions: {
                        country: 'AU'
                    }
                });

                ac.addListener('place_changed', () => {
                    const place = ac.getPlace();

                    if (!place.geometry) {
                        resultBox.textContent = 'No details for that place – try again.';
                        return;
                    }

                    // Fill visible field with formatted address; hidden fields with extras
                    input.value = place.formatted_address || place.name;
                    latField.value = place.geometry.location.lat();
                    lngField.value = place.geometry.location.lng();
                    idField.value = place.place_id || '';

                    // Nice feedback for the user
                    // resultBox.innerHTML =
                    //     `<strong>${place.name || ''}</strong><br>${place.formatted_address}`;
                });
            }

            // Google script loads async – wait until it is ready
            let tries = 0,
                w = setInterval(() => {
                    if (window.google && google.maps && google.maps.places) {
                        clearInterval(w);
                        init();
                    }
                    if (++tries > 20) clearInterval(w); // give up after ~6 s
                }, 300);
        });
    </script>
    <script>
        const monthlyPlans = @json($monthlyPlans);
        const yearlyPlans = @json($yearlyPlans);
        const userCurrentPlan = @json($userCurrentPlan);
        const isLoggedIn = {{ $userLogin ? 'true' : 'false' }};

        function renderPlans(plans) {
            const container = document.getElementById('plans-container');
            container.innerHTML = '';

            if (isLoggedIn == true && userCurrentPlan) {
                plans.forEach(plan => {
                    const html = `
                <div class="col-md-4 p-0">
                    <div class="plan-inner ${plan.name === 'Standard Plan' ? 'orange' : ''}">
                        ${plan.name === 'Standard Plan' ? '<div class="Recommended"><p>Recommended</p></div>' : ''}
                        <h5>${plan.name}</h5>
                        <p>${plan.description || ''}</p>
                        <div class="price" id="plan-price-${plan.id}">
                            <h3>$${plan.price} <span>/ ${plan.billing_type}</span></h3>
                        </div>
                        <h6>Features of ${plan.name}</h6>
                        <ul>
                            ${
                                Array.isArray(plan.features)
                                    ? plan.features
                                    : (typeof plan.features === 'string'
                                        ? JSON.parse(plan.features)
                                        : [])
                                    .map(f => `<li>${f}</li>`).join('')
                            }
                        </ul>
                        <div class="link border">
                            <a href="javascript:void(0)" onclick="handleBuyNow('${plan.id}')">Buy Now</a>
                        </div>
                    </div>
                </div>`;
                    container.innerHTML += html;
                    const h3Element = document.querySelector(`#plan-price-${plan.id} h3`);
                    if (userCurrentPlan && userCurrentPlan.plan_id === plan.id) {
                        h3Element.classList.add('fw-bold');
                    }
                });

            } else {
                plans.forEach(plan => {
                    const html = `
                <div class="col-md-4 p-0">
                    <div class="plan-inner ${plan.name === 'Standard Plan' ? 'orange' : ''}">
                        ${plan.name === 'Standard Plan' ? '<div class="Recommended"><p>Recommended</p></div>' : ''}
                        <h5>${plan.name}</h5>
                        <p>${plan.description || ''}</p>
                        <div class="price">
                            <h3>$${plan.price} <span>/ ${plan.billing_type}</span></h3>
                        </div>
                        <h6>Features of ${plan.name}</h6>
                        <ul>
                            ${
                                Array.isArray(plan.features)
                                    ? plan.features
                                    : (typeof plan.features === 'string'
                                        ? JSON.parse(plan.features)
                                        : [])
                                    .map(f => `<li>${f}</li>`).join('')
                            }
                        </ul>
                        <div class="link border">
                            <a href="javascript:void(0)" onclick="handleBuyNow('${plan.id}')">Buy Now</a>
                        </div>
                    </div>
                </div>`;
                    container.innerHTML += html;
                });
            }

        }

        function handleBuyNow(planId) {
            if (!isLoggedIn) {
                window.location.href = "{{ route('login') }}";
            } else {
                document.getElementById('plan-id-input').value = planId;
                document.getElementById('checkout-form').submit();
            }
        }

        // Initial render
        renderPlans(monthlyPlans);

        // Toggle handler
        document.querySelectorAll('input[name="billing"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'monthly') {
                    renderPlans(monthlyPlans);
                } else {
                    renderPlans(yearlyPlans);
                }
            });
        });
    </script>
@endsection
