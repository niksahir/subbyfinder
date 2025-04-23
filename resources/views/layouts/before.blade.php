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
    <!-- Bootstrap Multiselect CSS -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Choices.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

    {{-- Custom Css  --}}
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link href="{{ asset('assets/css/multiSelect.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <style>
        .pagination {
            padding-top: 0px !important;
            border: none !important;
            --bs-pagination-border-width: 0px !important;
            --bs-pagination-border-radius: 0px !important;
            height: auto !important;


        }

        .page-link {
            color: black !important;
        }

        .pagination .page-item {
            margin-right: 10px !important;
            border-radius: 4px !important;
            /* height: 44px !important;
    width: 44px !important; */
            -webkit-box-sizing: border-box;
            --bs-pagination-focus-bg: transparent;
            --bs-pagination-focus-box-shadow: none;
        }


        .active>.page-link,
        .page-link.active {
            background-color: #F77A36 !important;
            color: #fff !important;
            border: none !important;
            box-shadow: 0px 2px 8px 0px #2A41E840 !important;
            border-radius: 4px !important;
        }

        .pagination .disabled {
            border-radius: 4px !important;
        }

        .star-rating {
            direction: rtl;
            display: inline-flex;
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            font-size: 1.5rem;
            color: lightgray;
            cursor: pointer;
        }

        .star-rating input[type="radio"]:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: gold;
        }

        textarea {
            resize: none;
        }
    </style>
</head>

<body>
    @include('include.header')
    @yield('content')
    @include('include.footer')

    <script src=" {{ asset('assets/js/jquery.js') }} "></script>
    <script src=" {{ asset('assets/js/bootstrap.js') }} "></script>
    <script src=" {{ asset('assets/js/swiper.js') }} "></script>
    <script src=" {{ asset('assets/js/custom.js') }} "></script>
    <script src="{{ asset('assets/js/multiSelect.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Choices.js JS -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ Session::token() }}'
            }
        });
        @if (session()->has('success'))
            toastr.success('{{ session()->get('success') }}');
        @endif
        @if (session()->has('error'))
            toastr.error('{{ session()->get('error') }}');
        @endif
        $(window).on('load', function() {
            // Hide loading image when the page has finished loading
            $('#loading-image').fadeOut('slow');
        });
    </script>
    @yield('scripts')
</body>

</html>
