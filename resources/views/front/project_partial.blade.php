@forelse ($projects as $project)
    <div class="full-list mb-4">
        <div class="col-12">
            <div class="row">
                <!-- Project Logo -->
                <div class="col-sm-3">
                    <div class="p-logo">
                        <img src="{{ asset('storage/' . $project->project_logo) }}" alt="Project Logo" class="img-fluid">
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
                            <span>
                                @if (is_array($project->trade_category))
                                    {{ implode(', ', $project->expertise_names) }}
                                @else
                                    {{ $project->trade_category }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Budget and Actions -->
                <div class="col-sm-4">
                    <div class="budget">
                        <div class="copy">
                            <i class="fa-regular fa-bookmark"></i>
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
