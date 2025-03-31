<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">

    <title>@yield('title', config('app.name', 'Laravel')) </title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- {{-- bootstrap   --}} -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/swiper.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- {{-- theme scss  --}} -->
    <link href="{{ asset('assets/scss/theme.scss') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <link href="{{ asset('assets/css/multiSelect.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
    <div id="loader-overlay"></div>
    <div id="loader" style="display: none;">
        <img src="{{ asset('assets/images/loader-1.gif') }}" alt="Loading..." />
    </div>

    @include('include.contractor.header')
    @include('include.contractor.mobilemenu')
    <section class="dashboard">
        <div class="wrapper d-flex">
            @include('include.contractor.leftsidemenu')
            <div class="col-md-9">
                <div class="right-side">
                    @yield('content')
                    @include('include.contractor.footer')
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/multiSelect.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @yield('scripts')
    <script>
        $(document).ready(function() {
            $(".js-example-tags").select2({
                tags: true
            });
        });
        // Edit Project Function
        function editProject(projectId) {
            window.location.href = '/contractor/projects/' + projectId + '/edit';
        }

        // Delete Project Function
        function deleteProject(projectId) {
            if (confirm('Are you sure you want to delete this project?')) {
                // Create a form dynamically
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '/contractor/projects/' + projectId;

                // Add CSRF token
                let csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Add DELETE method
                let methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                // Append form to body and submit
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>

    <script>
        document.getElementById('projectLogoInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const projectLogoImage = document.getElementById('projectLogoImage');
            const defaultImage = "{{ asset('assets/images/team-3.png') }}";

            const profilePhoto = $('#projectLogoInput');
            const profileError = profilePhoto.next('.invalid-feedback');

            profileError.remove();
            profilePhoto.removeClass('is-invalid');

            if (file) {
                // Check if the file is an image
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

                if (allowedTypes.includes(file.type)) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        projectLogoImage.src = e.target.result; // Show selected image
                    }
                    reader.readAsDataURL(file);
                } else {
                    // Show error if file is not an image
                    profilePhoto.after(
                        "<span class='invalid-feedback' role='alert'><strong>Only image files (JPG, PNG) are allowed</strong></span>"
                    );
                    profilePhoto.addClass('is-invalid');
                    event.target.value = ""; // Reset file input
                    projectLogoImage.src = defaultImage; // Show default image
                }
            } else {
                // If no file is selected, show the default image
                projectLogoImage.src = defaultImage;
            }
        });

        $(document).ready(function() {
            // Show loader with overlay
            function showLoader() {
                $('#loader-overlay').show(); // Show dim background
                $('#loader').show(); // Show loader
            }

            // Hide loader and overlay
            function hideLoader() {
                $('#loader-overlay').hide(); // Hide dim background
                $('#loader').hide(); // Hide loader
            }

            $('#create_project_link').click(function(event) {
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

                const profilePhoto = $('#projectLogoInput');
                const profileError = profilePhoto.next('.invalid-feedback');

                if (!profilePhoto[0].files.length) {
                    formValid = false;
                    if (profileError.length === 0) {
                        profilePhoto.after(
                            "<span class='invalid-feedback' role='alert'><strong>Project logo is required</strong></span>"
                        );
                    } else {
                        profileError.html("<strong>Project logo is required</strong>");
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



                validateField($("input[name='project_name']"), "Project name is required");
                validateField($("input[name='location']"), "Location are required");
                validateField($("input[name='abn']"), "ABN are required");
                validateField($("input[name='license']"), "License are required");
                validateField($("textarea[name='description']"), "Description is required");


                if (!formValid) {
                    event.preventDefault();
                    hideLoader();
                } else {
                    showLoader();
                    $('#create_project_form').submit();
                }
            });

            $('#update_project_link').click(function(event) {
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


                validateField($("input[name='project_name']"), "Project name is required");
                validateField($("input[name='location']"), "Location are required");
                validateField($("input[name='abn']"), "ABN are required");
                validateField($("input[name='license']"), "License are required");
                validateField($("textarea[name='description']"), "Description is required");


                if (!formValid) {
                    event.preventDefault();
                    hideLoader();
                } else {
                    showLoader();
                    $('#update_project_form').submit();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
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
                        } else if (response.status === 'removed') {
                            iconElement.removeClass('fa-solid').addClass('fa-regular');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
