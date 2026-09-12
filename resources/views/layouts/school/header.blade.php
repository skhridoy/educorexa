{{-- ফটো এবং নোটিফিকেশন লজিক শুরু --}}
@php
    $user = auth()->user();
    $unreadNotifications = auth()->check() ? $user->unreadNotifications : collect();
    $school = $currentSchool ?? $user?->school;
    $tenant = $school?->slug ?? $user?->school?->slug ?? request()->route('tenant') ?? '';
    $schoolId = $school?->id ?? $user?->school_id;

    try {
        $unreadCount = $unreadNotifications ? $unreadNotifications->count() : 0;

        // ১. সাম্প্রতিক ফি পেমেন্ট (Recent Fee Collections)
        $recentFees = $schoolId ? \App\Models\StudentFee::with(['student', 'feeHead'])
            ->where('school_id', $schoolId)
            ->where('status', 'paid')
            ->latest('updated_at')
            ->take(6)
            ->get() : collect();

        // ২. সাম্প্রতিক স্কুল নোটিশ (School Notices)
        $recentSchoolNotices = $schoolId ? \App\Models\Notice::where('school_id', $schoolId)
            ->latest('created_at')
            ->take(6)
            ->get() : collect();

        // ৩. নতুন অনলাইন ভর্তি আবেদন (Admissions)
        $recentAdmissions = $schoolId ? \App\Models\Admission::with('class')
            ->where('school_id', $schoolId)
            ->latest('created_at')
            ->take(6)
            ->get() : collect();
        $pendingAdmissionCount = $schoolId ? \App\Models\Admission::where('school_id', $schoolId)->where('status', 'pending')->count() : 0;
    } catch (\Throwable $e) {
        $unreadCount = 0;
        $recentFees = collect();
        $recentSchoolNotices = collect();
        $recentAdmissions = collect();
        $pendingAdmissionCount = 0;
    }

    $totalNoticeBadge = $unreadCount;
    
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
        animation: schoolNoticePulse 2s infinite;
    }
    @keyframes schoolNoticePulse {
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
        .edu-school-notice-menu {
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

        {{-- Notifications Dropdown --}}
        <div class="dropdown edu-notice-dropdown">
            <button class="btn p-0 position-relative d-flex align-items-center justify-content-center notice-trigger-btn"
                    style="width:38px;height:38px;border-radius:10px;background:#f8fafc;border:1px solid #e2e8f0;color:#64748b;transition:all 0.2s;"
                    data-bs-toggle="dropdown" aria-expanded="false" title="{{ __('Notifications') }}">
                <i data-feather="bell" style="width:19px;height:19px;"></i>
                @if($totalNoticeBadge > 0)
                    <span class="position-absolute notice-pulse-badge" id="schoolNoticeBadgeCounter">
                        {{ $totalNoticeBadge > 9 ? '9+' : $totalNoticeBadge }}
                    </span>
                @endif
            </button>

            <div class="dropdown-menu dropdown-menu-end shadow-xl border-0 p-0 edu-school-notice-menu"
                 style="width: min(94vw, 420px); border-radius: 20px; overflow: hidden; margin-top: 10px; z-index: 1060; border: 1px solid #e2e8f0 !important;">
                
                {{-- Header --}}
                <div class="p-3 px-4 border-bottom bg-white d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:34px; height:34px; border-radius:10px; background:#eef2ff; color:#4f46e5; display:flex; align-items:center; justify-content:center;">
                            <i class="fa-solid fa-bell" style="font-size:0.95rem;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold" style="font-size:0.95rem; font-family:'Outfit',sans-serif; color:#1e293b;">{{ __('নোটিশ ও আপডেট') }}</h6>
                            <small class="text-muted" style="font-size:0.72rem;">{{ __('রিয়েল-টাইম স্কুল সিস্টেম ফিড') }}</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" id="markSchoolAllNoticeReadBtn" class="btn btn-sm btn-light border py-1 px-2 text-muted" style="font-size:0.75rem; border-radius:8px;" title="সব নোটিফিকেশন পড়া হয়েছে চিহ্নিত করুন">
                            <i class="fa-solid fa-check-double text-primary me-1"></i>Mark Read
                        </button>
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="notice-tabs-bar px-3 pt-2 bg-light border-bottom d-flex gap-1">
                    <button type="button" class="notice-tab-btn active" data-tab="school-all">
                        {{ __('সবগুলো') }}
                    </button>
                    <button type="button" class="notice-tab-btn" data-tab="school-fees">
                        💳 {{ __('ফি ও পেমেন্ট') }}
                    </button>
                    <button type="button" class="notice-tab-btn" data-tab="school-notices">
                        📢 {{ __('নোটিশ') }}
                    </button>
                    <button type="button" class="notice-tab-btn" data-tab="school-admissions">
                        🎓 {{ __('ভর্তি') }} @if($pendingAdmissionCount > 0)<span class="badge rounded-pill bg-warning text-dark ms-1" style="font-size:0.62rem; padding: 2px 5px;">{{ $pendingAdmissionCount }}</span>@endif
                    </button>
                </div>

                {{-- Tab Body --}}
                <div class="notice-scroll-body" style="max-height: 380px; overflow-y: auto; background:#fff;">

                    {{-- TAB 1: ALL NOTICES --}}
                    <div class="notice-tab-pane" id="notice-pane-school-all">
                        {{-- Database unread notifications first --}}
                        @foreach($unreadNotifications->take(6) as $notification)
                        @php
                            $notifGoUrl = ($tenant && \Illuminate\Support\Facades\Route::has('school.notifications.readAndGo'))
                                ? route('school.notifications.readAndGo', ['tenant' => $tenant, 'id' => $notification->id])
                                : ($notification->data['link'] ?? '#');
                        @endphp
                        <a href="{{ $notifGoUrl }}" class="notice-item notice-unread-item" style="background:#f8faff; border-left:3px solid #4f46e5;">
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

                        {{-- Recent Fees in All Tab --}}
                        @foreach($recentFees->take(2) as $fee)
                        @php
                            $feeUrl = ($tenant && \Illuminate\Support\Facades\Route::has('student-fees.index')) ? route('student-fees.index', ['tenant' => $tenant]) : '#';
                        @endphp
                        <a href="{{ $feeUrl }}" class="notice-item">
                            <div class="notice-item-icon" style="background:#dcfce7; color:#16a34a;">
                                <i class="fa-solid fa-receipt"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between gap-1">
                                    <div class="notice-item-title">{{ $fee->student->name ?? 'শিক্ষার্থীর ফি' }}</div>
                                    <span class="badge bg-success" style="font-size:0.65rem;">Paid</span>
                                </div>
                                <div class="notice-item-sub">
                                    ৳ {{ number_format($fee->amount) }} · {{ $fee->feeHead->name ?? 'ফি' }} ({{ $fee->month }})
                                </div>
                                <div class="notice-item-time">
                                    <i class="fa-regular fa-clock" style="font-size:0.65rem;"></i> {{ $fee->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                        @endforeach

                        {{-- Recent School Notices in All Tab --}}
                        @foreach($recentSchoolNotices->take(2) as $sNotice)
                        @php
                            $noticeUrl = ($tenant && \Illuminate\Support\Facades\Route::has('notices.index')) ? route('notices.index', ['tenant' => $tenant]) : '#';
                        @endphp
                        <a href="{{ $noticeUrl }}" class="notice-item">
                            <div class="notice-item-icon" style="background:#e0f2fe; color:#0284c7;">
                                <i class="fa-solid fa-bullhorn"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="notice-item-title">{{ $sNotice->title }}</div>
                                <div class="notice-item-sub">
                                    {{ Str::limit(strip_tags($sNotice->description), 45) }}
                                </div>
                                <div class="notice-item-time">
                                    <i class="fa-regular fa-clock" style="font-size:0.65rem;"></i> {{ $sNotice->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                        @endforeach

                        {{-- Recent Admissions in All Tab --}}
                        @foreach($recentAdmissions->take(2) as $adm)
                        @php
                            $admUrl = ($tenant && \Illuminate\Support\Facades\Route::has('admissions.index')) ? route('admissions.index', ['tenant' => $tenant]) : '#';
                        @endphp
                        <a href="{{ $admUrl }}" class="notice-item">
                            <div class="notice-item-icon" style="background:#fef3c7; color:#d97706;">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between gap-1">
                                    <div class="notice-item-title">{{ $adm->name }}</div>
                                    <span class="badge {{ $adm->status === 'pending' ? 'bg-warning text-dark' : 'bg-success' }}" style="font-size:0.65rem;">
                                        {{ ucfirst($adm->status) }}
                                    </span>
                                </div>
                                <div class="notice-item-sub">
                                    শ্রেণী: {{ $adm->class->name ?? 'N/A' }} · মোবাইল: {{ $adm->contact_number }}
                                </div>
                                <div class="notice-item-time">
                                    <i class="fa-regular fa-clock" style="font-size:0.65rem;"></i> {{ $adm->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                        @endforeach

                        @if($unreadNotifications->isEmpty() && $recentFees->isEmpty() && $recentSchoolNotices->isEmpty() && $recentAdmissions->isEmpty())
                        <div class="p-4 text-center text-muted small">
                            <i class="fa-regular fa-bell-slash fa-2x mb-2 text-slate-300 d-block"></i>
                            কোনো নোটিশ পাওয়া যায়নি
                        </div>
                        @endif
                    </div>

                    {{-- TAB 2: FEES --}}
                    <div class="notice-tab-pane d-none" id="notice-pane-school-fees">
                        @forelse($recentFees as $fee)
                        @php
                            $feeUrl = ($tenant && \Illuminate\Support\Facades\Route::has('student-fees.index')) ? route('student-fees.index', ['tenant' => $tenant]) : '#';
                        @endphp
                        <a href="{{ $feeUrl }}" class="notice-item">
                            <div class="notice-item-icon" style="background:#dcfce7; color:#16a34a;">
                                <i class="fa-solid fa-money-check-dollar"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between gap-1">
                                    <div class="notice-item-title">{{ $fee->student->name ?? 'শিক্ষার্থী' }}</div>
                                    <span class="badge bg-success" style="font-size:0.65rem;">Paid</span>
                                </div>
                                <div class="notice-item-sub">
                                    সংগৃহীত: <strong>৳ {{ number_format($fee->amount) }}</strong> · {{ $fee->feeHead->name ?? 'Fee' }}
                                    <br><small class="text-muted">মাস: {{ $fee->month }}</small>
                                </div>
                                <div class="notice-item-time">
                                    <i class="fa-regular fa-clock" style="font-size:0.65rem;"></i> {{ $fee->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="p-4 text-center text-muted small">
                            <i class="fa-solid fa-receipt fa-2x mb-2 text-slate-300 d-block"></i>
                            কোনো নতুন ফি কালেকশন রেকর্ড নেই
                        </div>
                        @endforelse
                    </div>

                    {{-- TAB 3: NOTICES --}}
                    <div class="notice-tab-pane d-none" id="notice-pane-school-notices">
                        @forelse($recentSchoolNotices as $sNotice)
                        @php
                            $noticeUrl = ($tenant && \Illuminate\Support\Facades\Route::has('notices.index')) ? route('notices.index', ['tenant' => $tenant]) : '#';
                        @endphp
                        <a href="{{ $noticeUrl }}" class="notice-item">
                            <div class="notice-item-icon" style="background:#e0f2fe; color:#0284c7;">
                                <i class="fa-solid fa-bullhorn"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="notice-item-title">{{ $sNotice->title }}</div>
                                <div class="notice-item-sub">
                                    {{ Str::limit(strip_tags($sNotice->description), 60) }}
                                </div>
                                <div class="notice-item-time">
                                    <i class="fa-regular fa-clock" style="font-size:0.65rem;"></i> {{ $sNotice->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="p-4 text-center text-muted small">
                            <i class="fa-solid fa-newspaper fa-2x mb-2 text-slate-300 d-block"></i>
                            কোনো প্রকাশিত নোটিশ নেই
                        </div>
                        @endforelse
                    </div>

                    {{-- TAB 4: ADMISSIONS --}}
                    <div class="notice-tab-pane d-none" id="notice-pane-school-admissions">
                        @forelse($recentAdmissions as $adm)
                        @php
                            $admUrl = ($tenant && \Illuminate\Support\Facades\Route::has('admissions.index')) ? route('admissions.index', ['tenant' => $tenant]) : '#';
                        @endphp
                        <a href="{{ $admUrl }}" class="notice-item">
                            <div class="notice-item-icon" style="background:#fef3c7; color:#d97706;">
                                <i class="fa-solid fa-user-graduate"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between gap-1">
                                    <div class="notice-item-title">{{ $adm->name }}</div>
                                    <span class="badge {{ $adm->status === 'pending' ? 'bg-warning text-dark' : 'bg-success' }}" style="font-size:0.65rem;">
                                        {{ ucfirst($adm->status) }}
                                    </span>
                                </div>
                                <div class="notice-item-sub">
                                    শ্রেণী: <strong>{{ $adm->class->name ?? 'N/A' }}</strong> · আবেদন নং: {{ $adm->admission_number }}
                                    <br><small class="text-muted"><i class="fa-solid fa-phone me-1" style="font-size:0.65rem;"></i>{{ $adm->contact_number }}</small>
                                </div>
                                <div class="notice-item-time">
                                    <i class="fa-regular fa-clock" style="font-size:0.65rem;"></i> আবেদন: {{ $adm->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="p-4 text-center text-muted small">
                            <i class="fa-solid fa-user-graduate fa-2x mb-2 text-slate-300 d-block"></i>
                            কোনো নতুন ভর্তি আবেদন নেই
                        </div>
                        @endforelse
                    </div>

                </div>

                {{-- Footer Links --}}
                <div class="p-2 px-3 bg-light border-top text-center d-flex justify-content-between align-items-center">
                    @php
                        $feeListUrl = ($tenant && \Illuminate\Support\Facades\Route::has('student-fees.index')) ? route('student-fees.index', ['tenant' => $tenant]) : '#';
                        $noticeListUrl = ($tenant && \Illuminate\Support\Facades\Route::has('notices.index')) ? route('notices.index', ['tenant' => $tenant]) : '#';
                        $admListUrl = ($tenant && \Illuminate\Support\Facades\Route::has('admissions.index')) ? route('admissions.index', ['tenant' => $tenant]) : '#';
                    @endphp
                    <a href="{{ $feeListUrl }}" class="small fw-bold text-success text-decoration-none" style="font-size:0.75rem;">
                        <i class="fa-solid fa-receipt me-1"></i>ফি তালিকা
                    </a>
                    <a href="{{ $noticeListUrl }}" class="small fw-bold text-primary text-decoration-none" style="font-size:0.75rem;">
                        <i class="fa-solid fa-bullhorn me-1"></i>নোটিশ বোর্ড
                    </a>
                    <a href="{{ $admListUrl }}" class="small fw-bold text-secondary text-decoration-none" style="font-size:0.75rem;">
                        <i class="fa-solid fa-user-graduate me-1"></i>ভর্তি তালিকা
                    </a>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Tab Switching for School Header
                document.querySelectorAll('.edu-school-notice-menu .notice-tab-btn').forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        document.querySelectorAll('.edu-school-notice-menu .notice-tab-btn').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                        const targetTab = this.getAttribute('data-tab');

                        document.querySelectorAll('.edu-school-notice-menu .notice-tab-pane').forEach(p => p.classList.add('d-none'));
                        const targetPane = document.getElementById('notice-pane-' + targetTab);
                        if (targetPane) targetPane.classList.remove('d-none');
                    });
                });

                // Mark all notifications read
                const markBtn = document.getElementById('markSchoolAllNoticeReadBtn');
                if (markBtn) {
                    markBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const markUrl = '{{ ($tenant && \Illuminate\Support\Facades\Route::has('school.notifications.markRead')) ? route('school.notifications.markRead', ['tenant' => $tenant]) : '' }}';
                        if (!markUrl) return;

                        fetch(markUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        }).then(r => r.json()).then(data => {
                            const badge = document.getElementById('schoolNoticeBadgeCounter');
                            if (badge) badge.style.display = 'none';
                            document.querySelectorAll('.edu-school-notice-menu .notice-unread-item').forEach(function(el) {
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
                document.querySelectorAll('.edu-school-notice-menu .notice-unread-item').forEach(function(item) {
                    item.addEventListener('click', function() {
                        const badge = document.getElementById('schoolNoticeBadgeCounter');
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