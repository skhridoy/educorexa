@php
    $user = auth()->user();
    $unreadNotifications = auth()->check() ? $user->unreadNotifications : collect();
    $folder = ($user && $user->role === 'super_admin') ? 'super_admin' : 'employees';
    $userPhoto = ($user && $user->photo)
                 ? asset('uploads/' . $folder . '/' . $user->photo)
                 : asset('assets/images/profile.webp');
@endphp

<nav class="navbar">

    {{-- Left: Hamburger + Search --}}
    <div class="d-flex align-items-center gap-3 flex-grow-1">

        {{-- Sidebar Toggle --}}
        <a href="#" class="sidebar-toggler d-flex align-items-center justify-content-center"
           style="width:38px;height:38px;border-radius:10px;color:var(--text-muted);text-decoration:none;flex-shrink:0;transition:background 0.2s;"
           onmouseover="this.style.background='var(--surface)'" onmouseout="this.style.background='transparent'">
            <i data-feather="menu" style="width:20px;height:20px;"></i>
        </a>

        {{-- Search Bar (Hidden on mobile) --}}
        <form class="search-form d-none d-lg-block" style="max-width:360px;width:100%;">
            <div class="input-group" style="background:#f8fafc;border-radius:30px;border:1px solid #e2e8f0;overflow:hidden;">
                <div class="input-group-text" style="background:transparent;border:none;padding:0 12px;color:#94a3b8;">
                    <i data-feather="search" style="width:16px;height:16px;"></i>
                </div>
                <input type="text" class="form-control" id="navbarForm" placeholder="Search schools, settings..."
                       style="background:transparent;border:none;box-shadow:none;font-size:0.875rem;color:var(--text-main);padding:10px 0;">
            </div>
        </form>

    </div>

    {{-- Right: Actions + Profile --}}
    <div class="d-flex align-items-center gap-2">

        {{-- Notifications --}}
        <div class="dropdown">
            <button class="btn p-0 position-relative d-flex align-items-center justify-content-center"
                    style="width:38px;height:38px;border-radius:10px;background:transparent;border:none;color:var(--text-muted);transition:background 0.2s;"
                    data-bs-toggle="dropdown" aria-expanded="false"
                    onmouseover="this.style.background='var(--surface)'" onmouseout="this.style.background='transparent'">
                <i data-feather="bell" style="width:19px;height:19px;"></i>
                @if($unreadNotifications->count() > 0)
                    <span class="position-absolute"
                          style="top:6px;right:6px;width:8px;height:8px;background:#ef4444;border-radius:50%;border:2px solid #fff;"></span>
                @endif
            </button>

            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-0"
                 style="width:340px;border-radius:16px;overflow:hidden;margin-top:8px;">
                <div class="p-4 border-bottom" style="background:#fafbff;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold" style="color:var(--navy);">Notifications</h6>
                        @if($unreadNotifications->count() > 0)
                            <span style="background:#eef2ff;color:var(--primary);font-size:11px;font-weight:700;padding:3px 8px;border-radius:20px;">
                                {{ $unreadNotifications->count() }} New
                            </span>
                        @endif
                    </div>
                </div>
                <div style="max-height:300px;overflow-y:auto;">
                    @forelse($unreadNotifications->take(5) as $notification)
                        <div class="p-3 border-bottom d-flex gap-3 align-items-start"
                             style="transition:background 0.15s;cursor:pointer;"
                             onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                            <div style="width:36px;height:36px;background:#eef2ff;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i data-feather="bell" style="width:15px;height:15px;color:var(--primary);"></i>
                            </div>
                            <div>
                                <p class="mb-0" style="font-size:0.82rem;font-weight:600;color:var(--navy);">
                                    {{ $notification->data['message'] ?? 'New notification' }}
                                </p>
                                <p class="mb-0" style="font-size:0.75rem;color:var(--text-faint);">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-center">
                            <i class="fa-solid fa-bell-slash fa-2x mb-3" style="color:#e2e8f0;"></i>
                            <p class="mb-0" style="font-size:0.85rem;color:var(--text-faint);">All caught up!</p>
                        </div>
                    @endforelse
                </div>
                @if($unreadNotifications->count() > 0)
                    <div class="p-3 text-center border-top" style="background:#fafbff;">
                        <a href="#" style="font-size:0.82rem;font-weight:600;color:var(--primary);text-decoration:none;">
                            View all notifications →
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Divider --}}
        <div style="width:1px;height:24px;background:#e2e8f0;"></div>

        {{-- Profile Dropdown --}}
        <div class="dropdown">
            <button class="btn p-0 d-flex align-items-center gap-2"
                    style="background:transparent;border:none;border-radius:10px;padding:4px 8px!important;transition:background 0.2s;"
                    data-bs-toggle="dropdown" aria-expanded="false"
                    onmouseover="this.style.background='var(--surface)'" onmouseout="this.style.background='transparent'">
                <img src="{{ $userPhoto }}" alt="{{ $user->name }}"
                     onerror="this.src='{{ asset('assets/images/profile.webp') }}'"
                     style="width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid #e0e7ff;">
                <div class="d-none d-md-block text-start">
                    <div style="font-size:0.82rem;font-weight:700;color:var(--navy);line-height:1.1;">{{ $user->name }}</div>
                    <div style="font-size:10px;font-weight:700;color:var(--text-faint);text-transform:uppercase;letter-spacing:0.05em;">
                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                    </div>
                </div>
                <i data-feather="chevron-down" style="width:14px;height:14px;color:var(--text-faint);"></i>
            </button>

            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-0"
                 style="width:240px;border-radius:16px;overflow:hidden;margin-top:8px;">

                {{-- Profile Header --}}
                <div class="p-4 text-center border-bottom" style="background:linear-gradient(135deg,#f8f7ff,#eef2ff);">
                    <img src="{{ $userPhoto }}" alt="{{ $user->name }}"
                         onerror="this.src='{{ asset('assets/images/profile.webp') }}'"
                         style="width:60px;height:60px;border-radius:50%;object-fit:cover;border:3px solid #fff;box-shadow:0 4px 12px rgba(79,70,229,0.2);margin-bottom:10px;">
                    <div style="font-weight:700;color:var(--navy);font-size:0.95rem;">{{ $user->name }}</div>
                    <div style="font-size:0.75rem;color:var(--text-faint);">{{ $user->email }}</div>
                </div>

                {{-- Menu Items --}}
                <div class="p-2">
                    <a href="{{ route('profile') }}"
                       class="d-flex align-items-center gap-3 px-3 py-2 text-decoration-none rounded-3"
                       style="color:var(--text-muted);font-size:0.875rem;font-weight:500;transition:background 0.15s;"
                       onmouseover="this.style.background='var(--surface)'" onmouseout="this.style.background='transparent'">
                        <i data-feather="user" style="width:16px;height:16px;color:var(--primary);"></i>
                        My Profile
                    </a>

                    @if($user->role === 'super_admin')
                    <a href="{{ route('settings.edit') }}"
                       class="d-flex align-items-center gap-3 px-3 py-2 text-decoration-none rounded-3"
                       style="color:var(--text-muted);font-size:0.875rem;font-weight:500;transition:background 0.15s;"
                       onmouseover="this.style.background='var(--surface)'" onmouseout="this.style.background='transparent'">
                        <i data-feather="settings" style="width:16px;height:16px;color:var(--primary);"></i>
                        Settings
                    </a>
                    @endif
                </div>

                <div class="p-2 border-top">
                    <a href="javascript:;" onclick="document.getElementById('logout-form').submit();"
                       class="d-flex align-items-center gap-3 px-3 py-2 text-decoration-none rounded-3"
                       style="color:#ef4444;font-size:0.875rem;font-weight:500;transition:background 0.15s;"
                       onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='transparent'">
                        <i data-feather="log-out" style="width:16px;height:16px;"></i>
                        Log Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>

            </div>
        </div>

    </div>
</nav>