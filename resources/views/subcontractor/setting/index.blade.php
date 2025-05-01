@extends('layouts.subcontractor')
@section('title')
    Sub Contractor
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
                    <li><a href="{{ route('front.home') }}">Home</a></li>
                    <li><a href="{{ route('subcontractor.dashboard.index') }}">Dashboard</a></li>
                    <li><a href="#">Settings</a></li>
                    <button class="bg-transparent border-none text-white box-shadow" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">Add protfolio</button>
                </ul>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('subcontractor.protfolio.index') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3 @error('project_name') is-invalid @enderror">
                            <label for="name">Project Name</label>
                            <input type="text" class="form-control" id="name" name="project_name">
                            @error('project_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-inner">
                            <label for="exampleInputPassword1" class="form-label">Location</label>
                            <div class="@error('location') is-invalid @enderror">
                                <select class="form-control js-example-tags" name="location" id="location">
                                    <option value="" selected>Select Location</option>
                                    @foreach ($locations as $key => $location)
                                        <option value="{{ $location->name }}">
                                            {{ $location->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 @error('protfolio_image[]') is-invalid @enderror">
                            <label for="name">Image</label>
                            <input type="file" class="form-control" id="protfolio_image" name="protfolio_image[]"
                                accept="jpg,jpeg,png" multiple>
                            @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 @error('description') is-invalid @enderror">
                            <label for="name">Description</label>
                            <input type="text" class="form-control" id="description" name="description">
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 @error('price') is-invalid @enderror">
                            <label for="name">Price</label>
                            <input type="text" class="form-control" id="price" name="price">
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary @if ($protfolioAdd == false) disabled @endif"
                        value="Save changes">
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="create-account-sec pt-0">
        <div class="container">

            <form method="POST" id="subcontractor_edit_form"
                action="{{ route('subcontractor.setting.update', $subcontractor->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="label">My Account</div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="col-md-3">
                            <div class="profile @error('profile_photo') is-invalid @enderror">
                                <input type="file" accept="image/*" name="profile_photo" class="form-control d-none"
                                    id="profileInput">
                                <img src="{{ $subcontractor->profile_photo ? asset('storage/' . $subcontractor->profile_photo) : asset('assets/images/team-3.png') }}"
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
                            <input type="hidden" name="role_id" class="role_id" value="3">
                            <div class="row g-3">
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Business Name</label>
                                    <input type="text"
                                        class="form-control @error('business_name') is-invalid @enderror"
                                        name="business_name" placeholder="Business Name"
                                        value="{{ old('business_name', $subcontractor->business_name) }}" required />
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
                                        value="{{ old('contact_name', $subcontractor->contact_name) }}" required />
                                    @error('contact_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="Phone" name="phone"
                                        value="{{ old('phone', $subcontractor->phone) }}" required />
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email" name="email"
                                        value="{{ old('email', $subcontractor->email) }}" required />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Password (leave empty to keep current)" name="password" />
                                    <small class="text-muted">Leave blank to keep current password</small>
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
                                        placeholder="Confirm Password" name="password_confirmation" />
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        placeholder="Address" name="address"
                                        value="{{ old('address', $subcontractor->address) }}" required />
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
                                        value="{{ old('support_staff_size', $subcontractor->support_staff_size) }}"
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
                                        placeholder="Years in Business" name="years_in_business"
                                        value="{{ old('years_in_business', $subcontractor->years_in_business) }}"
                                        required />
                                    @error('years_in_business')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Insurances</label>
                                    <input type="text" class="form-control @error('insurances') is-invalid @enderror"
                                        placeholder="Insurances" name="insurances"
                                        value="{{ old('insurances', $subcontractor->insurances) }}" required />
                                    @error('insurances')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">ABN</label>
                                    <input type="text" class="form-control @error('abn') is-invalid @enderror"
                                        placeholder="ABN" name="abn" value="{{ old('abn', $subcontractor->abn) }}"
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
                                        placeholder="Licenses" name="licenses"
                                        value="{{ old('licenses', $subcontractor->licenses) }}" required />
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
                                            @foreach ($expertise_in as $expertise)
                                                <option value="{{ $expertise->id }}"
                                                    {{ in_array($expertise->id, old('trade_category', $subcontractor->trade_category ?? [])) ? 'selected' : '' }}>
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
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Availability</label>
                                    <div class="@error('availability') is-invalid @enderror">
                                        <select class="form-control" name="availability" id="availability" required>
                                            <option value="" selected>Select availability</option>
                                            @foreach (config('constants.availability') as $availability)
                                                <option value="{{ $availability }}"
                                                    {{ $availability == $subcontractor->availability ? 'selected' : '' }}>
                                                    {{ $availability }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('availability')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 form-inner">
                                <label for="exampleInputPassword1" class="form-label">Location</label>
                                <div class="@error('location') is-invalid @enderror">
                                    <select class="form-control js-example-tags" name="location" id="location" required>
                                        <option value="" selected>Select Location</option>
                                        @foreach ($locations as $key => $location)
                                            <option value="{{ $location->name }}"
                                                {{ $location->name == $subcontractor->location ? 'selected' : '' }}>
                                                {{ $location->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    <div class="wrapper">
        <div class="description-item">
            <h5 for="description">Describe your Business</h5>
            <textarea class="form-control @error('description') is-invalid @enderror" rows="6"
                placeholder="Describe your Business" name="description" required>{{ old('description', $subcontractor->description) }}</textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="wrapper">
        <div class="values-item">
            <h5 class="@error('certificates.0') is-invalid @enderror">Certifications &amp; Training </h5>
            @error('certificates.0')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <div class="link">
                <a id="addMore">Add More</a>
            </div>
        </div>

        <div class="upload-cer pt-4 d-flex flex-wrap" id="imagePreviewContainer">
            <!-- Display existing certificates -->
            @if ($subcontractor->certifications && count($subcontractor->certifications) > 0)
                @foreach ($subcontractor->certifications as $certificate)
                    <div class="image-item me-2 position-relative">
                        @if (Str::endsWith($certificate->file_path, ['.jpg', '.jpeg', '.png', '.gif']))
                            <img src="{{ asset('storage/' . $certificate->file_path) }}" alt="Certificate"
                                class="img-fluid" width="150">
                        @else
                            <img src="{{ asset('assets/images/files.png') }}" alt="PDF Certificate" class="img-fluid"
                                width="150">
                        @endif
                        <button type="button"
                            class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-existing-image"
                            data-cert="{{ $certificate->file_path }}">X</button>
                    </div>
                @endforeach
            @else
                <div class="image-item me-2 position-relative">
                    <img src="{{ asset('assets/images/certificates.png') }}" alt=""
                        class="img-fluid default-img" width="150">
                </div>
            @endif
        </div>

        <input type="file" id="imageInput" name="certificates[]" class="d-none" multiple
            accept="image/*,application/pdf">
        <!-- Hidden input to track deleted certificates -->
        <input type="hidden" id="deleted_certificates" name="deleted_certificates" value="">
    </div>

    <div class="save-button link">
        <a href="#" name="subcontractor_update" id="subcontractor_update"> Save Changes</a>
    </div>
    </form>
    <h5 class="mt-4">Protfolio</h5>
    @if ($protfolios->isNotEmpty())
        @foreach ($protfolios as $p)
            <div class="prject-with-images mt-2 pb-3">
                <div class="row">
                    <div class="col-md-9">
                        <div class="img-with-text">
                            <h6>{{ $p->project_name }}</h6>

                            <ul class="list-unstyled">
                                <li><i class="fa-solid fa-location-dot"></i> {{ $p->location }}
                                </li>
                            </ul>

                            <p>{{ $p->description }}</p>
                            @php
                                $images = json_decode($p->images, true);
                            @endphp

                            <div class="img-wrapper">
                                <input type="hidden" name="dh" value="{{ $p->images }}">
                                @if ($images && is_array($images))
                                    @foreach ($images as $image)
                                        <img src="{{ asset('storage/' . $image) }}" alt="" class="img-fluid">
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 d-flex justify-content-center align-items-center">
                        <div class="price">
                            <h6>{{ $p->price }}</h6>
                            <p>outcomes</p>
                        </div>
                        <div class="buttons ms-2">
                            <i class="fa-solid fa-edit me-2" id="edit"
                                onclick="editProject({{ $p->id }})"></i>
                            <i class="fa-solid fa-trash" onclick="deleteProject({{ $p->id }})"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="prject-with-images mb-5 pb-3">
            <p>No past project available.</p>
        </div>
    @endif

    <div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Protfolio</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" id="edit_form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group mb-3 @error('project_name') is-invalid @enderror">
                            <label for="name">Project Name</label>
                            <input type="text" class="form-control" id="editname" name="project_name">
                            @error('project_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-inner">
                            <label for="editlocation" class="form-label">Location</label>
                            <div class="@error('location') is-invalid @enderror">
                                <select class="form-control" name="location" id="editlocation">
                                    <option value="" selected>Select Location</option>
                                </select>

                            </div>
                            @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 @error('protfolio_image[]') is-invalid @enderror">
                            <label for="name">Image</label>
                            <input type="file" class="form-control" id="editprotfolio_image" name="protfolio_image[]"
                                accept="jpg,jpeg,png" multiple>

                            <div class="form-group mb-3 mt-3">
                                <label>Existing Images</label>
                                <div id="existing-images" class="d-flex flex-wrap gap-2"></div>
                            </div>

                            @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 @error('description') is-invalid @enderror">
                            <label for="name">Description</label>
                            <input type="text" class="form-control" id="editdescription" name="description">
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 @error('price') is-invalid @enderror">
                            <label for="name">Price</label>
                            <input type="text" class="form-control" id="editprice" name="price">
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary @if ($protfolioAdd == false) disabled @endif"
                        value="Save changes">
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".js-example-tags").select2({
                tags: true
            });
        });
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
            }
        });

        $(document).ready(function() {

            function showLoader() {
                $('#loader-overlay').show(); // Show dim background
                $('#loader').show(); // Show loader
            }

            // Hide loader and overlay
            function hideLoader() {
                $('#loader-overlay').hide(); // Hide dim background
                $('#loader').hide(); // Hide loader
            }

            let selectedFiles = new DataTransfer(); // Stores files persistently
            let deletedCertificates = []; // Track certificates to be deleted

            $('#addMore').click(function() {
                $('#imageInput').click();
            });

            $('#imageInput').on('change', function(event) {
                let files = event.target.files;
                let container = $('#imagePreviewContainer');

                for (let i = 0; i < files.length; i++) {
                    let file = files[i];

                    // Check if the file is already in selectedFiles (avoid duplicates)
                    let exists = false;
                    for (let j = 0; j < selectedFiles.files.length; j++) {
                        if (selectedFiles.files[j].name === file.name) {
                            exists = true;
                            break;
                        }
                    }
                    if (exists) continue; // Skip duplicate files

                    selectedFiles.items.add(file); // Add new file to DataTransfer

                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let preview = '';

                        if (file.type.startsWith("image/")) {
                            preview = `<img src="${e.target.result}" class="img-fluid" width="150">`;
                        } else if (file.type === "application/pdf") {
                            preview =
                                `<img src="{{ asset('assets/images/files.png') }}" class="img-fluid" width="150">`;
                        }

                        let fileItem = `<div class="image-item me-2 position-relative">
                                ${preview}
                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image" data-name="${file.name}">X</button>
                            </div>`;
                        container.append(fileItem);
                    };

                    reader.readAsDataURL(file);
                }

                // Assign the updated file list to the input field
                $('#imageInput')[0].files = selectedFiles.files;
            });

            // Remove new file when clicking "X" button
            $(document).on('click', '.remove-image', function() {
                let fileName = $(this).attr('data-name');

                // Remove the file from selectedFiles
                let newDataTransfer = new DataTransfer();
                for (let i = 0; i < selectedFiles.files.length; i++) {
                    if (selectedFiles.files[i].name !== fileName) {
                        newDataTransfer.items.add(selectedFiles.files[i]);
                    }
                }

                selectedFiles = newDataTransfer; // Update DataTransfer object
                $('#imageInput')[0].files = selectedFiles.files; // Update input field

                $(this).closest('.image-item').remove(); // Remove preview from UI
            });

            // Remove existing certificate when clicking "X" button
            $(document).on('click', '.remove-existing-image', function() {
                let certPath = $(this).attr('data-cert');

                // Add to deleted certificates array
                deletedCertificates.push(certPath);

                // Update hidden input with deleted certificates
                $('#deleted_certificates').val(JSON.stringify(deletedCertificates));

                // Remove from UI
                $(this).closest('.image-item').remove();
            });

            $('#subcontractor_update').click(function(event) {
                event.preventDefault();
                let formValid = true;

                function validateField(field, message) {
                    let errorElement = field.next('.invalid-feedback');
                    // If the field is inside a wrapper like div, handle error properly
                    if (errorElement.length === 0) {
                        errorElement = field.parent().find('.invalid-feedback');
                    }
                    // Check for input and textarea fields
                    if ((field.is('input') || field.is('textarea')) && !field.val().trim() && field.prop(
                            'required')) {
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
                    else if (field.is('select') && (field.val() === null || field.val().length === 0) &&
                        field.prop('required')) {
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

                // Validate profile photo only if a new one is selected
                const profilePhoto = $('#profileInput');
                if (profilePhoto[0].files.length > 0) {
                    const profileError = profilePhoto.next('.invalid-feedback');
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
                validateField($("input[name='address']"), "Address is required");
                validateField($("input[name='support_staff_size']"), "Support Staff Size is required");
                validateField($("input[name='years_in_business']"), "Years in Business is required");
                validateField($("input[name='insurances']"), "Insurances are required");
                validateField($("input[name='abn']"), "ABN is required");
                validateField($("select[name='location']"), "location is required");
                validateField($("select[name='availability']"), "Availability is required");
                validateField($("input[name='licenses']"), "Licenses are required");
                validateField($("textarea[name='description']"), "Description is required");

                // Check password and confirmation only if password field is not empty
                const passwordField = $("input[name='password']");
                const confirmPasswordField = $("input[name='password_confirmation']");
                const password = passwordField.val().trim();
                const confirmPassword = confirmPasswordField.val().trim();
                const passwordError = confirmPasswordField.next('.invalid-feedback');

                if (password) {
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

                // Validate Certificate Images if new ones are selected
                const certificateInput = $('#imageInput');
                if (certificateInput[0].files.length > 0) {
                    const certificateError = certificateInput.next('.invalid-feedback');
                    const allowedFileTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];

                    let invalidFile = false;
                    for (let i = 0; i < certificateInput[0].files.length; i++) {
                        const certFile = certificateInput[0].files[i];
                        if (!allowedFileTypes.includes(certFile.type)) {
                            invalidFile = true;
                            break;
                        }
                    }

                    if (invalidFile) {
                        formValid = false;
                        if (certificateError.length === 0) {
                            certificateInput.after(
                                "<span class='invalid-feedback' role='alert'><strong>Only JPG, PNG, and PDF files are allowed for certificates</strong></span>"
                            );
                        } else {
                            certificateError.html(
                                "<strong>Only JPG, PNG, and PDF files are allowed for certificates</strong>"
                            );
                        }
                        certificateInput.addClass('is-invalid');
                    } else {
                        certificateError.remove();
                        certificateInput.removeClass('is-invalid');
                    }
                }

                // Check if all certificates are removed
                const certificatesExists = $('#imagePreviewContainer .image-item').length > 0 ||
                    certificateInput[0].files.length > 0;
                if (!certificatesExists) {
                    formValid = false;
                    if ($('#certificates-error').length === 0) {
                        $('#imagePreviewContainer').after(
                            "<span id='certificates-error' class='invalid-feedback d-block' role='alert'><strong>At least one certificate is required</strong></span>"
                        );
                    }
                } else {
                    $('#certificates-error').remove();
                }

                if (!formValid) {
                    return false;
                }

                // Check Email Uniqueness (only if email has changed)
                const emailField = $("input[name='email']");
                const email = emailField.val().trim();
                const originalEmail = "{{ $subcontractor->email }}";
                const emailError = emailField.next('.invalid-feedback');

                if (email !== originalEmail) {
                    showLoader();

                    $.ajax({
                        url: "{{ route('subcontractor.checkEmail') }}",
                        type: 'POST',
                        data: {
                            email: email,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.exists) {
                                hideLoader()
                                formValid = false;
                                if (emailError.length === 0) {
                                    emailField.after(
                                        "<span class='invalid-feedback' role='alert'><strong>Email is already exists.</strong></span>"
                                    );
                                } else {
                                    emailError.html(
                                        "<strong>Email is already exists.</strong>");
                                }
                                emailField.addClass('is-invalid');
                            } else {
                                emailError.remove();
                                emailField.removeClass('is-invalid');

                                if (formValid) {
                                    $('#subcontractor_edit_form')[0].submit();
                                }
                            }
                        },
                        error: function() {
                            hideLoader()
                        }
                    });
                } else {
                    // Email not changed, proceed with form submission
                    if (formValid) {
                        showLoader();
                        $('#subcontractor_edit_form')[0].submit();
                    }
                }
            });
        });

        function deleteProject(id) {
            const url = "{{ route('subcontractor.protfolio.destroy', ':id') }}".replace(':id', id);
            if (confirm('Are you sure you want to delete this project?')) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            location.reload();
                            toastr.success(response.message);
                        } else {
                            alert('Failed to delete project.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while deleting the project.');
                    }
                });
            }
        }

        function editProject(id) {
            const url = "{{ route('subcontractor.protfolio.edit', ':id') }}".replace(':id', id);
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status === 'success') {
                        console.log(response.data);
                        const project = response.data;
                        const locations = response.locations;
                        console.log(locations);

                        $('#exampleModalLabelEdit').text('Edit Project');
                        $('#editname').val(project.project_name);
                        $('#edit_id').val(project.id);

                        // Destroy existing select2 if active
                        // if ($.fn.select2 && $('#editlocation').hasClass("select2-hidden-accessible")) {
                        //     $('#editlocation').select2('destroy');
                        // }

                        // Clear and add options
                        $('#editlocation').empty().append('<option value="">Select Location</option>');
                        locations.forEach(loc => {
                            const selected = loc.name === project.location ? 'selected' : '';
                            $('#editlocation').append(
                                `<option value="${loc.name}" ${selected}>${loc.name}</option>`);
                        });



                        // // Reinitialize select2
                        // $('#editlocation').select2({
                        //     tags: true
                        // });

                        // Show existing images
                        $('#existing-images').empty(); // Clear old previews
                        if (project.images && Array.isArray(project.images)) {
                            project.images.forEach(imageUrl => {
                                const fullImageUrl =
                                    `/storage/${imageUrl}`; // Adjust this path if needed
                                $('#existing-images').append(`
                                <div>
                                    <img src="${fullImageUrl}" alt="Image" style="height: 100px; width: auto; border-radius: 4px; margin-right: 10px;">
                                </div>
                            `);
                            });
                        }

                        $('#editdescription').val(project.description);
                        $('#editprice').val(project.price);

                        // Set form action dynamically
                        var editUrl = "{{ route('subcontractor.protfolio.update', ':id') }}";
                        $('#edit_form').attr('action', editUrl.replace(':id', id));

                        // Ensure PUT method spoofing is added
                        $('#edit_form').find('input[name="_method"]').remove();
                        $('#edit_form').append('<input type="hidden" name="_method" value="PUT">');

                        $('#exampleModalEdit').modal('show');
                    } else {
                        alert('Failed to fetch project details.');
                    }
                },
                error: function() {
                    alert('An error occurred while fetching project details.');
                }
            });
        }
    </script>
@endsection
