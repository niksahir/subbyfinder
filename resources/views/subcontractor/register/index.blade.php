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
                            <a href="{{ route('front.home') }}">
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
            <form method="POST" action="{{ route('subcontractor.register.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="label"> My Account</div>
                        </div>

                        <div class="col-md-3">
                            <div class="profile">
                                <input type="file" name="profile_photo" class="form-control d-none"
                                    id="profileInput" required>
                                <img src="{{ asset('assets/images/team-3.png') }}" alt="" class="img-fluid"
                                    id="profileImage" onclick="document.getElementById('profileInput').click()">
                            </div>
                        </div>

                        <div class="col-md-9">

                            <input type="hidden" name="role_id" class="role_id" value="3">
                            <div class="row g-3">
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Business Name</label>
                                    <input type="text"
                                        class="form-control @error('business_name') is-invalid @enderror"
                                        name="business_name" placeholder="Business Name"
                                        value="{{ old('business_name') }}" required/>
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
                                        value="{{ old('contact_name') }}" required/>
                                    @error('contact_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="Phone" name="phone" value="{{ old('phone') }}" required/>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Email" name="email" value="{{ old('email') }}" required/>
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
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        placeholder="Address" name="address" value="{{ old('address') }}" required/>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Support Staff Size</label>
                                    <input type="number" class="form-control" placeholder="Support Staff Size"
                                        name="support_staff_size" value="{{ old('support_staff_size') }}" required/>
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Years in Business</label>
                                    <input type="text" class="form-control" placeholder="Years in Business"
                                        name="years_in_business" value="{{ old('years_in_business') }}" required/>
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Insurances</label>
                                    <input type="text" class="form-control" placeholder="Insurances"
                                        name="insurances" value="{{ old('insurances') }}" required/>
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">ABN</label>
                                    <input type="text" class="form-control" placeholder="ABN" name="abn"
                                        value="{{ old('abn') }}" required/>
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Licenses</label>
                                    <input type="text" class="form-control" placeholder="Licenses"
                                        name="licenses" value="{{ old('licenses') }}" required/>
                                </div>
                                <div class="col-md-6 form-inner">
                                    <label class="form-label">Expertise in</label>
                                    <select name="expertise_in[]" class="form-control" multiple data-multi-select required>
                                        @foreach ($expertise_in as $expertise)
                                            <option value="{{ $expertise->id }}">{{ $expertise->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 form-inner">
                                <label class="form-label">Project Types</label>
                                <select name="project_types[]" class="form-control" multiple data-multi-select required>
                                    @foreach ($project_types as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="col-12">
                        <h6>Availability
                           <img src="{{ asset('assets/images/pluse.png') }}" alt="" class="img-fluid ps-5">
                        </h6>
                     </div>

                     <div class="row">
                        <div class="input-wrapper row">
                           <div class="col d-flex flex-wrap">
                              <input type="text" class="form-control w-100" placeholder="Mon" name="availability['Mon'][]" />

                              <div class="mt-4 col-12">
                                 <div class="list">
                                    <ul>
                                       <li>7:00AM</li>
                                       <li>9:30PM</li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                           <div class="col d-flex flex-wrap">
                              <input type="text" class="form-control w-100" placeholder="Tue" name="availability['Tue'][]" />

                              <div class="mt-4 col-12">
                                 <div class="list">
                                    <ul>
                                       <li>7:00AM</li>
                                       <li>9:30PM</li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                           <div class="col d-flex flex-wrap">
                              <input type="text" class="form-control w-100" placeholder="Wed" name="availability['Wed'][]" />

                              <div class="mt-4 col-12">
                                 <div class="list">
                                    <ul>
                                       <li>7:00AM</li>
                                       <li>9:30PM</li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                           <div class="col d-flex flex-wrap">
                              <input type="text" class="form-control w-100" placeholder="Thus" name="availability['Thus'][]" />

                              <div class="mt-4 col-12">
                                 <div class="list">
                                    <ul>
                                       <li>7:00AM</li>
                                       <li>9:30PM</li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
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
                        <h5 class="">Certifications &amp; Training</h5>

                        <div class="link">
                            <a id="addMore">Add More</a>
                        </div>
                    </div>

                    <div class="upload-cer pt-4 d-flex flex-wrap" id="imagePreviewContainer">
                        <div class="image-item me-2 position-relative">
                            <img src="assets/images/certificates.png" alt="" class="img-fluid default-img"
                                width="150">
                        </div>
                    </div>
                    <input type="file" id="imageInput" class="d-none" multiple accept="image/*">

                </div>


                <div class="save-button link">
                    <button type="submit" name="subcontractor_register" id="subcontractor_register"
                        class="btn btn-primary buttons">Save Changes</button>
                </div>
            </form>
        </div>
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
                                    <i class="fa-brands fa-facebook-f"></i></a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-brands fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-brands fa-google-plus-g"></i></a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa-brands fa-linkedin-in"></i></a>
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
    <script>
        $(document).ready(function() {
            $('#addMore').click(function() {
                $('#imageInput').click();
            });

            $('#imageInput').on('change', function(event) {
                let files = event.target.files;
                let container = $('#imagePreviewContainer');

                for (let i = 0; i < files.length; i++) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let imageItem = `<div class="image-item me-2 position-relative">
                                    <img src="${e.target.result}" class="img-fluid" width="150">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image">X</button>
                                    <input type="hidden" name="certificates[]" value="${e.target.result}">
                                </div>`;
                        container.append(imageItem);
                    };
                    reader.readAsDataURL(files[i]);
                }
            });

            $(document).on('click', '.remove-image', function() {
                $(this).closest('.image-item').remove();
            });

        });
    </script>
</body>

</html>
