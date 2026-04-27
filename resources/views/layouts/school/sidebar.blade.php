<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('school.home') }}" class="sidebar-brand text-capitalize">
            {{ $currentSchool->slug }}
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                @php
                    $user = auth()->user();
                    // ১. ইউজার থেকে না নিয়ে সরাসরি মিডলওয়্যার থেকে আসা $currentSchool ব্যবহার করা হয়েছে 
                    $tenant = $currentSchool->slug; 
                    $permissions = $user->getAllPermissions()->pluck('name')->toArray();
                    
                    // ২. URL::defaults সেট করা থাকায় ['tenant' => $tenant] আর লিখতে হবে না
                    $dashboardRoute = match($user->role) { // লক্ষ্য করুন: আমি role_type ব্যবহার করেছি
                        'student' => route('student.dashboard'),
                        'teacher' => route('teacher.dashboard'),
                        'school_admin', 'school_staff' => route('school.dashboard'),
                        default => '#'
                    };
                @endphp

                <a href="{{ $dashboardRoute }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item nav-category">School Management</li>

            {{-- 1. Academic --}}
            @if(count(array_intersect(['academic-year.manage', 'category.manage', 'sub-category.manage', 'class.manage', 'section.manage', 'subject.manage', 'assign.subject'], $permissions)) > 0)
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#academicMenu" role="button">
                    <i class="link-icon" data-feather="layers"></i>
                    <span class="link-title">Academic</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="academicMenu">
                    <ul class="nav sub-menu mx-3">
                        @if(in_array('academic-year.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('academic-year.index', ['tenant' => $tenant]) }}" class="nav-link">Academic Years</a>
                        </li>
                        @endif
                        @if(in_array('category.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('categories.index', ['tenant' => $tenant]) }}" class="nav-link">Categories</a>
                        </li>
                        @endif
                        @if(in_array('sub-category.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('sub-categories.index', ['tenant' => $tenant]) }}" class="nav-link">Sub Categories</a>
                        </li>
                        @endif
                        @if(in_array('class.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('classes.index', ['tenant' => $tenant]) }}" class="nav-link">Classes</a>
                        </li>
                        @endif
                        @if(in_array('section.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('sections.index', ['tenant' => $tenant]) }}" class="nav-link">Sections</a>
                        </li>
                        @endif
                        @if(in_array('subject.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('subjects.index', ['tenant' => $tenant]) }}" class="nav-link">Subjects</a>
                        </li>
                        @endif
                        @if(in_array('assign.subject', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('subjects.assign', ['tenant' => $tenant]) }}" class="nav-link">Assign Subject</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- 2. Students & Admissions --}}
            @if(in_array('admission.manage', $permissions) || in_array('student.manage', $permissions))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#studentMenu" role="button">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Students Module</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="studentMenu">
                    <ul class="nav sub-menu mx-3">
                        @if(in_array('admission.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('admissions.index', ['tenant' => $tenant]) }}" class="nav-link">Admissions</a>
                        </li>
                        @endif
                        @if(in_array('student.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('students.index', ['tenant' => $tenant]) }}" class="nav-link">Student List</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('students.create', ['tenant' => $tenant]) }}" class="nav-link">Add Student</a>
                        </li>
                        @endif
                        @if(in_array('student.idcard', $permissions) || $user->hasRole('school_admin'))
                        <li class="nav-item">
                            <a href="{{ route('students.idcard.index', ['tenant' => $tenant]) }}" class="nav-link">Generate ID Cards</a>
                        </li>
                        @endif
                        @if(in_array('student.promotion', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('students.promotion', ['tenant' => $tenant]) }}" class="nav-link">Promotion</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- 3. Staff & HR --}}
            @if(in_array('teacher.manage', $permissions) || in_array('assign.teacher', $permissions))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#teacherMenu" role="button">
                    <i class="link-icon" data-feather="user-check"></i>
                    <span class="link-title">Staff & HR</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="teacherMenu">
                    <ul class="nav sub-menu mx-3">
                        @if(in_array('teacher.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('teachers.index', ['tenant' => $tenant]) }}" class="nav-link">Teachers</a>
                        </li>
                        @endif
                        @if(in_array('assign.teacher', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('teacher.assign', ['tenant' => $tenant]) }}" class="nav-link">Assign Teacher</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- 4. Attendance & Exams --}}
            @if(count(array_intersect(['attendance.manage', 'attendance.report', 'holiday.manage', 'exam.manage', 'mark.manage'], $permissions)) > 0)
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#attendanceExamMenu" role="button">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Attendance & Exams</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="attendanceExamMenu">
                    <ul class="nav sub-menu mx-3">
                        @if(in_array('attendance.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('attendances.index', ['tenant' => $tenant]) }}" class="nav-link">Take Attendance</a>
                        </li>
                        @endif
                        @if(in_array('attendance.report', $permissions) || $user->hasRole('school_admin'))
                        <li class="nav-item">
                            <a href="{{ route('student.attendance.report', ['tenant' => $tenant]) }}" class="nav-link">Attendance Report</a>
                        </li>
                        @endif
                        @if(in_array('holiday.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('holidays.index', ['tenant' => $tenant]) }}" class="nav-link">Holiday Setup</a>
                        </li>
                        @endif
                        @if(in_array('exam.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('exams.index', ['tenant' => $tenant]) }}" class="nav-link">Manage Exams</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('exams.admit-card', ['tenant' => $tenant]) }}" class="nav-link">Admit Cards</a>
                        </li>
                        @endif
                        @if(in_array('mark.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('marks.index', ['tenant' => $tenant]) }}" class="nav-link">Marks Entry</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('marks.view-marks', ['tenant' => $tenant]) }}" class="nav-link">View Results</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- 5. Digital Diary --}}
            @if($user->can('lesson.view') || $user->hasRole('student'))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#diaryMenu" role="button">
                    <i class="link-icon" data-feather="book"></i>
                    <span class="link-title">Digital Diary</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="diaryMenu">
                    <ul class="nav sub-menu mx-3">
                        @can('lesson.manage')
                        <li class="nav-item">
                            <a href="{{ route('diary.index', ['tenant' => $tenant]) }}" class="nav-link">Daily Entry</a>
                        </li>
                        @endcan
                        <li class="nav-item">
                            <a href="{{ route('diary.student_view', ['tenant' => $tenant]) }}" class="nav-link">View Diary</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            {{-- 6. Finance (Fees) --}}
            @if(in_array('fee.manage', $permissions) || in_array('fee.collect', $permissions))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#feeMenu" role="button">
                    <i class="link-icon" data-feather="dollar-sign"></i>
                    <span class="link-title">Finance (Fees)</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="feeMenu">
                    <ul class="nav sub-menu mx-3">
                        @if(in_array('fee.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('fee-heads.index', ['tenant' => $tenant]) }}" class="nav-link">Fee Heads</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('fee-amounts.index', ['tenant' => $tenant]) }}" class="nav-link">Fee Amounts</a>
                        </li>
                        @endif
                        @if(in_array('fee.collect', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('payment.index', ['tenant' => $tenant]) }}" class="nav-link fw-bold">Collect Payment</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- 7. Website & Communication --}}
            @if(count(array_intersect(['notice.manage', 'newsletter.manage', 'slider.manage', 'system.settings'], $permissions)) > 0)
            <li class="nav-item nav-category">Communication & Settings</li>
            
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#webMenu" role="button">
                    <i class="link-icon" data-feather="globe"></i>
                    <span class="link-title">Website Admin</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="webMenu">
                    <ul class="nav sub-menu mx-3">
                        @if(in_array('notice.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('notices.index', ['tenant' => $tenant]) }}" class="nav-link">Notice Board</a>
                        </li>
                        @endif
                        @if(in_array('slider.manage', $permissions) || in_array('system.settings', $permissions))
                        <li class="nav-item"><a href="{{ route('sliders.index', ['tenant' => $tenant]) }}" class="nav-link">Sliders</a></li>
                        <li class="nav-item"><a href="{{ route('about.index', ['tenant' => $tenant]) }}" class="nav-link">About Content</a></li>
                        <li class="nav-item"><a href="{{ route('footer.edit', ['tenant' => $tenant]) }}" class="nav-link">Footer Settings</a></li>
                        @endif
                        @if(in_array('newsletter.manage', $permissions))
                        <li class="nav-item"><a href="{{ route('admin.newsletter.index', ['tenant' => $tenant]) }}" class="nav-link">Subscribers</a></li>
                        <li class="nav-item"><a href="{{ route('admin.message.index', ['tenant' => $tenant]) }}" class="nav-link">Messages</a></li>
                        @endif
                    </ul>
                </div>
            </li>

            @if(in_array('system.settings', $permissions))
            <li class="nav-item">
                <a href="{{ route('admin.school.info-edit', ['tenant' => $tenant]) }}" class="nav-link">
                    <i class="link-icon" data-feather="settings"></i>
                    <span class="link-title">General Settings</span>
                </a>
            </li>
            @endif
            @endif
        </ul>
    </div>
</nav>