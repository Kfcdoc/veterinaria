@extends('layouts.app')

@section('titulo_pagina', 'Antecedentes Patológicos - Veterinaria')

@section('contenido')

@push('styles')
<style>
    /* === PATOLÓGICOS: Temática Clínica / Azul-Teal Oscuro de Medicina === */
    .pato-hero {
        background: linear-gradient(135deg, #004d40 0%, #00695c 55%, #00897b 100%);
        border-radius: 16px;
        padding: 32px 36px;
        color: white;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 105, 92, 0.4);
    }
    .pato-hero .bg-dna {
        position: absolute;
        right: 28px; top: 50%; transform: translateY(-50%);
        font-size: 8rem; color: rgba(255,255,255,0.07); line-height: 1;
    }
    .pato-hero h2 { font-size: 1.65rem; font-weight: 800; margin-bottom: 6px; }
    .pato-hero .subtitle { opacity: 0.82; font-size: 0.92rem; }
    .pato-hero .chip {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.18); color: white;
        padding: 6px 14px; border-radius: 20px;
        font-size: 0.78rem; font-weight: 600;
    }

    /* Historial de condiciones en tarjetas */
    .card-pato {
        border: none; border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0, 105, 92, 0.12);
        overflow: hidden;
    }
    .card-pato .header-pato {
        background: linear-gradient(90deg, #e0f2f1, #f1f8e9);
        border-bottom: 2px solid #80cbc4;
        padding: 18px 24px; display: flex; align-items: center; gap: 14px;
    }
    .card-pato .header-pato .icon-circle {
        width: 44px; height: 44px;
        background: linear-gradient(135deg, #004d40, #00897b);
        border-radius: 12px; display: flex; align-items: center;
        justify-content: center; color: white; font-size: 1.2rem;
    }

    /* Quick Condition Tags */
    .condition-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px; }
    .ctag {
        background: #e0f2f1; border: 1.5px solid #80cbc4;
        color: #00695c; padding: 6px 14px; border-radius: 20px;
        font-size: 0.8rem; font-weight: 600; cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }
    .ctag:hover {
        background: #00897b; color: white;
        border-color: #00897b; transform: scale(1.05);
    }
    .ctag i { margin-right: 5px; }

    .status-pato {
        border-radius: 12px; padding: 14px 20px;
        display: flex; align-items: center; gap: 14px;
        margin-bottom: 20px; font-weight: 600;
    }
    .status-pato.has { background: #e0f2f1; border: 1.5px solid #80cbc4; color: #004d40; }
    .status-pato.none { background: #fafafa; border: 1.5px dashed #bdbdbd; color: #757575; }

    .btn-save-pato {
        background: linear-gradient(135deg, #004d40, #00897b);
        color: white; border: none;
        padding: 14px 36px; border-radius: 50px;
        font-size: 1rem; font-weight: 700; letter-spacing: 0.5px;
        box-shadow: 0 6px 20px rgba(0, 137, 123, 0.4);
        transition: all 0.3s ease;
    }
    .btn-save-pato:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,137,123,0.5); color: white; }
    .ck-editor__editable_inline { min-height: 260px; font-size: 1.05rem; }
    .alert-success-custom {
        background: linear-gradient(135deg, #e8f5e9, #f1f8e9);
        border: 1.5px solid #a5d6a7; border-radius: 12px;
        color: #2e7d32; padding: 16px 20px;
        display: flex; align-items: center; gap: 12px; margin-bottom: 20px;
    }
</style>
@endpush

    {{-- Hero Header --}}
    <div class="pato-hero">
        <div class="bg-dna"><i class="fas fa-dna"></i></div>
        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:12px;">
            <div>
                <div class="chip mb-2"><i class="fas fa-notes-medical"></i> Antecedentes del Paciente</div>
                <h2>Historial Patológico</h2>
                <div class="subtitle">
                    <i class="fas fa-paw mr-1"></i> <strong>{{ $mascota->nombre }}</strong> · {{ $mascota->especie }}
                    @if($mascota->raza) · {{ $mascota->raza }}@endif
                </div>
            </div>
            <div class="chip"><i class="fas fa-calendar-alt"></i> {{ $consulta->fecha_consulta ? $consulta->fecha_consulta->format('d/m/Y') : 'Sin fecha' }}</div>
        </div>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('expedientes.consultas.detalle', [$mascota->id, $consulta->id]) }}" class="btn btn-sm btn-outline-secondary" style="border-radius:50px; font-weight:600;">
            <i class="fas fa-arrow-left mr-1"></i> Volver a la Consulta
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success-custom">
            <i class="fas fa-check-circle fa-lg" style="color:#43a047;"></i>
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    <div class="card card-pato mb-4">
        <div class="header-pato">
            <div class="icon-circle"><i class="fas fa-file-medical-alt"></i></div>
            <div>
                <h6 class="mb-0 font-weight-bold" style="color:#004d40;">Enfermedades y Condiciones Médicas</h6>
                <small class="text-muted">Historial clínico permanente — enfermedades crónicas, cirugías y condiciones previas</small>
            </div>
        </div>
        <div class="card-body p-4">
            @if($mascota->patologicos)
                <div class="status-pato has">
                    <i class="fas fa-clipboard-list fa-lg" style="flex-shrink:0;"></i>
                    <span>Existen antecedentes documentados. Analiza su relevancia en el contexto actual.</span>
                </div>
            @else
                <div class="status-pato none">
                    <i class="fas fa-folder-open fa-lg" style="flex-shrink:0;"></i>
                    <span>Sin antecedentes registrados. Utiliza los atajos para agilizar el proceso.</span>
                </div>
            @endif

            {{-- Atajos de condiciones comunes --}}
            <div class="mb-3">
                <p class="font-weight-bold text-gray-800 mb-2" style="font-size:0.87rem;">
                    <i class="fas fa-tags mr-1" style="color:#00695c;"></i> Condiciones frecuentes (haz clic para insertar):
                </p>
                <div class="condition-tags">
                    <span class="ctag" data-text="Diabetes mellitus"><i class="fas fa-tint"></i>Diabetes</span>
                    <span class="ctag" data-text="Insuficiencia renal crónica"><i class="fas fa-kidneys"></i>Insuf. Renal</span>
                    <span class="ctag" data-text="Enfermedad cardíaca"><i class="fas fa-heartbeat"></i>Cardíaca</span>
                    <span class="ctag" data-text="Epilepsia / convulsiones"><i class="fas fa-brain"></i>Epilepsia</span>
                    <span class="ctag" data-text="Hipotiroidismo"><i class="fas fa-thermometer-half"></i>Hipotiroidismo</span>
                    <span class="ctag" data-text="Displasia de cadera"><i class="fas fa-running"></i>Displasia</span>
                    <span class="ctag" data-text="Cataratas"><i class="fas fa-eye"></i>Cataratas</span>
                    <span class="ctag" data-text="Dermatitis atópica"><i class="fas fa-hand-sparkles"></i>Dermatitis</span>
                </div>
            </div>

            <form action="{{ route('expedientes.consultas.patologicos.guardar', [$mascota->id, $consulta->id]) }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label for="patologicos" class="font-weight-bold text-gray-800 mb-2">
                        <i class="fas fa-stethoscope mr-1" style="color:#00695c;"></i> Condiciones Médicas Registradas:
                    </label>
                    <textarea class="form-control" id="patologicos" name="patologicos"
                        placeholder="Indica las enfermedades previas, cirugías realizadas, condiciones crónicas y fechas aproximadas de diagnóstico...">{{ old('patologicos', $mascota->patologicos) }}</textarea>
                    <small class="form-text text-muted mt-2">
                        <i class="fas fa-info-circle mr-1"></i> Esta información queda en el expediente permanente de la mascota.
                    </small>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-save-pato">
                        <i class="fas fa-save mr-2"></i> Guardar Antecedentes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    let editorPato;
    ClassicEditor.create(document.querySelector('#patologicos'), {
        toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
    }).then(editor => {
        editorPato = editor;
        document.querySelectorAll('.ctag').forEach(tag => {
            tag.addEventListener('click', () => {
                const text = tag.getAttribute('data-text');
                editorPato.model.change(writer => {
                    editorPato.model.insertContent(writer.createText('• ' + text + ': '));
                });
            });
        });
    }).catch(error => console.error(error));
</script>
@endpush
