@php
    $unreadNotifications = auth()->user()->unreadNotifications;
@endphp
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
                
                <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in notification-dropdown" 
                    aria-labelledby="notificationDropdown" 
                    style="width: 350px; max-width: 90vw; padding: 0; border: none;">
                    
                    <div class="dropdown-header bg-primary text-white d-flex justify-content-between align-items-center p-3">
                        <h6 class="m-0 font-weight-bold">Notifications</h6>
                        <a href="#" class="text-white-50 small" id="mark-all-read">Read All</a>
                    </div>

                    <div style="max-height: 400px; overflow-y: auto;">
                        @forelse($unreadNotifications as $notification)
                            <a class="dropdown-item d-flex align-items-start p-3 border-bottom" href="{{ $notification->data['link'] ?? '#' }}">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary text-white p-2 rounded-circle">
                                        <i class="fas fa-{{ $notification->data['icon'] ?? 'bell' }}"></i>
                                    </div>
                                </div>
                                <div class="notification-content">
                                    <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                    <span class="font-weight-bold text-dark d-block text-truncate-2">
                                        {{ $notification->data['message'] }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="p-4 text-center text-gray-500">No new notifications</div>
                        @endforelse
                    </div>

                    <a class="dropdown-item text-center small text-gray-500 p-2" href="#">Show All Alerts</a>
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