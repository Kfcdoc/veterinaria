@extends('layouts.app')
@section('hide_sidebar', true)

@section('titulo_pagina', 'Dashboard - Veterinaria')

@push('styles')
<style>
    .vet-hero {
        background: linear-gradient(135deg, #2e59d9 0%, #17a673 100%);
        border-radius: 16px; padding: 32px 36px; color: white;
        margin-bottom: 28px; position: relative; overflow: hidden;
        box-shadow: 0 8px 32px rgba(23, 166, 115, 0.3);
    }
    .vet-hero::after {
        content: ''; position: absolute; top: -50px; right: -50px;
        width: 250px; height: 250px; border-radius: 50%;
        background: rgba(255,255,255,0.08);
    }
    .vet-hero .bg-icon {
        position: absolute; right: 30px; top: 50%; transform: translateY(-50%);
        font-size: 8rem; color: rgba(255,255,255,0.1);
    }
    .vet-hero h2 { font-size: 1.8rem; font-weight: 800; margin-bottom: 4px; }
    .vet-hero .subtitle { opacity: 0.9; font-size: 0.95rem; }

    .stat-card {
        border: none; border-radius: 16px; transition: all 0.3s ease;
        overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); background: white;
    }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 8px 28px rgba(0,0,0,0.1); }
    .stat-card .card-body { padding: 24px; position: relative; z-index: 2; display: flex; align-items: center; justify-content: space-between; }
    .stat-info .stat-value { font-size: 2rem; font-weight: 800; line-height: 1; margin-bottom: 4px; color: #3a3b45; }
    .stat-info .stat-label { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #858796; }
    .stat-icon-wrapper { width: 60px; height: 60px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; }
    
    .c-hoy .stat-icon-wrapper { background: #e3f2fd; color: #4e73df; }
    .c-mis .stat-icon-wrapper { background: #e8f5e9; color: #1cc88a; }
    .c-tot .stat-icon-wrapper { background: #fff3e0; color: #f6c23e; }

    .recent-card { border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
    .recent-header { background: #f8f9fc; padding: 18px 24px; border-bottom: 2px solid #eaecf4; display: flex; align-items: center; justify-content: space-between; border-radius: 16px 16px 0 0; }
    .recent-header h6 { margin: 0; font-weight: 800; color: #4e73df; }
    
    .recent-item { display: flex; align-items: center; justify-content: space-between; padding: 16px 24px; border-bottom: 1px solid #eaecf4; transition: background 0.2s; }
    .recent-item:last-child { border-bottom: none; }
    .recent-item:hover { background: #f8f9fc; }
    .recent-item .info h5 { margin: 0; font-size: 1rem; font-weight: 700; color: #3a3b45; margin-bottom: 2px; }
    .recent-item .info p { margin: 0; font-size: 0.85rem; color: #858796; }
    .btn-detalle { background: #eaecf4; color: #4e73df; border-radius: 8px; padding: 6px 14px; font-weight: 700; font-size: 0.85rem; transition: all 0.2s; text-decoration: none; }
    .btn-detalle:hover { background: #4e73df; color: white; text-decoration: none; }
    
    .quick-search { background: white; border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); text-align: center; }
    .quick-search i { font-size: 3rem; color: #eaecf4; margin-bottom: 16px; }
    .quick-search h5 { font-weight: 800; color: #5a5c69; }
    .btn-search { background: #1cc88a; color: white; border-radius: 50px; padding: 12px 30px; font-weight: 700; box-shadow: 0 4px 12px rgba(28,200,138,0.3); transition: all 0.2s; display: inline-block; margin-top: 10px; text-decoration: none; }
    .btn-search:hover { background: #13855c; color: white; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(28,200,138,0.4); text-decoration: none; }
</style>
@endpush

@section('contenido')

    {{-- Hero --}}
    <div class="vet-hero">
        <div class="bg-icon"><i class="fas fa-user-md"></i></div>
        <div>
            <h2>Hola, Dr(a). {{ Auth::user()->name }}</h2>
            <div class="subtitle">Panel de Control Clínico · {{ now()->format('l, d de F de Y') }}</div>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card c-hoy h-100">
                <div class="card-body">
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['consultas_hoy'] }}</div>
                        <div class="stat-label">Consultas Hoy (Global)</div>
                    </div>
                    <div class="stat-icon-wrapper"><i class="fas fa-calendar-day"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card c-mis h-100">
                <div class="card-body">
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['mis_consultas'] }}</div>
                        <div class="stat-label">Mis Consultas</div>
                    </div>
                    <div class="stat-icon-wrapper"><i class="fas fa-stethoscope"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card stat-card c-tot h-100">
                <div class="card-body">
                    <div class="stat-info">
                        <div class="stat-value">{{ $stats['total_mascotas'] }}</div>
                        <div class="stat-label">Total Pacientes</div>
                    </div>
                    <div class="stat-icon-wrapper"><i class="fas fa-paw"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Consultas Recientes --}}
        <div class="col-lg-8 mb-4">
            <div class="card recent-card h-100">
                <div class="recent-header">
                    <h6><i class="fas fa-history mr-2"></i> Mis Consultas Recientes</h6>
                    <a href="{{ route('expedientes.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 20px; font-weight: 600;">Ver Todo</a>
                </div>
                <div class="card-body p-0">
                    @if($consultasRecientes->count() > 0)
                        @foreach($consultasRecientes as $consulta)
                            <div class="recent-item">
                                <div class="d-flex align-items-center" style="gap: 16px;">
                                    <div style="width: 45px; height: 45px; border-radius: 50%; background: #eaecf4; display: flex; align-items: center; justify-content: center; color: #858796; font-size: 1.2rem;">
                                        <i class="fas fa-dog"></i>
                                    </div>
                                    <div class="info">
                                        <h5>{{ $consulta->mascota->nombre ?? 'Paciente Desconocido' }}</h5>
                                        <p><i class="fas fa-clock mr-1"></i> {{ $consulta->fecha_consulta ? $consulta->fecha_consulta->diffForHumans() : 'Sin fecha' }} · Peso: {{ $consulta->peso }}kg</p>
                                    </div>
                                </div>
                                <a href="{{ route('expedientes.consultas.detalle', [$consulta->mascota_id, $consulta->id]) }}" class="btn-detalle">Abrir Ficha</a>
                            </div>
                        @endforeach
                    @else
                        <div class="p-5 text-center text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3" style="opacity: 0.2;"></i>
                            <p>No tienes consultas recientes registradas a tu nombre.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Atajo Buscar --}}
        <div class="col-lg-4 mb-4">
            <div class="quick-search h-100 d-flex flex-column justify-content-center">
                <i class="fas fa-search"></i>
                <h5>Buscar Paciente</h5>
                <p class="text-muted mb-4">Accede rápidamente al expediente médico de un paciente.</p>
                <div>
                    <a href="{{ route('expedientes.index') }}" class="btn-search"><i class="fas fa-search mr-2"></i> Ir al Buscador</a>
                </div>
            </div>
        </div>
    </div>

@endsection
