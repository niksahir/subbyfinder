@extends('layouts.before')
@section("title")
Contractor - Subby Finder
@endsection

@section("content")
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
                  <button class="nav-link " id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="false" tabindex="-1">Subcontractor </button>
                  <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Contractor</button>
               </div>
            </nav>


            <div class="tab-content" id="nav-tabContent">
               <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                  <h3>Welcome Back, Dude</h3>

                  <div class="login-type">
                     <img src="{{ asset('assets/images/google.png') }}" alt="" class="img-fluid">
                     <span>Login with Google</span>
                  </div>


                  <div class="divider">
                     <p>Or login with email</p>
                  </div>

                  <form method="POST" action="{{ route('login') }}">
                     @csrf
                     <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>

                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>

                     <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>

                     <div class="mb-3 form-check">
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                           <label class="form-check-label" for="remember">
                              {{ __('Remember Me') }}
                           </label>
                        </div>
                     </div>

                     <button type="submit" class="btn "> {{ __('Login') }}</button>

                     <div class="account">
                        <p>Don’t have an account? <a href="{{ route('register') }}"> Sign up</a></p>
                     </div>
                  </form>
               </div>


               <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                  <h3>Welcome Back, Dude</h3>

                  <div class="login-type">
                     <img src="{{ asset('assets/images/google.png') }}" alt="" class="img-fluid">
                     <span>Login with Google</span>
                  </div>


                  <div class="divider">
                     <p>Or login with email</p>
                  </div>

                  <form method="POST" action="{{ route('login') }}">
                     @csrf
                     <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>

                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>

                     <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>

                     <div class="mb-3 form-check">
                        <div class="form-check">
                           <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                           <label class="form-check-label" for="remember">
                              {{ __('Remember Me') }}
                           </label>
                        </div>
                     </div>

                     <button type="submit" class="btn "> {{ __('Login') }}</button>

                     <div class="account">
                        <p>Don’t have an account? <a href="{{ route('register') }}"> Sign up</a></p>
                     </div>
                  </form>
               </div>
            </div>


         </div>
      </div>
   </div>
</section>
@endsection
