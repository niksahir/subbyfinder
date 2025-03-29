@extends('layouts.contractor')
@section('title')
    Contractor
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="title">
                <h4>Settings</h4>
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
                        <a href="#">Settings</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="create-account-sec">
        <div class="container">
            <div class="title">
                <h5>Update Account</h5>
            </div>
            <form method="POST" id="contractor_update_form"
                action="{{ route('contractor.setting.update', $contractor->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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

                        <!-- Profile Photo -->
                        <div class="col-md-3">
                            <div class="profile @error('profile_photo') is-invalid @enderror">
                                <input type="file" accept="image/*" name="profile_photo" class="form-control d-none"
                                    id="profileInput">
                                <img src="{{ $contractor->profile_photo ? asset('storage/' . $contractor->profile_photo) : asset('assets/images/team-3.png') }}"
                                    alt="" class="img-fluid" id="profileImage"
                                    onclick="document.getElementById('profileInput').click()">
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
                                    <input type="text" class="form-control @error('business_name') is-invalid @enderror"
                                        name="business_name" placeholder="Business Name"
                                        value="{{ old('business_name', $contractor->business_name) }}" required />
                                    @error('business_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Contact Name</label>
                                    <input type="text" class="form-control @error('contact_name') is-invalid @enderror"
                                        name="contact_name" placeholder="Contact Name"
                                        value="{{ old('contact_name', $contractor->contact_name) }}" required />
                                    @error('contact_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" placeholder="Phone" value="{{ old('phone', $contractor->phone) }}"
                                        required />
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" placeholder="Email" value="{{ old('email', $contractor->email) }}"
                                        required />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" placeholder="Leave empty to keep current password" />
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
                                        name="password_confirmation" placeholder="Confirm Password" />
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        name="address" placeholder="Address"
                                        value="{{ old('address', $contractor->address) }}" required />
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
                                        name="support_staff_size" placeholder="Support Staff Size"
                                        value="{{ old('support_staff_size', $contractor->support_staff_size) }}"
                                        required />
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
                                        name="years_in_business" placeholder="Years in Business"
                                        value="{{ old('years_in_business', $contractor->years_in_business) }}" required />
                                    @error('years_in_business')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Insurances</label>
                                    <input type="text" class="form-control @error('insurances') is-invalid @enderror"
                                        name="insurances" placeholder="Insurances"
                                        value="{{ old('insurances', $contractor->insurances) }}" required />
                                    @error('insurances')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-inner">
                                    <label class="form-label">ABN</label>
                                    <input type="text" class="form-control @error('abn') is-invalid @enderror"
                                        name="abn" placeholder="ABN" value="{{ old('abn', $contractor->abn) }}"
                                        required />
                                    @error('abn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Licenses</label>
                                    <input type="text" class="form-control @error('licenses') is-invalid @enderror"
                                        name="licenses" placeholder="Licenses"
                                        value="{{ old('licenses', $contractor->licenses) }}" required />
                                    @error('licenses')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Trade Category Multi-select -->
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Trade Category</label>
                                    <select name="trade_category" class="form-control" multiple data-multi-select>
                                        @foreach ($expertise_in as $expertise)
                                            <option value="{{ $expertise->id }}"
                                                {{ in_array($expertise->id, old('trade_category', $contractor->trade_category ?? [])) ? 'selected' : '' }}>
                                                {{ $expertise->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('trade_category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="wrapper">
                    <div class="description-item">
                        <h5 for="description">Describe your Business</h5>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="6"
                            placeholder="Describe your Business" name="description" required>{{ old('description', $contractor->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="save-button link">
                    <a href="#" name="contractor_update" id="contractor_update"> Save Changes</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
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
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

            if (allowedTypes.includes(file.type)) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImage.src = e.target.result; // Show selected image
                };
                reader.readAsDataURL(file);
            } else {
                profilePhoto.after(
                    "<span class='invalid-feedback' role='alert'><strong>Only image files (JPG, PNG) are allowed</strong></span>"
                );
                profilePhoto.addClass('is-invalid');
                event.target.value = ""; // Reset file input
                profileImage.src = defaultImage; // Show default image
            }
        } else {
            profileImage.src = defaultImage;
        }
    });

    $(document).ready(function() {
        function showLoader() {
            $('#loader-overlay').show(); // Show dim background
            $('#loader').show(); // Show loader
        }

        function hideLoader() {
            $('#loader-overlay').hide(); // Hide dim background
            $('#loader').hide(); // Hide loader
        }

        $('#contractor_update').click(function(event) {
            event.preventDefault();
            let formValid = true;

            function validateField(field, message) {
                let errorElement = field.next('.invalid-feedback');
                if (errorElement.length === 0) {
                    errorElement = field.parent().find('.invalid-feedback');
                }
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
                } else if (field.is('select') && (field.val() === null || field.val().length === 0)) {
                    formValid = false;
                    if (errorElement.length === 0) {
                        field.after(
                            `<span class='invalid-feedback' role='alert'><strong>${message}</strong></span>`
                        );
                    } else {
                        errorElement.html(`<strong>${message}</strong>`);
                    }
                    field.addClass('is-invalid');
                } else {
                    errorElement.remove();
                    field.removeClass('is-invalid');
                }
            }

            const profilePhoto = $('#profileInput');
            const profileError = profilePhoto.next('.invalid-feedback');

            if (profilePhoto[0].files.length) {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                const file = profilePhoto[0].files[0];

                if (!allowedTypes.includes(file.type)) {
                    formValid = false;
                    if (profileError.length === 0) {
                        profilePhoto.after(
                            "<span class='invalid-feedback' role='alert'><strong>Only image files (JPG, PNG) are allowed</strong></span>"
                        );
                    } else {
                        profileError.html("<strong>Only image files (JPG, PNG) are allowed</strong>");
                    }
                    profilePhoto.addClass('is-invalid');
                } else if (file.size > 2 * 1024 * 1024) {
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
            validateField($("input[name='address']"), "Address is required");
            validateField($("input[name='support_staff_size']"), "Support Staff Size is required");
            validateField($("input[name='years_in_business']"), "Years in Business is required");
            validateField($("input[name='insurances']"), "Insurances are required");
            validateField($("input[name='abn']"), "ABN is required");
            validateField($("input[name='licenses']"), "Licenses are required");
            validateField($("textarea[name='description']"), "Description is required");

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
            }

            if (!formValid) {
                hideLoader();
                return false;
            }

            // Check Email Uniqueness (Only if email is changed)
            const emailField = $("input[name='email']");
            const email = emailField.val().trim();
            const emailError = emailField.next('.invalid-feedback');

            if (email !== "{{ $contractor->email }}") {
                showLoader();
                $.ajax({
                    url: "{{ route('contractor.checkEmail') }}",
                    type: 'POST',
                    data: {
                        email: email,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.exists) {
                            hideLoader();
                            formValid = false;
                            if (emailError.length === 0) {
                                emailField.after(
                                    "<span class='invalid-feedback' role='alert'><strong>Email is already exists.</strong></span>"
                                );
                            } else {
                                emailError.html("<strong>Email is already exists.</strong>");
                            }
                            emailField.addClass('is-invalid');
                        } else {
                            emailError.remove();
                            emailField.removeClass('is-invalid');

                            if (formValid) {
                                $('#contractor_update_form')[0].submit(); // Submit the form
                            }
                        }
                    },
                    error: function() {
                        hideLoader();
                    }
                });
            } else {
                if (formValid) {
                    showLoader();
                    $('#contractor_update_form')[0].submit();
                }
            }
        });
    });
</script>

@endsection
