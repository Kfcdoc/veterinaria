{{-- ==========================================
     PARTIAL: TOPBAR / NAVBAR
     resources/views/layouts/partials/_topbar.blade.php
     ========================================== --}}

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    {{-- Sidebar Toggle (Mobile) --}}
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    {{-- Topbar Search (Removido) --}}
    
    {{-- Pestañas de Navegación --}}
    <ul class="navbar-nav mr-auto ml-3">
        <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('home') }}" style="color: {{ request()->routeIs('home') ? '#4e73df' : '#858796' }}; font-weight: {{ request()->routeIs('home') ? 'bold' : 'normal' }}; border-bottom: {{ request()->routeIs('home') ? '2px solid #4e73df' : 'none' }};">
                Inicio
            </a>
        </li>
        <li class="nav-item {{ request()->routeIs('expedientes.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('expedientes.index') }}" style="color: {{ request()->routeIs('expedientes.index') ? '#4e73df' : '#858796' }}; font-weight: {{ request()->routeIs('expedientes.index') ? 'bold' : 'normal' }}; border-bottom: {{ request()->routeIs('expedientes.index') ? '2px solid #4e73df' : 'none' }};">
                Expedientes
            </a>
        </li>
    </ul>

    {{-- Topbar Navbar --}}
    <ul class="navbar-nav ml-auto">

        <div class="topbar-divider d-none d-sm-block"></div>

        {{-- Nav Item - User Information --}}
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ Auth::user()->name ?? 'Usuario' }}
                </span>
                <i class="fas fa-user-circle fa-2x text-gray-400"></i>
            </a>

            {{-- Dropdown - User Information --}}
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Perfil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Cerrar sesión
                </a>
            </div>
        </li>

    </ul>

</nav>
