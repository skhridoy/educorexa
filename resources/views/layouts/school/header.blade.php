{{-- ফটো এবং নোটিফিকেশন লজিক শুরু --}}
@php
    $user = auth()->user();
    $unreadNotifications = auth()->check() ? $user->unreadNotifications : collect();
    $school = $currentSchool ?? $user?->school;
    $tenant = $school?->slug ?? $user?->school?->slug ?? request()->route('tenant') ?? '';
    
    // ইউজার রোল অনুযায়ী ফোল্ডার পাথ নির্ধারণ
    $folder = ($user && $user->role === 'super_admin') ? 'super_admin' : 'employees';
    
    // ফটো লজিক (স্কুল প্যানেল ও সুপার এডমিন প্যানেলের সমন্বয়)
    $userPhoto = asset('assets/images/profile.webp'); // ডিফল্ট

    if ($user) {
        if ($user->role === 'super_admin' || $user->role === 'HR' || $user->role === 'Marketing') {
            $userPhoto = $user->photo ? asset('uploads/' . $folder . '/' . $user->photo) : $userPhoto;
        } 
        elseif ($user->role === 'school_admin' && $user->photo) {
            $userPhoto = asset($user->photo);
        } 
        elseif ($user->role === 'teacher' && $user->teacher && $user->teacher->photo) {
            $userPhoto = asset($user->teacher->photo);
        } 
        elseif ($user->role === 'student' && $user->student && $user->student->photo) {
            $userPhoto = asset($user->student->photo);
        }
    }

    $currentLocale = app()->getLocale();
@endphp
{{-- ফটো লজিক শেষ --}}

