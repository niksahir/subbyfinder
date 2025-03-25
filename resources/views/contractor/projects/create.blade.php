@extends('layouts.contractor')
@section('title')
    Create New Project
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="title">
                <h4>
                    Add New Project
                </h4>
            </div>
        </div>

        <div class="col-md-6">
            <div class="breadcrumb">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Add New</a></li>
                </ul>
            </div>
        </div>
    </div>

    <section class="project-adding">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <form method="POST" id="create_project_form" action="{{ route('contractor.projects.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="wrapper">
                            <legend> <span></span> Add Project</legend>

                            <div class="row">
                                <div class="col-md-3">
                                    <label for="exampleInputPassword1" class="form-label">Logo</label>
                                    <div class="profile @error('project_logo') is-invalid @enderror">
                                        <input type="file" accept="image/*" name="project_logo"
                                            class="form-control d-none" id="projectLogoInput" required>
                                        <img src="{{ asset('assets/images/team-3.png') }}" alt="" class="img-fluid"
                                            id="projectLogoImage"
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
                                            <input type="email"
                                                class="form-control @error('project_name') is-invalid @enderror"
                                                id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('project_name') }}" name="project_name">
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
                                                <select class="form-select" name="location"
                                                    aria-label="Default select example">
                                                    @foreach(config('constants.states') as $state)
                                                        <option value="{{ $state }}">
                                                            {{ $state }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="@error('location') is-invalid @enderror">
                                                </div>
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
                                                        id="floatingTextarea" placeholder="Enter project description here">{{ old('description') }}</textarea>
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
                                                <input type="text" value="{{ old('abn') }}"
                                                    class="form-control @error('abn') is-invalid @enderror" id=""
                                                    placeholder="85637669305" name="abn"
                                                    aria-describedby="emailHelp">
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
                                                <input type="text" name="license" value="{{ old('license') }}"
                                                    class="form-control @error('license') is-invalid @enderror"
                                                    id="" placeholder="79252" aria-describedby="emailHelp">
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
                                                                {{ $key == 0 ? 'selected' : '' }}>
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
                                            <label for="exampleInputEmail1" class="form-label"> Budget</label>
                                            <div class="@error('budget') is-invalid @enderror">
                                                <select name="budget" class="form-select" required>
                                                    <option value="5K under">
                                                        Under $5k
                                                    </option>
                                                    <option value="10K">
                                                        $5-10K
                                                    </option>
                                                    <option value="25K">
                                                        $10-25K
                                                    </option>
                                                    <option value="50K">
                                                        $25-50K
                                                    </option>
                                                    <option value="100K">
                                                        $50-100K
                                                    </option>
                                                    <option value="$100k above">
                                                        $100k or above
                                                    </option>
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
                                    <a href="{{ route('contractor.projects.index') }}">Cancel</a>
                                    <a href="#" id="create_project_link">Post</a>
                                </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
