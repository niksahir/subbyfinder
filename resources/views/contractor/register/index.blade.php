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
         <form method="POST" action="{{ route('contractor.register.store') }}">
            @csrf
            <input type="hidden" name="role_id" class="role_id" value="2">
            <div class="wrapper">
               <div class="row">
                  <div class="col-12">
                     <div class="label"> My Account</div>
                  </div>
                  @if(session('success'))
                  <div class="alert alert-success">
                     {{ session('success') }}
                  </div>
                  @endif

                  <div class="col-md-3">
                     <div class="profile">
                        <img src="{{ asset('assets/images/team-3.png') }}" alt="" class="img-fluid">
                     </div>
                  </div>

                  <div class="col-md-9">

                     <div class="row g-3">
                        <div class="col-md-6 form-inner">
                           <label class="form-label">Business Name</label>
                           <input type="text" class="form-control @error('business_name') is-invalid @enderror" name="business_name" placeholder="Business Name" value="{{ old('business_name') }}" />
                           @error('business_name')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                        <div class="col-md-6 form-inner">
                           <label class="form-label">Contact Name</label>
                           <input type="text" class="form-control @error('contact_name') is-invalid @enderror" name="contact_name" placeholder="Contact Name" value="{{ old('contact_name') }}" />
                           @error('contact_name')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                        <div class="col-md-6 form-inner">
                           <label class="form-label">Phone</label>
                           <input type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone" name="phone" value="{{ old('phone') }}" />
                           @error('phone')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                        <div class="col-md-6 form-inner">
                           <label class="form-label">Email</label>
                           <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" />
                           @error('email')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                        <div class="col-md-6 form-inner">
                           <label class="form-label">Address</label>
                           <input type="text" class="form-control @error('address') is-invalid @enderror" placeholder="Address" name="address" value="{{ old('address') }}" />
                           @error('address')
                           <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                        <div class="col-md-6 form-inner">
                           <label class="form-label">Support Staff Size</label>
                           <input type="number" class="form-control" placeholder="Support Staff Size" name="support_staff_size" value="{{ old('support_staff_size') }}" />
                        </div>
                        <div class="col-md-6 form-inner">
                           <label class="form-label">Years in Business</label>
                           <input type="text" class="form-control" placeholder="Years in Business" name="years_in_business" value="{{ old('years_in_business') }}" />
                        </div>
                        <div class="col-md-6 form-inner">
                           <label class="form-label">Insurances</label>
                           <input type="text" class="form-control" placeholder="Insurances" name="insurances" value="{{ old('insurances') }}" />
                        </div>
                        <div class="col-md-6 form-inner">
                           <label class="form-label">ABN</label>
                           <input type="text" class="form-control" placeholder="ABN" name="abn" value="{{ old('abn') }}" />
                        </div>
                        <div class="col-md-6 form-inner">
                           <label class="form-label">Licenses</label>
                           <input type="text" class="form-control" placeholder="Licenses" name="licenses" value="{{ old('licenses') }}" />
                        </div>
                        <div class="col-md-6 form-inner">
                           <label class="form-label">Expertise in</label>
                           <input type="text" class="form-control" placeholder="Expertise in" name="expertise_in" value="{{ old('expertise_in') }}" />
                        </div>
                     </div>

                     <div class="mt-4 col-12">
                        <div class="list">
                           <ul>
                              <li>Lighting</li>
                              <li>Cabling</li>
                              <li>Decommissioning</li>
                              <li>Power</li>
                              <li>Repairs</li>
                              <li>Rough-in & Fitoff</li>
                              <li>Smoke Detectors</li>
                           </ul>
                        </div>
                     </div>


                     <div class="col-md-6 form-inner">
                        <label class="form-label">Project Types</label>
                        <input type="text" class="form-control" placeholder="Project Types" name="project_type" />
                     </div>

                     <div class="mt-4 col-12">
                        <div class="list">
                           <ul>
                              <li>Lighting</li>
                              <li>Cabling</li>
                              <li>Decommissioning</li>
                              <li>Power</li>
                              <li>Repairs</li>
                              <li>Rough-in & Fitoff</li>
                              <li>Smoke Detectors</li>
                           </ul>
                        </div>
                     </div>

                     <div class="col-12">
                        <h6>Availability </h6>
                     </div>


                     <div class="row">
                        <div class="input-wrapper">
                           <input type="text" class="form-control" placeholder="Mon" name="availability['Mon'][]" />
                           <input type="text" class="form-control" placeholder="Tue" name="availability['Tue'][]" />
                           <input type="text" class="form-control" placeholder="Wed" name="availability['Wed'][]" />
                           <input type="text" class="form-control" placeholder="Thus" name="availability['Thus'][]" />
                        </div>
                     </div>

                     <div class="mt-4 col-12">
                        <div class="list">
                           <ul>
                              <li>Lighting</li>
                              <li>Cabling</li>
                              <li>Decommissioning</li>
                              <li>Power</li>
                              <li>Repairs</li>
                              <li>Rough-in & Fitoff</li>
                              <li>Smoke Detectors</li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="wrapper">
               <div class="description-item">
                  <h5 for="description">Description</h5>
                  <textarea class="form-control @error('description') is-invalid @enderror" rows="6" placeholder="Enter description here" name="description"></textarea>
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
                  <textarea class="form-control" rows="6" placeholder="Enter values here" name="value"></textarea>
               </div>

            </div>

            <div class="save-button link">

               <button type="submit" name="contractor_register" id="contractor_register" class="btn btn-primary buttons">Save Changes</button>
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
</body>

</html>
