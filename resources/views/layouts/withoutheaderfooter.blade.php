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

   {{-- bootstrap   --}}
   <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
   <link href="{{ asset('assets/css/swiper.css') }}" rel="stylesheet">
   <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

   {{-- Custom Css  --}}
   <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">
</head>

<body>

   @yield('content')

   <script src=" {{ asset('assets/js/jquery.js') }} "></script>
   <script src=" {{ asset('assets/js/bootstrap.js') }} "></script>
   <script src=" {{ asset('assets/js/swiper.js') }} "></script>
   <script src=" {{ asset('assets/js/custom.js') }} "></script>
</body>

</html>
