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

   <section class="login-section">
      <div class="logo">
         <img src="{{ asset('assets/images/logo.png') }}" alt="" class="img-fluid">
      </div>

      <div class="row">
         <div class="col-md-5">
            <div class="left-img">
               <img src="{{ asset('assets/images/login.png') }}" alt="" class="img-fluid">
            </div>
         </div>

         <div class="col-md-7">
            <div class="form-outer">
               <h3>Sign Up As a </h3>

               <div class="login-btn-wrapper">
                  <a href="{{  route('subcontractor.register.index') }}">Subcontractor</a>
                  <a href="{{ route('contractor.register.index') }}">Contractor</a>
               </div>


               <form>
                  <div class="account">
                     <p>Already have an account? <a href="{{ route('login') }}"> Sign In</a></p>
                  </div>
               </form>
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
