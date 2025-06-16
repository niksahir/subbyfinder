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
                            <li>
                                <a href="{{ route('front.pricing') }}">Pricing</a>
                            </li>
                            <li><a href="{{ route('contractor.dashboard.index') }}">Dashboard</a></li>
                            <li><a href="{{ route('contractor.projects.create') }}">Post Project</a></li>
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
                    @php
                        $unseenMessages = \App\Models\Message::where(
                            'to_user_id',
                            Auth::guard('contractor')->user()->id,
                        )
                            ->where('receiver_type', 'contractor')
                            ->where('is_seen', 0)
                            ->select('from_user_id')
                            ->distinct()
                            ->count('from_user_id');
                    @endphp
                    <ul>
                        @php
                            $user = auth('contractor')->user();
                        @endphp
                        <li class="nav-item dropdown">
                            <a class="nav-link position-relative" href="#" id="notificationDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bell"></i>
                                @if (auth('contractor')->user()->unreadNotifications->count())
                                    <span>
                                        {{ auth('contractor')->user()->unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-3 shadow"
                                aria-labelledby="notificationDropdown"
                                style="width: 350px; max-height: 400px; overflow-y: auto;">

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">Notifications</h5>
                                    <a href="{{ route('contractor.notifications.markAllAsRead') }}"
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
                            <!-- Notifications Dropdown -->
                        </li>

                        <li><a class="nav-link" style="height: 45px"
                                href="{{ route('contractor.messages.index') }}"><img
                                    src="{{ asset('assets/images/message-mail-svgrepo-com.svg') }}" alt=""
                                    class="object-cover" height="25" width="25"><span id="header-unseen-count"
                                    class="@if ($unseenMessages <= 0) d-none @endif">
                                    {{ $unseenMessages }}</span></a></li>
                        <!-- Notification Bell Icon -->

                    </ul>


                    <div class="user">
                        @if (Auth::check() && Auth::user()->profile_photo)
                            <a href="{{ route('contractor.dashboard.index') }}"><img
                                    src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('assets/images/icons8-person-94.png') }}"
                                    alt="Profile Photo" class="img-fluid"></a>
                        @else
                            <a href="{{ route('contractor.dashboard.index') }}"><img
                                    src="{{ asset('assets/images/icons8-person-94.png') }}" alt="No Image"
                                    class="img-fluid"></a>
                        @endif
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
