@extends('layouts.app')

@section('titulo_pagina', 'Alergias - Veterinaria')

@section('contenido')

@push('styles')
<style>
    /* === ALERGIAS: Temática de Alerta Crítica / Rojo-Coral === */
    .alergia-hero {
        background: linear-gradient(135deg, #7f0000 0%, #c62828 60%, #e53935 100%);
        border-radius: 16px;
        padding: 28px 32px;
        color: white;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(198, 40, 40, 0.4);
    }
    .alergia-hero::after {
        content: '';
        position: absolute;
        top: -30px; right: -30px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
    }
    .alergia-hero::before {
        content: '';
        position: absolute;
        bottom: -50px; right: 80px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }
    .alergia-hero h2 { font-size: 1.6rem; font-weight: 800; }
    .alergia-hero .hero-tag {
        display: inline-block;
        background: rgba(255,255,255,0.2);
        padding: 4px 14px; border-radius: 20px;
        font-size: 0.78rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1px;
        margin-bottom: 10px; backdrop-filter: blur(4px);
    }
    .alergia-hero .date-chip {
        background: rgba(0,0,0,0.2); color: white;
        padding: 6px 14px; border-radius: 20px;
        font-size: 0.78rem; font-weight: 600;
    }

    /* Warning Banner */
    .alergia-warning-banner {
        background: linear-gradient(90deg, #ff5252, #ff1744);
        border-radius: 12px;
        padding: 16px 24px;
        color: white;
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        box-shadow: 0 4px 16px rgba(255, 23, 68, 0.3);
    }
    .alergia-warning-banner .warn-icon {
        font-size: 2.2rem;
        flex-shrink: 0;
        animation: pulse-warn 2s infinite;
    }
    @keyframes pulse-warn {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.6; }
    }
    .alergia-ok-banner {
        background: linear-gradient(90deg, #e0f2f1, #f1f8e9);
        border: 1.5px solid #80cbc4;
        border-radius: 12px; padding: 16px 24px;
        color: #00695c; display: flex; align-items: center; gap: 14px;
        margin-bottom: 24px;
    }
    .card-alergia {
        border: none; border-radius: 16px;
        box-shadow: 0 4px 24px rgba(198, 40, 40, 0.1);
        overflow: hidden;
    }
    .card-alergia .header-alergia {
        background: #fff8f8;
        border-bottom: 2px solid #ffcdd2;
        padding: 18px 24px;
        display: flex; align-items: center; gap: 14px;
    }
    .card-alergia .header-alergia .icon-circle {
        width: 44px; height: 44px;
        background: linear-gradient(135deg, #c62828, #e53935);
        border-radius: 50%; display: flex; align-items: center;
        justify-content: center; color: white; font-size: 1.2rem;
    }
    .btn-save-alergia {
        background: linear-gradient(135deg, #7f0000, #c62828);
        color: white; border: none;
        padding: 14px 36px; border-radius: 50px;
        font-size: 1rem; font-weight: 700; letter-spacing: 0.5px;
        box-shadow: 0 6px 20px rgba(198, 40, 40, 0.4);
        transition: all 0.3s ease;
    }
    .btn-save-alergia:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(198,40,40,0.5); color: white; }
    .ck-editor__editable_inline { min-height: 260px; font-size: 1.05rem; }
    .alert-success-custom {
        background: linear-gradient(135deg, #e8f5e9, #f1f8e9);
        border: 1.5px solid #a5d6a7; border-radius: 12px;
        color: #2e7d32; padding: 16px 20px; margin-bottom: 20px;
    }
</style>
@endpush

    {{-- Hero Header --}}
    <div class="alergia-hero">
        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 12px;">
            <div>
                <span class="hero-tag"><i class="fas fa-exclamation-triangle mr-1"></i> Registro Clínico</span>
                <h2 class="mb-1">Alergias del Paciente</h2>
                <p style="opacity:0.82; margin-bottom:0; font-size:0.92rem;">
                    <i class="fas fa-paw mr-1"></i> <strong>{{ $mascota->nombre }}</strong> · {{ $mascota->especie }}
                    @if($mascota->raza) · {{ $mascota->raza }} @endif
                </p>
            </div>
            <div class="text-right">
                <div class="date-chip mb-2"><i class="fas fa-calendar-alt mr-1"></i> {{ $consulta->fecha_consulta ? $consulta->fecha_consulta->format('d/m/Y') : 'Sin fecha' }}</div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('expedientes.consultas.detalle', [$mascota->id, $consulta->id]) }}" class="btn btn-sm btn-outline-secondary" style="border-radius:50px; font-weight:600;">
            <i class="fas fa-arrow-left mr-1"></i> Volver a la Consulta
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success-custom d-flex align-items-center" style="gap:12px; display:flex !important;">
            <i class="fas fa-check-circle fa-lg" style="color:#43a047;"></i>
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    {{-- Warning Banner --}}
    @if($mascota->alergias)
        <div class="alergia-warning-banner">
            <div class="warn-icon"><i class="fas fa-radiation-alt"></i></div>
            <div>
                <strong style="font-size:1.05rem;">¡Atención! Alergias registradas</strong>
                <div style="opacity:0.9; font-size:0.88rem; margin-top:2px;">Este paciente tiene alergias documentadas. Revisa el historial antes de recetar.</div>
            </div>
        </div>
    @else
        <div class="alergia-ok-banner">
            <i class="fas fa-shield-alt fa-2x" style="color:#00897b; flex-shrink:0;"></i>
            <div>
                <strong>Sin alergias conocidas</strong>
                <div style="font-size:0.88rem; margin-top:2px;">No hay registros previos. Documenta cualquier reacción adversa que se identifique.</div>
            </div>
        </div>
    @endif

    <div class="card card-alergia mb-4">
        <div class="header-alergia">
            <div class="icon-circle"><i class="fas fa-allergies"></i></div>
            <div>
                <h6 class="mb-0 font-weight-bold" style="color:#7f0000;">Registro de Alergias</h6>
                <small class="text-muted">Medicamentos, alimentos, ambientales u otras reacciones adversas</small>
            </div>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('expedientes.consultas.alergias.guardar', [$mascota->id, $consulta->id]) }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label for="alergias" class="font-weight-bold text-gray-800 mb-2">
                        <i class="fas fa-list-ul mr-1" style="color:#c62828;"></i> Listado de Alergias:
                    </label>
                    <textarea class="form-control" id="alergias" name="alergias"
                        placeholder="Ejemplo: Alergia a la penicilina (reacción cutánea severa), intolerancia a la lactosa...">{{ old('alergias', $mascota->alergias) }}</textarea>
                    <small class="form-text text-muted mt-2">
                        <i class="fas fa-info-circle mr-1"></i> Esta información queda en el expediente permanente de la mascota.
                    </small>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-save-alergia">
                        <i class="fas fa-save mr-2"></i> Guardar Alergias
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#alergias'), {
        toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
    }).catch(error => console.error(error));
</script>
@endpush
