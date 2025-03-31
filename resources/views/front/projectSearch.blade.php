@extends('layouts.before')
@section('title')
    Project Search - Subby Finder
@endsection

@section('content')
    <section class="job-info">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filters -->
                <div class="col-md-4">
                    <div class="left-sidebar">
                        <form id="filter-form" method="GET">
                            <fieldset>
                                <!-- Location Filter -->
                                <div class="inner-form">
                                    <label for="location" class="form-label">Location</label>
                                    <select class="form-select" name="location" aria-label="Default select example"
                                        onchange="fetchProjects()">
                                        <option value="">
                                            Select location
                                        </option>
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->name }}">
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
                                            <option value="{{ $expertise->id }}">
                                                {{ $expertise->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Budget Filter -->
                                <div style="margin-bottom: 40px">
                                    <label for="budget" class="form-label">Budget Range</label>
                                    <select name="budget[]" id="budget" class="form-control" onchange="fetchProjects()"
                                        multiple>
                                        <option value="5K under">Under $5K</option>
                                        <option value="10K">$5K - $10K</option>
                                        <option value="25K">$10K - $25K</option>
                                        <option value="50K">$25K - $50K</option>
                                        <option value="100K">$50K - $100K</option>
                                        <option value="100k above">$100K or above</option>
                                    </select>
                                </div>

                                <!-- Project Types Filter -->
                                <div style="margin-bottom: 40px">
                                    <label for="project_type" class="form-label">Project type</label>
                                    <select name="project_type[]" id="project_type" multiple="multiple" class="form-control"
                                        onchange="fetchProjects()">
                                        @foreach ($project_types as $project_type)
                                            <option value="{{ $project_type->id }}">
                                                {{ $project_type->name }}
                                            </option>
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
                        @include('front.project_partial', ['projects' => $projects])
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
        document.addEventListener('DOMContentLoaded', function() {
            const element = document.querySelector('#budget');
            const choices = new Choices(element, {
                removeItemButton: true,
                placeholderValue: 'Select Options',
                searchEnabled: true
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const element = document.querySelector('#project_type');
            const choices = new Choices(element, {
                removeItemButton: true,
                placeholderValue: 'Select Options',
                searchEnabled: true
            });
        });
    </script>
    <script>
        // Fetch projects without submit button when value changes
        function fetchProjects(page = 1) {
            let url = '{{ route('front.projectSearch') }}?page=' + page;

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
                        } else if (response.status === 'removed') {
                            iconElement.removeClass('fa-solid').addClass('fa-regular');
                        }
                    }
                });
            });

            $(document).on('change', '#flexSwitchCheckChecked', function(event) {
                const emailAlerts = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    url: "{{ route('updateEmailAlerts') }}",
                    type: 'POST',
                    data: {
                        email_alerts: emailAlerts,
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
