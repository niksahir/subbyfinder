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
                            <select name="sort_by" class="form-select" onchange="fetchProjects()" style="width: auto;">
                                <option value="latest" @if ($sortBy == 'latest') selected @endif>
                                    Latest to Old
                                </option>
                                <option value="oldest" @if ($sortBy == 'oldest') selected @endif>
                                    Old to Latest
                                </option>
                                <option value="price_asc" @if ($sortBy == 'price_asc') selected @endif>
                                    Price Ascending
                                </option>
                                <option value="price_desc" @if ($sortBy == 'price_desc') selected @endif>
                                    Price Descending
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@forelse ($projects as $project)
    <div class="full-list mb-4">
        <div class="col-12">
            <div class="row">
                <!-- Project Logo -->
                <div class="col-sm-3">
                    <div class="p-logo">
                        <img src="{{ asset('storage/' . $project->project_logo) }}" alt="Project Logo"
                            class="img-fluid">
                    </div>
                </div>

                <!-- Project Details -->
                <div class="col-sm-5">
                    <div class="content">
                        <h6>{{ $project->project_name }}</h6>
                        <ul>
                            <li><i class="fa-solid fa-location-dot"></i> {{ $project->location }}</li>
                            <li><i class="fa-regular fa-clock"></i> {{ $project->created_at->diffForHumans() }}</li>
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

                <!-- Budget and Actions -->
                <div class="col-sm-4">
                    <div class="budget">
                        <div class="copy">
                            <i class="{{ $project->is_bookmarked ? 'fa-solid' : 'fa-regular' }} fa-bookmark bookmark-icon"
                                data-id="{{ $project->id }}" style="cursor: pointer;"></i>
                        </div>
                        <h5>{{ $project->budget }}</h5>
                        <p>Budget</p>
                        <div class="link-light">
                            <a href="{{ route('front.projectdetilslock', $project->id) }}">View Profile</a>
                        </div>
                        <div class="link">
                            <a href="#">Message</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="inner-slide text-center">
        <p>No projects found.</p>
    </div>
@endforelse

<!-- Pagination -->
<div class="pagination-wrapper mt-4">
    {{ $projects->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
</div>
