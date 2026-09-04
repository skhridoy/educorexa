@php
    $user = auth()->user();
    $school = $currentSchool ?? $user?->school;
    $tenant = $school?->slug ?? $user?->school?->slug ?? request()->route('tenant') ?? ''; 
    $userPermissions = $user ? $user->getAllPermissions()->pluck('name')->toArray() : [];
    
    // স্কুলের প্যাকেজে যে পারমিশনগুলো কেনা আছে
    $packagePermissions = optional($school?->subscriptionPackage)->permissions ?? [];

    // ড্যাশবোর্ড রাউট নির্ধারণ
    if ($user?->role === 'student' || ($user && method_exists($user, 'hasRole') && $user->hasRole('student'))) {
        $dashboardRoute = route('student.dashboard', ['tenant' => $tenant]);
    } elseif ($user?->role === 'teacher' || ($user && method_exists($user, 'hasRole') && $user->hasRole('teacher'))) {
        $dashboardRoute = route('teacher.dashboard', ['tenant' => $tenant]);
    } elseif ($user?->role === 'super_admin' || ($user && method_exists($user, 'hasRole') && $user->hasRole('super_admin'))) {
        $dashboardRoute = route('super.dashboard');
    } else {
        $dashboardRoute = route('school.dashboard', ['tenant' => $tenant]);
    }

    /**
     * ডাইনামিক পারমিশন চেক হেল্পার
     * এটি চেক করে যে ইউজারের পারমিশন আছে কি না এবং সেটি স্কুলের প্যাকেজে অন্তর্ভুক্ত কি না।
     */
    $hasFeature = function($permission) use ($user, $userPermissions, $packagePermissions) {
        if (!$user) return false;
        if ($user->hasRole('super_admin') || $user->role === 'super_admin') return true;
        
        // ১. চেক: স্কুলের প্যাকেজে এই পারমিশন আছে কি না (যদি প্যাকেজ না থাকে, তাহলে ফুল এক্সেস)
        $inPackage = empty($packagePermissions) || in_array($permission, $packagePermissions);
        
        // ২. চেক: ইউজারের এই পারমিশন আছে কি না (স্কুল এডমিন হলে সব পাবে যা প্যাকেজে আছে)
        $hasPerm = in_array($permission, $userPermissions) || $user->hasRole('school_admin') || $user->role === 'school_admin';
        
        return $inPackage && $hasPerm;
    };

    /**
     * কোনো নির্দিষ্ট গ্রুপের অন্তত একটি ফিচার প্যাকেজে আছে কি না চেক করার জন্য
     */
    $hasGroupAccess = function($permissionsArray) use ($user, $packagePermissions, $userPermissions) {
        if (!$user) return false;
        if ($user->hasRole('super_admin') || $user->role === 'super_admin') return true;
        
        if (empty($packagePermissions)) {
            if ($user->hasRole('school_admin') || $user->role === 'school_admin') return true;
            return count(array_intersect($permissionsArray, $userPermissions)) > 0;
        }

        $packageIntersect = array_intersect($permissionsArray, $packagePermissions);
        if (count($packageIntersect) === 0) return false;

        if ($user->hasRole('school_admin') || $user->role === 'school_admin') return true;
        
        return count(array_intersect($packageIntersect, $userPermissions)) > 0;
    };
@endphp

