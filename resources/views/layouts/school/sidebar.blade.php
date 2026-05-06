@php
    $user = auth()->user();
    $tenant = $currentSchool->slug; 
    $permissions = $user->getAllPermissions()->pluck('name')->toArray();
    
    $dashboardRoute = match($user->role) {
        'student' => route('student.dashboard'),
        'teacher' => route('teacher.dashboard'),
        'school_admin', 'school_staff' => route('school.dashboard'),
        default => '#'
    };
@endphp

<nav class="sidebar edu-sidebar">
    <div class="edu-sidebar-header">
        <a href="{{ route('school.home') }}" class="edu-brand">
            <div class="edu-brand-icon">
                {{ strtoupper(substr($currentSchool->name ?? 'E', 0, 1)) }}
            </div>
            <div>
                <div class="edu-brand-name">{{ $currentSchool->name ?? 'EduCorexa' }}</div>
                <div class="edu-brand-sub">SCHOOL PORTAL</div>
            </div>
        </a>
        <div class="sidebar-toggler not-active d-lg-none ms-auto" style="cursor:pointer; color:var(--text-faint);">
            <i data-feather="x" style="width:20px;height:20px;"></i>
        </div>
    </div>

    <div class="edu-sidebar-body">
        <ul class="edu-nav">
            <li class="edu-nav-category">Main</li>
            <li class="edu-nav-item">
                <a href="{{ $dashboardRoute }}" class="edu-nav-link {{ Request::is('*/dashboard*') ? 'active' : '' }}">
                    <i data-feather="grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="edu-nav-category">School Management</li>

            {{-- 1. Academic --}}
            @if(count(array_intersect(['academic-year.manage', 'category.manage', 'sub-category.manage', 'class.manage', 'section.manage', 'subject.manage', 'assign.subject', 'class.routine'], $permissions)) > 0)
            <li class="edu-nav-item">
                <a class="edu-nav-link {{ Request::is('*/academic*') || Request::is('*/classes*') || Request::is('*/sections*') || Request::is('*/subjects*') || Request::is('*/routine*') ? 'active' : '' }}" 
                   data-bs-toggle="collapse" href="#academicMenu" role="button">
                    <i data-feather="layers"></i>
                    <span>Academic</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/academic*') || Request::is('*/classes*') || Request::is('*/sections*') || Request::is('*/subjects*') || Request::is('*/routine*') ? 'show' : '' }}" id="academicMenu">
                    <ul class="edu-sub-nav">
                        @if(in_array('academic-year.manage', $permissions))
                        <li><a href="{{ route('academic-year.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/academic-year*') ? 'active' : '' }}">Academic Years</a></li>
                        @endif
                        @if(in_array('category.manage', $permissions))
                        <li><a href="{{ route('categories.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/categories*') ? 'active' : '' }}">Categories</a></li>
                        @endif
                        @if(in_array('sub-category.manage', $permissions))
                        <li><a href="{{ route('sub-categories.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/sub-categories*') ? 'active' : '' }}">Sub Categories</a></li>
                        @endif
                        @if(in_array('class.manage', $permissions))
                        <li><a href="{{ route('classes.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/classes*') ? 'active' : '' }}">Classes</a></li>
                        @endif
                        @if(in_array('section.manage', $permissions))
                        <li><a href="{{ route('sections.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/sections*') ? 'active' : '' }}">Sections</a></li>
                        @endif
                        @if(in_array('subject.manage', $permissions))
                        <li><a href="{{ route('subjects.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/subjects*') ? 'active' : '' }}">Subjects</a></li>
                        @endif
                        @if(in_array('assign.subject', $permissions))
                        <li><a href="{{ route('subjects.assign', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/subjects/assign*') ? 'active' : '' }}">Assign Subject</a></li>
                        @endif
                        @if(in_array('class.routine', $permissions))
                        <li><a href="{{ route('routine.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/routine*') ? 'active' : '' }}">Class Routine</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- 2. Students & Admissions --}}
            @if(in_array('admission.manage', $permissions) || in_array('student.manage', $permissions))
            <li class="edu-nav-item">
                <a class="edu-nav-link {{ Request::is('*/students*') || Request::is('*/admissions*') ? 'active' : '' }}" 
                   data-bs-toggle="collapse" href="#studentMenu" role="button">
                    <i data-feather="users"></i>
                    <span>Students Module</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/students*') || Request::is('*/admissions*') ? 'show' : '' }}" id="studentMenu">
                    <ul class="edu-sub-nav">
                        @if(in_array('admission.manage', $permissions))
                        <li><a href="{{ route('admissions.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/admissions*') ? 'active' : '' }}">Admissions</a></li>
                        @endif
                        @if(in_array('student.manage', $permissions))
                        <li><a href="{{ route('students.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/students') ? 'active' : '' }}">Student List</a></li>
                        <li><a href="{{ route('students.create', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/students/create') ? 'active' : '' }}">Add Student</a></li>
                        @endif
                        @if(in_array('student.idcard', $permissions) || $user->hasRole('school_admin'))
                        <li><a href="{{ route('students.idcard.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/students/idcard*') ? 'active' : '' }}">Generate ID Cards</a></li>
                        @endif
                        @if(in_array('student.promotion', $permissions))
                        <li><a href="{{ route('students.promotion', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/students/promotion*') ? 'active' : '' }}">Promotion</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- 3. Staff & HR --}}
            @if(in_array('teacher.manage', $permissions) || in_array('assign.teacher', $permissions))
            <li class="edu-nav-item">
                <a class="edu-nav-link {{ Request::is('*/teachers*') ? 'active' : '' }}" 
                   data-bs-toggle="collapse" href="#teacherMenu" role="button">
                    <i data-feather="user-check"></i>
                    <span>Staff & HR</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/teachers*') ? 'show' : '' }}" id="teacherMenu">
                    <ul class="edu-sub-nav">
                        @if(in_array('teacher.manage', $permissions))
                        <li><a href="{{ route('teachers.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/teachers') ? 'active' : '' }}">Teachers</a></li>
                        @endif
                        @if(in_array('assign.teacher', $permissions))
                        <li><a href="{{ route('teacher.assign', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/teachers/assign*') ? 'active' : '' }}">Assign Teacher</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- 4. Attendance & Exams --}}
            @if(count(array_intersect(['attendance.manage', 'attendance.report', 'holiday.manage', 'exam.manage', 'mark.manage'], $permissions)) > 0)
            <li class="edu-nav-item">
                <a class="edu-nav-link {{ Request::is('*/attendances*') || Request::is('*/exams*') || Request::is('*/marks*') ? 'active' : '' }}" 
                   data-bs-toggle="collapse" href="#attendanceExamMenu" role="button">
                    <i data-feather="calendar"></i>
                    <span>Attendance & Exams</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/attendances*') || Request::is('*/exams*') || Request::is('*/marks*') ? 'show' : '' }}" id="attendanceExamMenu">
                    <ul class="edu-sub-nav">
                        @if(in_array('attendance.manage', $permissions))
                        <li><a href="{{ route('attendances.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/attendances') ? 'active' : '' }}">Take Attendance</a></li>
                        @endif
                        @if(in_array('attendance.report', $permissions) || $user->hasRole('school_admin'))
                        <li><a href="{{ route('student.attendance.report', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/student/attendance/report*') ? 'active' : '' }}">Attendance Report</a></li>
                        @endif
                        @if(in_array('holiday.manage', $permissions))
                        <li><a href="{{ route('holidays.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/holidays*') ? 'active' : '' }}">Holiday Setup</a></li>
                        @endif
                        @if(in_array('exam.manage', $permissions))
                        <li><a href="{{ route('exams.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/exams') ? 'active' : '' }}">Manage Exams</a></li>
                        <li><a href="{{ route('exams.admit-card', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/exams/admit-card*') ? 'active' : '' }}">Admit Cards</a></li>
                        @endif
                        @if(in_array('mark.manage', $permissions))
                        <li><a href="{{ route('marks.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/marks') ? 'active' : '' }}">Marks Entry</a></li>
                        <li><a href="{{ route('marks.view-marks', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/marks/view-marks*') ? 'active' : '' }}">View Results</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- 5. Digital Diary --}}
            @if($user->can('lesson.view') || $user->hasRole('student'))
            <li class="edu-nav-item">
                <a class="edu-nav-link {{ Request::is('*/diary*') ? 'active' : '' }}" 
                   data-bs-toggle="collapse" href="#diaryMenu" role="button">
                    <i data-feather="book"></i>
                    <span>Digital Diary</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/diary*') ? 'show' : '' }}" id="diaryMenu">
                    <ul class="edu-sub-nav">
                        @can('lesson.manage')
                        <li><a href="{{ route('diary.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/diary') ? 'active' : '' }}">Daily Entry</a></li>
                        @endcan
                        <li><a href="{{ route('diary.student_view', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/diary/student_view*') ? 'active' : '' }}">View Diary</a></li>
                    </ul>
                </div>
            </li>
            @endif

            {{-- 6. Finance (Fees) --}}
            @if(in_array('fee.manage', $permissions) || in_array('fee.collect', $permissions))
            <li class="edu-nav-item">
                <a class="edu-nav-link {{ Request::is('*/fee*') || Request::is('*/payment*') ? 'active' : '' }}" 
                   data-bs-toggle="collapse" href="#feeMenu" role="button">
                    <i data-feather="dollar-sign"></i>
                    <span>Finance (Fees)</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/fee*') || Request::is('*/payment*') ? 'show' : '' }}" id="feeMenu">
                    <ul class="edu-sub-nav">
                        @if(in_array('fee.manage', $permissions))
                        <li><a href="{{ route('fee-heads.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/fee-heads*') ? 'active' : '' }}">Fee Heads</a></li>
                        <li><a href="{{ route('fee-amounts.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/fee-amounts*') ? 'active' : '' }}">Fee Amounts</a></li>
                        <li><a href="{{ route('student-fees.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/fee/student*') ? 'active' : '' }}">Fees Generation</a></li>
                        @endif
                        @if(in_array('fee.collect', $permissions))
                        <li><a href="{{ route('payment.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/payment*') ? 'active' : '' }}">Collect Payment</a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            <li class="edu-nav-category">Communication & Settings</li>
            
            <li class="edu-nav-item">
                <a class="edu-nav-link {{ Request::is('*/notices*') || Request::is('*/sliders*') || Request::is('*/about*') || Request::is('*/footer*') ? 'active' : '' }}" 
                   data-bs-toggle="collapse" href="#webMenu" role="button">
                    <i data-feather="globe"></i>
                    <span>Website Admin</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('*/notices*') || Request::is('*/sliders*') || Request::is('*/about*') || Request::is('*/footer*') ? 'show' : '' }}" id="webMenu">
                    <ul class="edu-sub-nav">
                        @if(in_array('notice.manage', $permissions))
                        <li><a href="{{ route('notices.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/notices*') ? 'active' : '' }}">Notice Board</a></li>
                        @endif
                        @if(in_array('slider.manage', $permissions) || in_array('system.settings', $permissions))
                        <li><a href="{{ route('sliders.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/sliders*') ? 'active' : '' }}">Sliders</a></li>
                        <li><a href="{{ route('about.index', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/about*') ? 'active' : '' }}">About Content</a></li>
                        <li><a href="{{ route('footer.edit', ['tenant' => $tenant]) }}" class="edu-sub-link {{ Request::is('*/footer*') ? 'active' : '' }}">Footer Settings</a></li>
                        @endif
                    </ul>
                </div>
            </li>

            @if(in_array('system.settings', $permissions))
            <li class="edu-nav-item">
                <a href="{{ route('admin.school.info-edit', ['tenant' => $tenant]) }}" class="edu-nav-link {{ Request::is('*/school-info*') ? 'active' : '' }}">
                    <i data-feather="settings"></i>
                    <span>General Settings</span>
                </a>
            </li>
            @endif

            @if($user->hasRole('school_admin'))
            <li class="edu-nav-item">
                <a href="{{ route('school.review.create', ['tenant' => $tenant]) }}" class="edu-nav-link {{ Request::is('*/review*') ? 'active' : '' }}">
                    <i data-feather="star" class="text-warning"></i>
                    <span class="text-warning fw-bold">Submit Review</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</nav>