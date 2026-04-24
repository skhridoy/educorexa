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
            {{-- Language Dropdown (আগের মতোই থাকবে) --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="flag-icon flag-icon-us mt-1" title="us"></i> 
                    <span class="ms-1 me-1 d-none d-md-inline-block">English</span>
                </a>
            </li>

            @php
                $user = auth()->user();
                $unreadNotifications = auth()->check() ? $user->unreadNotifications : collect();
                
                // ডায়নামিক ইমেজ পাথ লজিক
                $folder = ($user && $user->role === 'super_admin') ? 'super_admin' : 'employees';
                $userPhoto = ($user && $user->photo) 
                             ? asset('uploads/' . $folder . '/' . $user->photo) 
                             : asset('assets/images/profile.webp');
            @endphp

            {{-- Notification Dropdown (আগের মতোই থাকবে) --}}
            <li class="nav-item dropdown">
                {{-- ... নোটিফিকেশন কোড ... --}}
            </li>

            {{-- Profile Dropdown --}}
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="wd-30 ht-30 rounded-circle" src="{{ $userPhoto }}" alt="profile">
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                        <div class="mb-3">
                            <img class="wd-80 ht-80 rounded-circle" src="{{ $userPhoto }}" alt="profile">
                        </div>
                        <div class="text-center">
                            <p class="tx-16 fw-bolder">{{ $user->name }}</p>
                            <p class="tx-12 text-muted">{{ $user->email }}</p>
                        </div>
                    </div>
                    <ul class="list-unstyled p-1">
                        <li class="dropdown-item py-2">
                            <a href="{{ route('profile') }}" class="text-body ms-0 d-flex align-items-center">
                                <i class="me-2 icon-md" data-feather="user"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        
                        {{-- সুপার অ্যাডমিন হলে সেটিংস দেখাবে --}}
                        @if($user->role === 'super_admin')
                        <li class="dropdown-item py-2">
                            <a href="{{ route('settings.edit') }}" class="text-body ms-0 d-flex align-items-center">
                                <i class="me-2 icon-md" data-feather="settings"></i>
                                <span>Settings</span>
                            </a>
                        </li>
                        @endif

                        <li class="dropdown-item py-2">
                            <a href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                               class="text-body ms-0 d-flex align-items-center">
                                <i class="me-2 icon-md text-danger" data-feather="log-out"></i>
                                <span class="text-danger">Log Out</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>