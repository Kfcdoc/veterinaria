{{-- ==========================================
     PARTIAL: SIDEBAR
     resources/views/layouts/partials/_sidebar.blade.php
     ========================================== --}}

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Sidebar - Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Panel</div>
    </a>

    {{-- Divider --}}
    <hr class="sidebar-divider my-0">

    {{-- Nav Item - Dashboard --}}
    <li class="nav-item {{ request()->routeIs('admin.home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard Admin</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- Heading --}}
    <div class="sidebar-heading">
        Sistema
    </div>

    {{-- Nav Item - Pacientes --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePacientes"
            aria-expanded="true" aria-controls="collapsePacientes">
            <i class="fas fa-fw fa-dog"></i>
            <span>Pacientes</span>
        </a>
        <div id="collapsePacientes" class="collapse" aria-labelledby="headingPacientes"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestión:</h6>
                <a class="collapse-item" href="#">Ver pacientes</a>
                <a class="collapse-item" href="#">Nuevo paciente</a>
            </div>
        </div>
    </li>

    {{-- Nav Item - Usuarios --}}
    <li class="nav-item {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('admin.usuarios.*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseUsuarios"
            aria-expanded="{{ request()->routeIs('admin.usuarios.*') ? 'true' : 'false' }}" aria-controls="collapseUsuarios">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Usuarios</span>
        </a>
        <div id="collapseUsuarios" class="collapse {{ request()->routeIs('admin.usuarios.*') ? 'show' : '' }}" aria-labelledby="headingUsuarios"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Gestión de acceso:</h6>
                <a class="collapse-item {{ request()->routeIs('admin.usuarios.index') ? 'active' : '' }}" href="{{ route('admin.usuarios.index') }}">Ver usuarios</a>
                <a class="collapse-item {{ request()->routeIs('admin.usuarios.create') ? 'active' : '' }}" href="{{ route('admin.usuarios.create') }}">Nuevo usuario</a>
            </div>
        </div>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggler --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