<nav class="sidebar edu-sidebar">
    {{-- Header Section --}}
    <div class="edu-sidebar-header">
        <a href="{{ route('school.home', ['tenant' => $tenant]) }}" class="edu-brand">
            {{-- School Logo --}}
            @if($school->logo ?? null)
                <img src="{{ asset($school->logo) }}" alt="{{ $school->name }}" 
                     class="edu-brand-logo"
                     style="width:36px; height:36px; border-radius:10px; object-fit:cover; flex-shrink:0;">
            @else
                <div class="edu-brand-icon" style="background: linear-gradient(135deg, #4f46e5, #818cf8); color: white; width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:1rem; flex-shrink:0;">
                    {{ strtoupper(substr($school->name ?? 'E', 0, 1)) }}
                </div>
            @endif
            <div class="edu-brand-text" style="min-width:0; overflow:hidden;">
                <div class="edu-brand-name" style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $school->name ?? 'EduCorexa' }}</div>
                <div class="edu-brand-sub">School Portal</div>
            </div>
        </a>
        {{-- Mobile Close Button --}}
        <button id="sidebarCloseBtn" class="edu-mobile-close d-lg-none" 
                style="cursor:pointer; background:none; border:none; color:#94a3b8; padding: 6px; border-radius: 6px; transition: all 0.2s; margin-left: auto; flex-shrink:0;"
                aria-label="Close Sidebar">
            <i data-feather="x" style="width:22px;height:22px;"></i>
        </button>
    </div>

    <div class="edu-sidebar-body sidebar-body">
        <ul class="edu-nav">
            <li class="edu-nav-category">{{ __('Main') }}</li>
            <li class="edu-nav-item">
                <a href="{{ $dashboardRoute }}" class="edu-nav-link {{ Request::is('*/dashboard*') ? 'active' : '' }}">
                    <i data-feather="grid"></i> <span>{{ __('Dashboard') }}</span>
                </a>
            </li>

            @php
                $anyModule = $hasGroupAccess(['academic-year.manage', 'class.manage', 'section.manage', 'subject.manage', 'admission.manage', 'student.manage', 'teacher.manage', 'employee.manage', 'attendance.manage', 'exam.manage', 'fee.manage', 'notice.manage', 'category.manage', 'sub-category.manage']);
            @endphp

            @if($anyModule)
                <li class="edu-nav-category">{{ __('Modules') }}</li>
            @endif

            {{-- 1. Academic Section --}}
            @php
                $academicPerms = ['academic-year.manage', 'class.manage', 'section.manage', 'subject.manage', 'class.routine', 'syllabus.manage', 'category.manage', 'sub-category.manage'];
            @endphp
            @if($hasGroupAccess($academicPerms))
            <li class="edu-nav-item">
                <a class="edu-nav-link edu-has-submenu {{ Request::is('*/academic*') || Request::is('*/classes*') || Request::is('*/sections*') || Request::is('*/subjects*') || Request::is('*/routine*') || Request::is('*/categories*') || Request::is('*/sub-categories*') ? 'active' : '' }}" 
                   data-bs-toggle="collapse" href="#academicMenu">
                    <i data-feather="layers"></i> <span>{{ __('Academic') }}</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/academic*') || Request::is('*/classes*') || Request::is('*/sections*') || Request::is('*/subjects*') || Request::is('*/routine*') || Request::is('*/categories*') || Request::is('*/sub-categories*') ? 'show' : '' }}" id="academicMenu">
                    <ul class="edu-sub-nav">
                        @if($hasFeature('academic-year.manage'))
                            <li class="edu-sub-item"><a href="{{ route('academic-year.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/academic-year*') ? 'active' : '' }}">{{ __('Academic Years') }}</a></li>
                        @endif
                        @if($hasFeature('category.manage') || $hasFeature('class.manage'))
                            <li class="edu-sub-item"><a href="{{ route('categories.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/categories*') ? 'active' : '' }}">{{ __('Categories') }}</a></li>
                        @endif
                        @if($hasFeature('sub-category.manage') || $hasFeature('class.manage'))
                            <li class="edu-sub-item"><a href="{{ route('sub-categories.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/sub-categories*') ? 'active' : '' }}">{{ __('Sub Categories') }}</a></li>
                        @endif
                        @if($hasFeature('class.manage'))
                            <li class="edu-sub-item"><a href="{{ route('classes.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/classes*') ? 'active' : '' }}">{{ __('Classes') }}</a></li>
                        @endif
                        @if($hasFeature('section.manage'))
                            <li class="edu-sub-item"><a href="{{ route('sections.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/sections*') ? 'active' : '' }}">{{ __('Sections') }}</a></li>
                        @endif
                        @if($hasFeature('subject.manage'))
                            <li class="edu-sub-item"><a href="{{ route('subjects.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/subjects') ? 'active' : '' }}">{{ __('Subjects List') }}</a></li>
                            <li class="edu-sub-item"><a href="{{ route('subjects.assign', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/subjects-assign*') ? 'active' : '' }}">{{ __('Assign Subjects') }}</a></li>
                        @endif
                        @if($hasFeature('class.routine'))
                            <li class="edu-sub-item"><a href="{{ route('routine.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/routine*') ? 'active' : '' }}">{{ __('Class Routine') }}</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- 2. Students & Admissions --}}
            @php
                $studentPerms = ['admission.manage', 'student.manage', 'student.idcard', 'student.promotion'];
            @endphp
            @if($hasGroupAccess($studentPerms))
            <li class="edu-nav-item">
                <a class="edu-nav-link edu-has-submenu {{ Request::is('*/students*') || Request::is('*/admissions*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#studentMenu">
                    <i data-feather="users"></i> <span>{{ __('Students') }}</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/students*') || Request::is('*/admissions*') ? 'show' : '' }}" id="studentMenu">
                    <ul class="edu-sub-nav">
                        @if($hasFeature('admission.manage'))
                            <li class="edu-sub-item"><a href="{{ route('admissions.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/admissions*') ? 'active' : '' }}">{{ __('Admissions') }}</a></li>
                        @endif
                        @if($hasFeature('student.index') || $hasFeature('student.manage'))
                            <li class="edu-sub-item"><a href="{{ route('students.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/students') || Request::is('*/students/*') ? 'active' : '' }}">{{ __('Student List') }}</a></li>
                        @endif
                        @if($hasFeature('student.create'))
                            <li class="edu-sub-item"><a href="{{ route('students.create', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/students/create*') ? 'active' : '' }}">{{ __('Add Student') }}</a></li>
                        @endif
                        @if($hasFeature('student.idcard'))
                            <li class="edu-sub-item"><a href="{{ route('students.idcard.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/id-cards*') ? 'active' : '' }}">{{ __('ID Cards') }}</a></li>
                        @endif
                        @if($hasFeature('student.promotion'))
                            <li class="edu-sub-item"><a href="{{ route('students.promotion', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/promotion*') ? 'active' : '' }}">{{ __('Promotion') }}</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- 3. Staff & HR --}}
            @php
                $staffPerms = ['teacher.manage', 'employee.manage', 'attendance.manage', 'payroll.manage'];
            @endphp
            @if($hasGroupAccess($staffPerms))
            <li class="edu-nav-item">
                <a class="edu-nav-link edu-has-submenu {{ Request::is('*/teachers*') || Request::is('*/staff*') || Request::is('*/teacher-assign*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#staffMenu">
                    <i data-feather="user-check"></i> <span>{{ __('Staff & HR') }}</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/teachers*') || Request::is('*/staff*') || Request::is('*/teacher-assign*') ? 'show' : '' }}" id="staffMenu">
                    <ul class="edu-sub-nav">
                        @if($hasFeature('teacher.manage'))
                            <li class="edu-sub-item"><a href="{{ route('teachers.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/teachers') ? 'active' : '' }}">{{ __('Teachers List') }}</a></li>
                            <li class="edu-sub-item"><a href="{{ route('teachers.create', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/teachers/create*') ? 'active' : '' }}">{{ __('Add Teacher') }}</a></li>
                            <li class="edu-sub-item"><a href="{{ route('teacher.assign', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/teacher-assign*') ? 'active' : '' }}">{{ __('Assign Teachers') }}</a></li>
                        @endif
                        @if($hasFeature('employee.manage'))
                            <li class="edu-sub-item"><a href="{{ route('staff.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/staff') ? 'active' : '' }}">{{ __('Staff List') }}</a></li>
                            <li class="edu-sub-item"><a href="{{ route('staff.create', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/staff/create*') ? 'active' : '' }}">{{ __('Add Staff') }}</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- 4. Attendance & Exams --}}
            @php
                $examPerms = ['attendance.manage', 'exam.manage', 'mark.manage', 'holiday.manage'];
            @endphp
            @if($hasGroupAccess($examPerms))
            <li class="edu-nav-item">
                <a class="edu-nav-link edu-has-submenu {{ Request::is('*/attendance*') || Request::is('*/exam*') || Request::is('*/mark*') || Request::is('*/holiday*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#examMenu">
                    <i data-feather="edit-3"></i> <span>{{ __('Attendance & Exams') }}</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/attendance*') || Request::is('*/exam*') || Request::is('*/mark*') || Request::is('*/holiday*') ? 'show' : '' }}" id="examMenu">
                    <ul class="edu-sub-nav">
                        @if($hasFeature('attendance.manage'))
                            <li class="edu-sub-item"><a href="{{ route('attendances.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/attendance') ? 'active' : '' }}">{{ __('Daily Attendance') }}</a></li>
                            <li class="edu-sub-item"><a href="{{ route('attendance.qr.scan', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/attendance/qr-scan*') ? 'active' : '' }}"><i class="fa-solid fa-qrcode me-1 text-primary"></i> {{ __('ID Card QR Attendance') }}</a></li>
                        @endif
                        @if($hasFeature('attendance.analytics') || $hasFeature('attendance.manage'))
                            <li class="edu-sub-item"><a href="{{ route('attendance.analytics', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/attendance/analytics*') ? 'active' : '' }}">{{ __('Attendance Analytics') }}</a></li>
                        @endif
                        @if($hasFeature('attendance.manage') || $hasFeature('attendance.report'))
                            <li class="edu-sub-item"><a href="{{ route('student.attendance.report', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/attendance/report*') ? 'active' : '' }}">{{ __('Attendance Report') }}</a></li>
                        @endif
                        @if($hasFeature('holiday.manage'))
                            <li class="edu-sub-item"><a href="{{ route('holidays.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/holidays*') ? 'active' : '' }}">{{ __('Holidays Setup') }}</a></li>
                        @endif
                        @if($hasFeature('exam.manage'))
                            <li class="edu-sub-item"><a href="{{ route('exams.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/exams*') ? 'active' : '' }}">{{ __('Exams List') }}</a></li>
                            <li class="edu-sub-item"><a href="{{ route('exams.admit-card', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/admit-card*') ? 'active' : '' }}">{{ __('Admit Cards') }}</a></li>
                            <li class="edu-sub-item"><a href="{{ route('exam.routine.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/exam-routine*') ? 'active' : '' }}">{{ __('Exams Routine') }}</a></li>
                        @endif
                        @if($hasFeature('mark.manage'))
                            <li class="edu-sub-item"><a href="{{ route('marks.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/marks') || Request::is('*/marks/*') && !Request::is('*/marks/view-marks*') && !Request::is('*/result-search*') ? 'active' : '' }}">{{ __('Marks Entry') }}</a></li>
                            <li class="edu-sub-item"><a href="{{ route('marks.view-marks', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/marks/view-marks*') ? 'active' : '' }}">{{ __('Result Report') }}</a></li>
                            <li class="edu-sub-item"><a href="{{ route('marks.result-search', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/result-search*') ? 'active' : '' }}">{{ __('Result Search') }}</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- 5. Finance (Fees) --}}
            @php
                $financePerms = ['fee.manage', 'fee.collect', 'fee.report'];
            @endphp
            @if($hasGroupAccess($financePerms))
            <li class="edu-nav-item">
                <a class="edu-nav-link edu-has-submenu {{ Request::is('*/fee*') || Request::is('*/payment*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#feeMenu">
                    <i data-feather="dollar-sign"></i> <span>{{ __('Finance') }}</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/fee*') || Request::is('*/payment*') ? 'show' : '' }}" id="feeMenu">
                    <ul class="edu-sub-nav">
                        @if($hasFeature('fee.manage'))
                            <li class="edu-sub-item"><a href="{{ route('fee-heads.index', ['tenant' => $tenant]) }}" class="edu-sub-link">{{ __('Fee Heads') }}</a></li>
                            <li class="edu-sub-item"><a href="{{ route('fee-amounts.index', ['tenant' => $tenant]) }}" class="edu-sub-link">{{ __('Fee Structure') }}</a></li>
                            <li class="edu-sub-item"><a href="{{ route('student-fees.index', ['tenant' => $tenant]) }}" class="edu-sub-link">{{ __('Fees Generation') }}</a></li>
                            <li class="edu-sub-item"><a href="{{ route('student-fee-concessions.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/student-fee-concessions*') ? 'active' : '' }}">{{ __('Fee Concessions (মাইনাস ফি)') }}</a></li>
                        @endif
                        @if($hasFeature('fee.collect'))
                            <li class="edu-sub-item"><a href="{{ route('payment.index', ['tenant' => $tenant]) }}" class="edu-sub-link">{{ __('Collect Payment') }}</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- 6. Communication --}}
            @php
                $commPerms = ['notice.manage', 'slider.manage', 'message.manage', 'newsletter.manage'];
            @endphp
            @if($hasGroupAccess($commPerms))
            <li class="edu-nav-item">
                <a class="edu-nav-link edu-has-submenu {{ Request::is('*/notices*') || Request::is('*/message*') || Request::is('*/newsletter*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#commMenu">
                    <i data-feather="mail"></i> <span>{{ __('Communication') }}</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/notices*') || Request::is('*/message*') || Request::is('*/newsletter*') ? 'show' : '' }}" id="commMenu">
                    <ul class="edu-sub-nav">
                        @if($hasFeature('notice.manage'))
                            <li class="edu-sub-item"><a href="{{ route('notices.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/notices*') ? 'active' : '' }}">{{ __('Notices') }}</a></li>
                        @endif
                        @if($hasFeature('message.manage'))
                            <li class="edu-sub-item"><a href="{{ route('admin.message.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/message*') ? 'active' : '' }}">{{ __('Website Messages') }}</a></li>
                            <li class="edu-sub-item"><a href="{{ route('school.inbox.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/inbox*') ? 'active' : '' }}">{{ __('School Email Inbox') }}</a></li>
                        @endif
                        @if($hasFeature('newsletter.manage'))
                            <li class="edu-sub-item"><a href="{{ route('admin.newsletter.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/newsletter*') ? 'active' : '' }}">{{ __('Newsletter Subscribers') }}</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            <li class="edu-nav-item">
                <a href="{{ route('school.support.index', ['tenant' => $tenant]) }}" class="edu-nav-link {{ Request::is('*/support*') ? 'active' : '' }}">
                    <i data-feather="help-circle"></i> <span>{{ __('Support Center') }}</span>
                </a>
            </li>

            @if($user->hasRole('school_admin') || $user->role === 'school_admin' || $user->hasRole('super_admin') || $user->role === 'super_admin')
            <li class="edu-nav-item">
                <a href="{{ route('school.review.create', ['tenant' => $tenant]) }}" class="edu-nav-link {{ Request::is('*/review*') ? 'active' : '' }}">
                    <i data-feather="star"></i> <span>{{ __('Review') }}</span>
                </a>
            </li>
            @endif

            <li class="edu-nav-category">{{ __('Settings') }}</li>
            
            @if($user->hasRole('school_admin') || $user->role === 'school_admin' || $hasFeature('system.settings'))
            <li class="edu-nav-item">
                <a class="edu-nav-link edu-has-submenu {{ Request::is('*/school-settings*') || Request::is('*/sliders*') || Request::is('*/about-settings*') || Request::is('*/settings/footer*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#settingMenu">
                    <i data-feather="settings"></i> <span>{{ __('Settings') }}</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/school-settings*') || Request::is('*/sliders*') || Request::is('*/about-settings*') || Request::is('*/settings/footer*') ? 'show' : '' }}" id="settingMenu">
                    <ul class="edu-sub-nav">
                        <li class="edu-sub-item"><a href="{{ route('admin.school.info-edit', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/school-info*') ? 'active' : '' }}">{{ __('General Settings') }}</a></li>
                        <li class="edu-sub-item"><a href="{{ route('admin.school.api-setup', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/api-setup*') ? 'active' : '' }}">{{ __('API Setup') }}</a></li>
                        <li class="edu-sub-item"><a href="{{ route('admin.school.communication', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/communication*') ? 'active' : '' }}">{{ __('Communication Settings') }}</a></li>
                        @if($user->hasRole('school_admin'))
                            <li class="edu-sub-item"><a href="{{ route('school.roles.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/roles*') ? 'active' : '' }}">{{ __('Role & Permissions') }}</a></li>
                        @endif
                        @if($hasFeature('system.settings'))
                            <li class="edu-sub-item"><a href="{{ route('sliders.index', ['tenant' => $tenant]) }}" class="edu-sub-link">{{ __('Sliders') }}</a></li>
                            <li class="edu-sub-item"><a href="{{ route('about.index', ['tenant' => $tenant]) }}" class="edu-sub-link">{{ __('About Section') }}</a></li>
                            <li class="edu-sub-item"><a href="{{ route('footer.edit', ['tenant' => $tenant]) }}" class="edu-sub-link">{{ __('Footer Settings') }}</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif
        </ul>
    </div>

    {{-- Upgrade Plan Card (Pinned to Sidebar Bottom) --}}
    @if($user->hasRole('school_admin') || $user->role === 'school_admin')
    @php
        $currentPackage = optional($school->subscriptionPackage);
        $activeSubscription = $school->activeSubscription();
        $isPremium = $currentPackage->is_popular ?? false;
        $packageName = $currentPackage->name ?? 'Basic';
    @endphp

    <div class="edu-sidebar-footer mx-3 mb-3 mt-auto sidebar-folded-hide">
        @if(!$activeSubscription)
            <div class="card border-0 rounded-4 overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #b91c1c, #ef4444);">
                <div class="card-body p-3 text-white text-center">
                    <div class="mb-1"><i class="fa-solid fa-credit-card fa-xl opacity-85"></i></div>
                    <h6 class="fw-bold mb-1" style="font-size:12.5px;">{{ __('Payment Required') }}</h6>
                    <p class="mb-2" style="font-size:10.5px; opacity:0.85; line-height:1.3;">{{ __('Your trial or subscription has ended.') }}</p>
                    <a href="{{ route('school.pricing', ['tenant' => $tenant]) }}" class="btn w-100 rounded-pill py-1.5 fw-bold" style="background:#fff; color:#b91c1c; font-size:11.5px;">
                        <i class="fa-solid fa-arrow-right me-1"></i> {{ __('Pay Now') }}
                    </a>
                </div>
            </div>
        @elseif($activeSubscription->isExpiringSoon(15))
            {{-- Renewal Reminder Card (15 days before expiry) --}}
            @php $daysLeft = $activeSubscription->daysRemaining(); @endphp
            <div class="card border-0 rounded-4 overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #d97706, #f59e0b);">
                <div class="card-body p-3 text-white text-center">
                    <div class="mb-1.5">
                        <i class="fa-solid fa-clock-rotate-left fa-xl opacity-90"></i>
                    </div>
                    <h6 class="fw-bold mb-1" style="font-size:12.5px;">{{ __('Renew Plan') }}</h6>
                    <p class="mb-2" style="font-size:10.5px; opacity:0.9; line-height:1.3;">
                        {{ $daysLeft == 0 ? __('Expires today') : ($daysLeft == 1 ? __('1 day remaining') : __(':count days remaining', ['count' => $daysLeft])) }}
                    </p>
                    <a href="{{ route('school.pricing', ['tenant' => $tenant]) }}" 
                       class="btn w-100 rounded-pill py-1.5 fw-bold shadow-sm" 
                       style="background:#fff; color:#d97706; font-size:11.5px;">
                        <i class="fa-solid fa-arrows-rotate me-1"></i> {{ __('Renew Now') }}
                    </a>
                </div>
            </div>
        @elseif(!$isPremium)
            {{-- Basic Package: Upgrade Card --}}
            <div class="card border-0 rounded-4 overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #4f46e5, #818cf8);">
                <div class="card-body p-3 text-white text-center">
                    <div class="mb-1.5">
                        <i class="fa-solid fa-rocket fa-xl opacity-85"></i>
                    </div>
                    <h6 class="fw-bold mb-1" style="font-size:12.5px;">{{ __('Upgrade to Premium') }}</h6>
                    <p class="mb-2" style="font-size:10.5px; opacity:0.85; line-height:1.3;">{{ __('Unlock all premium features & unlimited benefits.') }}</p>
                    <div class="mb-2">
                        <span class="badge" style="background:rgba(255,255,255,0.22); padding:3px 8px; border-radius:20px; font-size:9.5px;">
                            {{ __('Current') }}: {{ $packageName }}
                        </span>
                    </div>
                    <a href="{{ route('school.pricing', ['tenant' => $tenant]) }}" 
                       class="btn w-100 rounded-pill py-1.5 fw-bold" 
                       style="background:#fff; color:#4f46e5; font-size:11.5px;">
                        <i class="fa-solid fa-arrow-up me-1"></i> {{ __('Upgrade Now') }}
                    </a>
                </div>
            </div>
        @else
            {{-- Premium Package: Active Badge --}}
            <div class="card border-0 rounded-4 overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #059669, #10b981);">
                <div class="card-body p-2.5 text-white text-center">
                    <div class="mb-1">
                        <i class="fa-solid fa-crown fa-lg" style="opacity:0.9; color:#fcd34d;"></i>
                    </div>
                    <h6 class="fw-bold mb-0.5" style="font-size:12px; color:#fcd34d;">{{ __('Premium Active') }}</h6>
                    <p class="mb-1.5" style="font-size:10.5px; opacity:0.85;">{{ __(':package package', ['package' => $packageName]) }}</p>
                    <div style="background:rgba(255,255,255,0.18); border-radius:8px; padding:4px 8px; font-size:9.5px;">
                        <i class="fa-solid fa-check-circle me-1" style="color:#fcd34d;"></i>
                        {{ __('All features active') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
    @endif
</nav>

<form id="logout-form" action="{{ route('school.logout', ['tenant' => $tenant]) }}" method="POST" style="display: none;">
    @csrf
</form>