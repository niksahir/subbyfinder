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



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link href="{{ asset('assets/css/multiSelect.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
