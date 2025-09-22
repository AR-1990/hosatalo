<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ route('admin.dashboard') }}"> 
        <img alt="image" src="{{ asset('assets-admin/img/logo.png') }}" class="header-logo" /> 
        <span class="logo-name">Hostalo Admin</span>
      </a>
    </div>
    <ul class="sidebar-menu">
             <li class="dropdown {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
         <a href="{{ route('admin.dashboard') }}" class="nav-link">
           <i data-feather="monitor"></i><span>Dashboard</span>
         </a>
       </li>
       
       <li class="dropdown {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">
         <a href="#" class="menu-toggle nav-link has-dropdown">
           <i data-feather="user-plus"></i><span>Lead Management</span>
         </a>
         <ul class="dropdown-menu">
           <li><a class="nav-link" href="{{ route('admin.leads.index') }}">All Leads</a></li>
           <li><a class="nav-link" href="{{ route('admin.leads.create') }}">Add New Lead</a></li>
         </ul>
       </li>
       
       <li class="dropdown {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
         <a href="#" class="menu-toggle nav-link has-dropdown">
           <i data-feather="users"></i><span>Client Management</span>
         </a>
         <ul class="dropdown-menu">
           <li><a class="nav-link" href="{{ route('admin.clients.index') }}">All Clients</a></li>
           <li><a class="nav-link" href="{{ route('admin.clients.create') }}">Add New Client</a></li>
         </ul>
       </li>
      
      {{-- @if(Auth::check() && Auth::user()->role === 'client') --}}
      {{-- <li class="dropdown {{ request()->routeIs('admin.client.rooms.*') ? 'active' : '' }}">
        <a href="#" class="menu-toggle nav-link has-dropdown">
          <i data-feather="bed"></i><span>My Hostel Rooms</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{ route('admin.client.rooms') }}">My Rooms</a></li>
          <li><a class="nav-link" href="{{ route('admin.client.rooms.create') }}">Add New Room</a></li>
        </ul>
      </li> --}}
      {{-- @endif
      
      @if(Auth::check() && Auth::user()->role === 'admin') --}}
      <li class="dropdown {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
        <a href="#" class="menu-toggle nav-link has-dropdown">
          <i data-feather="home"></i><span>All Hostel Rooms</span>
        </a>
        <ul class="dropdown-menu">
                      <li><a class="nav-link" href="{{ route('admin.rooms.index') }}">All Rooms</a></li>
          <li><a class="nav-link" href="{{ route('admin.rooms.create') }}">Add New Room</a></li>
        </ul>
      </li>
      {{-- @endif --}}
      
             <li class="dropdown {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
         <a href="#" class="menu-toggle nav-link has-dropdown">
           <i data-feather="calendar"></i><span>Bookings</span>
         </a>
         <ul class="dropdown-menu">
           <li><a class="nav-link" href="{{ route('admin.bookings.index') }}">All Bookings</a></li>
           <li><a class="nav-link" href="{{ route('admin.bookings.report') }}">Booking Reports</a></li>
         </ul>
       </li>
       
       <li class="dropdown {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
         <a href="#" class="menu-toggle nav-link has-dropdown">
           <i data-feather="credit-card"></i><span>Payments</span>
         </a>
         <ul class="dropdown-menu">
           <li><a class="nav-link" href="{{ route('admin.payments.index') }}">All Payments</a></li>
           <li><a class="nav-link" href="{{ route('admin.payments.report') }}">Payment Reports</a></li>
         </ul>
       </li>
      

      
             <li class="dropdown">
         <a href="#" class="menu-toggle nav-link has-dropdown">
           <i data-feather="user-check"></i><span>Users</span>
         </a>
         <ul class="dropdown-menu">
           <li><a class="nav-link" href="#">All Users</a></li>
           <li><a class="nav-link" href="#">User Roles</a></li>
         </ul>
       </li>
       
       <li class="dropdown">
         <a href="#" class="menu-toggle nav-link has-dropdown">
           <i data-feather="bar-chart-2"></i><span>Reports</span>
         </a>
         <ul class="dropdown-menu">
           <li><a class="nav-link" href="{{ route('admin.bookings.report') }}">Booking Reports</a></li>
           <li><a class="nav-link" href="{{ route('admin.payments.report') }}">Payment Reports</a></li>
           <li><a class="nav-link" href="#">Revenue Reports</a></li>
           <li><a class="nav-link" href="#">Client Reports</a></li>
         </ul>
       </li>
       
       <li class="dropdown">
         <a href="#" class="menu-toggle nav-link has-dropdown">
           <i data-feather="settings"></i><span>System</span>
         </a>
         <ul class="dropdown-menu">
           <li><a class="nav-link" href="#">General Settings</a></li>
           <li><a class="nav-link" href="#">Email Settings</a></li>
           <li><a class="nav-link" href="#">Backup & Restore</a></li>
         </ul>
       </li>
       
       <li class="dropdown">
         <a href="#" class="menu-toggle nav-link has-dropdown">
           <i data-feather="user"></i><span>Profile</span>
         </a>
         <ul class="dropdown-menu">
           <li><a class="nav-link" href="#">My Profile</a></li>
           <li><a class="nav-link" href="#">Change Password</a></li>
           <li><hr class="dropdown-divider"></li>
           <li>
             <form method="POST" action="{{ route('logout') }}" class="d-inline">
               @csrf
               <button type="submit" class="dropdown-item">
                 <i data-feather="log-out"></i> Logout
               </button>
             </form>
           </li>
         </ul>
       </li>
    </ul>
  </aside>
</div>
