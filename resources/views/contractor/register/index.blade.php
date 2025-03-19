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
                                <input type="file" accept="image/*" name="profile_photo" class="form-control d-none"
                                    id="profileInput" required>
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
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
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
                                    <label class="form-label">Trade Category</label>
                                    <div class="@error('trade_category') is-invalid @enderror">
                                        <select name="trade_category" class="form-control" multiple data-multi-select>
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
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Expertise in</label>
                                    <input type="text"
                                        class="form-control @error('expertise_in') is-invalid @enderror"
                                        placeholder="Expertise in" name="expertise_in"
                                        value="{{ old('expertise_in') }}" required />
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

                            <div class="col-md-6 form-inner">
                                <label class="form-label">Values</label>
                                <div class="@error('values') is-invalid @enderror">
                                    <select name="values" class="form-control" data-max="1" data-multi-select
                                        required>
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
                                @error('values')
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
                        <h5 for="description">Describe your Business</h5>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="6"
                            placeholder="Describe your Business" name="description" required>{{ old('description') }}</textarea>
                        @error('description')
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
            const profileImage = document.getElementById('profileImage');
            const defaultImage = "{{ asset('assets/images/team-3.png') }}";

            const profilePhoto = $('#profileInput');
            const profileError = profilePhoto.next('.invalid-feedback');

            profileError.remove();
            profilePhoto.removeClass('is-invalid');

            if (file) {
                // Check if the file is an image
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                if (allowedTypes.includes(file.type)) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profileImage.src = e.target.result; // Show selected image
                    }
                    reader.readAsDataURL(file);
                } else {
                    // Show error if file is not an image
                    profilePhoto.after(
                        "<span class='invalid-feedback' role='alert'><strong>Only image files (JPG, PNG) are allowed</strong></span>"
                    );
                    profilePhoto.addClass('is-invalid');
                    event.target.value = ""; // Reset file input
                    profileImage.src = defaultImage; // Show default image
                }
            } else {
                // If no file is selected, show the default image
                profileImage.src = defaultImage;
            }
        });
        $(document).ready(function() {
            $('#contractor_register').click(function(event) {
                let formValid = true;

                function validateField(field, message) {
                    let errorElement = field.next('.invalid-feedback');
                    // If the field is inside a wrapper like div, handle error properly
                    if (errorElement.length === 0) {
                        errorElement = field.parent().find('.invalid-feedback');
                    }
                    // Check for input and textarea fields
                    if ((field.is('input') || field.is('textarea')) && !field.val().trim()) {
                        formValid = false;
                        if (errorElement.length === 0) {
                            field.after(
                                `<span class='invalid-feedback' role='alert'><strong>${message}</strong></span>`
                            );
                        } else {
                            errorElement.html(`<strong>${message}</strong>`);
                        }
                        field.addClass('is-invalid');
                    }
                    // Check for select fields
                    else if (field.is('select') && (field.val() === null || field.val().length === 0)) {
                        formValid = false;
                        if (errorElement.length === 0) {
                            field.after(
                                `<span class='invalid-feedback' role='alert'><strong>${message}</strong></span>`
                            );
                        } else {
                            errorElement.html(`<strong>${message}</strong>`);
                        }
                        field.addClass('is-invalid');
                    }
                    // Remove error if valid
                    else {
                        errorElement.remove();
                        field.removeClass('is-invalid');
                    }
                }

                const profilePhoto = $('#profileInput');
                const profileError = profilePhoto.next('.invalid-feedback');

                if (!profilePhoto[0].files.length) {
                    formValid = false;
                    if (profileError.length === 0) {
                        profilePhoto.after(
                            "<span class='invalid-feedback' role='alert'><strong>Profile photo is required</strong></span>"
                        );
                    } else {
                        profileError.html("<strong>Profile photo is required</strong>");
                    }
                    profilePhoto.addClass('is-invalid');
                } else {
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    const file = profilePhoto[0].files[0];

                    if (!allowedTypes.includes(file.type)) {
                        formValid = false;
                        if (profileError.length === 0) {
                            profilePhoto.after(
                                "<span class='invalid-feedback' role='alert'><strong>Only image files (JPG, PNG) are allowed</strong></span>"
                            );
                        } else {
                            profileError.html(
                                "<strong>Only image files (JPG, PNG) are allowed</strong>");
                        }
                        profilePhoto.addClass('is-invalid');
                    }
                    // Check file size (optional - 2MB max)
                    else if (file.size > 2 * 1024 * 1024) {
                        formValid = false;
                        if (profileError.length === 0) {
                            profilePhoto.after(
                                "<span class='invalid-feedback' role='alert'><strong>File size must be less than 2MB</strong></span>"
                            );
                        } else {
                            profileError.html("<strong>File size must be less than 2MB</strong>");
                        }
                        profilePhoto.addClass('is-invalid');
                    } else {
                        profileError.remove();
                        profilePhoto.removeClass('is-invalid');
                    }
                }



                validateField($("input[name='business_name']"), "Business Name is required");
                validateField($("input[name='contact_name']"), "Contact Name is required");
                validateField($("input[name='phone']"), "Phone is required");
                validateField($("input[name='email']"), "Email is required");
                validateField($("input[name='password']"), "Password is required");
                validateField($("input[name='password_confirmation']"), "Confirm Password is required");
                validateField($("input[name='address']"), "Address is required");
                validateField($("input[name='support_staff_size']"), "Support Staff Size is required");
                validateField($("input[name='years_in_business']"), "Years in Business is required");
                validateField($("input[name='insurances']"), "Insurances are required");
                validateField($("input[name='abn']"), "ABN is required");
                validateField($("input[name='licenses']"), "Licenses are required");
                validateField($("textarea[name='description']"), "Description is required");
                // validateField($("textarea[name='values']"), "Description is required");
                validateField($("input[name='expertise_in']"), "Expertise in is required");
                // validateField($("select[name='expertise_in']"), "Please select at least one expertise");
                // validateField($("select[name='project_types']"), "Please select at least one project type");


                const passwordField = $("input[name='password']");
                const confirmPasswordField = $("input[name='password_confirmation']");
                const password = passwordField.val().trim();
                const confirmPassword = confirmPasswordField.val().trim();
                const passwordError = confirmPasswordField.next('.invalid-feedback');

                if (password && confirmPassword) {
                    if (password !== confirmPassword) {
                        formValid = false;
                        if (passwordError.length === 0) {
                            confirmPasswordField.after(
                                "<span class='invalid-feedback' role='alert'><strong>Passwords do not match</strong></span>"
                            );
                        } else {
                            passwordError.html("<strong>Passwords do not match</strong>");
                        }
                        confirmPasswordField.addClass('is-invalid');
                    } else {
                        passwordError.remove();
                        confirmPasswordField.removeClass('is-invalid');
                    }
                } else if (!confirmPassword) {
                    formValid = false;
                    if (passwordError.length === 0) {
                        confirmPasswordField.after(
                            "<span class='invalid-feedback' role='alert'><strong>Confirm Password is required</strong></span>"
                        );
                    } else {
                        passwordError.html("<strong>Confirm Password is required</strong>");
                    }
                    confirmPasswordField.addClass('is-invalid');
                }

                if (!formValid) {
                    event.preventDefault();
                }
            });
        });
    </script>
</body>

</html>
