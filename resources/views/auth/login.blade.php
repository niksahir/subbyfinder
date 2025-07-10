@extends('layouts.withoutheaderfooter')

@section('content')
<!-- <section class="login-section">
   <div class="logo">
      <a href="{{ url('/') }}">
         <img src="{{ asset('assets/images/logo.png') }}" alt="" class="img-fluid">
      </a>
   </div>

   <div class="row">
      <div class="col-md-5">
         <div class="left-img">
            <img src="{{ asset('assets/images/login-register.jpg') }}" alt="" class="img-fluid">
         </div>
      </div>

      <div class="col-md-7">
         <div class="form-outer">
            <ul>
               <li>Subcontractor</li>
               <li>Contractor</li>
            </ul>

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
</section> -->
<section class="login-section">
   {{-- <div class="logo">
      <img src="{{ asset('assets/images/logo.png') }}" alt="" class="img-fluid">
   </div> --}}

   <div class="row">
      <div class="col-md-5">
         <div class="left-img">
            <img src="{{ asset('assets/images/login-register.jpg') }}" alt="" class="img-fluid">
         </div>
      </div>

      <div class="col-md-7">
         <div class="form-outer">
            <h3>Sign In As a </h3>
            @if(session('success'))
            <div class="alert alert-success">
               {{ session('success') }}
            </div>
            @endif

            <div class="login-btn-wrapper">
               <a href="{{ route('subcontractor.login.index') }}">Subcontractor</a>
               <a href="{{ route('contractor.login.index') }}">Principal Contractor</a>
            </div>


            <form>
               <div class="account">
                  <p>Create an Account? <a href="{{ route('front.createaccount') }}"> Sign up</a></p>
               </div>
            </form>
         </div>

      </div>
   </div>
   </div>
</section>
@endsection
