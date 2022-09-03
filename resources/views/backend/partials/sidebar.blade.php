<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        {{-- <img src="" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        <span class="brand-text font-weight-light">{{@config('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/backend/dist/img/avatar.png') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link {{ Request::is('dashboard') ? 'active' : null }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @role('admin')
                    <li class="nav-item">
                        <a href="{{route('roles.index')}}" class="nav-link {{ request()->is('admin/roles*') ? 'active' : null }}">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>
                                Role Management
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('users.index')}}" class="nav-link {{ request()->is('admin/users*') ? 'active' : null }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                User Management
                            </p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('') ? 'menu-open' : null }}">
                        <a href="#" class="nav-link {{ request()->is('') ? 'active' : null }}">
                          <i class="nav-icon fas fa-briefcase"></i>
                          <p>
                            Menu
                            <i class="right fas fa-angle-left"></i>
                          </p>
                        </a>
                        <ul class="nav nav-treeview">
                          <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('') ? 'active' : null }}">
                              <i class="fas fa-list nav-icon"></i>
                              <p>Sub Menu</p>
                            </a>
                          </li>
                        </ul>
                      </li>
                @endrole
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
