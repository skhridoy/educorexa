@php
    $user = auth()->user();
    $folder = ($user && $user->role === 'super_admin') ? 'super_admin' : 'employees';
    $userPhoto = ($user && $user->photo)
                 ? asset('uploads/' . $folder . '/' . $user->photo)
                 : asset('assets/images/profile.webp');

    try {
        // ১. ডাটাবেজ নোটিফিকেশন
        $unreadNotifications = ($user && method_exists($user, 'unreadNotifications')) ? $user->unreadNotifications : collect();
        $unreadCount = $unreadNotifications ? $unreadNotifications->count() : 0;

        // ২. লাইভ পেমেন্ট সংক্রান্ত তথ্য (Payments)
        $recentPayments = \App\Models\SchoolSubscription::with(['school', 'package'])
            ->whereNotNull('payment_submitted_at')
            ->orWhere('status', 'pending')
            ->latest('updated_at')
            ->take(6)
            ->get();
        $pendingPaymentCount = $recentPayments->where('status', 'pending')->count();

        // ৩. নতুন স্কুল রেজিস্ট্রেশন (Schools)
        $recentSchools = \App\Models\School::with('representative.user')
            ->latest('created_at')
            ->take(6)
            ->get();

        // ৪. নতুন এমপ্লয়ি ও রিপ্রেজেন্টেটিভ এক্টিভিটি (Employees)
        $recentEmployees = \App\Models\Employee::with('user')
            ->latest('created_at')
            ->take(6)
            ->get();

        // ৫. কন্টাক্ট মেসেজ লিড (Contact Inquiries)
        $unreadInquiries = \App\Models\MainContactMsg::where('is_read', false)->latest()->take(4)->get();
    } catch (\Throwable $e) {
        $unreadNotifications = collect();
        $unreadCount = 0;
        $recentPayments = collect();
        $pendingPaymentCount = 0;
        $recentSchools = collect();
        $recentEmployees = collect();
        $unreadInquiries = collect();
    }

    // নোটিস কাউন্ট (শুধুমাত্র অপঠিত নোটিফিকেশন যা ভিউ/রিড করলে মাইনাস হবে)
    $totalNoticeBadge = $unreadCount;
@endphp

