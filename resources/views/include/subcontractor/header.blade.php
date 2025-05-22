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
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative" href="#" id="notificationDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bell"></i>
                                @if (auth('subcontractor')->user()->unreadNotifications->count())
                                    <span>
                                        {{ auth('subcontractor')->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>

                            <!-- Notifications Dropdown -->
                            @php
                                $user = auth('subcontractor')->user();
                            @endphp

                            <ul class="dropdown-menu dropdown-menu-end p-3 shadow"
                                aria-labelledby="notificationDropdown"
                                style="width: 350px; max-height: 400px; overflow-y: auto;">

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">Notifications</h5>
                                    <a href="{{ route('subcontractor.notifications.markAllAsRead') }}"
                                        class="text-orange text-decoration-none fs-6" style="color: #fd7e14;">
                                        Mark all as read
                                    </a>
                                </div>

                                @forelse ($user->unreadNotifications as $notification)
                                    <div class="notification-card d-flex align-items-start border-bottom pb-2 mb-2">
                                        @if (isset($notification->data['image']))
                                            <img src="{{ asset('storage/' . $notification->data['image']) }}"
                                                alt="Notification Image" class="img-fluid me-2" height="48"
                                                width="48" style="border-radius: 50%;">
                                        @else
                                            <img src="{{ asset('assets/images/icons8-person-94.png') }}"
                                                alt="Default Notification Image" class="img-fluid me-2" height="48"
                                                width="48" style="border-radius: 50%;">
                                        @endif
                                        <div>
                                            <div>{{ $notification->data['message'] }}</div>
                                            <div class="text-muted small mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted">No new notifications</div>
                                @endforelse
                            </ul>
                        </li>

                        <li><a href="#"><i class="fa-regular fa-envelope"></i> <span>6</span></a></li>
                    </ul>
                    {{-- <ul class="notification">
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
                            </ul> --}}

                    <div class="user">
                        @if (Auth::check() && Auth::user()->profile_photo)
                            <a href="{{ route('subcontractor.dashboard.index') }}"><img
                                    src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo"
                                    class="img-fluid"></a>
                        @else
                            <a href="{{ route('subcontractor.dashboard.index') }}"><img src="" alt="No Image"
                                    class="img-fluid"></a>
                        @endif
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
