<nav class="sidebar">
  <div class="sidebar-header">
    <a href="{{ route('super.dashboard') }}" class="sidebar-brand">
      Edu<span>Corexa</span>
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

      <li class="nav-item nav-category">SaaS Management</li>
      <li class="nav-item {{ Request::is('super/schools*') ? 'active' : '' }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#schoolsMenu" role="button" 
           aria-expanded="{{ Request::is('super/schools*') ? 'true' : 'false' }}" aria-controls="schoolsMenu">
          <i class="link-icon" data-feather="home"></i>
          <span class="link-title">Schools Manage</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ Request::is('super/schools*') ? 'show' : '' }}" id="schoolsMenu">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ route('super.schools.all') }}" class="nav-link {{ Request::is('super/schools/all') ? 'active' : '' }}">All Schools</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('super.schools.pending') }}" class="nav-link {{ Request::is('super/schools/pending') ? 'active' : '' }}">
                Pending Requests 
                <span class="badge bg-warning ms-auto" style="font-size: 10px;">New</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('super.schools.create') }}" class="nav-link {{ Request::is('super/schools/create') ? 'active' : '' }}">Add New School</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('super.schools.rejected') }}" class="nav-link {{ Request::is('super/schools/rejected') ? 'active' : '' }}">Rejected List</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="link-icon" data-feather="package"></i>
          <span class="link-title">Subscription Plans</span>
        </a>
      </li>

      <li class="nav-item nav-category">Access Control</li>
      <li class="nav-item {{ Request::is('super/roles*') ? 'active' : '' }}">
        <a href="{{ route('super.roles.index') }}" class="nav-link">
          <i class="link-icon" data-feather="key"></i>
          <span class="link-title">Manage Roles</span>
        </a>
      </li>
      <li class="nav-item {{ Request::is('super/permissions*') ? 'active' : '' }}">
        <a href="{{ route('super.permissions.index') }}" class="nav-link">
          <i class="link-icon" data-feather="shield"></i>
          <span class="link-title">Manage Permissions</span>
        </a>
      </li>

      <li class="nav-item nav-category">System Configuration</li>
      <li class="nav-item {{ Request::is('super/settings*') ? 'active' : '' }}">
        <a href="{{ route('super.settings.edit') }}" class="nav-link">
          <i class="link-icon" data-feather="settings"></i>
          <span class="link-title">System Settings</span>
        </a>
      </li>
      
    </ul>
  </div>
</nav>