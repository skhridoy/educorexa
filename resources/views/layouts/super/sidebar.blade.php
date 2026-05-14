@php
    $user = auth()->user();
    $isSuperAdmin = $user->hasRole('super_admin');
    $isFrontendMenuOpen = Request::is('manage/frontend*');
    $isSchoolMenuOpen = Request::is('manage/schools*') || Request::is('*/schools*') || Request::is('manage/professional-emails*');
    $isSystemMenuOpen = Request::is('super-admin/roles*') || Request::is('super-admin/permissions*') || Request::is('settings*');
@endphp

<nav class="sidebar edu-sidebar">

    {{-- ===== BRAND ===== --}}
    <div class="edu-sidebar-header">
        <a href="{{ route('main.home') }}" class="edu-brand">
            <div class="edu-brand-icon">
                {{ strtoupper(substr($setting->site_name ?? 'E', 0, 1)) }}
            </div>
            <div>
                <div class="edu-brand-name">{{ $setting->site_name ?? 'EduCorexa' }}</div>
                <div class="edu-brand-sub">Admin Portal</div>
            </div>
        </a>
        {{-- Mobile Close Button --}}
        <div class="sidebar-toggler not-active d-lg-none ms-auto" style="cursor:pointer; color:var(--text-faint);">
            <i data-feather="x" style="width:20px;height:20px;"></i>
        </div>
    </div>

    {{-- ===== NAV BODY ===== --}}
    <div class="edu-sidebar-body">
        <ul class="edu-nav">

            {{-- MAIN --}}
            <li class="edu-nav-category">Main</li>

            <li class="edu-nav-item">
                <a href="{{ $isSuperAdmin ? route('super.dashboard') : route('employee.dashboard') }}"
                   class="edu-nav-link {{ Request::is('super-admin/dashboard*') || Request::is('employee/dashboard*') ? 'active' : '' }}">
                    <i data-feather="grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- STAFF & HR --}}
            @if($isSuperAdmin)
            <li class="edu-nav-category">Staff &amp; HR</li>

            <li class="edu-nav-item">
                <a class="edu-nav-link edu-has-submenu {{ Request::is('super-admin/employees*') ? 'active' : '' }}"
                   data-bs-toggle="collapse" href="#employeeMenu" role="button"
                   aria-expanded="{{ Request::is('super-admin/employees*') ? 'true' : 'false' }}">
                    <i data-feather="users"></i>
                    <span>Employee Manage</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ Request::is('super-admin/employees*') ? 'show' : '' }}" id="employeeMenu">
                    <ul class="edu-sub-nav">
                        <li><a href="{{ route('super.employees.index') }}"
                               class="edu-sub-link {{ Request::is('super-admin/employees') ? 'active' : '' }}">View Employees</a></li>
                        <li><a href="{{ route('super.employees.create') }}"
                               class="edu-sub-link {{ Request::is('super-admin/employees/create') ? 'active' : '' }}">Add Employee</a></li>
                    </ul>
                </div>
            </li>
            @endif

            {{-- MANAGEMENT --}}
            @can('school.manage')
            <li class="edu-nav-category">Management</li>

            <li class="edu-nav-item">
                <a class="edu-nav-link edu-has-submenu {{ $isSchoolMenuOpen ? 'active' : '' }}"
                   data-bs-toggle="collapse" href="#schoolsMenu" role="button"
                   aria-expanded="{{ $isSchoolMenuOpen ? 'true' : 'false' }}">
                    <i data-feather="home"></i>
                    <span>Manage Schools</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ $isSchoolMenuOpen ? 'show' : '' }}" id="schoolsMenu">
                    <ul class="edu-sub-nav">
                        <li><a href="{{ route('manage.schools.all') }}"
                               class="edu-sub-link {{ Request::is('*/schools/all') ? 'active' : '' }}">All Schools</a></li>
                        <li><a href="{{ route('manage.schools.pending') }}"
                               class="edu-sub-link {{ Request::is('*/schools/pending') ? 'active' : '' }}">Pending Requests</a></li>
                        @can('school.create')
                        <li><a href="{{ route('manage.schools.create') }}"
                               class="edu-sub-link {{ Request::is('*/schools/create') ? 'active' : '' }}">Create School</a></li>
                        @endcan
                        <li><a href="{{ route('manage.pro-email.index') }}"
                               class="edu-sub-link {{ Request::is('manage/professional-emails*') ? 'active' : '' }}">Email Requests</a></li>
                    </ul>
                </div>
            </li>
            @endcan

            {{-- SYSTEM --}}
            @if($isSuperAdmin || $user->can('contact.messages.view'))

                @if($isSuperAdmin && $user->can('super.roles.manage'))
                <li class="edu-nav-item">
                    <a class="edu-nav-link edu-has-submenu {{ $isSystemMenuOpen ? 'active' : '' }}"
                       data-bs-toggle="collapse" href="#roleMenu" role="button"
                       aria-expanded="{{ $isSystemMenuOpen ? 'true' : 'false' }}">
                        <i data-feather="shield"></i>
                        <span>Roles &amp; Permissions</span>
                        <i data-feather="chevron-down" class="edu-arrow"></i>
                    </a>
                    <div class="collapse {{ $isSystemMenuOpen ? 'show' : '' }}" id="roleMenu">
                        <ul class="edu-sub-nav">
                            <li><a href="{{ route('super.roles.index') }}"
                                   class="edu-sub-link {{ Request::is('*/roles*') ? 'active' : '' }}">Manage Roles</a></li>
                            <li><a href="{{ route('super.permissions.index') }}"
                                   class="edu-sub-link {{ Request::is('*/permissions*') ? 'active' : '' }}">Manage Permissions</a></li>
                        </ul>
                    </div>
                </li>
                @endif

                @if($isSuperAdmin)
                <li class="edu-nav-item">
                    <a href="{{ route('super.subscription-packages.index') }}" class="edu-nav-link {{ Request::is('super-admin/subscription-packages*') ? 'active' : '' }}">
                        <i class="fa-solid fa-gem edu-nav-icon"></i>
                        <span>Subscription Packages</span>
                    </a>
                </li>

                {{-- Events --}}
                <li class="edu-nav-item">
                    <a href="{{ route('super.events.index') }}" class="edu-nav-link {{ Request::is('super-admin/events*') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-check edu-nav-icon"></i>
                        <span>Manage Events</span>
                    </a>
                </li>
                <li class="edu-nav-item">
                    <a href="{{ route('super.testimonials.index') }}"
                       class="edu-nav-link {{ Request::is('super-admin/testimonials*') ? 'active' : '' }}">
                        <i data-feather="message-square"></i>
                        <span>Testimonials</span>
                    </a>
                </li>
                @endif

                @can('contact.messages.view')
                <li class="edu-nav-item">
                    <a href="{{ route('manage.contact.index') }}"
                       class="edu-nav-link {{ Request::is('manage/contact*') ? 'active' : '' }}">
                        <i data-feather="phone-call"></i>
                        <span>Call Request</span>
                    </a>
                </li>
                @endcan

                @can('support.manage')
                <li class="edu-nav-item">
                    <a href="{{ route('manage.support.index') }}"
                       class="edu-nav-link {{ Request::is('manage/support-tickets*') ? 'active' : '' }}">
                        <i data-feather="help-circle"></i>
                        <span>Support Tickets</span>
                    </a>
                </li>
                @endcan

            @endif

            {{-- FRONTEND --}}
            @can('frontend.manage')
            <li class="edu-nav-category">Frontend</li>
            <li class="edu-nav-item">
                <a class="edu-nav-link edu-has-submenu {{ $isFrontendMenuOpen ? 'active' : '' }}"
                   data-bs-toggle="collapse" href="#frontendMenu" role="button"
                   aria-expanded="{{ $isFrontendMenuOpen ? 'true' : 'false' }}">
                    <i data-feather="layout"></i>
                    <span>Landing Page</span>
                    <i data-feather="chevron-down" class="edu-arrow"></i>
                </a>
                <div class="collapse {{ $isFrontendMenuOpen ? 'show' : '' }}" id="frontendMenu">
                    <ul class="edu-sub-nav">
                        <li><a href="{{ route('manage.frontend.index') }}"
                               class="edu-sub-link {{ Request::is('manage/frontend/manage-sections') ? 'active' : '' }}">Manage Sections</a></li>
                    </ul>
                </div>
            </li>

            @endcan
            
            @can('settings.manage')
                <li class="edu-nav-item">
                    <a href="{{ route('settings.edit') }}"
                       class="edu-nav-link {{ Request::is('settings') ? 'active' : '' }}">
                        <i data-feather="settings"></i>
                        <span>Site Settings</span>
                    </a>
                </li>
                <li class="edu-nav-item">
                    <a href="{{ route('settings.api') }}"
                       class="edu-nav-link {{ Request::is('api-setup') ? 'active' : '' }}">
                        <i data-feather="link"></i>
                        <span>API Setup</span>
                    </a>
                </li>
            @endcan

            {{-- USER --}}
            <li class="edu-nav-category">Account</li>
            <li class="edu-nav-item">
                <a href="{{ route('profile') }}"
                   class="edu-nav-link {{ Request::is('profile*') ? 'active' : '' }}">
                    <i data-feather="user"></i>
                    <span>My Profile</span>
                </a>
            </li>

        </ul>
    </div>

</nav>