<nav class="main-header navbar navbar-expand navbar-white navbar-light" @role('user')style="margin-left:0" @endrole>
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        @role('admin')
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        @endrole
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/') }}" class="nav-link">Home</a>
        </li>
        @role('user')
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('point.log', [encrypt(Auth::user()->id)]) }}" class="nav-link"> <i
                        class="nav-icon fas fa-solid fa-coins"></i> Points Log</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('ticket.log') }}" class="nav-link"> <i class="nav-icon fas fa-tachometer-alt"></i> Log</a>
            </li>
        @endrole
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" v-pre>
                {{ auth()->user()->name }} <span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                {{-- <a class="dropdown-item" href="{{ url('/users') }}">
                    Users
                </a>
                <div class="dropdown-divider"></div> --}}
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"
                role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
