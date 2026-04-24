    
@php
    $user = auth()->user();
    $isSuperAdmin = $user->hasRole('super_admin');
    
    // রাউট ফাইল অনুযায়ী স্কুলের সব রাউট 'manage.' দিয়ে শুরু
    $schoolRoutePrefix = 'manage.'; 
    
    // Active Class এর জন্য URL প্যাটার্ন চেক
    $isSchoolMenuOpen = Request::is('manage/schools*') || Request::is('*/schools*');
    $isSystemMenuOpen = Request::is('super-admin/roles*') || Request::is('super-admin/permissions*') || Request::is('settings*');
@endphp

<nav class="sidebar">
  <div class="sidebar-header">
    <a href="{{ route('main.home') }}" class="sidebar-brand">
        @if(!empty($setting->logo_wide))
            <img src="{{ asset($setting->logo_wide) }}" alt="logo" style="height: 30px; margin-right: 8px;">
        @else
            <i class="link-icon" data-feather="box" style="width: 25px; margin-right: 5px;"></i>
            <span class="text-capitalize" style="font-weight: 700; font-size: 1.1rem;">
                {{ $setting->site_name ?? 'EduCorexa' }}
            </span>
        @endif
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
      
      {{-- Dashboard Link (Role Based Redirect) --}}
      <li class="nav-item {{ Request::is('super-admin/dashboard*') || Request::is('employee/dashboard*') ? 'active' : '' }}">
        <a href="{{ $isSuperAdmin ? route('super.dashboard') : route('employee.dashboard') }}" class="nav-link">
          <i class="link-icon" data-feather="grid"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>

      {{-- Staff & HR Section (Only for Super Admin who can manage employees) --}}
      @if($isSuperAdmin)
      <li class="nav-item nav-category">Staff & HR</li>
      <li class="nav-item {{ Request::is('super-admin/employees*') ? 'active' : '' }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#employeeMenu" role="button" aria-expanded="{{ Request::is('super-admin/employees*') ? 'true' : 'false' }}">
          <i class="link-icon" data-feather="users"></i>
          <span class="link-title">Employee Manage</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ Request::is('super-admin/employees*') ? 'show' : '' }}" id="employeeMenu">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('super.employees.index') }}" class="nav-link {{ Request::is('super-admin/employees') ? 'active' : '' }}">View Employees</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('super.employees.create') }}" class="nav-link {{ Request::is('super-admin/employees/create') ? 'active' : '' }}">Add Employee</a>
            </li>
          </ul>
        </div>
      </li>
      @endif

      {{-- Schools Management (Shared based on permission: school.manage) --}}
      @can('school.manage')
      <li class="nav-item nav-category">Management</li>
      <li class="nav-item {{ $isSchoolMenuOpen ? 'active' : '' }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#schoolsMenu" role="button" aria-expanded="{{ $isSchoolMenuOpen ? 'true' : 'false' }}">
          <i class="link-icon" data-feather="home"></i>
          <span class="link-title">Manage Schools</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ $isSchoolMenuOpen ? 'show' : '' }}" id="schoolsMenu">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('manage.schools.all') }}" class="nav-link {{ Request::is('*/schools/all') ? 'active' : '' }}">All Schools</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('manage.schools.pending') }}" class="nav-link {{ Request::is('*/schools/pending') ? 'active' : '' }}">Pending Requests</a>
            </li>
            
            {{-- স্কুল তৈরি করার পারমিশন চেক --}}
            @can('school.create')
            <li class="nav-item">
              <a href="{{ route('manage.schools.create') }}" class="nav-link {{ Request::is('*/schools/create') ? 'active' : '' }}">Create School</a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endcan

      {{-- System & Settings Section --}}
      @if($isSuperAdmin || $user->can('settings.manage'))
          {{-- Roles & Permissions (Only Super Admin) --}}
          @if($isSuperAdmin && $user->can('super.roles.manage'))
          <li class="nav-item {{ Request::is('super-admin/roles*') || Request::is('super-admin/permissions*') ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#roleMenu" role="button">
              <i class="link-icon" data-feather="shield"></i>
              <span class="link-title">Roles & Permissions</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse {{ Request::is('super-admin/roles*') || Request::is('super-admin/permissions*') ? 'show' : '' }}" id="roleMenu">
              <ul class="nav sub-menu">
                <li class="nav-item"><a href="{{ route('super.roles.index') }}" class="nav-link {{ Request::is('*/roles*') ? 'active' : '' }}">Manage Roles</a></li>
                <li class="nav-item"><a href="{{ route('super.permissions.index') }}" class="nav-link {{ Request::is('*/permissions*') ? 'active' : '' }}">Manage Permissions</a></li>
              </ul>
            </div>
          </li>
          @endif

          {{-- System Settings (Based on settings.manage permission) --}}
          @can('settings.manage')
          <li class="nav-item {{ Request::is('settings*') ? 'active' : '' }}">
            <a href="{{ route('settings.edit') }}" class="nav-link">
              <i class="link-icon" data-feather="settings"></i>
              <span class="link-title">System Settings</span>
            </a>
          </li>
          @endcan
      @endif

      {{-- Profile (For everyone) --}}
      <li class="nav-item nav-category">User</li>
      <li class="nav-item {{ Request::is('profile*') ? 'active' : '' }}">
        <a href="{{ route('profile') }}" class="nav-link">
          <i class="link-icon" data-feather="user"></i>
          <span class="link-title">My Profile</span>
        </a>
      </li>
      
    </ul>
  </div>
</nav>