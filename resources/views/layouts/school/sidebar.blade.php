@php
    $user = auth()->user();
    $school = $currentSchool;
    $tenant = $school->slug; 
    $userPermissions = $user->getAllPermissions()->pluck('name')->toArray();
    
    // স্কুলের প্যাকেজে যে পারমিশনগুলো কেনা আছে
    $packagePermissions = optional($school->subscriptionPackage)->permissions ?? [];

    // ড্যাশবোর্ড রাউট নির্ধারণ
    $dashboardRoute = match($user->role) {
        'student' => route('student.dashboard'),
        'teacher' => route('teacher.dashboard'),
        'school_admin', 'school_staff' => route('school.dashboard'),
        default => '#'
    };

    /**
     * ডাইনামিক পারমিশন চেক হেল্পার
     * এটি চেক করে যে ইউজারের পারমিশন আছে কি না এবং সেটি স্কুলের প্যাকেজে অন্তর্ভুক্ত কি না।
     */
    $hasFeature = function($permission) use ($user, $userPermissions, $packagePermissions) {
        if ($user->hasRole('super_admin') || $user->role === 'super_admin') return true;
        
        // ১. চেক: স্কুলের প্যাকেজে এই পারমিশন আছে কি না
        $inPackage = in_array($permission, $packagePermissions);
        
        // ২. চেক: ইউজারের এই পারমিশন আছে কি না (স্কুল এডমিন হলে সব পাবে যা প্যাকেজে আছে)
        $hasPerm = in_array($permission, $userPermissions) || $user->hasRole('school_admin') || $user->role === 'school_admin';
        
        return $inPackage && $hasPerm;
    };

    /**
     * কোনো নির্দিষ্ট গ্রুপের অন্তত একটি ফিচার প্যাকেজে আছে কি না চেক করার জন্য
     */
    $hasGroupAccess = function($permissionsArray) use ($user, $packagePermissions, $userPermissions) {
        if ($user->hasRole('super_admin') || $user->role === 'super_admin') return true;
        
        $packageIntersect = array_intersect($permissionsArray, $packagePermissions);
        if (count($packageIntersect) === 0) return false;

        if ($user->hasRole('school_admin') || $user->role === 'school_admin') return true;
        
        return count(array_intersect($packageIntersect, $userPermissions)) > 0;
    };
@endphp

