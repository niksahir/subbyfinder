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
                                    <label class="form-label">Location</label>

                                    {{-- Autocomplete text box --}}
                                    <input type="text" id="autocomplete" name="location"
                                        class="form-control @error('location') is-invalid @enderror"
                                        placeholder="Search for a location…" value="{{ old('location') }}"
                                        autocomplete="off" />

                                    {{-- These get filled automatically after the user picks a place --}}
                                    <input type="hidden" name="lat" id="lat">
                                    <input type="hidden" name="lng" id="lng">
                                    <input type="hidden" name="place_id" id="place_id">

                                    @error('location')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror

                                    <div id="place-result" class="mt-2 small text-muted"></div>
                                </div>
                                <div class="inner-form d-none" id="range-container">
                                    <label for="range" class="form-label">Range:
                                        <span id="rangeValue">5</span> <!-- Will update dynamically -->
                                    </label>
                                    <input type="range" id="range" name="range"
                                        class="form-control @error('range') is-invalid @enderror" min="5"
                                        max="100" value="5"
                                        style="color: #F77A36 !important; background-color: #FEF6F1 !important; height: 19px !important; padding: 0px !important; border-radius: 50px;" />
                                </div>
                                <!-- Category Filter -->
                                <div style="margin-bottom: 40px">
                                    <label for="trade_category" class="form-label">Category</label>
                                    <select name="trade_category[]" id="trade_category" multiple="multiple"
                                        class="form-control" onchange="fetchProjects()">
                                        @foreach ($expertise_in as $expertise)
                                            <option value="{{ $expertise->id }}"
                                                @if ($tradeCategory && $expertise->id == $tradeCategory) selected @endif>
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
                        @include('front.subcontractor_partial', [
                            'subcontractors' => $subcontractors,
                            'subcontractorReviews' => $subcontractorReviews,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rangeInput = document.getElementById('range');
            const rangeValue = document.getElementById('rangeValue');
            const locationInput = document.getElementById('autocomplete');

            if (!locationInput.value) {
                rangeInput.setAttribute('disabled', 'disabled');
            }

            rangeValue.textContent = rangeInput.value;

            rangeInput.addEventListener('input', function() {
                rangeValue.textContent = this.value;
            });
        });
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_places.key') }}&libraries=places"
        defer></script>

    <script>
        $(function() {

            const $form = $('#filter-form'); // whole sidebar form
            const $input = $('#autocomplete'); // visible location box
            const $lat = $('#lat'); // hidden
            const $lng = $('#lng'); // hidden
            const $placeId = $('#place_id'); // hidden
            const $resultTxt = $('#place-result'); // small feedback line
            const $listBox = $('#project-list'); // results wrapper

            /* ---------- 1.  CENTRAL AJAX HELPER ---------- */
            window.fetchProjects = function fetchProjects(page = 1){

                const base = "{{ route('front.subcontractorsearch') }}";
                const url = `${base}?page=${page}`;

                // collect every input inside #filter-form
                const data = $form.serializeArray();

                // include sort_by if dropdown lives elsewhere
                const sortVal = $('select[name="sort_by"]').val();
                if (sortVal !== undefined) {
                    data.push({
                        name: 'sort_by',
                        value: sortVal
                    });
                }

                $.ajax({
                    url,
                    type: 'GET',
                    data: $.param(data),
                    beforeSend() {
                        $listBox.html('<p class="text-center my-3">Loading …</p>');
                    },
                    success(resp) {
                        $listBox.html(resp.html);
                        wirePagination(); // re‑attach AJAX to new links
                    },
                    error(xhr) {
                        console.error(xhr.responseText);
                        $listBox.html('<p class="text-danger my-3">Could not load results.</p>');
                    }
                });
            }

            function wirePagination() {
                $listBox.find('.pagination a').on('click', function(e) {
                    e.preventDefault();
                    const page = (this.href.split('page=')[1]) || 1;
                    fetchProjects(page);
                });
            }

            function initPlaces() {
                const ac = new google.maps.places.Autocomplete(
                    document.getElementById('autocomplete'), {
                        types: ['geocode'],
                        componentRestrictions: {
                            country: 'AU'
                        }
                    }
                );

                ac.addListener('place_changed', () => {
                    const place = ac.getPlace();
                    if (!place.geometry) {
                        $resultTxt.text('No details for that place – try again.');
                        return;
                    }

                    // fill hidden fields
                    $input.val(place.formatted_address || place.name);
                    $lat.val(place.geometry.location.lat());
                    $lng.val(place.geometry.location.lng());
                    $placeId.val(place.place_id || '');
                    // $resultTxt.text(place.formatted_address);
                    const rangeInput = document.getElementById('range');
                    const rangeContainer = document.getElementById('range-container');
                    rangeContainer.classList.remove('d-none');
                    rangeContainer.classList.add('d-block');
                    rangeInput.removeAttribute('disabled');

                    /* show the current thumb value again (optional) */
                    document.getElementById('rangeValue').textContent = rangeInput.value;

                    fetchProjects(); // run search immediately
                });
            }

            // wait for Google script (loaded with defer)
            (function waitForGoogle(tries = 0) {
                if (window.google && google.maps && google.maps.places) {
                    initPlaces();
                } else if (tries < 20) {
                    setTimeout(() => waitForGoogle(++tries), 300);
                }
            })();

            $form.on('change', 'select, input[name="availability"], input[name="project"]', () => fetchProjects());

            wirePagination(); // first server‑rendered list

            const rangeInput = document.getElementById('range');
            const rangeValue = document.getElementById('rangeValue');

            rangeInput.addEventListener('change', function() {
                fetchProjects();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Choices('#trade_category', {
                removeItemButton: true,
                placeholderValue: 'Select Options',
                searchEnabled: true
            });
        });
    </script>

    <script>
        $(function() {

            /* --- bookmark toggle --- */
            $(document).on('click', '.bookmark-icon', function() {

                const subcontractorId = $(this).data('id');
                const $icon = $(this);

                $.ajax({
                    url: "{{ route('subcontractor.bookmark.store') }}",
                    type: 'POST',
                    data: {
                        id: subcontractorId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success(resp) {
                        if (resp.status === 'added') {
                            $icon.removeClass('fa-regular').addClass('fa-solid');
                            toastr.success(resp.message);
                        } else if (resp.status === 'removed') {
                            toastr.success(resp.message);
                            $icon.removeClass('fa-solid').addClass('fa-regular');
                        } else {
                            window.location.href = "{{ route('login') }}";
                        }
                    },
                    error() {
                        window.location.href = "{{ route('login') }}";
                    }
                });
            });

            /* --- email alerts toggle --- */
            $(document).on('change', '#flexSwitchCheckChecked', function() {
                $.post("{{ route('updateEmailAlerts') }}", {
                    subcontractor_email_alerts: $(this).is(':checked') ? 1 : 0,
                    _token: $('meta[name="csrf-token"]').attr('content')
                });
            });
        });
    </script>
@endsection
