@extends('layouts.contractor')
@section('title')
    Contractor Bookmark - Subby Finder
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
                        <a href="{{ route('contractor.dashboard.index') }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('contractor.dashboard.index') }}">Dashboard</a>
                    </li>
                    <li><a href="#">Bookmark</a></li>
                </ul>
            </div>
        </div>
    </div>


    <section class="review-dash">
        @forelse ($subcontractors as $subcontractor)
            <div class="inner-slide">
                <div class="inner-wrapper">
                    <div class="image">
                        <img src="{{ asset('storage/' . $subcontractor->profile_photo) }}" alt="" class="img-fluid">
                    </div>

                    <div class="content">
                        <h6>{{ $subcontractor->contact_name }}</h6>

                        <ul>
                            @if (is_array($subcontractor->trade_category) && count($subcontractor->expertise_names))
                                @foreach ($subcontractor->expertise_names as $expertise)
                                    <span style="margin-bottom: 5px;">{{ $expertise }}</span>
                                @endforeach
                            @else
                                <span>{{ $subcontractor->trade_category }}</span>
                            @endif
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
                    </div>
                </div>

                <div class="buttons">
                    <i class="{{ $subcontractor->is_bookmarked ? 'fa-solid' : 'fa-regular' }} fa-bookmark bookmark-icon"
                        data-id="{{ $subcontractor->id }}" style="cursor: pointer;"></i>

                    <a href="{{ route('front.subcontractorprojectdetilslock', $subcontractor->id) }}">View Profile</a>
                    <a href="#">Messages</a>
                </div>
            </div>
        @empty
            <div class="inner-slide text-center">
                <p>No Bookmark Subcontractor found.</p>
            </div>
        @endforelse


        <!-- Pagination -->
        <div class="pagination-wrapper mt-4">
            {{ $subcontractors->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
        </div>
    </section>
@endsection