<style>
    .notice-trigger-btn:hover, .notice-trigger-btn[aria-expanded="true"] {
        background: #eef2ff !important;
        color: #4f46e5 !important;
        border-color: #c7d2fe !important;
    }
    .notice-pulse-badge {
        top: -3px;
        right: -3px;
        background: #ef4444;
        color: #fff;
        font-size: 10px;
        font-weight: 800;
        min-width: 18px;
        height: 18px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 4px;
        border: 2px solid #fff;
        box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
        animation: noticePulse 2s infinite;
    }
    @keyframes noticePulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    .notice-tabs-bar {
        scrollbar-width: none;
    }
    .notice-tabs-bar::-webkit-scrollbar { display: none; }
    .notice-tab-btn {
        border: none;
        background: transparent;
        color: #64748b;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 7px 12px;
        border-radius: 8px 8px 0 0;
        position: relative;
        white-space: nowrap;
        transition: all 0.15s;
    }
    .notice-tab-btn.active {
        background: #fff;
        color: #4f46e5;
        font-weight: 700;
        box-shadow: 0 -2px 6px rgba(0,0,0,0.03);
    }
    .notice-tab-dot {
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #ef4444;
        margin-left: 4px;
    }
    .notice-item {
        padding: 12px 16px;
        border-bottom: 1px solid #f8fafc;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        text-decoration: none !important;
        transition: background 0.15s ease;
    }
    .notice-item:hover {
        background: #f8fafc;
    }
    .notice-item:last-child {
        border-bottom: none;
    }
    .notice-item-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
    .notice-item-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2px;
        line-height: 1.3;
    }
    .notice-item-sub {
        font-size: 0.75rem;
        color: #64748b;
        margin-bottom: 3px;
        line-height: 1.3;
    }
    .notice-item-time {
        font-size: 0.7rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    @media (max-width: 576px) {
        .edu-notice-menu {
            position: fixed !important;
            top: 62px !important;
            left: 50% !important;
            right: auto !important;
            transform: translateX(-50%) !important;
            width: 95vw !important;
            max-width: 95vw !important;
        }
    }
</style>

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

        {{-- Notifications Dropdown --}}
        <div class="dropdown edu-notice-dropdown">
            <button class="btn p-0 position-relative d-flex align-items-center justify-content-center notice-trigger-btn"
                    style="width:38px;height:38px;border-radius:10px;background:#f8fafc;border:1px solid #e2e8f0;color:var(--text-muted);transition:all 0.2s;"
                    data-bs-toggle="dropdown" aria-expanded="false" title="নোটিশ ও এক্টিভিটি">
                <i data-feather="bell" style="width:19px;height:19px;"></i>
                @if($totalNoticeBadge > 0)
                    <span class="position-absolute notice-pulse-badge" id="noticeBadgeCounter">
                        {{ $totalNoticeBadge > 9 ? '9+' : $totalNoticeBadge }}
                    </span>
                @endif
            </button>

            <div class="dropdown-menu dropdown-menu-end shadow-xl border-0 p-0 edu-notice-menu"
                 style="width: min(94vw, 420px); border-radius: 20px; overflow: hidden; margin-top: 10px; z-index: 1060; border: 1px solid #e2e8f0 !important;">
                
                {{-- Header --}}
                <div class="p-3 px-4 border-bottom bg-white d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:34px; height:34px; border-radius:10px; background:#eef2ff; color:#4f46e5; display:flex; align-items:center; justify-content:center;">
                            <i class="fa-solid fa-bell" style="font-size:0.95rem;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold" style="font-size:0.95rem; font-family:'Outfit',sans-serif; color:var(--navy);">নোটিশ ও আপডেট</h6>
                            <small class="text-muted" style="font-size:0.72rem;">রিয়েল-টাইম সিস্টেম ফিড</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" id="markAllNoticeReadBtn" class="btn btn-sm btn-light border py-1 px-2 text-muted" style="font-size:0.75rem; border-radius:8px;" title="সব নোটিফিকেশন পড়া হয়েছে চিহ্নিত করুন">
                            <i class="fa-solid fa-check-double text-primary me-1"></i>Mark Read
                        </button>
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="notice-tabs-bar px-3 pt-2 bg-light border-bottom d-flex gap-1">
                    <button type="button" class="notice-tab-btn active" data-tab="all">
                        সবগুলো
                    </button>
                    <button type="button" class="notice-tab-btn" data-tab="payments">
                        💳 পেমেন্ট @if($pendingPaymentCount > 0)<span class="badge rounded-pill bg-warning text-dark ms-1" style="font-size:0.65rem; padding: 2px 6px;">{{ $pendingPaymentCount }}</span>@endif
                    </button>
                    <button type="button" class="notice-tab-btn" data-tab="schools">
                        🏫 নতুন স্কুল
                    </button>
                    <button type="button" class="notice-tab-btn" data-tab="employees">
                        👥 এমপ্লয়ি
                    </button>
                </div>

                {{-- Tab Body --}}
                <div class="notice-scroll-body" style="max-height: 380px; overflow-y: auto; background:#fff;">

                    {{-- TAB 1: ALL NOTICES --}}
                    <div class="notice-tab-pane" id="notice-pane-all">
                        {{-- Database unread notifications first --}}
                        @foreach($unreadNotifications->take(6) as $notification)
                        <a href="{{ route('super.notifications.readAndGo', $notification->id) }}" class="notice-item notice-unread-item" style="background:#f8faff; border-left:3px solid #4f46e5;">
                            <div class="notice-item-icon" style="background:#eef2ff; color:#4f46e5;">
                                <i class="fa-solid fa-{{ $notification->data['icon'] ?? 'bell' }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between gap-1">
                                    <div class="notice-item-title fw-bold" style="color:#1e1b4b;">{{ $notification->data['message'] ?? 'নতুন নোটিফিকেশন' }}</div>
                                    <span class="badge" style="font-size:0.62rem; background:#e0e7ff; color:#4338ca; border-radius:6px; padding:2px 6px;">নতুন</span>
                                </div>
                                <div class="notice-item-time" style="color:#6366f1;">
                                    <i class="fa-regular fa-clock" style="font-size:0.65rem;"></i> {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                        @endforeach

                        {{-- Recent Payments in All Tab --}}
                        @foreach($recentPayments->take(2) as $pay)
                        <a href="{{ route('super.subscription-payments.index') }}" class="notice-item">
                            <div class="notice-item-icon" style="background:{{ $pay->status === 'pending' ? '#fef3c7' : '#dcfce7' }}; color:{{ $pay->status === 'pending' ? '#d97706' : '#16a34a' }};">
                                <i class="fa-solid fa-credit-card"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between gap-1">
                                    <div class="notice-item-title">{{ $pay->school->name ?? 'স্কুল সাবস্ক্রিপশন' }}</div>
                                    <span class="badge {{ $pay->status === 'pending' ? 'bg-warning text-dark' : 'bg-success' }}" style="font-size:0.65rem;">
                                        {{ ucfirst($pay->status) }}
                                    </span>
                                </div>
                                <div class="notice-item-sub">
                                    ৳ {{ number_format($pay->amount) }} via {{ strtoupper($pay->payment_method ?? 'bKash/Nagad') }} ({{ $pay->payment_reference ?? 'N/A' }})
                                </div>
                                <div class="notice-item-time">
                                    <i class="fa-regular fa-clock" style="font-size:0.65rem;"></i> {{ ($pay->payment_submitted_at ?? $pay->updated_at)->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                        @endforeach

                        {{-- Recent Schools in All Tab --}}
                        @foreach($recentSchools->take(2) as $sch)
                        <a href="{{ route('manage.schools.all') }}" class="notice-item">
                            <div class="notice-item-icon" style="background:#e0f2fe; color:#0284c7;">
                                <i class="fa-solid fa-school"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="notice-item-title">{{ $sch->name }}</div>
                                <div class="notice-item-sub">
                                    @if($sch->representative?->user)
                                        রিপ্রেজেন্টেটিভ: {{ $sch->representative->user->name }}
                                    @else
                                        সরাসরি ওয়েবসাইট থেকে রেজিস্টার হয়েছে
                                    @endif
                                </div>
                                <div class="notice-item-time">
                                    <i class="fa-regular fa-clock" style="font-size:0.65rem;"></i> {{ $sch->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                        @endforeach

                        {{-- Recent Employees in All Tab --}}
                        @foreach($recentEmployees->take(2) as $emp)
                        <a href="{{ route('super.employees.index') }}" class="notice-item">
                            <div class="notice-item-icon" style="background:#f3e8ff; color:#9333ea;">
                                <i class="fa-solid fa-user-plus"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="notice-item-title">{{ $emp->user->name ?? 'কর্মচারী' }}</div>
                                <div class="notice-item-sub">
                                    {{ $emp->designation ?? 'Staff' }} · ID: {{ $emp->employee_id }}
                                </div>
                                <div class="notice-item-time">
                                    <i class="fa-regular fa-clock" style="font-size:0.65rem;"></i> {{ $emp->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    {{-- TAB 2: PAYMENTS ONLY --}}
                    <div class="notice-tab-pane d-none" id="notice-pane-payments">
                        @forelse($recentPayments as $pay)
                        <a href="{{ route('super.subscription-payments.index') }}" class="notice-item">
                            <div class="notice-item-icon" style="background:{{ $pay->status === 'pending' ? '#fef3c7' : '#dcfce7' }}; color:{{ $pay->status === 'pending' ? '#d97706' : '#16a34a' }};">
                                <i class="fa-solid fa-money-bill-transfer"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between gap-1">
                                    <div class="notice-item-title">{{ $pay->school->name ?? 'স্কুল সাবস্ক্রিপশন' }}</div>
                                    <span class="badge {{ $pay->status === 'pending' ? 'bg-warning text-dark' : 'bg-success' }}" style="font-size:0.65rem;">
                                        {{ ucfirst($pay->status) }}
                                    </span>
                                </div>
                                <div class="notice-item-sub">
                                    অ্যামাউন্ট: <strong>৳ {{ number_format($pay->amount) }}</strong> · {{ strtoupper($pay->payment_method ?? 'MFS') }}
                                    @if($pay->sender_number)
                                        <br><small class="text-muted">নম্বর: {{ $pay->sender_number }} · Trx: {{ $pay->payment_reference }}</small>
                                    @endif
                                </div>
                                <div class="notice-item-time">
                                    <i class="fa-regular fa-clock" style="font-size:0.65rem;"></i> {{ ($pay->payment_submitted_at ?? $pay->updated_at)->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="p-4 text-center text-muted small">
                            <i class="fa-solid fa-receipt fa-2x mb-2 text-slate-300 d-block"></i>
                            কোনো নতুন পেমেন্ট রেকর্ড পাওয়া যায়নি
                        </div>
                        @endforelse
                    </div>

                    {{-- TAB 3: SCHOOLS ONLY --}}
                    <div class="notice-tab-pane d-none" id="notice-pane-schools">
                        @forelse($recentSchools as $sch)
                        <a href="{{ route('manage.schools.all') }}" class="notice-item">
                            <div class="notice-item-icon" style="background:#e0f2fe; color:#0284c7;">
                                <i class="fa-solid fa-school"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="notice-item-title">{{ $sch->name }}</div>
                                <div class="notice-item-sub">
                                    @if($sch->representative?->user)
                                        <span class="badge bg-indigo-subtle text-indigo me-1" style="font-size:0.68rem;">Rep</span> 
                                        {{ $sch->representative->user->name }}
                                    @else
                                        ওয়েবসাইট থেকে স্বয়ংক্রিয় আবেদন
                                    @endif
                                    · {{ $sch->email }}
                                </div>
                                <div class="notice-item-time">
                                    <i class="fa-regular fa-clock" style="font-size:0.65rem;"></i> {{ $sch->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="p-4 text-center text-muted small">
                            <i class="fa-solid fa-school fa-2x mb-2 text-slate-300 d-block"></i>
                            কোনো নতুন স্কুল রেকর্ড পাওয়া যায়নি
                        </div>
                        @endforelse
                    </div>

                    {{-- TAB 4: EMPLOYEES & REPRESENTATIVES --}}
                    <div class="notice-tab-pane d-none" id="notice-pane-employees">
                        @forelse($recentEmployees as $emp)
                        <a href="{{ route('super.employees.index') }}" class="notice-item">
                            <div class="notice-item-icon" style="background:#f3e8ff; color:#9333ea;">
                                <i class="fa-solid fa-id-badge"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between gap-1">
                                    <div class="notice-item-title">{{ $emp->user->name ?? 'কর্মচারী' }}</div>
                                    <span class="badge bg-light text-dark border" style="font-size:0.65rem;">
                                        {{ $emp->status ?? 'Active' }}
                                    </span>
                                </div>
                                <div class="notice-item-sub">
                                    পদবী: <strong>{{ $emp->designation ?? 'Staff' }}</strong> · ID: {{ $emp->employee_id }}
                                    @if($emp->phone_personal)
                                        <br><small class="text-muted"><i class="fa-solid fa-phone me-1" style="font-size:0.65rem;"></i>{{ $emp->phone_personal }}</small>
                                    @endif
                                </div>
                                <div class="notice-item-time">
                                    <i class="fa-regular fa-clock" style="font-size:0.65rem;"></i> যুক্ত হয়েছেন {{ $emp->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="p-4 text-center text-muted small">
                            <i class="fa-solid fa-users-slash fa-2x mb-2 text-slate-300 d-block"></i>
                            কোনো নতুন কর্মচারী রেকর্ড পাওয়া যায়নি
                        </div>
                        @endforelse
                    </div>

                </div>

                {{-- Footer Links --}}
                <div class="p-2 px-3 bg-light border-top text-center d-flex justify-content-between align-items-center">
                    <a href="{{ route('super.subscription-payments.index') }}" class="small fw-bold text-primary text-decoration-none" style="font-size:0.75rem;">
                        <i class="fa-solid fa-credit-card me-1"></i>পেমেন্ট তালিকা
                    </a>
                    <a href="{{ route('manage.schools.all') }}" class="small fw-bold text-secondary text-decoration-none" style="font-size:0.75rem;">
                        <i class="fa-solid fa-school me-1"></i>সকল স্কুল
                    </a>
                    <a href="{{ route('super.employees.index') }}" class="small fw-bold text-dark text-decoration-none" style="font-size:0.75rem;">
                        <i class="fa-solid fa-users me-1"></i>এমপ্লয়ি
                    </a>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Tab Switching
                document.querySelectorAll('.notice-tab-btn').forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        document.querySelectorAll('.notice-tab-btn').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                        const targetTab = this.getAttribute('data-tab');

                        document.querySelectorAll('.notice-tab-pane').forEach(p => p.classList.add('d-none'));
                        const targetPane = document.getElementById('notice-pane-' + targetTab);
                        if (targetPane) targetPane.classList.remove('d-none');
                    });
                });

                // Mark all notifications read
                const markBtn = document.getElementById('markAllNoticeReadBtn');
                if (markBtn) {
                    markBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        fetch('{{ route('super.notifications.markRead') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        }).then(r => r.json()).then(data => {
                            const badge = document.getElementById('noticeBadgeCounter');
                            if (badge) badge.style.display = 'none';
                            document.querySelectorAll('.notice-unread-item').forEach(function(el) {
                                el.style.background = '#fff';
                                el.style.borderLeft = 'none';
                                const newBadge = el.querySelector('.badge');
                                if (newBadge) newBadge.remove();
                            });
                            markBtn.innerHTML = '<i class="fa-solid fa-check text-success me-1"></i>Done';
                            markBtn.disabled = true;
                        }).catch(err => console.log(err));
                    });
                }

                // Client-side instant decrement on unread notice click
                document.querySelectorAll('.notice-unread-item').forEach(function(item) {
                    item.addEventListener('click', function() {
                        const badge = document.getElementById('noticeBadgeCounter');
                        if (badge) {
                            let current = parseInt(badge.textContent.trim()) || 1;
                            current = Math.max(0, current - 1);
                            if (current === 0) {
                                badge.style.display = 'none';
                            } else {
                                badge.textContent = current > 9 ? '9+' : current;
                            }
                        }
                    });
                });
            });
        </script>

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