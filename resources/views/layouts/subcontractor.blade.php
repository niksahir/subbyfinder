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
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- {{-- Custom Css  --}} -->
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link href="{{ asset('assets/css/multiSelect.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

        .prject-with-images {
            -webkit-box-shadow: 0px 2px 12px 0px rgba(0, 0, 0, 0.1215686275);
            box-shadow: 0px 2px 12px 0px rgba(0, 0, 0, 0.1215686275);
            padding: 15px 20px;
            color: var(--c-text);
        }

        .prject-with-images .price {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .prject-with-images h6 {
            font-weight: 600;
        }

        .prject-with-images p {
            margin-top: 0;
        }

        .prject-with-images .full-label {
            margin-top: 20px !important;
        }

        .prject-with-images ul li i {
            margin-right: 10px;
        }

        .img-wrapper {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 15px;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        }

        .img-wrapper img {
            aspect-ratio: 1;
            margin-right: 20px;
            border-radius: 15px;
            width: 20%;
            margin-bottom: 12px;
        }

        @media screen and (min-width: 768px) {
            .img-wrapper img {
                width: 16%;
            }
        }

        .price {
            height: 100%;
            /* background-color: rgb(248, 248, 248); */
            padding: 30px 20px;
        }

        .buttons i {
            text-align: right;
            margin-bottom: 20px;
            color: var(--c-primary);
        }

        /* .review-item {
            background-color: #f8f8f8;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        } */
    </style>
</head>

<body>
    <div id="loader-overlay"></div>
    <div id="loader" style="display: none;">
        <img src="{{ asset('assets/images/loader-1.gif') }}" alt="Loading..." />
    </div>
    @include('include.subcontractor.header')
    @include('include.subcontractor.mobilemenu')
    <section class="dashboard">
        <div class="wrapper d-flex">
            @include('include.subcontractor.leftsidemenu')
            <div class="col-md-9">
                <div class="right-side">
                    @yield('content')
                    @include('include.subcontractor.footer')
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/multiSelect.js') }}"></script>
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
    <script>
        $(document).ready(function() {
            $(document).on('click', '.bookmark-icon', function(event) {

                const projectId = $(this).data('id');
                const iconElement = $(this);

                $.ajax({
                    url: "{{ route('contractor.bookmark.store') }}", // Route to store bookmark
                    type: 'POST',
                    data: {
                        id: projectId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 'added') {
                            iconElement.removeClass('fa-regular').addClass('fa-solid');
                            toastr.success(response.message);
                        } else if (response.status === 'removed') {
                            location.reload();
                            toastr.success(response.message);
                            iconElement.removeClass('fa-solid').addClass('fa-regular');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
