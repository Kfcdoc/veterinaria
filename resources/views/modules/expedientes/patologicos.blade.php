@extends('layouts.app')
@section('titulo_pagina', 'Antecedentes Patológicos - Veterinaria')
@section('contenido')

@push('styles')
<style>
    .pato-hero { background: linear-gradient(135deg, #004d40 0%, #00695c 55%, #00897b 100%); border-radius: 16px; padding: 32px 36px; color: white; margin-bottom: 28px; position: relative; overflow: hidden; box-shadow: 0 8px 32px rgba(0,105,92,0.4); }
    .pato-hero .bg-dna { position:absolute; right:28px; top:50%; transform:translateY(-50%); font-size:8rem; color:rgba(255,255,255,0.07); }
    .pato-hero h2 { font-size:1.65rem; font-weight:800; }
    .pato-hero .chip { display:inline-flex; align-items:center; gap:6px; background:rgba(255,255,255,0.18); color:white; padding:6px 14px; border-radius:20px; font-size:0.78rem; font-weight:600; }
    .card-section { border:none; border-radius:16px; box-shadow:0 4px 24px rgba(0,105,92,0.12); overflow:hidden; margin-bottom:24px; }
    .section-hdr { padding:16px 24px; display:flex; align-items:center; gap:12px; border-bottom:2px solid #80cbc4; background:linear-gradient(90deg,#e0f2f1,#f1f8e9); }
    .section-hdr .hico { width:40px; height:40px; background:linear-gradient(135deg,#004d40,#00897b); border-radius:10px; display:flex; align-items:center; justify-content:center; color:white; font-size:1rem; }
    .record-item { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; border-bottom:1px solid #e0f2f1; transition:background 0.15s; }
    .record-item:last-child { border-bottom:none; }
    .record-item:hover { background:#e0f2f1; }
    .record-item .info strong { color:#004d40; font-size:0.95rem; }
    .cronica-badge { font-size:0.7rem; font-weight:800; padding:3px 10px; border-radius:20px; text-transform:uppercase; letter-spacing:0.5px; }
    .cronica-si { background:#ffebee; color:#c62828; border:1px solid #ef9a9a; }
    .cronica-no { background:#e8f5e9; color:#2e7d32; border:1px solid #a5d6a7; }
    .empty-state { padding:40px 20px; text-align:center; color:#bdbdbd; }
    .empty-state i { font-size:3rem; margin-bottom:12px; }
    .form-add { background:#fafafa; border-top:2px solid #80cbc4; padding:20px 24px; }
    .form-add .form-control-add { border:1.5px solid #80cbc4; border-radius:10px; padding:10px 14px; }
    .form-add .form-control-add:focus { border-color:#00897b; box-shadow:0 0 0 3px rgba(0,137,123,0.12); }
    .btn-add-pato { background:linear-gradient(135deg,#004d40,#00897b); color:white; border:none; padding:10px 24px; border-radius:50px; font-weight:700; transition:all 0.3s; }
    .btn-add-pato:hover { transform:translateY(-2px); box-shadow:0 6px 16px rgba(0,137,123,0.4); color:white; }
    .alert-ok { background:linear-gradient(135deg,#e8f5e9,#f1f8e9); border:1.5px solid #a5d6a7; border-radius:12px; color:#2e7d32; padding:14px 20px; display:flex; align-items:center; gap:12px; margin-bottom:20px; }
    .count-badge { background:#00695c; color:white; font-size:0.75rem; font-weight:800; padding:4px 10px; border-radius:20px; }
    .custom-check { width:18px; height:18px; accent-color:#c62828; }
</style>
@endpush

<div class="pato-hero">
    <div class="bg-dna"><i class="fas fa-dna"></i></div>
    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:12px;">
        <div>
            <div class="chip mb-2"><i class="fas fa-notes-medical"></i> Antecedentes del Paciente</div>
            <h2>Historial Patológico</h2>
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
        <div class="hico"><i class="fas fa-file-medical-alt"></i></div>
        <div>
            <h6 class="mb-0 font-weight-bold" style="color:#004d40;">Enfermedades y Condiciones Médicas</h6>
            <small class="text-muted">Enfermedades crónicas, cirugías y condiciones previas</small>
        </div>
        @if($mascota->antecedentesPatologicos->count())
            <span class="count-badge ml-auto">{{ $mascota->antecedentesPatologicos->count() }}</span>
        @endif
    </div>

    @if($mascota->antecedentesPatologicos->count())
        @foreach($mascota->antecedentesPatologicos as $pato)
            <div class="record-item">
                <div class="info d-flex align-items-center" style="gap:12px;">
                    <strong><i class="fas fa-notes-medical mr-1"></i> {{ $pato->enfermedad }}</strong>
                    @if($pato->es_cronica)
                        <span class="cronica-badge cronica-si"><i class="fas fa-exclamation-circle mr-1"></i>Crónica</span>
                    @else
                        <span class="cronica-badge cronica-no">No crónica</span>
                    @endif
                </div>
                <form action="{{ route('expedientes.patologicos.eliminar', [$mascota->id, $pato->id]) }}" method="POST" onsubmit="return confirm('¿Eliminar este antecedente?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px;"><i class="fas fa-trash-alt"></i></button>
                </form>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <i class="fas fa-folder-open" style="color:#80cbc4;"></i>
            <p class="mb-0 font-weight-bold">Sin antecedentes patológicos</p>
            <small>Registra enfermedades o condiciones relevantes</small>
        </div>
    @endif

    <div class="form-add">
        <form action="{{ route('expedientes.consultas.patologicos.guardar', [$mascota->id, $consulta->id]) }}" method="POST">
            @csrf
            <h6 class="font-weight-bold mb-3" style="color:#00695c; font-size:0.88rem;"><i class="fas fa-plus-circle mr-1"></i> Registrar Condición Médica</h6>
            <div class="row align-items-end">
                <div class="col-md-5 mb-2">
                    <input type="text" name="enfermedad" class="form-control form-control-add" placeholder="Enfermedad o condición (ej: Diabetes mellitus)" required>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="d-flex align-items-center" style="gap:8px; cursor:pointer; font-weight:600; color:#c62828; font-size:0.88rem;">
                        <input type="checkbox" name="es_cronica" value="1" class="custom-check">
                        <span>¿Es crónica?</span>
                    </label>
                </div>
                <div class="col-md-3 mb-2">
                    <button type="submit" class="btn btn-add-pato w-100"><i class="fas fa-plus mr-1"></i> Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
