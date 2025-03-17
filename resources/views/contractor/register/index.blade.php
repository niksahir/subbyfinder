<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- bootstrap   --}}
    <link href=" {{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/swiper.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    {{-- Custom Css  --}}
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/multiSelect.css') }}" rel="stylesheet" type="text/css">
</head>

<body>

    <header class="py-2">
        <div class="container">
            <div class="row">
                <div class="col-6 col-lg-8">
                    <div class="logo-with-menu">
                        <div class="logo">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-4">
                    <div class="menu-toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                </div>
            </div>
        </div>
    </header>

    <div class="create-account-sec">
        <div class="container">
            <div class="title">
                <h5>Create Account</h5>
            </div>
            <form method="POST" action="{{ route('contractor.register.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="label"> My Account</div>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="col-md-3">
                            <div class="profile @error('profile_photo') is-invalid @enderror">
                                <input type="file" accept="image/*" name="profile_photo" class="form-control d-none" id="profileInput"
                                    required>
                                <img src="{{ asset('assets/images/team-3.png') }}" alt="" class="img-fluid"
                                    id="profileImage" onclick="document.getElementById('profileInput').click()">
                            </div>
                            @error('profile_photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-9">

                            <div class="row g-3">
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Business Name</label>
                                    <input type="text"
                                        class="form-control @error('business_name') is-invalid @enderror"
                                        name="business_name" placeholder="Business Name"
                                        value="{{ old('business_name') }}" required />
                                    @error('business_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Contact Name</label>
                                    <input type="text"
                                        class="form-control @error('contact_name') is-invalid @enderror"
                                        name="contact_name" placeholder="Contact Name"
                                        value="{{ old('contact_name') }}" required />
                                    @error('contact_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="Phone" name="phone" value="{{ old('phone') }}" required />
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email" name="email" value="{{ old('email') }}" required />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Password" name="password" value="{{ old('password') }}"
                                        required />
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                        placeholder="Confirm Password" name="password_confirmation" required />
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        placeholder="Address" name="address" value="{{ old('address') }}"
                                        required />
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Support Staff Size</label>
                                    <input type="number"
                                        class="form-control @error('support_staff_size') is-invalid @enderror"
                                        placeholder="Support Staff Size" name="support_staff_size"
                                        value="{{ old('support_staff_size') }}" required />
                                    @error('support_staff_size')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Years in Business</label>
                                    <input type="number"
                                        class="form-control @error('years_in_business') is-invalid @enderror"
                                        placeholder="Years in Business" name="years_in_business"
                                        value="{{ old('years_in_business') }}" required />
                                    @error('years_in_business')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Insurances</label>
                                    <input type="text"
                                        class="form-control @error('insurances') is-invalid @enderror"
                                        placeholder="Insurances" name="insurances" value="{{ old('insurances') }}"
                                        required />
                                    @error('insurances')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">ABN</label>
                                    <input type="text" class="form-control @error('abn') is-invalid @enderror"
                                        placeholder="ABN" name="abn" value="{{ old('abn') }}" required />
                                    @error('abn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Licenses</label>
                                    <input type="text"
                                        class="form-control @error('licenses') is-invalid @enderror"
                                        placeholder="Licenses" name="licenses" value="{{ old('licenses') }}"
                                        required />
                                    @error('licenses')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Expertise in</label>
                                    <div class="@error('expertise_in') is-invalid @enderror">
                                        <select name="expertise_in" class="form-control" multiple data-multi-select>
                                            @foreach ($expertise_in as $key => $expertise)
                                                <option value="{{ $expertise->id }}"
                                                    {{ $key == 0 ? 'selected' : '' }}>
                                                    {{ $expertise->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('expertise_in')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 form-inner">
                                <label class="form-label">Project Types</label>
                                <div class="@error('expertise_in') is-invalid @enderror">
                                    <select name="project_types" class="form-control" multiple data-multi-select
                                        required>
                                        @foreach ($project_types as $key => $project)
                                            <option value="{{ $project->id }}" {{ $key == 0 ? 'selected' : '' }}>
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('project_types')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- <div class="col-12">
                        <h6>Availability </h6>
                     </div>


                     <div class="row">
                        <div class="input-wrapper">
                            <input type="text" name="availability[Mon][start]" class="form-control" placeholder="Start Time">
                            <input type="text" name="availability[Mon][end]" class="form-control" placeholder="End Time">
                        </div>
                     </div> --}}
                        </div>
                    </div>
                </div>

                <div class="wrapper">
                    <div class="description-item">
                        <h5 for="description">Description</h5>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="6"
                            placeholder="Enter description here" name="description" required>{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="wrapper">
                    <div class="values-item">
                        <h5 class="">Values</h5>
                        <textarea class="form-control @error('values') is-invalid @enderror" rows="6" placeholder="Enter values here"
                            name="values" required>{{ old('values') }}</textarea>
                        @error('values')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                </div>

                <div class="save-button link">

                    <button type="submit" name="contractor_register" id="contractor_register"
                        class="btn btn-primary buttons">Register</button>
                </div>
        </div>
        </form>
    </div>

    <section class="footer">
        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <div class="left">
                        <p>© {{ date('Y') }} Subby Finder. All Rights Reserved.</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="social">
                        <ul>
                            <li>
                                <a href="#">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-brands fa-google-plus-g"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src=" {{ asset('assets/js/jquery.js') }} "></script>
    <script src=" {{ asset('assets/js/bootstrap.js') }} "></script>
    <script src=" {{ asset('assets/js/custom.js') }} "></script>
    <script src="{{ asset('assets/js/multiSelect.js') }}"></script>
    <script>
        document.getElementById('profileInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>
