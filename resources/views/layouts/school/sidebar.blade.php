<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('school.home', ['tenant' => auth()->user()->school->slug]) }}" class="sidebar-brand text-capitalize">
            {{ auth()->user()->school->slug }}
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
                    $tenant = $user->school->slug;
                    
                    // ড্যাশবোর্ড রাউট সিলেকশন
                    $dashboardRoute = match($user->role) {
                        'student' => route('student.dashboard', ['tenant' => $tenant]),
                        'teacher' => route('teacher.dashboard', ['tenant' => $tenant]),
                        'school_admin' => route('school.dashboard', ['tenant' =>  $tenant]),
                    };
                @endphp

                <a href="{{ $dashboardRoute }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            
            @php
                $permissions = auth()->user()->getAllPermissions()->pluck('name')->toArray();
            @endphp

            <li class="nav-item nav-category">School Management</li>

            @if(in_array('academic-year.manage', $permissions) || in_array('class.manage', $permissions) || in_array('section.manage', $permissions))
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
                            <a href="{{ route('academic-year.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Academic Years</a>
                        </li>
                        @endif
                        @if(in_array('category.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('categories.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">
                                <span class="nav-link">Categories</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sub-categories.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">
                                <span class="nav-link">Sub Categories</span>
                            </a>
                        </li>
                        @endif
                        @if(in_array('class.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('classes.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Classes</a>
                        </li>
                        @endif
                        @if(in_array('section.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('sections.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Sections</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif


            @if(in_array('admission.manage', $permissions))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#admissionMenu" role="button">
                    <i class="link-icon" data-feather="user-plus"></i>
                    <span class="link-title">Manage Admissions</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="admissionMenu">
                    <ul class="nav sub-menu mx-3">
                        <li class="nav-item">
                            <a href="{{ route('admissions.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Admissions</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            
            @if(in_array('teacher.manage', $permissions))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#teacherMenu" role="button">
                    <i class="link-icon" data-feather="user-check"></i>
                    <span class="link-title">Teacher Module</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="teacherMenu">
                    <ul class="nav sub-menu mx-3">
                        <li class="nav-item">
                            <a href="{{ route('teachers.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Teachers</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('teachers.create', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Add Teacher</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @if(in_array('subject.manage', $permissions) || in_array('assign.subject', $permissions) || in_array('assign.teacher', $permissions))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#subjectAssignMenu" role="button">
                    <i class="link-icon" data-feather="book-open"></i>
                    <span class="link-title">Subjects & Assign</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="subjectAssignMenu">
                    <ul class="nav sub-menu mx-3">
                        @if(in_array('subject.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('subjects.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Subjects</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('subjects.assign', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Assign Class</a>
                        </li>
                        @endif
                        @if(in_array('assign.teacher', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('teacher.assign', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Assign Teacher</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            @if(in_array('student.manage', $permissions))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#studentMenu" role="button">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Student Module</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="studentMenu">
                    <ul class="nav sub-menu mx-3">
                        <li class="nav-item">
                            <a href="{{ route('students.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Students</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('students.create', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Add Student</a>
                        </li>
                        {{-- শুধুমাত্র এডমিন দেখতে পারবে --}}
                        @if(auth()->user()->hasRole('school_admin') || in_array('student.idcard', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('students.idcard.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Generate ID Cards</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- Attendance Management Section --}}
            @if(in_array('attendance.manage', $permissions) || in_array('attendance.report', $permissions))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#attendanceMenu" role="button">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Attendance</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="attendanceMenu">
                    <ul class="nav sub-menu mx-3">
                        {{-- শুধু শিক্ষক বা যার হাজিরা নেওয়ার অনুমতি আছে সে দেখবে --}}
                        @if(in_array('attendance.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('attendances.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Take Attendance</a>
                        </li>
                        @endif

                        {{-- শুধু অ্যাডমিন বা যার রিপোর্ট দেখার অনুমতি আছে সে দেখবে --}}
                        @if(in_array('attendance.report', $permissions) || auth()->user()->hasRole('school_admin'))
                        <li class="nav-item">
                            <a href="{{ route('student.attendance.report', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Attendance Report</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif

            {{-- Digital Diary Management --}}
            @if(auth()->user()->can('lesson.view') || auth()->user()->hasRole('student'))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#diaryMenu" role="button">
                    <i class="link-icon" data-feather="book"></i>
                    <span class="link-title">Digital Diary</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ Request::is('*/diary*') ? 'show' : '' }}" id="diaryMenu">
                    <ul class="nav sub-menu mx-3">
                        {{-- টিচারদের জন্য --}}
                        @can('lesson.manage')
                        <li class="nav-item">
                            <a href="{{ route('diary.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Daily Entry</a>
                        </li>
                        @endcan

                        {{-- স্টুডেন্টদের জন্য --}}
                        <li class="nav-item">
                            <a href="{{ route('diary.student_view', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Daily Diary</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            @if(in_array('exam.manage', $permissions))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#examMenu" role="button">
                    <i class="link-icon" data-feather="edit"></i>
                    <span class="link-title">Exams Module</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="examMenu">
                    <ul class="nav sub-menu mx-3">
                        <li class="nav-item">
                            <a href="{{ route('exams.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Exams</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('exams.admit-card', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Admit Cards</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @can('mark.manage')
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#markMenu" role="button">
                    <i class="link-icon" data-feather="edit-3"></i>
                    <span class="link-title">Marks Module</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="markMenu">
                    <ul class="nav sub-menu mx-3">
                        <li class="nav-item">
                            <a href="{{ route('marks.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Marks Entry</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('marks.view-marks', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Marks View</a>
                        </li>
                        {{-- শুধুমাত্র এডমিন দেখতে পারবে --}}
                        @if(auth()->user()->hasRole('school_admin') || in_array('student.promotion', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('students.promotion', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Promotion</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endcan

            @if(in_array('fee.manage', $permissions) || in_array('fee.collect', $permissions))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#feeMenu" role="button">
                    <i class="link-icon" data-feather="dollar-sign"></i>
                    <span class="link-title">Fees Module</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="feeMenu">
                    <ul class="nav sub-menu mx-3">
                        @if(in_array('fee.manage', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('fee-heads.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Fee Head</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('fee-amounts.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Fee Amount</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('student-fees.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Student Fees</a>
                        </li>
                        @endif
                        @if(in_array('fee.collect', $permissions))
                        <li class="nav-item">
                            <a href="{{ route('payment.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link fw-bold">Payment Collect</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif
            
            @if(in_array('notice.manage', $permissions))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#noticeMenu" role="button">
                    <i class="link-icon" data-feather="bell"></i>
                    <span class="link-title">Notice Manage</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="noticeMenu">
                    <ul class="nav sub-menu mx-3">
                        <li class="nav-item">
                            <a href="{{ route('notices.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Notices</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @if(in_array('newsletter.manage', $permissions))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#subscriberMenu" role="button">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Newsletter</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="subscriberMenu">
                    <ul class="nav sub-menu mx-3">
                        <li class="nav-item">
                            <a href="{{ route('admin.newsletter.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Subscribers</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.newsletter.send', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Send Email</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @if(in_array('system.settings', $permissions))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#settingMenu" role="button">
                    <i class="link-icon" data-feather="settings"></i>
                    <span class="link-title">Settings</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="settingMenu">
                    <ul class="nav sub-menu mx-3">
                        <li class="nav-item"><a href="{{ route('admin.school.info-edit', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">General Setting</a></li>
                        <li class="nav-item"><a href="{{ route('sliders.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Slider Manage</a></li>
                        <li class="nav-item"><a href="{{ route('about.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">About Manage</a></li>
                        <li class="nav-item"><a href="{{ route('overview.index', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Overview Manage</a></li>
                        <li class="nav-item"><a href="{{ route('footer.edit', ['tenant' => auth()->user()->school->slug]) }}" class="nav-link">Footer Manage</a></li>
                    </ul>
                </div>
            </li>
            @endif
        </ul>
    </div>
</nav>