@extends('layouts.contractor')
@section('title')
    Edit Project
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="title">
                <h4>
                    Edit Project
                </h4>
            </div>
        </div>

        <div class="col-md-6">
            <div class="breadcrumb">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Edit Project</a></li>
                </ul>
            </div>
        </div>
    </div>

    <section class="project-adding">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" id="update_project_form"
                        action="{{ route('contractor.projects.update', $project->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="wrapper">
                            <legend><span></span> Edit Project</legend>

                            <div class="row">
                                {{-- <div class="col-md-3">
                                    <label for="exampleInputPassword1" class="form-label">Logo</label>
                                    <div class="profile @error('project_logo') is-invalid @enderror">
                                        <input type="file" accept="image/*" name="project_logo"
                                            class="form-control d-none" id="projectLogoInput">
                                        <img src="{{ $project->project_logo ? asset('storage/' . $project->project_logo) : asset('assets/images/team-3.png') }}"
                                            alt="" class="img-fluid" id="projectLogoImage"
                                            onclick="document.getElementById('projectLogoInput').click()">
                                    </div>
                                    @error('project_logo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}

                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="form-inner">
                                            <label for="exampleInputEmail1" class="form-label">Project Name</label>
                                            <input type="text"
                                                class="form-control @error('project_name') is-invalid @enderror"
                                                name="project_name"
                                                value="{{ old('project_name', $project->project_name) }}">
                                            @error('project_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-inner">
                                            <label class="form-label">Location</label>

                                            {{-- Autocomplete text box --}}
                                            <input type="text" id="autocomplete" name="location"
                                                class="form-control @error('location') is-invalid @enderror"
                                                placeholder="Search for a location…" value="{{ old('location',$project->location) }}"
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

                                        <div class="col-12">
                                            <div class="form-inner">
                                                <label for="floatingTextarea">Description</label>
                                                <div>
                                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="6"
                                                        id="floatingTextarea" placeholder="Enter project description here">{{ old('description', $project->description) }}</textarea>
                                                    @error('description')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{-- <div class="col-md-6">
                                            <div class="form-inner">
                                                <label for="exampleInputEmail1" class="form-label">ABN</label>
                                                <input type="text"
                                                    class="form-control @error('abn') is-invalid @enderror" name="abn"
                                                    value="{{ old('abn', $project->abn) }}">
                                                @error('abn')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-inner">
                                                <label for="exampleInputEmail1" class="form-label">License</label>
                                                <input type="text" name="license"
                                                    class="form-control @error('license') is-invalid @enderror"
                                                    value="{{ old('license', $project->license) }}">
                                                @error('license')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> --}}

                                        <div class="col-md-6">
                                            <div class="form-inner">
                                                <label class="form-label">Categories</label>
                                                <div class="@error('trade_category') is-invalid @enderror">
                                                    <select name="trade_category" class="form-control" multiple
                                                        data-multi-select>
                                                        @foreach ($expertise_in as $key => $expertise)
                                                            <option value="{{ $expertise->id }}"
                                                                {{ in_array($expertise->id, old('trade_category', $project->trade_category ?? [])) ? 'selected' : '' }}>
                                                                {{ $expertise->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('trade_category')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Budget</label>
                                                <div class="@error('budget') is-invalid @enderror">
                                                    <select name="budget" class="form-select">
                                                        @foreach ([
            '5K under' => 'Under $5k',
            '10K' => '$5-10K',
            '25K' => '$10-25K',
            '50K' => '$25-50K',
            '100K' => '$50-100K',
            '100k above' => '$100k or above',
        ] as $value => $label)
                                                            <option value="{{ $value }}"
                                                                {{ $value == old('budget', $project->budget) ? 'selected' : '' }}>
                                                                {{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('budget')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-inner">
                                            <label class="form-label">Project type</label>
                                            <div class="@error('project_type') is-invalid @enderror">
                                                <select name="project_type" class="form-control" multiple data-multi-select>
                                                    @foreach ($project_types as $key => $project_type)
                                                        <option value="{{ $project_type->id }}"
                                                            {{ in_array($project_type->id, old('project_type', $project->project_type ?? [])) ? 'selected' : '' }}>
                                                            {{ $project_type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('project_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-btn">
                                    <a href="{{ route('contractor.projects.index') }}" class="btn btn-secondary">Cancel</a>
                                    <input type="submit" class="save-project" id="create_project_link" value="Update">


                                </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_places.key') }}&libraries=places"
        defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('autocomplete');
            const resultBox = document.getElementById('place-result');
            const latField = document.getElementById('lat');
            const lngField = document.getElementById('lng');
            const idField = document.getElementById('place_id');

            function init() {
                const ac = new google.maps.places.Autocomplete(input, {
                    types: ['geocode'],
                    componentRestrictions: { country: 'AU' }
                });

                ac.addListener('place_changed', () => {
                    const place = ac.getPlace();

                    if (!place.geometry) {
                        resultBox.textContent = 'No details for that place – try again.';
                        return;
                    }

                    // Fill visible field with formatted address; hidden fields with extras
                    input.value = place.formatted_address || place.name;
                    latField.value = place.geometry.location.lat();
                    lngField.value = place.geometry.location.lng();
                    idField.value = place.place_id || '';

                    // Nice feedback for the user
                    // resultBox.innerHTML =
                    //     `<strong>${place.name || ''}</strong><br>${place.formatted_address}`;
                });
            }

            // Google script loads async – wait until it is ready
            let tries = 0,
                w = setInterval(() => {
                    if (window.google && google.maps && google.maps.places) {
                        clearInterval(w);
                        init();
                    }
                    if (++tries > 20) clearInterval(w); // give up after ~6 s
                }, 300);
        });
    </script>
@endsection