<nav class="navbar mb-0 shadow-sm border-bottom border-light" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); position: sticky; top: 0; z-index: 1030;">

    {{-- Left: Hamburger + Search --}}
    <div class="d-flex align-items-center gap-3 flex-grow-1">
        {{-- Sidebar Toggle --}}
        <a href="#" class="sidebar-toggler text-dark d-flex align-items-center justify-content-center"
           style="width:38px;height:38px;border-radius:10px;text-decoration:none;flex-shrink:0;transition:background 0.2s;">
            <i data-feather="menu" style="width:20px;height:20px;"></i>
        </a>

        {{-- Search Bar --}}
        <form class="search-form d-none d-lg-block" style="max-width:360px;width:100%;">
            <div class="input-group">
                <div class="input-group-text">
                    <i data-feather="search" style="width:16px;height:16px;"></i>
                </div>
                <input type="text" class="form-control" id="navbarForm" placeholder="{{ __('Search schools, settings...') }}">
            </div>
        </form>
    </div>

    {{-- Right: Actions + Profile --}}
    <div class="d-flex align-items-center gap-2 gap-md-3">
        
        {{-- Language Switcher (বাংলা ↔ English) --}}
        <div class="dropdown">
            <button class="btn btn-sm d-flex align-items-center gap-1.5 px-2.5 py-1.5 rounded-pill"
                    style="background: rgba(79, 70, 229, 0.08); border: 1px solid rgba(79, 70, 229, 0.2); color: #4f46e5; font-weight: 600; font-size: 12px; transition: all .2s;"
                    data-bs-toggle="dropdown" aria-expanded="false" title="{{ __('Language') }}">
                <i class="fa-solid fa-globe"></i>
                <span class="d-none d-sm-inline">{{ $currentLocale === 'bn' ? 'বাংলা' : 'EN' }}</span>
                <i data-feather="chevron-down" style="width:12px;height:12px;"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2" style="border-radius: 12px; min-width: 140px; margin-top: 8px; z-index: 1050;">
                <li>
                    @php
                        $enRoute = $tenant ? route('school.set.locale', ['tenant' => $tenant, 'lang' => 'en']) : route('set.locale', ['lang' => 'en']);
                    @endphp
                    <a class="dropdown-item d-flex align-items-center justify-content-between py-1.5 px-3 {{ $currentLocale === 'en' ? 'active fw-bold' : '' }}"
                       href="{{ $enRoute }}">
                        <span>🇬🇧 English</span>
                        @if($currentLocale === 'en')
                            <i class="fa-solid fa-check text-primary" style="font-size: 11px;"></i>
                        @endif
                    </a>
                </li>
                <li>
                    @php
                        $bnRoute = $tenant ? route('school.set.locale', ['tenant' => $tenant, 'lang' => 'bn']) : route('set.locale', ['lang' => 'bn']);
                    @endphp
                    <a class="dropdown-item d-flex align-items-center justify-content-between py-1.5 px-3 {{ $currentLocale === 'bn' ? 'active fw-bold font-bn' : 'font-bn' }}"
                       href="{{ $bnRoute }}">
                        <span>🇧🇩 বাংলা</span>
                        @if($currentLocale === 'bn')
                            <i class="fa-solid fa-check text-primary" style="font-size: 11px;"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </div>

        {{-- Theme Switcher --}}
        <div class="nav-item d-md-flex align-items-center">
            <label class="theme-switch">
                <input type="checkbox" id="theme-switcher" onclick="toggleTheme()">
                <span class="slider-round">
                    <i data-feather="sun" style="width:14px"></i>
                    <i data-feather="moon" style="width:14px"></i>
                </span>
            </label>
        </div>

        {{-- Notifications --}}
        <div class="dropdown">
            <button class="btn p-0 position-relative d-flex align-items-center justify-content-center"
                    style="width:38px;height:38px;border-radius:10px;background:transparent;border:none;color:#64748b;"
                    data-bs-toggle="dropdown" aria-expanded="false">
                <i data-feather="bell" style="width:19px;height:19px;"></i>
                @if($unreadNotifications->count() > 0)
                    <span class="position-absolute"
                          style="top:6px;right:6px;width:8px;height:8px;background:#ef4444;border-radius:50%;border:2px solid #fff;"></span>
                @endif
            </button>

            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-0"
                 style="width:340px;border-radius:16px;overflow:hidden;margin-top:8px;z-index:1050;">
                <div class="p-3 border-bottom" style="background:#fafbff;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">{{ __('Notifications') }}</h6>
                        @if($unreadNotifications->count() > 0)
                            <span class="badge bg-primary rounded-pill">{{ $unreadNotifications->count() }} {{ __('New') }}</span>
                        @endif
                    </div>
                </div>
                <div style="max-height:300px;overflow-y:auto;">
                    @forelse($unreadNotifications->take(5) as $notification)
                        <div class="p-3 border-bottom d-flex gap-3 align-items-start" style="cursor:pointer;">
                            <div style="width:36px;height:36px;background:#eef2ff;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i data-feather="bell" style="width:15px;height:15px;color:#6571ff;"></i>
                            </div>
                            <div>
                                <p class="mb-0 text-dark fw-bold" style="font-size:0.82rem;">
                                    {{ $notification->data['message'] ?? __('New notification') }}
                                </p>
                                <p class="mb-0 text-muted" style="font-size:0.75rem;">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center">
                            <p class="mb-0 text-muted small">{{ __('All caught up!') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Profile Dropdown --}}
        <div class="dropdown">
            <button class="btn p-0 d-flex align-items-center gap-2"
                    style="background:transparent;border:none;border-radius:10px;padding:4px 8px!important;"
                    data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ $userPhoto }}" alt="{{ $user->name }}"
                     style="width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid #e0e7ff;">
                <div class="d-none d-md-block text-start">
                    <div class="edu-user-name" style="font-size:0.82rem;font-weight:700;line-height:1.1;">{{ $user->name }}</div>
                    <div class="edu-user-role" style="font-size:10px;font-weight:700;text-transform:uppercase;">
                        {{ __(ucwords(str_replace('_', ' ', $user->role))) }}
                    </div>
                </div>
                <i data-feather="chevron-down" style="width:14px;height:14px;color:#94a3b8;"></i>
            </button>

            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-0"
                 style="width:240px;border-radius:16px;overflow:hidden;margin-top:8px;z-index:1050;">
                
                <div class="p-4 text-center border-bottom" style="background:linear-gradient(135deg,#f8f7ff,#eef2ff);">
                    <img src="{{ $userPhoto }}" alt="{{ $user->name }}"
                         style="width:60px;height:60px;border-radius:50%;object-fit:cover;border:3px solid #fff;box-shadow:0 4px 12px rgba(79,70,229,0.2);margin-bottom:10px;">
                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                    <div class="small text-muted">{{ $user->email }}</div>
                </div>

                <div class="p-2">
                    <a href="{{ ($user->role === 'super_admin') ? route('profile') : route('user.profile') }}"
                       class="dropdown-item d-flex align-items-center gap-2 py-2">
                        <i data-feather="user" style="width:16px;height:16px;"></i> {{ __('My Profile') }}
                    </a>
                </div>

                <div class="p-2 border-top">
                    @php
                        $logoutRoute = ($user && ($user->role === 'super_admin' || $user->role === 'HR' || $user->role === 'Marketing')) 
                                        ? route('logout') 
                                        : ($tenant ? route('school.logout', ['tenant' => $tenant]) : route('logout'));
                    @endphp
                    <a href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger">
                       <i data-feather="log-out" style="width:16px;height:16px;"></i> {{ __('Log Out') }}
                    </a>
                    <form id="logout-form" action="{{ $logoutRoute }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>