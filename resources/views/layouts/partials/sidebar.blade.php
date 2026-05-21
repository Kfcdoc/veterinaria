{{-- ==========================================
     PARTIAL: SIDEBAR
     resources/views/layouts/partials/_sidebar.blade.php
     ========================================== --}}

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Sidebar - Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-paw"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Veterinaria</div>
    </a>

    {{-- Divider --}}
    <hr class="sidebar-divider my-0">

    {{-- Heading --}}
    <div class="sidebar-heading">
        Consulta Actual
    </div>

    {{-- Nav Item - Diagnóstico --}}
    <li class="nav-item {{ request()->routeIs('expedientes.consultas.diagnostico') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('expedientes.consultas.diagnostico', [$mascota->id ?? 0, $consulta->id ?? 0]) }}">
            <i class="fas fa-fw fa-stethoscope"></i>
            <span>Diagnóstico</span>
        </a>
    </li>

    {{-- Nav Item - Tratamiento --}}
    <li class="nav-item {{ request()->routeIs('expedientes.consultas.tratamiento') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('expedientes.consultas.tratamiento', [$mascota->id ?? 0, $consulta->id ?? 0]) }}">
            <i class="fas fa-fw fa-pills"></i>
            <span>Tratamiento</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- Heading --}}
    <div class="sidebar-heading">
        Antecedentes del Paciente
    </div>

    {{-- Nav Item - Alergias --}}
    <li class="nav-item {{ request()->routeIs('expedientes.consultas.alergias') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('expedientes.consultas.alergias', [$mascota->id ?? 0, $consulta->id ?? 0]) }}">
            <i class="fas fa-fw fa-allergies"></i>
            <span>Alergias</span>
        </a>
    </li>

    {{-- Nav Item - Lesiones --}}
    <li class="nav-item {{ request()->routeIs('expedientes.consultas.lesiones') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('expedientes.consultas.lesiones', [$mascota->id ?? 0, $consulta->id ?? 0]) }}">
            <i class="fas fa-fw fa-bone"></i>
            <span>Lesiones</span>
        </a>
    </li>

    {{-- Nav Item - Patológicos --}}
    <li class="nav-item {{ request()->routeIs('expedientes.consultas.patologicos') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('expedientes.consultas.patologicos', [$mascota->id ?? 0, $consulta->id ?? 0]) }}">
            <i class="fas fa-fw fa-file-medical-alt"></i>
            <span>Patológicos</span>
        </a>
    </li>

    {{-- Nav Item - Alimentación --}}
    <li class="nav-item {{ request()->routeIs('expedientes.consultas.alimentacion') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('expedientes.consultas.alimentacion', [$mascota->id ?? 0, $consulta->id ?? 0]) }}">
            <i class="fas fa-fw fa-utensils"></i>
            <span>Alimentación</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggler --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
