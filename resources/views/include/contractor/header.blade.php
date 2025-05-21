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
                        <li><a href="#"> <i class="fa-solid fa-bell"></i> <span>4</span></a></li>
                        <li><a href="{{ route('contractor.messages.index') }}"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M9.99935 2.29199C5.74215 2.29199 2.29102 5.74313 2.29102 10.0003C2.29102 11.2345 2.58062 12.3993 3.09501 13.4321C3.30147 13.8466 3.38097 14.3422 3.25071 14.829L2.75437 16.6841C2.66321 17.0248 2.9749 17.3365 3.31559 17.2453L5.17062 16.749C5.65746 16.6187 6.1531 16.6982 6.56761 16.9047C7.60035 17.4191 8.76513 17.7087 9.99935 17.7087C14.2565 17.7087 17.7077 14.2575 17.7077 10.0003C17.7077 5.74313 14.2565 2.29199 9.99935 2.29199ZM1.04102 10.0003C1.04102 5.05277 5.0518 1.04199 9.99935 1.04199C14.9469 1.04199 18.9577 5.05277 18.9577 10.0003C18.9577 14.9479 14.9469 18.9587 9.99935 18.9587C8.56743 18.9587 7.21229 18.6222 6.01031 18.0236C5.83094 17.9342 5.64779 17.9153 5.49372 17.9565L3.63868 18.4528C2.36882 18.7926 1.20708 17.6308 1.54685 16.361L2.04319 14.506C2.08441 14.3519 2.06546 14.1687 1.97612 13.9894C1.37744 12.7874 1.04102 11.4322 1.04102 10.0003ZM6.04102 8.75033C6.04102 8.40515 6.32084 8.12533 6.66602 8.12533H13.3327C13.6779 8.12533 13.9577 8.40515 13.9577 8.75033C13.9577 9.0955 13.6779 9.37533 13.3327 9.37533H6.66602C6.32084 9.37533 6.04102 9.0955 6.04102 8.75033ZM6.04102 11.667C6.04102 11.3218 6.32084 11.042 6.66602 11.042H11.2493C11.5945 11.042 11.8743 11.3218 11.8743 11.667C11.8743 12.0122 11.5945 12.292 11.2493 12.292H6.66602C6.32084 12.292 6.04102 12.0122 6.04102 11.667Z"
                                        fill="currentColor" />
                                </svg> <span id="header-unseen-count"
                                    class="@if ($unseenMessages <= 0) d-none @endif">
                                    {{ $unseenMessages }}</span></a></li>
                    </ul>


                    <div class="user">
                        @if (Auth::check() && Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo"
                                class="img-fluid">
                        @else
                            <img src="" alt="No Image" class="img-fluid">
                        @endif
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
