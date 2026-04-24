<nav class="navbar mb-0">
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
            <li class="nav-item me-3 d-flex align-items-center">
            <label class="theme-switch">
                <input type="checkbox" id="theme-switcher" onclick="toggleTheme()">
                <span class="slider-round">
                    <i data-feather="sun" style="width:14px"></i>
                    <i data-feather="moon" style="width:14px"></i>
                </span>
            </label>
        </li>

            {{-- ফটো লজিক শুরু --}}
            @php
                $user = auth()->user();
                $userPhoto = asset('assets/images/profile.webp'); // ডিফল্ট

                if ($user->role == 'school_admin' && $user->photo) {
                    $userPhoto = asset($user->photo);
                } 
                elseif ($user->role == 'teacher' && $user->teacher && $user->teacher->photo) {
                    $userPhoto = asset($user->teacher->photo);
                } 
                elseif ($user->role == 'student' && $user->student && $user->student->photo) {
                    $userPhoto = asset($user->student->photo);
                }
            @endphp
            {{-- ফটো লজিক শেষ --}}

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{-- নেভবার ছোট ফটো --}}
                    <img class="wd-30 ht-30 rounded-circle" src="{{ $userPhoto }}" alt="profile">
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                        <div class="mb-3">
                            {{-- ড্রপডাউন বড় ফটো --}}
                            <img class="wd-80 ht-80 rounded-circle" src="{{ $userPhoto }}" alt="profile">
                        </div>
                        <div class="text-center">
                            <p class="tx-16 fw-bolder">{{ $user->name }}</p>
                            <p class="tx-12 text-muted">{{ $user->email }}</p>
                            <small class="badge bg-soft-primary text-primary mt-1">{{ strtoupper(str_replace('_', ' ', $user->role)) }}</small>
                        </div>
                    </div>
                    <ul class="list-unstyled p-1">
                        <li class="dropdown-item py-2">
                            <a href="{{ route('user.profile') }}" class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="user"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="dropdown-item py-2">
                            <a href="{{ route('school.logout') }}" class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="log-out"></i>
                                <span>Log Out</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>