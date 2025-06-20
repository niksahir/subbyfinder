<footer>
    <div class="footer-topbar">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="logo">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="img-fluid">
                    </div>
                </div>


                <div class="col-6">
                    <div class="social">
                        <ul>
                            <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-google-plus-g"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        if (auth('contractor')->check()) {
            $user = auth('contractor')->user();
            $guard = 'contractor';
        } elseif (auth('subcontractor')->check()) {
            $user = auth('subcontractor')->user();
            $guard = 'subcontractor';
        } else {
            // Handle case when no user is authenticated
            $user = null;
            $guard = null;
        }
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-6 col-md-2">
                <div class="menu-item">
                    <h5>Sub Contractor</h5>

                    <ul>
                        <li><a href="{{ route('front.projectSearch') }}">Browse Project</a></li>
                        <li><a href="#">Project Alerts</a></li>
                        <li><a
                                href="@if ($user && $guard === 'contractor') {{ route('contractor.bookmark.index') }} @elseif ($user && $guard === 'subcontractor') {{ route('subcontractor.bookmark.index') }} @else {{ route('login') }} @endif">My
                                Bookmarks</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="menu-item">
                    <h5>Principal Contractor</h5>

                    <ul>
                        <li><a href="{{ route('front.subcontractorsearch') }}">Browse Subcontractor</a></li>
                        <li><a href="{{ route('contractor.projects.create') }}">Post a Project</a></li>
                        <li><a href="{{ route('front.pricing') }}">Plans & Pricing</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="menu-item">
                    <h5>Helpful Links</h5>

                    <ul>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="{{ route('front.home') }}">Blogs</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="menu-item">
                    <h5>Account</h5>

                    <ul>
                        <li><a href="{{ route('login') }}">Log In</a></li>
                        <li><a
                                href="@if ($guard === 'contractor') {{ route('contractor.dashboard.index') }} @elseif ($guard === 'subcontractor') {{ route('subcontractor.dashboard.index') }} @else {{ route('login') }} @endif">My
                                Account</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="newsletter">
                    <h5> Sign Up For a Newsletter</h5>
                    <p>Weekly breaking news, analysis and cutting edge
                        advices on job searching.</p>

                    <div class="inner">
                        <input type="text" class="form-control" placeholder="Enter your email address">
                        <button class="btn">arrow</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="bottom">
            <div class="container">
                <p>© {{ date('Y') }} Subby Finder. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>
