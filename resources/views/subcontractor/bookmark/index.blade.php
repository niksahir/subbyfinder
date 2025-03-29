@extends('layouts.subcontractor')
@section('title')
    Sub Contractor
@endsection

@section('content')
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="title">
                <h4>Bookmark</h4>
            </div>
        </div>

        <div class="col-md-6">
            <div class="breadcrumb">
                <ul>
                    <li>
                        <a href="{{ route('front.home') }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('subcontractor.dashboard.index') }}">Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('subcontractor.bookmark.index') }}">Bookmark</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <section class="review-dash">
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
                <p>No Bookmark projects found.</p>
            </div>
        @endforelse


        <!-- Pagination -->
        <div class="pagination-wrapper mt-4">
            {{ $projects->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
        </div>
    </section>

@endsection
