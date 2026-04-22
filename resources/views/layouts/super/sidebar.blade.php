<nav class="sidebar">
  <div class="sidebar-header">
    <a href="{{ route('main.home') }}" class="sidebar-brand">
        {{-- ডাটাবেজ থেকে ডায়নামিক লোগো চেক --}}
        @if(!empty($setting->logo_wide))
            <img src="{{ asset($setting->logo_wide) }}" alt="logo" style="height: 30px; margin-right: 8px;">
        @else
            {{-- লোগো না থাকলে ডিফল্ট আইকন বা শুধু টেক্সট --}}
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
      <li class="nav-item {{ Request::is('super/dashboard*') ? 'active' : '' }}">
        <a href="{{ route('super.dashboard') }}" class="nav-link">
          <i class="link-icon" data-feather="grid"></i>
          <span class="link-title">Dashboard</span>
        </a>
      </li>

      {{-- Staff & HR Section --}}
      @if(auth()->user()->can('employee.index') || auth()->user()->can('employee.manage'))
      <li class="nav-item nav-category">Staff & HR</li>
      <li class="nav-item {{ Request::is('super/employees*') ? 'active' : '' }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#employeeMenu" role="button" 
           aria-expanded="{{ Request::is('super/employees*') ? 'true' : 'false' }}">
          <i class="link-icon" data-feather="users"></i>
          <span class="link-title">Employee Manage</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ Request::is('super/employees*') ? 'show' : '' }}" id="employeeMenu">
          <ul class="nav sub-menu">
            @can('employee.index')
            <li class="nav-item">
              <a href="{{ route('super.employees.index') }}" class="nav-link {{ Request::is('super/employees') ? 'active' : '' }}">View Employees</a>
            </li>
            @endcan
            
            @can('employee.create')
            <li class="nav-item">
              <a href="{{ route('super.employees.create') }}" class="nav-link {{ Request::is('super/employees/create') ? 'active' : '' }}">Add Employee</a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endif

      {{-- Super Admin Access Section --}}
      <li class="nav-item nav-category">Super Admin Access</li>

      @can('school.manage')
      <li class="nav-item {{ Request::is('super/schools*') ? 'active' : '' }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#schoolsMenu" role="button">
          <i class="link-icon" data-feather="home"></i>
          <span class="link-title">Manage Schools</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ Request::is('super/schools*') ? 'show' : '' }}" id="schoolsMenu">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('super.schools.all') }}" class="nav-link {{ Request::is('super/schools/all') ? 'active' : '' }}">All Schools</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('super.schools.pending') }}" class="nav-link {{ Request::is('super/schools/pending') ? 'active' : '' }}">Pending Requests</a>
            </li>
          </ul>
        </div>
      </li>
      @endcan

      @can('super.roles.manage')
      <li class="nav-item {{ Request::is('super/roles*') || Request::is('super/permissions*') ? 'active' : '' }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#roleMenu" role="button">
          <i class="link-icon" data-feather="shield"></i>
          <span class="link-title">Roles & Permissions</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ Request::is('super/roles*') || Request::is('super/permissions*') ? 'show' : '' }}" id="roleMenu">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('super.roles.index') }}" class="nav-link {{ Request::is('super/roles*') ? 'active' : '' }}">Manage Roles</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('super.permissions.index') }}" class="nav-link {{ Request::is('super/permissions*') ? 'active' : '' }}">Manage Permissions</a>
            </li>
          </ul>
        </div>
      </li>
      @endcan

      @can('super.settings.manage')
      <li class="nav-item {{ Request::is('super/settings*') ? 'active' : '' }}">
        <a href="{{ route('super.settings.edit') }}" class="nav-link">
          <i class="link-icon" data-feather="settings"></i>
          <span class="link-title">System Settings</span>
        </a>
      </li>
      @endcan
      
    </ul>
  </div>
</nav>