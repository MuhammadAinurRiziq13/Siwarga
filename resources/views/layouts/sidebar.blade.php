{{-- <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-header">Data Warga</li>
            <li class="nav-item">
                <a href="{{ url('/resident') }}" class="nav-link {{ request()->is('resident') ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-solid fa-users"></i>
                    <p>Warga Setempat</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/migrant') }}" class="nav-link {{ request()->is('migrant') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-user-clock"></i>
                    <p>Warga Perantau</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/poor-resident') }}"
                    class="nav-link {{ request()->is('poor-resident') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-user-group"></i>
                    <p>Warga Kurang Mampu</p>
                </a>
            </li>
            <li class="nav-header">Landing Page</li>
            <li class="nav-item">
                <a href="{{ url('/gallery') }}" class="nav-link {{ request()->is('gallery') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-images"></i>
                    <p>Gallery</p>
                </a>
            </li>
        </ul>
    </nav>

</div> --}}

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-user-cog"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SiWarga</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a href="{{ url('/dashboard') }}" class="nav-link">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Warga
    </div>

    <li class="nav-item {{ request()->is('resident') ? 'active' : '' }} ">
        <a href="{{ url('/resident') }}" class="nav-link">
            <i class="fas fa-fw fa-user-alt"></i>
            <span>Warga Setempat</span></a>
    </li>
    <li class="nav-item {{ request()->is('migrant') ? 'active' : '' }}">
        <a href="{{ url('/migrant') }}" class="nav-link">
            <i class="fas fa-fw fa-user-clock"></i>
            <span>Warga Perantau</span></a>
    </li>
    <li class="nav-item {{ request()->is('poor-resident') ? 'active' : '' }}">
        <a href="{{ url('/poor-resident') }}" class="nav-link">
            <i class="fas fa-fw fa-user-injured"></i>
            <span>Warga Kurang Mampu</span></a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Landing Page
    </div>

    <li class="nav-item {{ request()->is('gallery') ? 'active' : '' }}">
        <a href="{{ url('/gallery') }}" class="nav-link">
            <i class="fas fa-fw fa-images"></i>
            <span>Gallery</span></a>
    </li>

    {{-- <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> --}}

    {{-- <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li> --}}

    {{-- <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components,
            and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to
            Pro!</a>
    </div> --}}

</ul>