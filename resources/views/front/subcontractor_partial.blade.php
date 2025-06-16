<div class="full-list mb-4">
    <div class="col-12">
        <div class="row">
            <div class="top-bar">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"
                        {{ $userEmailAlerts ? 'checked' : '' }}>
                    <label class="form-check-label" for="flexSwitchCheckChecked">Turn on email alerts for this
                        search</label>
                </div>

                <div class="filter">
                    <div class="dropdown d-flex align-items-center">
                        <span class="me-2">Sort by:</span>
                        <div class="form-check-label">
                            <select name="sort_by" style="padding: 12px 28px" class="form-select"
                                onchange="fetchProjects()" style="width: auto;">
                                <option value="latest" @if ($sortBy == 'latest') selected @endif>
                                    Latest to Old
                                </option>
                                <option value="oldest" @if ($sortBy == 'oldest') selected @endif>
                                    Old to Latest
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="review-dash mt-5">
    @forelse ($subcontractors as $subcontractor)
        <div class="inner-slide">
            <div class="inner-wrapper">
                <div class="image">
                    <div class="check">
                        <img src="{{$subcontractor->profile_photo ? asset('storage/' . $subcontractor->profile_photo) : asset('assets/images/icons8-person-94.png')}}" alt=""
                            class="img-fluid">
                    </div>
                </div>

                <div class="content">
                    <h6>{{ $subcontractor->contact_name }} </h6>
                    <ul style="margin-bottom: 10px">
                        <li><i class="fa-solid fa-location-dot"></i> {{ $subcontractor->location }}</li>
                        <li><i class="fa-regular fa-clock"></i> {{ $subcontractor->created_at->diffForHumans() }}</li>
                    </ul>
                    <ul>
                        @if (is_array($subcontractor->trade_category) && count($subcontractor->expertise_names))
                            @foreach ($subcontractor->expertise_names as $expertise)
                                <span style="margin-bottom: 5px; margin-left: 3px; ">{{ $expertise }}</span>
                            @endforeach
                        @else
                            <span>{{ $subcontractor->trade_category }}</span>
                        @endif
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
                </div>
            </div>

            <div class="buttons">
                <div class="copy">
                    <i class="{{ $subcontractor->is_bookmarked ? 'fa-solid' : 'fa-regular' }} fa-bookmark bookmark-icon"
                        data-id="{{ $subcontractor->id }}" style="cursor: pointer;"></i>
                </div>
                <a href="{{ route('front.subcontractorprojectdetils', $subcontractor->id) }}">View More</a>
                {{-- <a href="#">Message </a> --}}
            </div>
        </div>
    @empty
        <div class="inner-slide text-center">
            <p>No Subcontractor found.</p>
        </div>
    @endforelse


    <!-- Pagination -->
    <div class="pagination-wrapper mt-4 d-flex justify-content-center">
        {{ $subcontractors->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
    </div>
</section>
