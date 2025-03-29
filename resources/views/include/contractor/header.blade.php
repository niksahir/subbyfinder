<header>
    <div class="container">
        <div class="row">
            <div class="col-6 col-lg-8">
                <div class="logo-with-menu">
                    <div class="logo">
                        <a href="{{ route('contractor.dashboard.index') }}">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="">
                        </a>
                    </div>

                    <div class="menus">
                        <ul>
                            <li><a href="{{ route('front.home') }}">Home</a></li>
                            <li><a href="{{ route('front.subcontractorsearch') }}">Find Subcontractors</a></li>
                            <li><a href="{{ route('contractor.dashboard.index') }}">Dashboard</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-4">
                <div class="menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <div class="logged-in">
                    <ul>
                        <li><a href="#"> <i class="fa-solid fa-bell"></i> <span>4</span></a></li>
                        <li><a href="#"><i class="fa-regular fa-envelope"></i> <span>6</span></a></li>


                    </ul>


                    <div class="user">
                        @if (Auth::check() && Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo"
                                class="img-fluid">
                        @else
                            <img src="{{ asset('assets/images/team-1.jpg') }}" alt="Default Image" class="img-fluid">
                        @endif
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
