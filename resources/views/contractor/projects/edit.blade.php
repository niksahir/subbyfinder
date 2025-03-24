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
                                <div class="col-md-3">
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
                                </div>

                                <div class="col-md-9">
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
                                            <label for="exampleInputPassword1" class="form-label">Location</label>
                                            <div class="@error('location') is-invalid @enderror">
                                                <select class="form-select" name="location" data-max="1"
                                                    data-multi-select>
                                                    @foreach (config('constants.states') as $state)
                                                        <option value="{{ $state }}"
                                                            {{ $state == $project->location ? 'selected' : '' }}>
                                                            {{ $state }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('location')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
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
                                        <div class="col-md-6">
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
                                        </div>

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
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Budget</label>
                                            <div class="@error('budget') is-invalid @enderror">
                                                <select name="budget" class="form-control" data-max="1"
                                                    data-multi-select>
                                                    @foreach ([
            '5K under' => 'Under $5k',
            '10K' => '$5-10K',
            '25K' => '$10-25K',
            '50K' => '$25-50K',
            '100K' => '$50-100K',
            '$100k above' => '$100k or above',
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

                                <div class="form-btn">
                                    <a href="{{ route('contractor.projects.index') }}"
                                        class="btn btn-secondary">Cancel</a>
                                    <a href="#" id="update_project_link">Update</a>

                                </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
