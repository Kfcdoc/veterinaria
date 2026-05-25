@extends('layouts.app')
@section('titulo_pagina', 'Lesiones Previas - Veterinaria')
@section('contenido')

@push('styles')
<style>
    .lesion-hero { background: linear-gradient(135deg, #e65100 0%, #ef6c00 55%, #fb8c00 100%); border-radius: 16px; padding: 32px 36px; color: white; margin-bottom: 28px; position: relative; overflow: hidden; box-shadow: 0 8px 32px rgba(239,108,0,0.38); }
    .lesion-hero .bg-bones { position:absolute; right:20px; top:50%; transform:translateY(-50%); font-size:8rem; color:rgba(255,255,255,0.06); }
    .lesion-hero h2 { font-size:1.65rem; font-weight:800; }
    .lesion-hero .chip { display:inline-flex; align-items:center; gap:6px; background:rgba(255,255,255,0.18); color:white; padding:6px 14px; border-radius:20px; font-size:0.78rem; font-weight:600; }
    .card-section { border:none; border-radius:16px; box-shadow:0 4px 24px rgba(239,108,0,0.12); overflow:hidden; margin-bottom:24px; }
    .section-hdr { padding:16px 24px; display:flex; align-items:center; gap:12px; border-bottom:2px solid #ffcc80; background:linear-gradient(90deg,#fff8f0,#fff3e0); }
    .section-hdr .hico { width:40px; height:40px; background:linear-gradient(135deg,#e65100,#ef6c00); border-radius:10px; display:flex; align-items:center; justify-content:center; color:white; font-size:1rem; }
    .record-item { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-bottom:1px solid #fff3e0; transition:background 0.15s; }
    .record-item:last-child { border-bottom:none; }
    .record-item:hover { background:#fff8f0; }
    .record-item .info strong { color:#e65100; font-size:0.95rem; }
    .empty-state { padding:40px 20px; text-align:center; color:#bdbdbd; }
    .empty-state i { font-size:3rem; margin-bottom:12px; }
    .form-add { background:#fafafa; border-top:2px solid #ffcc80; padding:20px 24px; }
    .form-add .form-control-add { border:1.5px solid #ffcc80; border-radius:10px; padding:10px 14px; }
    .form-add .form-control-add:focus { border-color:#ef6c00; box-shadow:0 0 0 3px rgba(239,108,0,0.12); }
    .btn-add-lesion { background:linear-gradient(135deg,#e65100,#fb8c00); color:white; border:none; padding:10px 24px; border-radius:50px; font-weight:700; transition:all 0.3s; }
    .btn-add-lesion:hover { transform:translateY(-2px); box-shadow:0 6px 16px rgba(239,108,0,0.4); color:white; }
    .alert-ok { background:linear-gradient(135deg,#e8f5e9,#f1f8e9); border:1.5px solid #a5d6a7; border-radius:12px; color:#2e7d32; padding:14px 20px; display:flex; align-items:center; gap:12px; margin-bottom:20px; }
    .count-badge { background:#e65100; color:white; font-size:0.75rem; font-weight:800; padding:4px 10px; border-radius:20px; }
</style>
@endpush

<div class="lesion-hero">
    <div class="bg-bones"><i class="fas fa-bone"></i></div>
    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:12px;">
        <div>
            <div class="chip mb-2"><i class="fas fa-file-medical-alt"></i> Antecedentes del Paciente</div>
            <h2>Historial de Lesiones</h2>
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
        <div class="hico"><i class="fas fa-bone"></i></div>
        <div>
            <h6 class="mb-0 font-weight-bold" style="color:#e65100;">Traumatismos y Lesiones Previas</h6>
            <small class="text-muted">Fracturas, luxaciones, cirugías ortopédicas</small>
        </div>
        @if($mascota->antecedentesLesiones->count())
            <span class="count-badge ml-auto">{{ $mascota->antecedentesLesiones->count() }}</span>
        @endif
    </div>

    @if($mascota->antecedentesLesiones->count())
        @foreach($mascota->antecedentesLesiones as $lesion)
            <div class="record-item">
                <div class="info">
                    <strong><i class="fas fa-band-aid mr-1"></i> {{ $lesion->tipo_lesion }}</strong>
                </div>
                <form action="{{ route('expedientes.lesiones.eliminar', [$mascota->id, $lesion->id]) }}" method="POST" onsubmit="return confirm('¿Eliminar esta lesión?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px;"><i class="fas fa-trash-alt"></i></button>
                </form>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <i class="fas fa-check-circle" style="color:#a5d6a7;"></i>
            <p class="mb-0 font-weight-bold">Sin lesiones previas</p>
            <small>Registra cualquier lesión o traumatismo identificado</small>
        </div>
    @endif

    <div class="form-add">
        <form action="{{ route('expedientes.consultas.lesiones.guardar', [$mascota->id, $consulta->id]) }}" method="POST">
            @csrf
            <h6 class="font-weight-bold mb-3" style="color:#e65100; font-size:0.88rem;"><i class="fas fa-plus-circle mr-1"></i> Registrar Nueva Lesión</h6>
            <div class="d-flex" style="gap:10px;">
                <input type="text" name="tipo_lesion" class="form-control form-control-add" placeholder="Tipo de lesión (ej: Fractura de tibia izquierda)" required style="flex:1;">
                <button type="submit" class="btn btn-add-lesion"><i class="fas fa-plus mr-1"></i> Agregar</button>
            </div>
        </form>
    </div>
</div>
@endsection
