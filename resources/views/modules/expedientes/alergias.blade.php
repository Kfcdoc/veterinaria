@extends('layouts.app')
@section('titulo_pagina', 'Alergias - Veterinaria')
@section('contenido')

@push('styles')
<style>
    .alergia-hero { background: linear-gradient(135deg, #7f0000 0%, #c62828 60%, #e53935 100%); border-radius: 16px; padding: 28px 32px; color: white; margin-bottom: 28px; position: relative; overflow: hidden; box-shadow: 0 8px 32px rgba(198,40,40,0.4); }
    .alergia-hero::after { content:''; position:absolute; top:-30px; right:-30px; width:160px; height:160px; border-radius:50%; background:rgba(255,255,255,0.06); }
    .alergia-hero h2 { font-size:1.6rem; font-weight:800; }
    .alergia-hero .chip { display:inline-flex; align-items:center; gap:6px; background:rgba(255,255,255,0.2); color:white; padding:6px 14px; border-radius:20px; font-size:0.78rem; font-weight:600; }
    .card-section { border:none; border-radius:16px; box-shadow:0 4px 24px rgba(198,40,40,0.1); overflow:hidden; margin-bottom:24px; }
    .section-hdr { padding:16px 24px; display:flex; align-items:center; gap:12px; border-bottom:2px solid #ffcdd2; background:#fff8f8; }
    .section-hdr .hico { width:40px; height:40px; background:linear-gradient(135deg,#c62828,#e53935); border-radius:10px; display:flex; align-items:center; justify-content:center; color:white; font-size:1rem; }
    .record-item { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-bottom:1px solid #fce4ec; transition:background 0.15s; }
    .record-item:last-child { border-bottom:none; }
    .record-item:hover { background:#fff5f5; }
    .record-item .info strong { color:#b71c1c; font-size:0.95rem; }
    .record-item .info small { color:#90a4ae; font-size:0.8rem; }
    .empty-state { padding:40px 20px; text-align:center; color:#bdbdbd; }
    .empty-state i { font-size:3rem; margin-bottom:12px; }
    .form-add { background:#fafafa; border-top:2px solid #ffcdd2; padding:20px 24px; }
    .form-add .form-control-add { border:1.5px solid #ffcdd2; border-radius:10px; padding:10px 14px; }
    .form-add .form-control-add:focus { border-color:#e53935; box-shadow:0 0 0 3px rgba(229,57,53,0.12); }
    .btn-add-alergia { background:linear-gradient(135deg,#7f0000,#c62828); color:white; border:none; padding:10px 24px; border-radius:50px; font-weight:700; transition:all 0.3s; }
    .btn-add-alergia:hover { transform:translateY(-2px); box-shadow:0 6px 16px rgba(198,40,40,0.4); color:white; }
    .alert-ok { background:linear-gradient(135deg,#e8f5e9,#f1f8e9); border:1.5px solid #a5d6a7; border-radius:12px; color:#2e7d32; padding:14px 20px; display:flex; align-items:center; gap:12px; margin-bottom:20px; }
    .count-badge { background:#c62828; color:white; font-size:0.75rem; font-weight:800; padding:4px 10px; border-radius:20px; }
</style>
@endpush

<div class="alergia-hero">
    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:12px;">
        <div>
            <div class="chip mb-2"><i class="fas fa-exclamation-triangle"></i> Antecedentes del Paciente</div>
            <h2>Alergias del Paciente</h2>
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
        <div class="hico"><i class="fas fa-allergies"></i></div>
        <div>
            <h6 class="mb-0 font-weight-bold" style="color:#7f0000;">Alergias Registradas</h6>
            <small class="text-muted">Sustancias alérgenas y reacciones documentadas</small>
        </div>
        @if($mascota->antecedentesAlergias->count())
            <span class="count-badge ml-auto">{{ $mascota->antecedentesAlergias->count() }}</span>
        @endif
    </div>

    @if($mascota->antecedentesAlergias->count())
        @foreach($mascota->antecedentesAlergias as $alergia)
            <div class="record-item">
                <div class="info">
                    <strong><i class="fas fa-radiation-alt mr-1"></i> {{ $alergia->sustancia_alergena }}</strong>
                    @if($alergia->reaccion)
                        <br><small><i class="fas fa-arrow-right mr-1"></i> Reacción: {{ $alergia->reaccion }}</small>
                    @endif
                </div>
                <form action="{{ route('expedientes.alergias.eliminar', [$mascota->id, $alergia->id]) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta alergia?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px;"><i class="fas fa-trash-alt"></i></button>
                </form>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <i class="fas fa-shield-alt"></i>
            <p class="mb-0 font-weight-bold">Sin alergias registradas</p>
            <small>Agrega la primera alergia usando el formulario de abajo</small>
        </div>
    @endif

    <div class="form-add">
        <form action="{{ route('expedientes.consultas.alergias.guardar', [$mascota->id, $consulta->id]) }}" method="POST">
            @csrf
            <h6 class="font-weight-bold mb-3" style="color:#c62828; font-size:0.88rem;"><i class="fas fa-plus-circle mr-1"></i> Agregar Nueva Alergia</h6>
            <div class="row">
                <div class="col-md-5 mb-2">
                    <input type="text" name="sustancia_alergena" class="form-control form-control-add" placeholder="Sustancia alérgena (ej: Penicilina)" required>
                </div>
                <div class="col-md-5 mb-2">
                    <input type="text" name="reaccion" class="form-control form-control-add" placeholder="Reacción observada (ej: Hinchazón severa)">
                </div>
                <div class="col-md-2 mb-2">
                    <button type="submit" class="btn btn-add-alergia w-100"><i class="fas fa-plus mr-1"></i> Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
