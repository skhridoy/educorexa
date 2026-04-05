<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <form class="search-form">
            <div class="input-group">
                <div class="input-group-text">
                    <i data-feather="search"></i>
                </div>
                <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
            </div>
        </form>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="flag-icon flag-icon-us mt-1" title="us"></i> 
                    <span class="ms-1 me-1 d-none d-md-inline-block">English</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="bell"></i>
                    {{-- যদি কোনো আন-রিড নোটিফিকেশন থাকে তবেই সংখ্যা দেখাবে --}}
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <div class="indicator">
                            <span class="badge bg-danger rounded-circle" style="font-size: 10px; position: absolute; top: 10px; right: 5px;">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        </div>
                    @endif
                </a>
                
                <div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
                    <div class="px-1 py-2 d-flex align-items-center justify-content-between border-bottom">
                        <p class="px-2">{{ Auth::user()->unreadNotifications->count() }} Notifications</p>
                        <a href="{{ route('super.notifications.readAll') }}" class="text-muted mx-2">Read All</a>
                    </div>
                    
                    <div class="p-1" style="max-height: 300px; overflow-y: auto;">
                        @forelse(Auth::user()->unreadNotifications as $notification)
                            <a href="{{ $notification->data['link'] }}" class="dropdown-item d-flex align-items-center py-2">
                                <div class="wd-30 ht-30 d-flex align-items-center justify-content-center bg-primary rounded-circle me-3">
                                    <i class="icon-sm text-white" data-feather="{{ $notification->data['icon'] }}"></i>
                                </div>
                                <div class="flex-grow-1 me-2">
                                    <p class="text-dark">{{ $notification->data['message'] }}</p>
                                    <p class="tx-12 text-muted">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="dropdown-item d-flex align-items-center py-2">
                                <p class="text-muted text-center w-100">No new notifications</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="wd-30 ht-30 rounded-circle" 
                         src="{{ Auth::user()->photo ? asset('uploads/super_admin/'.Auth::user()->photo) : asset('assets/images/profile.webp') }}"
                         alt="profile">
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                        <div class="mb-3">
                            <img class="wd-80 ht-80 rounded-circle" 
                                 src="{{ Auth::user()->photo ? asset('uploads/super_admin/'.Auth::user()->photo) : asset('assets/images/profile.webp') }}" 
                                 alt="">
                        </div>
                        <div class="text-center">
                            <p class="tx-16 fw-bolder">{{ Auth::user()->name }}</p>
                            <p class="tx-12 text-muted">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <ul class="list-unstyled p-1">
                        <li class="dropdown-item py-2">
                            <a href="{{ route('super.profile') }}" class="text-body ms-0 d-flex align-items-center">
                                <i class="me-2 icon-md" data-feather="user"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="dropdown-item py-2">
                            <a href="{{ route('super.settings.edit') }}" class="text-body ms-0 d-flex align-items-center">
                                <i class="me-2 icon-md" data-feather="settings"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li class="dropdown-item py-2">
                            <a href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                               class="text-body ms-0 d-flex align-items-center">
                                <i class="me-2 icon-md text-danger" data-feather="log-out"></i>
                                <span class="text-danger">Log Out</span>
                            </a>
                            <form id="logout-form" action="{{ route('super.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>