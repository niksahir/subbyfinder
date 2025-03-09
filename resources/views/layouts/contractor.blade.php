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
</head>

<body>
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
</body>

</html>
