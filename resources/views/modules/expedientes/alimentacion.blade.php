@extends('layouts.app')
@section('titulo_pagina', 'Dieta y Alimentación - Veterinaria')
@section('contenido')

@push('styles')
<style>
    .alim-hero { background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 55%, #43a047 100%); border-radius: 16px; padding: 32px 36px; color: white; margin-bottom: 28px; position: relative; overflow: hidden; box-shadow: 0 8px 32px rgba(46,125,50,0.38); }
    .alim-hero .bg-icon { position:absolute; right:28px; top:50%; transform:translateY(-50%); font-size:8rem; color:rgba(255,255,255,0.07); }
    .alim-hero h2 { font-size:1.65rem; font-weight:800; }
    .alim-hero .chip { display:inline-flex; align-items:center; gap:6px; background:rgba(255,255,255,0.2); color:white; padding:6px 14px; border-radius:20px; font-size:0.78rem; font-weight:600; }
    .card-section { border:none; border-radius:16px; box-shadow:0 4px 24px rgba(46,125,50,0.1); overflow:hidden; margin-bottom:24px; }
    .section-hdr { padding:16px 24px; display:flex; align-items:center; gap:12px; border-bottom:2px solid #a5d6a7; background:linear-gradient(90deg,#f1f8e9,#e8f5e9); }
    .section-hdr .hico { width:40px; height:40px; background:linear-gradient(135deg,#1b5e20,#43a047); border-radius:10px; display:flex; align-items:center; justify-content:center; color:white; font-size:1rem; }
    .record-item { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-bottom:1px solid #e8f5e9; transition:background 0.15s; }
    .record-item:last-child { border-bottom:none; }
    .record-item:hover { background:#f1f8e9; }
    .record-item .info strong { color:#1b5e20; font-size:0.95rem; }
    .freq-badge { font-size:0.72rem; font-weight:700; padding:3px 10px; border-radius:20px; background:#e8f5e9; color:#2e7d32; border:1px solid #a5d6a7; }
    .empty-state { padding:40px 20px; text-align:center; color:#bdbdbd; }
    .empty-state i { font-size:3rem; margin-bottom:12px; }
    .form-add { background:#fafafa; border-top:2px solid #a5d6a7; padding:20px 24px; }
    .form-add .form-control-add { border:1.5px solid #a5d6a7; border-radius:10px; padding:10px 14px; }
    .form-add .form-control-add:focus { border-color:#43a047; box-shadow:0 0 0 3px rgba(67,160,71,0.12); }
    .btn-add-alim { background:linear-gradient(135deg,#1b5e20,#43a047); color:white; border:none; padding:10px 24px; border-radius:50px; font-weight:700; transition:all 0.3s; }
    .btn-add-alim:hover { transform:translateY(-2px); box-shadow:0 6px 16px rgba(67,160,71,0.4); color:white; }
    .alert-ok { background:linear-gradient(135deg,#e8f5e9,#f1f8e9); border:1.5px solid #a5d6a7; border-radius:12px; color:#2e7d32; padding:14px 20px; display:flex; align-items:center; gap:12px; margin-bottom:20px; }
    .count-badge { background:#2e7d32; color:white; font-size:0.75rem; font-weight:800; padding:4px 10px; border-radius:20px; }
</style>
@endpush

<div class="alim-hero">
    <div class="bg-icon"><i class="fas fa-leaf"></i></div>
    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:12px;">
        <div>
            <div class="chip mb-2"><i class="fas fa-apple-alt"></i> Antecedentes del Paciente</div>
            <h2>Dieta y Alimentación</h2>
            <div style="opacity:0.82; font-size:0.92rem;"><i class="fas fa-paw mr-1"></i> <strong>{{ $mascota->nombre }}</strong> · {{ $mascota->especie }}@if($mascota->raza) · {{ $mascota->raza }}@endif</div>
        </div>
        <div class="chip"><i class="fas fa-calendar-alt"></i> {{ $consulta->fecha_consulta ? $consulta->fecha_consulta->format('d/m/Y') : 'Sin fecha' }}</div>
    </div>
</div>

<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('expedientes.consultas.detalle', [$mascota->id, $consulta->id]) }}" class="btn btn-sm btn-outline-secondary" style="border-radius:50px; font-weight:600;"><i class="fas fa-arrow-left mr-1"></i> Volver a la Consulta</a>
</div>

@if(session('success'))
    <div class="alert-ok"><i class="fas fa-check-circle fa-lg" style="color:#43a047;"></i><strong>{{ session('success') }}</strong></div>
@endif

<div class="card card-section">
    <div class="section-hdr">
        <div class="hico"><i class="fas fa-utensils"></i></div>
        <div>
            <h6 class="mb-0 font-weight-bold" style="color:#1b5e20;">Plan Nutricional</h6>
            <small class="text-muted">Tipo de alimento, marcas, porciones y frecuencia</small>
        </div>
        @if($mascota->historialAlimentacion->count())
            <span class="count-badge ml-auto">{{ $mascota->historialAlimentacion->count() }}</span>
        @endif
    </div>

    @if($mascota->historialAlimentacion->count())
        @foreach($mascota->historialAlimentacion as $alim)
            <div class="record-item">
                <div class="info d-flex align-items-center" style="gap:12px; flex-wrap:wrap;">
                    <strong><i class="fas fa-drumstick-bite mr-1"></i> {{ $alim->descripcion_dieta }}</strong>
                    <span class="freq-badge"><i class="fas fa-clock mr-1"></i>{{ $alim->frecuencia_diaria }}x al día</span>
                </div>
                <form action="{{ route('expedientes.alimentacion.eliminar', [$mascota->id, $alim->id]) }}" method="POST" onsubmit="return confirm('¿Eliminar este registro?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px;"><i class="fas fa-trash-alt"></i></button>
                </form>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <i class="fas fa-question-circle" style="color:#a5d6a7;"></i>
            <p class="mb-0 font-weight-bold">Sin información nutricional</p>
            <small>Registra la dieta actual del paciente</small>
        </div>
    @endif

    <div class="form-add">
        <form action="{{ route('expedientes.consultas.alimentacion.guardar', [$mascota->id, $consulta->id]) }}" method="POST">
            @csrf
            <h6 class="font-weight-bold mb-3" style="color:#2e7d32; font-size:0.88rem;"><i class="fas fa-plus-circle mr-1"></i> Agregar Registro de Alimentación</h6>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <input type="text" name="descripcion_dieta" class="form-control form-control-add" placeholder="Tipo / marca de alimento (ej: Croquetas Royal Canin Adult)" required>
                </div>
                <div class="col-md-3 mb-2">
                    <select name="frecuencia_diaria" class="form-control form-control-add">
                        <option value="1">1 vez al día</option>
                        <option value="2" selected>2 veces al día</option>
                        <option value="3">3 veces al día</option>
                        <option value="4">4+ veces / libre</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <button type="submit" class="btn btn-add-alim w-100"><i class="fas fa-plus mr-1"></i> Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