<nav class="sidebar edu-sidebar">
    {{-- Header Section --}}
    <div class="edu-sidebar-header">
        <a href="{{ route('school.home') }}" class="edu-brand">
            <div class="edu-brand-icon" style="background: linear-gradient(135deg, #4f46e5, #818cf8); color: white;">
                {{ strtoupper(substr($school->name ?? 'E', 0, 1)) }}
            </div>
            <div>
                <div class="edu-brand-name">{{ $school->name ?? 'EduCorexa' }}</div>
                <div class="edu-brand-sub">School Portal</div>
            </div>
        </a>
        {{-- Mobile Close Button --}}
        <div class="edu-mobile-close d-lg-none" style="cursor:pointer; color:#94a3b8; z-index: 9999; display: flex !important; align-items: center; justify-content: center; margin-left: auto;">
            <i data-feather="x" style="width:22px;height:22px;"></i>
        </div>
    </div>

    <div class="edu-sidebar-body">
        <ul class="edu-nav">
            <li class="edu-nav-category">Main</li>
            <li class="edu-nav-item">
                <a href="{{ $dashboardRoute }}" class="edu-nav-link {{ Request::is('*/dashboard*') ? 'active' : '' }}">
                    <i data-feather="grid"></i> <span>Dashboard</span>
                </a>
            </li>

            @php
                $anyModule = $hasGroupAccess(['academic-year.manage', 'class.manage', 'section.manage', 'subject.manage', 'admission.manage', 'student.manage', 'teacher.manage', 'employee.manage', 'attendance.manage', 'exam.manage', 'fee.manage', 'notice.manage', 'category.manage', 'sub-category.manage']);
            @endphp

            @if($anyModule)
                <li class="edu-nav-category">Modules</li>
            @endif

            {{-- 1. Academic Section --}}
            @php
                $academicPerms = ['academic-year.manage', 'class.manage', 'section.manage', 'subject.manage', 'class.routine', 'syllabus.manage', 'category.manage', 'sub-category.manage'];
            @endphp
            @if($hasGroupAccess($academicPerms))
            <li class="edu-nav-item">
                <a class="edu-nav-link edu-has-submenu {{ Request::is('*/academic*') || Request::is('*/classes*') || Request::is('*/sections*') || Request::is('*/subjects*') || Request::is('*/routine*') || Request::is('*/categories*') || Request::is('*/sub-categories*') ? 'active' : '' }}" 
                   data-bs-toggle="collapse" href="#academicMenu">
                    <i data-feather="layers"></i> <span>Academic</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/academic*') || Request::is('*/classes*') || Request::is('*/sections*') || Request::is('*/subjects*') || Request::is('*/routine*') || Request::is('*/categories*') || Request::is('*/sub-categories*') ? 'show' : '' }}" id="academicMenu">
                    <ul class="edu-sub-nav">
                        @if($hasFeature('academic-year.manage'))
                            <li class="edu-sub-item"><a href="{{ route('academic-year.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/academic-year*') ? 'active' : '' }}">Academic Years</a></li>
                        @endif
                        @if($hasFeature('category.manage'))
                            <li class="edu-sub-item"><a href="{{ route('categories.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/categories*') ? 'active' : '' }}">Categories</a></li>
                        @endif
                        @if($hasFeature('sub-category.manage'))
                            <li class="edu-sub-item"><a href="{{ route('sub-categories.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/sub-categories*') ? 'active' : '' }}">Sub Categories</a></li>
                        @endif
                        @if($hasFeature('class.manage'))
                            <li class="edu-sub-item"><a href="{{ route('classes.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/classes*') ? 'active' : '' }}">Classes</a></li>
                        @endif
                        @if($hasFeature('section.manage'))
                            <li class="edu-sub-item"><a href="{{ route('sections.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/sections*') ? 'active' : '' }}">Sections</a></li>
                        @endif
                        @if($hasFeature('subject.manage'))
                            <li class="edu-sub-item"><a href="{{ route('subjects.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/subjects') ? 'active' : '' }}">Subjects List</a></li>
                            <li class="edu-sub-item"><a href="{{ route('subjects.assign', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/subjects-assign*') ? 'active' : '' }}">Assign Subjects</a></li>
                        @endif
                        @if($hasFeature('class.routine'))
                            <li class="edu-sub-item"><a href="{{ route('routine.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/routine*') ? 'active' : '' }}">Class Routine</a></li>
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
                    <i data-feather="users"></i> <span>Students</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/students*') || Request::is('*/admissions*') ? 'show' : '' }}" id="studentMenu">
                    <ul class="edu-sub-nav">
                        @if($hasFeature('admission.manage'))
                            <li class="edu-sub-item"><a href="{{ route('admissions.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/admissions*') ? 'active' : '' }}">Admissions</a></li>
                        @endif
                        @if($hasFeature('student.index') || $hasFeature('student.manage'))
                            <li class="edu-sub-item"><a href="{{ route('students.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/students') || Request::is('*/students/*') ? 'active' : '' }}">Student List</a></li>
                        @endif
                        @if($hasFeature('student.create'))
                            <li class="edu-sub-item"><a href="{{ route('students.create', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/students/create*') ? 'active' : '' }}">Add Student</a></li>
                        @endif
                        @if($hasFeature('student.idcard'))
                            <li class="edu-sub-item"><a href="{{ route('students.idcard.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/id-cards*') ? 'active' : '' }}">ID Cards</a></li>
                        @endif
                        @if($hasFeature('student.promotion'))
                            <li class="edu-sub-item"><a href="{{ route('students.promotion', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/promotion*') ? 'active' : '' }}">Promotion</a></li>
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
                    <i data-feather="user-check"></i> <span>Staff & HR</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/teachers*') || Request::is('*/staff*') || Request::is('*/teacher-assign*') ? 'show' : '' }}" id="staffMenu">
                    <ul class="edu-sub-nav">
                        @if($hasFeature('teacher.manage'))
                            <li class="edu-sub-item"><a href="{{ route('teachers.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/teachers') ? 'active' : '' }}">Teachers List</a></li>
                            <li class="edu-sub-item"><a href="{{ route('teachers.create', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/teachers/create*') ? 'active' : '' }}">Add Teacher</a></li>
                            <li class="edu-sub-item"><a href="{{ route('teacher.assign', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/teacher-assign*') ? 'active' : '' }}">Assign Teachers</a></li>
                        @endif
                        @if($hasFeature('employee.manage'))
                            <li class="edu-sub-item"><a href="{{ route('staff.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/staff') ? 'active' : '' }}">Staff List</a></li>
                            <li class="edu-sub-item"><a href="{{ route('staff.create', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/staff/create*') ? 'active' : '' }}">Add Staff</a></li>
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
                    <i data-feather="edit-3"></i> <span>Attendance & Exams</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/attendance*') || Request::is('*/exam*') || Request::is('*/mark*') || Request::is('*/holiday*') ? 'show' : '' }}" id="examMenu">
                    <ul class="edu-sub-nav">
                        @if($hasFeature('attendance.manage'))
                            <li class="edu-sub-item"><a href="{{ route('attendances.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/attendance') ? 'active' : '' }}">Daily Attendance</a></li>
                            <li class="edu-sub-item"><a href="{{ route('student.attendance.report', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/attendance/report*') ? 'active' : '' }}">Attendance Report</a></li>
                        @endif
                        @if($hasFeature('holiday.manage'))
                            <li class="edu-sub-item"><a href="{{ route('holidays.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/holidays*') ? 'active' : '' }}">Holidays Setup</a></li>
                        @endif
                        @if($hasFeature('exam.manage'))
                            <li class="edu-sub-item"><a href="{{ route('exams.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/exams*') ? 'active' : '' }}">Exams List</a></li>
                            <li class="edu-sub-item"><a href="{{ route('exams.admit-card', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/admit-card*') ? 'active' : '' }}">Admit Cards</a></li>
                        @endif
                        @if($hasFeature('mark.manage'))
                            <li class="edu-sub-item"><a href="{{ route('marks.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/marks*') ? 'active' : '' }}">Marks Entry</a></li>
                            <li class="edu-sub-item"><a href="{{ route('marks.view-marks', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/marks/view-marks') ? 'active' : '' }}">Marks Report</a></li>
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
                    <i data-feather="dollar-sign"></i> <span>Finance</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/fee*') || Request::is('*/payment*') ? 'show' : '' }}" id="feeMenu">
                    <ul class="edu-sub-nav">
                        @if($hasFeature('fee.manage'))
                            <li class="edu-sub-item"><a href="{{ route('fee-heads.index', ['tenant' => $tenant]) }}" class="edu-sub-link">Fee Heads</a></li>
                            <li class="edu-sub-item"><a href="{{ route('fee-amounts.index', ['tenant' => $tenant]) }}" class="edu-sub-link">Fee Structure</a></li>
                            <li class="edu-sub-item"><a href="{{ route('student-fees.index', ['tenant' => $tenant]) }}" class="edu-sub-link">Fees Generation</a></li>
                        @endif
                        @if($hasFeature('fee.collect'))
                            <li class="edu-sub-item"><a href="{{ route('payment.index', ['tenant' => $tenant]) }}" class="edu-sub-link">Collect Payment</a></li>
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
                    <i data-feather="mail"></i> <span>Communication</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/notices*') || Request::is('*/message*') || Request::is('*/newsletter*') ? 'show' : '' }}" id="commMenu">
                    <ul class="edu-sub-nav">
                        @if($hasFeature('notice.manage'))
                            <li class="edu-sub-item"><a href="{{ route('notices.index', ['tenant' => $tenant]) }}" class="edu-sub-link">Notices</a></li>
                        @endif
                        @if($hasFeature('message.manage'))
                            <li class="edu-sub-item"><a href="{{ route('admin.message.index', ['tenant' => $tenant]) }}" class="edu-sub-link">Website Messages</a></li>
                        @endif
                        @if($hasFeature('newsletter.manage'))
                            <li class="edu-sub-item"><a href="{{ route('admin.newsletter.index', ['tenant' => $tenant]) }}" class="edu-sub-link">Newsletter Subscribers</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            <li class="edu-nav-item">
                <a href="{{ route('school.support.index', ['tenant' => $tenant]) }}" class="edu-nav-link {{ Request::is('*/support*') ? 'active' : '' }}">
                    <i data-feather="help-circle"></i> <span>Support Center</span>
                </a>
            </li>

            @if($user->hasRole('school_admin') || $user->role === 'school_admin' || $user->hasRole('super_admin') || $user->role === 'super_admin')
            <li class="edu-nav-item">
                <a href="{{ route('school.review.create', ['tenant' => $tenant]) }}" class="edu-nav-link {{ Request::is('*/review*') ? 'active' : '' }}">
                    <i data-feather="star"></i> <span>Review</span>
                </a>
            </li>
            @endif

            <li class="edu-nav-category">Settings</li>
            
            @if($user->hasRole('school_admin') || $user->role === 'school_admin' || $hasFeature('system.settings'))
            <li class="edu-nav-item">
                <a class="edu-nav-link edu-has-submenu {{ Request::is('*/school-settings*') || Request::is('*/sliders*') || Request::is('*/about-settings*') || Request::is('*/settings/footer*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#settingMenu">
                    <i data-feather="settings"></i> <span>Settings</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/school-settings*') || Request::is('*/sliders*') || Request::is('*/about-settings*') || Request::is('*/settings/footer*') ? 'show' : '' }}" id="settingMenu">
                    <ul class="edu-sub-nav">
                        <li class="edu-sub-item"><a href="{{ route('admin.school.info-edit', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/school-info*') ? 'active' : '' }}">General Settings</a></li>
                        <li class="edu-sub-item"><a href="{{ route('admin.school.api-setup', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/api-setup*') ? 'active' : '' }}">API Setup</a></li>
                        <li class="edu-sub-item"><a href="{{ route('admin.school.communication', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/communication*') ? 'active' : '' }}">Communication Settings</a></li>
                        @if($user->hasRole('school_admin'))
                            <li class="edu-sub-item"><a href="{{ route('school.roles.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/roles*') ? 'active' : '' }}">Role & Permissions</a></li>
                        @endif
                        @if($hasFeature('system.settings'))
                            <li class="edu-sub-item"><a href="{{ route('sliders.index', ['tenant' => $tenant]) }}" class="edu-sub-link">Sliders</a></li>
                            <li class="edu-sub-item"><a href="{{ route('about.index', ['tenant' => $tenant]) }}" class="edu-sub-link">About Section</a></li>
                            <li class="edu-sub-item"><a href="{{ route('footer.edit', ['tenant' => $tenant]) }}" class="edu-sub-link">Footer Settings</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

        </ul>

        {{-- Upgrade Plan Card --}}
        @if($user->hasRole('school_admin') || $user->role === 'school_admin')
        @php
            $currentPackage = optional($school->subscriptionPackage);
            $isPremium = $currentPackage->is_popular ?? false;
            $packageName = $currentPackage->name ?? 'Basic';
        @endphp

        <div class="edu-sidebar-footer mx-3 my-4">
            @if(!$isPremium)
                {{-- Basic Package: Upgrade Card --}}
                <div class="card border-0 rounded-4 overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #4f46e5, #818cf8);">
                    <div class="card-body p-3 text-white text-center">
                        <div class="mb-2">
                            <i class="fa-solid fa-rocket fa-2x opacity-75"></i>
                        </div>
                        <h6 class="fw-bold mb-1" style="font-size:13px;">Upgrade to Premium</h6>
                        <p class="mb-2" style="font-size:11px; opacity:0.8;">আনলক করুন সকল প্রিমিয়াম ফিচার ও আনলিমিটেড সুবিধা।</p>
                        <div class="mb-2" style="font-size:10px; opacity:0.7;">
                            <span class="badge" style="background:rgba(255,255,255,0.2); padding:3px 8px; border-radius:20px;">
                                বর্তমান: {{ $packageName }}
                            </span>
                        </div>
                        <a href="{{ route('school.pricing', ['tenant' => $tenant]) }}" 
                           class="btn w-100 rounded-pill py-2 fw-bold" 
                           style="background:#fff; color:#4f46e5; font-size:12px; margin-top:4px;">
                            <i class="fa-solid fa-arrow-up me-1"></i> Upgrade Now
                        </a>
                    </div>
                </div>
            @else
                {{-- Premium Package: Active Badge --}}
                <div class="card border-0 rounded-4 overflow-hidden shadow-sm" style="background: linear-gradient(135deg, #059669, #10b981);">
                    <div class="card-body p-3 text-white text-center">
                        <div class="mb-2">
                            <i class="fa-solid fa-crown fa-2x" style="opacity:0.85; color:#fcd34d;"></i>
                        </div>
                        <h6 class="fw-bold mb-1" style="font-size:13px; color:#fcd34d;">Premium Active</h6>
                        <p class="mb-2" style="font-size:11px; opacity:0.85;">আপনি {{ $packageName }} প্যাকেজে আছেন।</p>
                        <div style="background:rgba(255,255,255,0.15); border-radius:10px; padding:6px 10px; font-size:10px;">
                            <i class="fa-solid fa-check-circle me-1" style="color:#fcd34d;"></i>
                            সকল প্রিমিয়াম ফিচার সক্রিয়
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @endif
    </div>
</nav>

<form id="logout-form" action="{{ route('school.logout', ['tenant' => $tenant]) }}" method="POST" style="display: none;">
    @csrf
</form>