<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/home" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <img src="{{asset('/img/profile/'.Auth::user()->image)}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
            <a href="#" class="d-block">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item"><a href="/home" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
                <li class="nav-item"><a href="/hr/profile" class="nav-link"><i class="nav-icon fas fa-user"></i><p>Profile</p></a></li>
                <li class="nav-item"><a href="/hr/users" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Users</p></a></li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="nav-icon fas fa-laptop"></i><p>Inventory <i class="right fas fa-angle-left"></i></p></a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/inventory/devices" class="nav-link"><i class="far fa-circle nav-icon"></i><p>All Devices</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="/inventory/device/new" class="nav-link"><i class="far fa-circle nav-icon"></i><p>New Devices</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="/inventory/device/damaged" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Damaged Devices</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="/inventory/device/repaired" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Repaired Devices</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="/inventory/device/due" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Maintenance Due Devices</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="/inventory/device/sold" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Sold Devices</p></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="nav-icon fas fa-user-cog"></i><p>Administrator <i class="right fas fa-angle-left"></i></p></a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <router-link to="/admin/departments" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Departments</p></router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/admin/branches" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Branches</p></router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/admin/logs" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Logs/Activities</p></router-link>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>