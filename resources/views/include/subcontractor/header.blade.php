<header>
    <div class="container">
        <div class="row">
            <div class="col-6 col-lg-8">
                <div class="logo-with-menu">
                    <div class="logo">
                        <a href="{{ route('front.home') }}">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="">
                        </a>
                    </div>

                    <div class="menus">
                        <ul>
                            <li>
                                <a href="{{ route('front.home') }}">Home</a>
                            </li>
                            <li>
                                <a href="{{ route('front.projectSearch') }}">Find Work</a>
                            </li>
                            <li>
                                <a href="{{ route('front.pricing') }}">Pricing</a>
                            </li>
                            <li>
                                <a href="{{ route('subcontractor.dashboard.index') }}">Dashboard</a>
                            </li>
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
                        <li><a href="#"> <i class="fa-solid fa-bell"></i> <span>4</span></a>
                            <ul class="notification">
                                <div class="title-item"><span>Notifications</span> <a href="#">Mark all as
                                        read</a> </div>

                                <li>
                                    <img src="{{ asset('assets/images/team-1.jpg') }}" alt="" class="img-fluid">

                                    <div class="content">
                                        <p><b>Jan Mayer</b> New joiner </p>
                                        <div class="view-profile"> <a href="#">View Profile</a></div>
                                        <small>12 mins ago</small>
                                    </div>
                                </li>
                                <li>
                                    <img src="{{ asset('assets/images/team-2.jpg') }}" alt="" class="img-fluid">

                                    <div class="content">
                                        <p><b>Jan Mayer</b> New joiner </p>
                                        <div class="view-profile"> <a href="#">View Profile</a></div>
                                        <small>12 mins ago</small>
                                    </div>
                                </li>
                                <li>
                                    <img src="{{ asset('assets/images/client-1.png') }}" alt=""
                                        class="img-fluid">

                                    <div class="content">
                                        <p><b>Jan Mayer</b> New joiner </p>
                                        <div class="view-profile"> <a href="#">View Profile</a></div>
                                        <small>12 mins ago</small>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <li><a href="#"><i class="fa-regular fa-envelope"></i> <span>6</span></a></li>


                    </ul>


                    <div class="user">
                        @if (Auth::check() && Auth::user()->profile_photo)
                            <a href="{{ route('subcontractor.dashboard.index') }}"><img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo"
                                class="img-fluid"></a>
                        @else
                            <a href="{{ route('subcontractor.dashboard.index') }}"><img src="" alt="No Image" class="img-fluid"></a>    
                        @endif
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
