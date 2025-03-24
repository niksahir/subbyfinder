@extends('layouts.contractor')
@section('title')
    Projects
@endsection

@section('content')
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="title">
                <h4>Projects</h4>
            </div>
        </div>

        <div class="col-md-6">
            <div class="breadcrumb">
                <ul>
                    <li>
                        <a href="{{ route('contractor.dashboard.index') }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('contractor.dashboard.index') }}">Dashboard</a>
                    </li>
                    <li>
                        <a href="#">Bookmark</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <section class="review-dash">
        <div class="inner-slide">
            <div class="top-label">
                <div class="row">
                    <div class="col-md-6">
                        <img src="{{ asset('assets/images/order.png') }}" alt="">
                        <p>Project Listing</p>
                    </div>

                    <div class="col-md-6">
                        <div class="link text-right">
                            <a href="{{ route('contractor.projects.create') }}">Post New</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($projects as $project)
            <div class="inner-slide">
                <div class="inner-wrapper">
                    <!-- Project Logo -->
                    <div class="image not-round">
                        <img src="{{ asset('storage/' . $project->project_logo) }}" alt="Project Logo" class="img-fluid">
                    </div>

                    <!-- Project Details -->
                    <div class="content">
                        <h6>{{ $project->project_name }}</h6>

                        <ul class="">
                            <li>
                                @if (is_array($project->trade_category))
                                    {{ implode(', ', $project->expertise_names) }}
                                @else
                                    {{ $project->trade_category }}
                                @endif
                            </li>
                            <li>
                                <i class="fa-solid fa-location-dot"></i> {{ $project->location }}
                            </li>
                        </ul>

                        <p>{{ Str::limit($project->description, 100) }}</p>
                        <span>{{ $project->budget }}</span>
                    </div>
                </div>

                <!-- Buttons for Edit/Delete -->
                <div class="buttons">
                    <i class="fa-solid fa-edit" onclick="editProject({{ $project->id }})"></i>
                    <i class="fa-solid fa-trash" onclick="deleteProject({{ $project->id }})"></i>
                </div>
            </div>
        @endforeach
        <div class="pagination-wrapper mt-4">
            {{ $projects->links('pagination::bootstrap-4') }}
        </div>
    </section>
@endsection
