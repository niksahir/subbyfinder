@extends('layouts.before')
@section('title')
    Principal Contractor - Subby Finder
@endsection

@section('content')
    <section class="job-info">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="left-sidebar">
                        <form id="filter-form" method="GET">
                            <fieldset>
                                <input type="hidden" name="project" value="{{ request('project') }}">
                                <!-- Location Filter -->
                                <div class="inner-form">
                                    <label for="location" class="form-label">Location</label>
                                    <select class="form-select" name="location" onchange="fetchProjects()">
                                        <option value="">Select location</option>
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->name }}"
                                                {{ request('location') == $location->name ? 'selected' : '' }}>
                                                {{ $location->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Category Filter -->
                                <div style="margin-bottom: 40px">
                                    <label for="trade_category" class="form-label">Category</label>
                                    <select name="trade_category[]" id="trade_category" multiple="multiple"
                                        class="form-control" onchange="fetchProjects()">
                                        @foreach ($expertise_in as $expertise)
                                            <option value="{{ $expertise->id }}" @if($tradeCategory && $expertise->id == $tradeCategory) selected @endif>
                                                {{ $expertise->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Location Filter -->
                                <div class="inner-form">
                                    <label for="availability" class="form-label">Availability</label>
                                    <select class="form-select" name="availability" aria-label="Default select example"
                                        onchange="fetchProjects()">
                                        <option value="">
                                            Select availability
                                        </option>
                                        @foreach (config('constants.availability') as $availability)
                                            <option value="{{ $availability }}">
                                                {{ $availability }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>

                <!-- Projects List -->
                <div class="col-md-8">
                    <div class="result" id="project-list">
                        @include('front.subcontractor_partial', ['subcontractors' => $subcontractors,'subcontractorReviews' => $subcontractorReviews])
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const element = document.querySelector('#trade_category');
            const choices = new Choices(element, {
                removeItemButton: true,
                placeholderValue: 'Select Options',
                searchEnabled: true
            });
        });

        function fetchProjects(page = 1) {
            let url = '{{ route('front.subcontractorsearch') }}?page=' + page;

            // Get form data and add sort_by value
            let formData = $('#filter-form').serializeArray();
            formData.push({
                name: 'sort_by',
                value: $('select[name="sort_by"]').val()
            });

            $.ajax({
                url: url,
                type: 'GET',
                data: $.param(formData),
                success: function(response) {
                    $('#project-list').html(response.html);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            // Fetch projects when the page loads
            fetchProjects();

            // Handle Pagination without reload
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetchProjects(page);
            });

            $(document).on('click', '.bookmark-icon', function(event) {

                const subcontractorId = $(this).data('id');
                const iconElement = $(this);

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

            $(document).on('change', '#flexSwitchCheckChecked', function(event) {
                const emailAlerts = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    url: "{{ route('updateEmailAlerts') }}",
                    type: 'POST',
                    data: {
                        subcontractor_email_alerts: emailAlerts,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // alert(response.message);
                    }
                });
            });
        });
    </script>
@endsection
