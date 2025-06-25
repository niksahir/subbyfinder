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
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link " id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                                type="button" role="tab" aria-controls="nav-home"
                                aria-selected="true">Subcontractor </button>
                            <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                                aria-selected="false">Principal Contractor</button>
                        </div>
                    </nav>


                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <h3>Welcome Back, Dude</h3>

                            <div class="login-type">
                                <img src="{{ asset('assets/images/google.png') }}" alt="" class="img-fluid">
                                <span onclick="signInWithGoogle('subcontractor')" data-type="subcontractor"
                                    style="cursor: pointer;">
                                    Login with Google
                                </span>
                            </div>


                            <div class="divider">
                                <p>Or login with email</p>
                            </div>

                            <form method="POST" action="{{ route('subcontractor.login.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email Address') }}</label>

                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn "> {{ __('Login') }}</button>

                                <div class="account">
                                    <p>Don’t have an account? <a href="{{ route('subcontractor.register.index') }}">
                                            Sign up</a></p>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel"
                            aria-labelledby="nav-profile-tab">
                            <h3>Welcome Back, Dude</h3>

                            <div class="login-type">
                                <img src="{{ asset('assets/images/google.png') }}" alt="" class="img-fluid">
                                <span onclick="signInWithGoogle('subcontractor')" data-type="subcontractor"
                                    style="cursor: pointer;">
                                    Login with Google
                                </span>
                            </div>


                            <div class="divider">
                                <p>Or login with email</p>
                            </div>

                            <form method="POST" action="{{ route('contractor.login.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email Address') }}</label>

                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                            id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn "> {{ __('Login') }}</button>

                                <div class="account">
                                    <p>Don’t have an account? <a href="{{ route('contractor.register.index') }}"> Sign
                                            up</a></p>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>


    <script src=" {{ asset('assets/js/jquery.js') }} "></script>
    <script src=" {{ asset('assets/js/bootstrap.js') }} "></script>
    <script src=" {{ asset('assets/js/custom.js') }} "></script>


    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-firestore-compat.js"></script>
    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyCZn3R2CXhxP-Hy45V4xnO3RwM3KBp3Adw",
            authDomain: "subby-finder-fb190.firebaseapp.com",
            projectId: "subby-finder-fb190",
            appId: "1:143717964761:web:a5b77edbd254d36ec2d7c8",
        };

        firebase.initializeApp(firebaseConfig);
        const provider = new firebase.auth.GoogleAuthProvider();

        function signInWithGoogle(type) {
            firebase.auth().signInWithPopup(provider)
                .then(async (result) => {
                    const user = result.user;
                    const idToken = await user.getIdToken();
                    const storedParam = type;

                    fetch('/api/firebase-login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': 'Bearer ' + idToken,
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            name: user.displayName,
                            email: user.email,
                            type: storedParam
                        })
                    }).then(res => res.json()).then(data => console.log(data));
                })
                .catch(err => console.error(err));
        }
    </script>

</body>

</html>
