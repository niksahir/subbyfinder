@extends('layouts.before')
@section('title')
    Sub Contractor Project Detils Lock - Subby Finder
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
                                    <img src="{{ asset('assets/images/project-logo.png') }}" alt="">
                                </div>

                                <div class="text">
                                    <div class="content">
                                        <h6>{{ $project->contact_name }} </h6>

                                        <ul>
                                            <li> <i class="fa-solid fa-location-dot"></i> {{ $project->location ?? '-' }}
                                            </li>
                                        </ul>
                                        @if (isset($averageRating) && $averageRating !== null)
                                            <div class="ratimg">
                                                <div class="ratimg-inner">
                                                    <div class="number">
                                                        {{ number_format($averageRating, 1) }}
                                                    </div>

                                                    <div class="star">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($averageRating >= $i)
                                                                <i class="fa-solid fa-star" style="color: #fbbf24;"></i>
                                                                <!-- full star -->
                                                            @elseif ($averageRating >= $i - 0.5)
                                                                <i class="fa-solid fa-star-half-stroke"
                                                                    style="color: #fbbf24;"></i> <!-- half star -->
                                                            @else
                                                                <i class="fa-regular fa-star" style="color: #fbbf24;"></i>
                                                                <!-- empty star -->
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="verified"><i class="fa-solid fa-check"></i> Verified</div>
                                            </div>
                                        @else
                                            <div class="ratimg">
                                                <div class="number">
                                                    0.0
                                                </div>
                                            </div>
                                        @endif



                                        {{-- <div class="ratimg">
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
                                        </div> --}}

                                    </div>
                                </div>
                            </div>
                            <div class="bookmark bookmark-icon-1" style="cursor: pointer;" data-id="{{ $project->id }}">
                                <span>
                                    <i class="{{ $project->is_bookmarked ? 'fa-solid' : 'fa-regular' }} fa-bookmark"
                                        data-id="{{ $project->id }}"></i>
                                    Bookmark
                                </span>
                            </div>

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
                        <p>Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative
                            approaches to
                            corporate strategy foster collaborative thinking to further the overall value proposition.
                            Organically grow
                            the holistic world view of disruptive innovation via workplace diversity and empowerment.
                        </p>

                        <p>Bring to the table win-win survival strategies to ensure proactive domination. At the end of
                            the day, going
                            forward, a new normal that has evolved from generation X is on the runway heading towards a
                            streamlined cloud solution. User generated content in real-time will have multiple
                            touchpoints for
                            offshoring.</p>

                        <p>Capitalize on low hanging fruit to identify a ballpark value added activity to beta test.
                            Override the digital
                            divide with additional clickthroughs from DevOps. Nanotechnology immersion along the
                            information
                            highway will close the loop on focusing solely on the bottom line.</p>

                        <div class="info">
                            <div class="lock-button">
                                @if ($userId == null)
                                    <a class="text-decoration-none" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalLogin">Unlock
                                        Contact</a>
                                @elseif ($unlockProject == false)
                                    <a href="{{ '/unlock-subcontractor-project/' . $project->id }}"
                                        class="text-decoration-none" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">Unlock
                                        Contact</a>
                                @else
                                    <a href="{{ '/unlock-subcontractor-project/' . $project->id }}"
                                        class="text-decoration-none">Unlock
                                        Contact</a>
                                @endif
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
                                    {{ $project->expertise_in ?? '-' }}
                                </li>
                                {{-- <li>
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
                                </li> --}}

                            </ul>
                        </div>

                        <div class="list mt-3">
                            <h6>Project types</h6>
                            <ul>
                                @if ($projectTypes != null)
                                    @foreach ($projectTypes as $projectType)
                                        <li>
                                            <div>{{ $projectType->name }}</div>
                                        </li>
                                    @endforeach
                                @else
                                    <li>
                                        -
                                    </li>
                                @endif
                                {{-- <li>
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
                                </li> --}}

                            </ul>
                        </div>

                        {{-- <div class="values">
                            <h6>Values</h6>
                            <p>Capitalize on low hanging fruit to identify a ballpark value added activity to beta test.
                                Override the digital
                                divide with additional clickthroughs from DevOps. Nanotechnology immersion along the
                                information
                                highway will close the loop on focusing solely on the bottom line.</p>
                        </div> --}}

                        <div class="detail-info">
                            <div class="full-label">
                                <h6>Current Opportunities:</h6>
                            </div>

                            @if ($contractorProjects->isNotEmpty())
                                @foreach ($contractorProjects as $contractorProject)
                                    <div class="full-list">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="content">
                                                        <h6>{{ $contractorProject->project_name }}</h6>
                                                        <ul>
                                                            <li><i class="fa-solid fa-location-dot"></i>
                                                                {{ $contractorProject->location }}</li>
                                                            <li><i class="fa-regular fa-clock"></i>
                                                                {{ $contractorProject->created_at->diffForHumans() }}</li>
                                                        </ul>

                                                        <p>{{ Str::limit($contractorProject->description, 100) }}</p>

                                                        <div class="gender">
                                                            @if (is_array($contractorProject->trade_category) && count($contractorProject->expertise_names))
                                                                @foreach ($contractorProject->expertise_names as $expertise)
                                                                    <span
                                                                        style="margin-bottom: 5px;">{{ $expertise }}</span>
                                                                @endforeach
                                                            @else
                                                                <span>{{ $contractorProject->trade_category }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="budget">
                                                        <div class="copy">
                                                            <i class="{{ $contractorProject->is_bookmarked ? 'fa-solid' : 'fa-regular' }} fa-bookmark bookmark-icon"
                                                                data-id="{{ $contractorProject->id }}"
                                                                style="cursor: pointer;"></i>
                                                        </div>
                                                        <h5>{{ $contractorProject->budget }}</h5>
                                                        <p>Budget</p>

                                                        <div class="link-light">
                                                            <a
                                                                href="{{ route('front.projectDetils', $contractorProject->id) }}">View
                                                                Profile</a>
                                                        </div>

                                                        <div class="link">
                                                            <a href="#">Message</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="full-list">
                                    <div class="col-12">
                                        <p>No current opportunities available.</p>
                                    </div>
                                </div>
                            @endif

                            {{-- <div class="full-list">
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
                            </div> --}}

                            <div class="full-label">
                                <h6>Past Project Completed : </h6>
                            </div>

                            @if ($portfolio->subContractorProtfolio->isNotEmpty())
                                @foreach ($portfolio->subContractorProtfolio as $p)
                                    <div class="prject-with-images mb-5 pb-3">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="img-with-text">
                                                    <h6>{{ $p->project_name }}</h6>

                                                    <ul class="list-unstyled">
                                                        <li><i class="fa-solid fa-location-dot"></i> {{ $p->location }}
                                                        </li>
                                                    </ul>

                                                    <p>{{ $p->description }}</p>
                                                    @php
                                                        $images = json_decode($p->images, true);
                                                    @endphp

                                                    <div class="img-wrapper">
                                                        <input type="hidden" name="dh" value="{{ $p->images }}">
                                                        @if ($images && is_array($images))
                                                            @foreach ($images as $image)
                                                                <img src="{{ asset('storage/' . $image) }}" alt=""
                                                                    class="img-fluid">
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="price">
                                                    <h6>{{ $p->price }}</h6>
                                                    <p>outcomes</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="prject-with-images mb-5 pb-3">
                                    <p>No past project available.</p>
                                </div>
                            @endif


                            {{-- <div class="prject-with-images mb-5 pb-3">
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
                                 <img src="{{ asset('assets/images/project-1.png') }}" alt="" class="img-fluid">
                                 <img src="{{ asset('assets/images/project-2.png') }}" alt="" class="img-fluid">
                                 <img src="{{ asset('assets/images/project-3.png') }}" alt="" class="img-fluid">
                                 <img src="{{ asset('assets/images/project-4.png') }}" alt="" class="img-fluid">
                                 <img src="{{ asset('assets/images/project-5.png') }}" alt="" class="img-fluid">
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
                  </div> --}}

                            <div class="full-label">
                                <h6>Reviews </h6>
                            </div>

                            @if ($subcontractorReviews != null && $subcontractorReviews->isNotEmpty() || $contractorReviews != null && $contractorReviews->isNotEmpty())
                                @foreach ($subcontractorReviews as $review)
                                    <div class="review-item">
                                        <div class="star">
                                            @php
                                                $subRatings = collect();

                                                foreach ($subcontractorReviews as $review) {
                                                    $subRatings = $subRatings->merge([
                                                        $review->workmanship,
                                                        $review->integrity,
                                                        $review->presentation,
                                                        $review->communication,
                                                    ]);
                                                }

                                                $filtered = $subRatings->filter(fn($val) => $val !== null);
                                                $subAvgRating = $filtered->isNotEmpty() ? $filtered->avg() : null;
                                            @endphp

                                            <div class="stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($subAvgRating >= $i)
                                                        <i class="fa-solid fa-star" style="color: #fbbf24;"></i>
                                                    @elseif ($subAvgRating >= $i - 0.5)
                                                        <i class="fa-solid fa-star-half-stroke" style="color: #fbbf24;"></i>
                                                    @else
                                                        <i class="fa-regular fa-star" style="color: #fbbf24;"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>

                                        {{-- <p>{{ $review->review_text ?? 'No comment provided.' }}</p> --}}

                                        @if ($review->user != null)
                                            <div class="client">
                                                <div class="photo">
                                                    <img src="{{ asset('storage/' . $review->user->profile_photo) }}" alt="Project Logo"
                                                        class="img-fluid">
                                                </div>
                                                <div class="name">
                                                    <h6>{{ $review->user->contact_name ?? 'Anonymous' }}</h6>
                                                    {{-- <p>{{ $review->user->designation ?? 'Client' }}</p> --}}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                 @endforeach
                                 @foreach ($contractorReviews as $review)
                                    <div class="review-item">
                                        <div class="star">
                                            @php
                                                $subRatings = collect();

                                                foreach ($contractorReviews as $review) {
                                                    $subRatings = $subRatings->merge([
                                                        $review->doj,
                                                        $review->payment_terms,
                                                        $review->support_staff,
                                                        $review->safety,
                                                    ]);
                                                }

                                                $filtered = $subRatings->filter(fn($val) => $val !== null);
                                                $subAvgRating = $filtered->isNotEmpty() ? $filtered->avg() : null;
                                            @endphp

                                            <div class="stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($subAvgRating >= $i)
                                                        <i class="fa-solid fa-star" style="color: #fbbf24;"></i>
                                                    @elseif ($subAvgRating >= $i - 0.5)
                                                        <i class="fa-solid fa-star-half-stroke" style="color: #fbbf24;"></i>
                                                    @else
                                                        <i class="fa-regular fa-star" style="color: #fbbf24;"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>

                                        {{-- <p>{{ $review->review_text ?? 'No comment provided.' }}</p> --}}

                                        @if ($review->user != null)
                                            <div class="client">
                                                <div class="photo">
                                                    <img src="{{ asset('storage/' . $review->user->profile_photo) }}" alt="Project Logo"
                                                        class="img-fluid">
                                                </div>
                                                <div class="name">
                                                    <h6>{{ $review->user->contact_name ?? 'Anonymous' }}</h6>
                                                    {{-- <p>{{ $review->user->designation ?? 'Client' }}</p> --}}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                 @endforeach
                            @else
                                <div class="review-item">
                                    <p>No reviews available.</p>
                                </div>
                            @endif

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

                            <form action="{{ route('front.sendEnquiryMail') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Phone </label>
                                    <input type="text" class="form-control" name="phone"
                                        value="{{ old('phone') }}" id="exampleInputPassword1">
                                    @error('phone')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Email </label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ old('email') }}" id="exampleInputPassword1">
                                    @error('email')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="floatingTextarea">Message</label>
                                    <textarea class="form-control" name="description" placeholder="" rows="4">{{{ old('description') }}}</textarea>
                                    @error('description')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" id="exampleInputPassword1" name="url"
                                        value="{{ Request::url() }}">
                                </div>

                                <button type="submit" class="btn btn-primary">Send</button>
                            </form>
                        </div>

                        <div class="share">
                            <p> Interesting? <a href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#shareModal">Share It!</a></p>
                        </div>

                        {{-- share popup --}}
                        <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-4 shadow">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="shareModalLabel">Share This Page</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    @php
                                        $url = urlencode(url()->current());
                                        $text = 'Check this out!';
                                        $encodedText = urlencode($text);
                                    @endphp
                                    <div class="modal-body text-center">
                                        <div class="d-flex justify-content-center gap-3">
                                            <div class="share-container">
                                                {{-- <div class="share-title">Share this page:</div> --}}
                                                <div class="share-buttons">
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}"
                                                        class="facebook" target="_blank" title="Facebook">
                                                        <i class="fab fa-facebook-f"></i>
                                                    </a>
                                                    <a href="https://twitter.com/intent/tweet?url={{ $url }}&text={{ $encodedText }}"
                                                        class="twitter" target="_blank" title="Twitter">
                                                        <i class="fab fa-twitter"></i>
                                                    </a>
                                                    <a href="https://wa.me/?text={{ $url }}" class="whatsapp"
                                                        target="_blank" title="WhatsApp">
                                                        <i class="fab fa-whatsapp"></i>
                                                    </a>
                                                    <a href="mailto:?subject={{ $encodedText }}&body={{ $url }}"
                                                        class="email" target="_blank" title="Email">
                                                        <i class="fas fa-envelope"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="area-map">
                            <div class="full-label">
                                <h6>Service Area Map</h6>
                            </div>

                            <img src="{{ asset('assets/images/map.png') }}" alt="" class="img-fluid">
                        </div> --}}

                        {{-- <div class="working-hours">
                            <div class="full-label">
                                <h6>Service Area Map</h6>
                            </div>

                            <p>{{ $protfolio->availability  ?? '-'}}</p>
                            {{-- <p>Tue <span>07:00 AM - 03:00 PM</span></p>
                            <p>Wed <span>07:00 AM - 03:00 PM</span></p>
                            <p>Thu <span>07:00 AM - 03:00 PM</span></p>
                            <p>Fir <span>07:00 AM - 03:00 PM</span></p>
                            <p>Sat <span>Close</span></p>
                            <p>Sun <span>Close</span></p>
                        </div> --}}

                        {{-- <div class="post-item">
                            <img src="{{ asset('assets/images/m-1.png') }}" alt="" class="img-fluid">
                            <h3>{{ $protfolioCount ?? '0' }}</h3>
                            <p>Project Posted</p>
                        </div> --}}

                        <div class="certificates-item">
                            <div class="full-label">
                                <h6>Certificates </h6>
                            </div>
                            @foreach ($portfolio->certifications as $certificat)
                                <img src="{{ asset('storage/' . $certificat->file_path) }}" alt=""
                                    class="img-fluid">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Limit Over</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Your Unlock Contact Limit Is Over,For More Unlock Pay AUD9</h4>
                </div>
                <div class="modal-footer">
                    <a href="{{ '/unlock-subcontractor-project/' . $project->id }}" class="btn">Buy</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Login</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Please Login For Unlock Contact</h4>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('login') }}" class="btn">Login</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.bookmark-icon', function(event) {

                const projectId = $(this).data('id');
                const iconElement = $(this);

                $.ajax({
                    url: "{{ route('contractor.bookmark.store') }}", // Route to store bookmark
                    type: 'POST',
                    data: {
                        id: projectId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'added') {
                            iconElement.removeClass('fa-regular').addClass('fa-solid');
                            toastr.success(response.message);
                        } else if (response.status === 'removed') {
                            toastr.success(response.message);
                            iconElement.removeClass('fa-solid').addClass('fa-regular');
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.bookmark-icon-1', function(event) {
                const iconElement = $(this).find('i');
                const subcontractorId = iconElement.data('id');

                $.ajax({
                    url: "{{ route('subcontractor.bookmark.store') }}", // Route to store bookmark
                    type: 'POST',
                    data: {
                        id: subcontractorId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'added') {
                            iconElement.removeClass('fa-regular').addClass('fa-solid');
                            toastr.success(response.message);
                        } else if (response.status === 'removed') {
                            toastr.success(response.message);
                            iconElement.removeClass('fa-solid').addClass('fa-regular');
                        } else {
                            window.location.href = "{{ route('login') }}";
                        }
                    },
                    error: function(xhr, status, error) {
                        window.location.href = "{{ route('login') }}";
                    }
                });
            });
        });
    </script>
@endsection
