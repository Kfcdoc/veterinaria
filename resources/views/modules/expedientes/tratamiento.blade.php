@extends('layouts.app')

@section('titulo_pagina', 'Tratamiento Médico - Veterinaria')

@section('contenido')

@push('styles')
<style>
    /* === TRATAMIENTO: Temática Farmacéutica/Prescripción Azul-Violeta === */
    .rx-hero {
        background: linear-gradient(135deg, #1a237e 0%, #3949ab 50%, #5c6bc0 100%);
        border-radius: 16px;
        padding: 28px 32px;
        color: white;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(57, 73, 171, 0.35);
    }
    .rx-hero::before {
        content: 'Rx';
        position: absolute;
        right: 24px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 7rem;
        font-weight: 900;
        font-style: italic;
        color: rgba(255,255,255,0.08);
        font-family: 'Georgia', serif;
        line-height: 1;
    }
    .rx-hero .badge-consulta {
        background: rgba(255,255,255,0.18);
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        backdrop-filter: blur(4px);
    }
    .rx-hero h2 { font-size: 1.6rem; font-weight: 800; margin-bottom: 4px; }
    .rx-hero p  { opacity: 0.8; font-size: 0.92rem; margin-bottom: 0; }
    .rx-hero .hero-icon { font-size: 3.5rem; opacity: 0.9; }

    .card-rx {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(57, 73, 171, 0.1);
        overflow: hidden;
    }
    .card-rx .card-header-rx {
        background: linear-gradient(90deg, #f5f7ff 0%, #eef0fa 100%);
        border-bottom: 2px solid #c5cae9;
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .card-rx .card-header-rx .icon-circle {
        width: 42px; height: 42px;
        background: linear-gradient(135deg, #3949ab, #5c6bc0);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 1.1rem;
        flex-shrink: 0;
    }
    .status-pill {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 10px 18px; border-radius: 50px; font-size: 0.875rem;
        font-weight: 600; margin-bottom: 20px;
    }
    .status-pill.has-data { background: #e8eaf6; color: #3949ab; border: 1.5px solid #9fa8da; }
    .status-pill.no-data  { background: #fff8e1; color: #f57f17; border: 1.5px solid #ffcc02; }
    .status-pill .dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .status-pill.has-data .dot { background: #3949ab; }
    .status-pill.no-data  .dot  { background: #f57f17; }

    .btn-rx-save {
        background: linear-gradient(135deg, #1a237e, #3949ab);
        color: white; border: none;
        padding: 14px 36px; border-radius: 50px; font-size: 1rem;
        font-weight: 700; letter-spacing: 0.5px;
        box-shadow: 0 6px 20px rgba(57, 73, 171, 0.4);
        transition: all 0.3s ease;
    }
    .btn-rx-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(57, 73, 171, 0.5);
        color: white;
    }
    .ck-editor__editable_inline { min-height: 260px; font-size: 1.05rem; }
    .alert-rx-success {
        background: linear-gradient(135deg, #e8f5e9, #f1f8e9);
        border: 1.5px solid #a5d6a7; border-radius: 12px;
        color: #2e7d32; padding: 16px 20px;
    }
    .back-btn { border-radius: 50px !important; font-size: 0.8rem; font-weight: 600; }
</style>
@endpush

    {{-- Hero Header --}}
    <div class="rx-hero">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center gap-3" style="gap: 18px;">
                <div class="hero-icon"><i class="fas fa-prescription-bottle-alt"></i></div>
                <div>
                    <h2 class="mb-1">Prescripción y Tratamiento</h2>
                    <p><i class="fas fa-paw mr-1"></i> Paciente: <strong>{{ $mascota->nombre }}</strong> · {{ $mascota->especie }}</p>
                </div>
            </div>
            <div class="mt-2">
                <span class="badge-consulta"><i class="fas fa-calendar-alt mr-1"></i>{{ $consulta->fecha_consulta ? $consulta->fecha_consulta->format('d/m/Y H:i') : 'Sin fecha' }}</span>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <span></span>
        <a href="{{ route('expedientes.consultas.detalle', [$mascota->id, $consulta->id]) }}" class="btn btn-sm btn-outline-secondary back-btn">
            <i class="fas fa-arrow-left mr-1"></i> Volver a la Consulta
        </a>
    </div>

    @if(session('success'))
        <div class="alert-rx-success mb-4 d-flex align-items-center" style="gap: 12px; display: flex !important;">
            <i class="fas fa-check-circle fa-lg" style="color: #43a047;"></i>
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    <div class="card card-rx mb-4">
        <div class="card-header-rx">
            <div class="icon-circle"><i class="fas fa-pills"></i></div>
            <div>
                <h6 class="mb-0 font-weight-bold" style="color: #1a237e;">Receta Médica de esta Consulta</h6>
                <small class="text-muted">Medicamentos, dosis y frecuencia de administración</small>
            </div>
        </div>
        <div class="card-body p-4">
            @if($consulta->tratamiento)
                <div class="status-pill has-data mb-3">
                    <span class="dot"></span>
                    Tratamiento activo registrado — puedes actualizarlo
                </div>
            @else
                <div class="status-pill no-data mb-3">
                    <span class="dot"></span>
                    Aún sin prescripción — indica los medicamentos a continuación
                </div>
            @endif

            <form action="{{ route('expedientes.consultas.tratamiento.guardar', [$mascota->id, $consulta->id]) }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label for="tratamiento" class="font-weight-bold text-gray-800 mb-2">
                        <i class="fas fa-file-prescription mr-1" style="color: #3949ab;"></i> Detalles del Tratamiento:
                    </label>
                    <textarea class="form-control" id="tratamiento" name="tratamiento"
                        placeholder="Especifica: medicamento, dosis (mg/kg), frecuencia y duración del tratamiento...">{{ old('tratamiento', $consulta->tratamiento) }}</textarea>
                    <small class="form-text text-muted mt-2">
                        <i class="fas fa-lightbulb mr-1 text-warning"></i> Tip: Sé específico con las instrucciones para evitar errores en la medicación.
                    </small>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-rx-save">
                        <i class="fas fa-save mr-2"></i> Guardar Prescripción
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#tratamiento'), {
        toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
    }).catch(error => console.error(error));
</script>
@endpush
