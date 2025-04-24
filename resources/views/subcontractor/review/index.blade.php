@extends('layouts.subcontractor')
@section('title')
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
        @foreach ($projectsToDisplay as $unlockedProject)
            @if ($unlockedProject->project_type === 'contractor_project')
                <div class="inner-slide">
                    <div class="top-label">
                        <img src="{{ asset('assets/images/order.png') }}" alt="">
                        <p>Rate Subcontractor</p>
                    </div>

                    <div class="inner-wrapper">
                        <div class="image">
                            <img src="{{ asset('storage/' . $unlockedProject->project->project_logo) ?? '' }}" alt=""
                                class="img-fluid">
                        </div>

                        <div class="content">
                            <h6>{{ $unlockedProject->project->contractor->contact_name }} </h6>

                            <ul>
                                <li>Electrician</li>
                                <li> <i class="fa-solid fa-location-dot"></i> {{ $unlockedProject->project->location }}
                                </li>
                            </ul>

                            <p>Project: <b>{{ $unlockedProject->project->project_name }}</b></p>

                            @php
                                $matchedReview = $reviewProjects->first(function ($review) use ($unlockedProject) {
                                    return $review->project_id == $unlockedProject->project->id &&
                                        $review->project_type == $unlockedProject->project_type;
                                });

                                if ($matchedReview) {
                                    $ratings = [
                                        $matchedReview->workmanship,
                                        $matchedReview->integrity,
                                        $matchedReview->presentation,
                                        $matchedReview->communication,
                                    ];

                                    // Filter out nulls and calculate average
                                    $filtered = array_filter($ratings, fn($r) => $r !== null);
                                    $averageRating = count($filtered)
                                        ? round(array_sum($filtered) / count($filtered), 1)
                                        : null;
                                }
                            @endphp

                            @if ($matchedReview && $averageRating)
                                <div class="ratimg">
                                    <div class="number">
                                        {{ number_format($averageRating, 1) }}
                                    </div>

                                    <div class="star">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($averageRating >= $i)
                                                <i class="fa-solid fa-star" style="color: #fbbf24;"></i> <!-- full star -->
                                            @elseif ($averageRating >= $i - 0.5)
                                                <i class="fa-solid fa-star-half-stroke" style="color: #fbbf24;"></i>
                                                <!-- half star -->
                                            @else
                                                <i class="fa-regular fa-star" style="color: #fbbf24;"></i>
                                                <!-- empty star -->
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="link">
                        @if ($matchedReview)
                            <!-- Show delete icon -->
                            <form method="POST" style="display: inline;"
                                action="{{ route('subcontractor.reviews.destroy', $matchedReview->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete border-0">
                                    <img src="{{ asset('assets/images/delete.png') }}" alt="" class="img-fluid">
                                </button>
                            </form>
                        @else
                            <!-- Show leave review link -->
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                class="text-white pe-auto" data-project-id="{{ $unlockedProject->project->id }}"
                                data-project-type="{{ $unlockedProject->project_type }}">
                                Leave a Review
                            </a>
                        @endif
                    </div>
                </div>
            @elseif($unlockedProject->project_type === 'subcontractor_project')
                <div class="inner-slide">
                    <div class="top-label">
                        <img src="{{ asset('assets/images/order.png') }}" alt="">
                        <p>Rate Subcontractor</p>
                    </div>

                    <div class="inner-wrapper">
                        <div class="image">
                            <img src="{{ asset('storage/' . $unlockedProject->project->profile_photo) ?? '' }}" alt=""
                                class="img-fluid">
                        </div>

                        <div class="content">
                            <h6>{{ $unlockedProject->project->contact_name }} </h6>

                            <ul>
                                <li>Electrician</li>
                                <li> <i class="fa-solid fa-location-dot"></i>
                                    {{ $unlockedProject->project->location ?? '-' }}
                                </li>
                            </ul>

                            <p>Project: <b>{{ $unlockedProject->project->business_name }}</b></p>


                            @php
                                $matchedReview = $reviewProjects->first(function ($review) use ($unlockedProject) {
                                    return $review->project_id == $unlockedProject->project->id &&
                                        $review->project_type == $unlockedProject->project_type;
                                });

                                if ($matchedReview) {
                                    $ratings = [
                                        $matchedReview->workmanship,
                                        $matchedReview->integrity,
                                        $matchedReview->presentation,
                                        $matchedReview->communication,
                                    ];

                                    // Filter out nulls and calculate average
                                    $filtered = array_filter($ratings, fn($r) => $r !== null);
                                    $averageRating = count($filtered)
                                        ? round(array_sum($filtered) / count($filtered), 1)
                                        : null;
                                }
                            @endphp

                            @if ($matchedReview && $averageRating)
                                <div class="ratimg">
                                    <div class="number">
                                        {{ number_format($averageRating, 1) }}
                                    </div>

                                    <div class="star">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($averageRating >= $i)
                                                <i class="fa-solid fa-star" style="color: #fbbf24;"></i> <!-- full star -->
                                            @elseif ($averageRating >= $i - 0.5)
                                                <i class="fa-solid fa-star-half-stroke" style="color: #fbbf24;"></i>
                                                <!-- half star -->
                                            @else
                                                <i class="fa-regular fa-star" style="color: #fbbf24;"></i>
                                                <!-- empty star -->
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="link">
                        @if ($matchedReview)
                            <!-- Show delete icon -->
                            <form method="POST" style="display: inline;"
                                action="{{ route('subcontractor.reviews.destroy', $matchedReview->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete border-0">
                                    <img src="{{ asset('assets/images/delete.png') }}" alt="" class="img-fluid">
                                </button>
                            </form>
                        @else
                            <!-- Show leave review link -->
                            <div class="link">
                                <a href="" data-bs-toggle="modal" class="text-white pe-auto"
                                    data-bs-target="#exampleModal" data-project-id="{{ $unlockedProject->project->id }}"
                                    data-project-type="{{ $unlockedProject->project_type }}">Leave
                                    a Review </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
        {{-- @foreach ($unlockedProjects as $unlockedProject)
            <div class="inner-slide">
                <div class="top-label">
                    <img src="{{ asset('assets/images/order.png') }}" alt="">
                    <p>Rate Subcontractor</p>
                </div>

                <div class="inner-wrapper">
                    <div class="image">
                        <img src="{{ asset('storage/' . $unlockedProject->project->project_logo) }}" alt=""
                            class="img-fluid">
                    </div>

                    <div class="content">
                        <h6>{{ $unlockedProject->project->contractor->contact_name }} </h6>

                        <ul>
                            <li>Electrician</li>
                            <li> <i class="fa-solid fa-location-dot"></i> {{ $unlockedProject->project->location }} </li>
                        </ul>

                        <p>Project: <b>{{ $unlockedProject->project->project_name }}</b></p>


                        @php
                            $matchedReview = $reviewProjects->first(function ($review) use ($unlockedProject) {
                                return $review->project_id == $unlockedProject->project->id &&
                                    $review->project_type == $unlockedProject->project_type;
                            });

                            if ($matchedReview) {
                                $ratings = [
                                    $matchedReview->workmanship,
                                    $matchedReview->integrity,
                                    $matchedReview->presentation,
                                    $matchedReview->communication,
                                ];

                                // Filter out nulls and calculate average
                                $filtered = array_filter($ratings, fn($r) => $r !== null);
                                $averageRating = count($filtered)
                                    ? round(array_sum($filtered) / count($filtered), 1)
                                    : null;
                            }
                        @endphp

                        @if ($matchedReview && $averageRating)
                            <div class="ratimg">
                                <div class="number">
                                    {{ number_format($averageRating, 1) }}
                                </div>

                                <div class="star">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($averageRating >= $i)
                                            <i class="fa-solid fa-star" style="color: #fbbf24;"></i> <!-- full star -->
                                        @elseif ($averageRating >= $i - 0.5)
                                            <i class="fa-solid fa-star-half-stroke" style="color: #fbbf24;"></i> <!-- half star -->
                                        @else
                                            <i class="fa-regular fa-star" style="color: #fbbf24;"></i> <!-- empty star -->
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        @endif
                    </div>
                </div>


                <div class="link">
                    @if ($matchedReview)
                        <!-- Show delete icon -->
                        <form method="POST" style="display: inline;"
                            action="{{ route('subcontractor.reviews.destroy', $matchedReview->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete border-0">
                                <img src="{{ asset('assets/images/delete.png') }}" alt="" class="img-fluid">
                            </button>
                        </form>
                    @else
                        <!-- Show leave review link -->
                        <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="text-white pe-auto"
                            data-project-id="{{ $unlockedProject->project->id }}"
                            data-project-type="{{ $unlockedProject->project_type }}">
                            Leave a Review
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
        @foreach ($unlockedSubContractorProjects as $unlockedProject)
            <div class="inner-slide">
                <div class="top-label">
                    <img src="{{ asset('assets/images/order.png') }}" alt="">
                    <p>Rate Subcontractor</p>
                </div>

                <div class="inner-wrapper">
                    <div class="image">
                        <img src="{{ asset('storage/' . $unlockedProject->project->profile_photo) }}" alt=""
                            class="img-fluid">
                    </div>

                    <div class="content">
                        <h6>{{ $unlockedProject->project->contact_name }} </h6>

                        <ul>
                            <li>Electrician</li>
                            <li> <i class="fa-solid fa-location-dot"></i> {{ $unlockedProject->project->location ?? '-' }}
                            </li>
                        </ul>

                        <p>Project: <b>{{ $unlockedProject->project->business_name }}</b></p>


                        @php
                            $matchedReview = $reviewProjects->first(function ($review) use ($unlockedProject) {
                                return $review->project_id == $unlockedProject->project->id &&
                                    $review->project_type == $unlockedProject->project_type;
                            });

                            if ($matchedReview) {
                                $ratings = [
                                    $matchedReview->workmanship,
                                    $matchedReview->integrity,
                                    $matchedReview->presentation,
                                    $matchedReview->communication,
                                ];

                                // Filter out nulls and calculate average
                                $filtered = array_filter($ratings, fn($r) => $r !== null);
                                $averageRating = count($filtered)
                                    ? round(array_sum($filtered) / count($filtered), 1)
                                    : null;
                            }
                        @endphp

                        @if ($matchedReview && $averageRating)
                            <div class="ratimg">
                                <div class="number">
                                    {{ number_format($averageRating, 1) }}
                                </div>

                                <div class="star">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($averageRating >= $i)
                                            <i class="fa-solid fa-star" style="color: #fbbf24;"></i> <!-- full star -->
                                        @elseif ($averageRating >= $i - 0.5)
                                            <i class="fa-solid fa-star-half-stroke" style="color: #fbbf24;"></i> <!-- half star -->
                                        @else
                                            <i class="fa-regular fa-star" style="color: #fbbf24;"></i> <!-- empty star -->
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        @endif
                    </div>
                </div>



                <div class="link">
                    @if ($matchedReview)
                        <!-- Show delete icon -->
                        <form method="POST" style="display: inline;"
                            action="{{ route('subcontractor.reviews.destroy', $matchedReview->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete border-0">
                                <img src="{{ asset('assets/images/delete.png') }}" alt="" class="img-fluid">
                            </button>
                        </form>
                    @else
                        <!-- Show leave review link -->
                        <div class="link">
                            <a href="" data-bs-toggle="modal" class="text-white pe-auto"
                                data-bs-target="#exampleModal" data-project-id="{{ $unlockedProject->project->id }}"
                                data-project-type="{{ $unlockedProject->project_type }}">Leave
                                a Review </a>
                        </div>
                    @endif
                </div>
            </div>
            </div>
        @endforeach --}}
        {{-- <div class="inner-slide">
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
        </div> --}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="max-w-3xl mx-auto bg-white p-8 rounded">

                            <form id="reviewForm" class="space-y-6" method="POST"
                                action="{{ route('subcontractor.reviews.store') }}">
                                @csrf
                                <input type="hidden" name="project_id" id="project_id">
                                <input type="hidden" name="project_type" id="project_type">
                                <!-- Question 1 -->
                                <div class="form-group mb-4">
                                    <label class="block font-medium mb-2">1. Did you contact the contractor?</label>
                                    <div class="flex space-x-4">
                                        <label><input type="radio" name="contacted" value="yes" class="mr-1" />
                                            Yes</label>
                                        <label><input type="radio" name="contacted" value="no" class="mr-1" />
                                            No</label>
                                    </div>
                                    <div id="feedbackWhyNoContact" class="mt-4 d-none">
                                        <label class="block text-sm mb-1">Please share why:</label>
                                        <input type="text" class="w-full border rounded px-3 py-2"
                                            name="reason_no_contact" />
                                    </div>
                                </div>

                                <!-- Question 2 -->
                                <div id="agreedWorkSection" class="d-none form-group mb-4">
                                    <label class="block font-medium mb-2">2. Have you agreed to works with the
                                        contractor?</label>
                                    <div class="flex space-x-4">
                                        <label><input type="radio" name="agreed" value="yes" class="mr-1" />
                                            Yes</label>
                                        <label><input type="radio" name="agreed" value="no" class="mr-1" />
                                            No</label>
                                    </div>
                                    <div id="shortReviewDealings" class="mt-4 d-none">
                                        <label class="block text-sm mb-1">Please leave a short review of your
                                            dealings:</label>
                                        <textarea class="w-full border rounded px-3 py-2" name="dealings_review"></textarea>
                                    </div>
                                </div>

                                <!-- Question 3 -->
                                <div id="completedProjectSection" class="d-none form-group mb-4">
                                    <label class="block font-medium mb-2">3. Have you completed the project?</label>
                                    <div class="flex space-x-4">
                                        <label><input type="radio" name="completed" value="yes" class="mr-1" />
                                            Yes</label>
                                        <label><input type="radio" name="completed" value="no" class="mr-1" />
                                            No</label>
                                    </div>
                                    <div id="finalReviewSection" class="mt-4 d-none">
                                        <label class="block text-sm mb-1">Please leave a final review:</label>
                                        <textarea class="w-full border rounded px-3 py-2" name="final_review"></textarea>
                                    </div>
                                </div>

                                <!-- Question 4 -->
                                <div id="completionEstimateSection" class="d-none form-group mb-4">
                                    <label class="block font-medium mb-2">4. When do you think you will carry out the
                                        project?</label><br>
                                    <select class="w-full border rounded px-3 py-2" name="completion_estimate">
                                        <option value="" disabled selected>Select an option</option>
                                        <option value="7">Within 7 days</option>
                                        <option value="30">Within 30 days</option>
                                        <option value="90">Within 3 months</option>
                                    </select>
                                </div>



                                <div class="form-group mb-4">
                                    <label>Workmanship</label>
                                    <div class="star-rating">
                                        <input type="radio" name="workmanship" id="workmanship-5"
                                            value="5"><label for="workmanship-5">★</label>
                                        <input type="radio" name="workmanship" id="workmanship-4"
                                            value="4"><label for="workmanship-4">★</label>
                                        <input type="radio" name="workmanship" id="workmanship-3"
                                            value="3"><label for="workmanship-3">★</label>
                                        <input type="radio" name="workmanship" id="workmanship-2"
                                            value="2"><label for="workmanship-2">★</label>
                                        <input type="radio" name="workmanship" id="workmanship-1"
                                            value="1"><label for="workmanship-1">★</label>
                                    </div>
                                </div>

                                <div class=" form-group mb-4">
                                    <label>Integrity</label>
                                    <div class="star-rating">
                                        <input type="radio" name="integrity" id="integrity-5" value="5"><label
                                            for="integrity-5">★</label>
                                        <input type="radio" name="integrity" id="integrity-4" value="4"><label
                                            for="integrity-4">★</label>
                                        <input type="radio" name="integrity" id="integrity-3" value="3"><label
                                            for="integrity-3">★</label>
                                        <input type="radio" name="integrity" id="integrity-2" value="2"><label
                                            for="integrity-2">★</label>
                                        <input type="radio" name="integrity" id="integrity-1" value="1"><label
                                            for="integrity-1">★</label>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label>Presentation</label>
                                    <div class="star-rating">
                                        <input type="radio" name="presentation" id="presentation-5"
                                            value="5"><label for="presentation-5">★</label>
                                        <input type="radio" name="presentation" id="presentation-4"
                                            value="4"><label for="presentation-4">★</label>
                                        <input type="radio" name="presentation" id="presentation-3"
                                            value="3"><label for="presentation-3">★</label>
                                        <input type="radio" name="presentation" id="presentation-2"
                                            value="2"><label for="presentation-2">★</label>
                                        <input type="radio" name="presentation" id="presentation-1"
                                            value="1"><label for="presentation-1">★</label>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <label>Communication</label>
                                    <div class="star-rating">
                                        <input type="radio" name="communication" id="communication-5"
                                            value="5"><label for="communication-5">★</label>
                                        <input type="radio" name="communication" id="communication-4"
                                            value="4"><label for="communication-4">★</label>
                                        <input type="radio" name="communication" id="communication-3"
                                            value="3"><label for="communication-3">★</label>
                                        <input type="radio" name="communication" id="communication-2"
                                            value="2"><label for="communication-2">★</label>
                                        <input type="radio" name="communication" id="communication-1"
                                            value="1"><label for="communication-1">★</label>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Save changes">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="pagination-wrapper mt-4 d-flex justify-content-center">
            {{ $paginatedProjects->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        document.querySelectorAll('input[name="contacted"]').forEach(el => {
            el.addEventListener('change', e => {
                const value = e.target.value;
                document.getElementById('feedbackWhyNoContact').classList.toggle('d-none', value !== 'no');
                document.getElementById('agreedWorkSection').classList.toggle('d-none', value !== 'yes');
            });
        });

        document.querySelectorAll('input[name="agreed"]').forEach(el => {
            el.addEventListener('change', e => {
                const value = e.target.value;
                document.getElementById('shortReviewDealings').classList.toggle('d-none', value !== 'no');
                document.getElementById('completedProjectSection').classList.toggle('d-none', value !==
                    'yes');
            });
        });

        document.querySelectorAll('input[name="completed"]').forEach(el => {
            el.addEventListener('change', e => {
                const value = e.target.value;
                document.getElementById('finalReviewSection').classList.toggle('d-none', value !== 'yes');
                document.getElementById('completionEstimateSection').classList.toggle('d-none', value !==
                    'no');
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#exampleModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var projectId = button.data('project-id'); // Extract info from data-* attributes
                var projectType = button.data('project-type'); // Extract info from data-* attributes
                var modal = $(this);
                modal.find('#project_id').val(projectId); // Set the project ID in the hidden input
                modal.find('#project_type').val(projectType); // Set the project ID in the hidden input
            });
        });
    </script>
@endsection
