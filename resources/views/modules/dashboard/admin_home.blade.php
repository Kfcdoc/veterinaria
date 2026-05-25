@extends('layouts.admin')

@section('titulo_pagina', 'Dashboard Administrador')

@push('styles')
<style>
    .admin-hero {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border-radius: 16px; padding: 32px 36px; color: white;
        margin-bottom: 28px; position: relative; overflow: hidden;
        box-shadow: 0 8px 32px rgba(78, 115, 223, 0.35);
    }
    .admin-hero::after {
        content: ''; position: absolute; top: -50px; right: -50px;
        width: 250px; height: 250px; border-radius: 50%;
        background: rgba(255,255,255,0.08);
    }
    .admin-hero .bg-icon {
        position: absolute; right: 30px; top: 50%; transform: translateY(-50%);
        font-size: 8rem; color: rgba(255,255,255,0.1);
    }
    .admin-hero h2 { font-size: 1.8rem; font-weight: 800; margin-bottom: 4px; }
    .admin-hero .subtitle { opacity: 0.85; font-size: 0.95rem; }
    
    .stat-card {
        border: none; border-radius: 16px; transition: all 0.3s ease;
        overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 8px 28px rgba(0,0,0,0.1); }
    .stat-card .card-body { padding: 24px; position: relative; z-index: 2; }
    .stat-card .stat-icon {
        position: absolute; right: -10px; bottom: -10px;
        font-size: 5rem; opacity: 0.1; z-index: 1; transition: all 0.3s ease;
    }
    .stat-card:hover .stat-icon { transform: scale(1.1) rotate(-5deg); opacity: 0.15; }
    .stat-value { font-size: 2.2rem; font-weight: 800; line-height: 1; margin-bottom: 8px; }
    .stat-label { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; opacity: 0.8; }
    
    .card-usuarios { background: linear-gradient(135deg, #1cc88a, #13855c); color: white; }
    .card-mascotas { background: linear-gradient(135deg, #f6c23e, #dda20a); color: white; }
    .card-consultas { background: linear-gradient(135deg, #36b9cc, #258391); color: white; }
    
    .config-quick {
        background: white; border-radius: 16px; padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05); display: flex;
        align-items: center; justify-content: space-between;
    }
    .config-quick .info h5 { color: #2d3748; font-weight: 800; margin-bottom: 4px; }
    .config-quick .info p { color: #718096; margin-bottom: 0; font-size: 0.9rem; }
    .btn-config {
        background: #4e73df; color: white; border-radius: 50px;
        padding: 10px 24px; font-weight: 700; box-shadow: 0 4px 12px rgba(78,115,223,0.3);
        transition: all 0.2s ease; text-decoration: none; display: inline-block;
    }
    .btn-config:hover { background: #224abe; color: white; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(78,115,223,0.4); text-decoration: none; }
</style>
@endpush

@section('contenido')

    {{-- Hero Panel --}}
    <div class="admin-hero">
        <div class="bg-icon"><i class="fas fa-crown"></i></div>
        <div>
            <h2>Hola, {{ Auth::user()->name }}</h2>
            <div class="subtitle">Bienvenido al Panel de Control de Administración</div>
        </div>
        <div class="mt-3">
            <span class="badge badge-light px-3 py-2 rounded-pill shadow-sm" style="color: #4e73df; font-weight: 700;">
                <i class="fas fa-calendar-alt mr-1"></i> {{ now()->format('d M, Y') }}
            </span>
        </div>
    </div>

    {{-- Estadísticas Principales --}}
    <div class="row mb-4">
        {{-- Usuarios --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card card-usuarios h-100">
                <div class="card-body">
                    <i class="fas fa-users-cog stat-icon"></i>
                    <div class="stat-value">{{ $stats['usuarios'] }}</div>
                    <div class="stat-label">Usuarios del Sistema</div>
                    <div class="mt-3">
                        <a href="{{ route('admin.usuarios.index') }}" class="text-white text-decoration-none" style="font-size: 0.85rem; font-weight: 600;">
                            Gestionar usuarios <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mascotas --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card card-mascotas h-100">
                <div class="card-body">
                    <i class="fas fa-paw stat-icon"></i>
                    <div class="stat-value">{{ $stats['mascotas'] }}</div>
                    <div class="stat-label">Pacientes Registrados</div>
                    <div class="mt-3">
                        <span style="font-size: 0.85rem; font-weight: 600; opacity: 0.8;">Base de datos general</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Consultas --}}
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card card-consultas h-100">
                <div class="card-body">
                    <i class="fas fa-stethoscope stat-icon"></i>
                    <div class="stat-value">{{ $stats['consultas'] }}</div>
                    <div class="stat-label">Consultas Médicas</div>
                    <div class="mt-3">
                        <span style="font-size: 0.85rem; font-weight: 600; opacity: 0.8;">Historial completo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Acceso a Configuración --}}
    <div class="config-quick">
        <div class="d-flex align-items-center" style="gap: 20px;">
            <div style="width: 60px; height: 60px; border-radius: 16px; background: #eaecf4; display: flex; align-items: center; justify-content: center; color: #4e73df; font-size: 1.5rem;">
                <i class="fas fa-cogs"></i>
            </div>
            <div class="info">
                <h5>Configuración de la Clínica</h5>
                <p>Clínica actual: <strong>{{ $config->nombre_clinica }}</strong>. Personaliza el nombre, logo, información y lista de precios.</p>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.configuracion') }}" class="btn-config">
                Ajustes <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

@endsection
