@extends('layouts.app')

@section('titulo_pagina', 'Lesiones Previas - Veterinaria')

@section('contenido')

@push('styles')
<style>
    /* === LESIONES: Temática Anatómica / Naranja-Ámbar de Trauma === */
    .lesion-hero {
        background: linear-gradient(135deg, #e65100 0%, #ef6c00 55%, #fb8c00 100%);
        border-radius: 16px;
        padding: 32px 36px;
        color: white;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(239, 108, 0, 0.38);
    }
    .lesion-hero .bg-bones {
        position: absolute;
        right: 20px; top: 50%;
        transform: translateY(-50%);
        font-size: 8rem;
        color: rgba(255,255,255,0.06);
        line-height: 1;
    }
    .lesion-hero h2 { font-size: 1.65rem; font-weight: 800; margin-bottom: 6px; }
    .lesion-hero .subtitle { opacity: 0.85; font-size: 0.92rem; }
    .lesion-hero .chip {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.18); color: white;
        padding: 6px 14px; border-radius: 20px;
        font-size: 0.78rem; font-weight: 600;
    }

    /* Body Region Selector (visual touch) */
    .region-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 10px;
        margin-bottom: 20px;
    }
    .region-btn {
        background: #fff8f0; border: 2px solid #ffe0b2;
        border-radius: 10px; padding: 10px 8px;
        text-align: center; cursor: pointer;
        font-size: 0.78rem; font-weight: 600; color: #e65100;
        transition: all 0.2s ease;
        user-select: none;
    }
    .region-btn:hover, .region-btn.active {
        background: #ff6d00; border-color: #ff6d00; color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255,109,0,0.3);
    }
    .region-btn i { display: block; font-size: 1.5rem; margin-bottom: 4px; }

    .card-lesion {
        border: none; border-radius: 16px;
        box-shadow: 0 4px 24px rgba(239, 108, 0, 0.12);
        overflow: hidden;
    }
    .card-lesion .header-lesion {
        background: linear-gradient(90deg, #fff8f0, #fff3e0);
        border-bottom: 2px solid #ffcc80;
        padding: 18px 24px;
        display: flex; align-items: center; gap: 14px;
    }
    .card-lesion .header-lesion .icon-circle {
        width: 44px; height: 44px;
        background: linear-gradient(135deg, #e65100, #ef6c00);
        border-radius: 12px; display: flex; align-items: center;
        justify-content: center; color: white; font-size: 1.2rem;
    }
    .status-lesion {
        border-radius: 12px; padding: 14px 20px;
        display: flex; align-items: center; gap: 14px;
        margin-bottom: 20px; font-weight: 600;
    }
    .status-lesion.has { background: #fff3e0; border: 1.5px solid #ffcc80; color: #e65100; }
    .status-lesion.none { background: #f1f8e9; border: 1.5px solid #c5e1a5; color: #558b2f; }

    .btn-save-lesion {
        background: linear-gradient(135deg, #e65100, #fb8c00);
        color: white; border: none;
        padding: 14px 36px; border-radius: 50px;
        font-size: 1rem; font-weight: 700; letter-spacing: 0.5px;
        box-shadow: 0 6px 20px rgba(239, 108, 0, 0.4);
        transition: all 0.3s ease;
    }
    .btn-save-lesion:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(239,108,0,0.5); color: white; }
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
    <div class="lesion-hero">
        <div class="bg-bones"><i class="fas fa-bone"></i></div>
        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:12px;">
            <div>
                <div class="chip mb-2"><i class="fas fa-file-medical-alt"></i> Antecedentes del Paciente</div>
                <h2>Historial de Lesiones</h2>
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

    <div class="card card-lesion mb-4">
        <div class="header-lesion">
            <div class="icon-circle"><i class="fas fa-bone"></i></div>
            <div>
                <h6 class="mb-0 font-weight-bold" style="color:#e65100;">Traumatismos, Fracturas y Lesiones Previas</h6>
                <small class="text-muted">Historial permanente de la mascota — independiente de la consulta</small>
            </div>
        </div>
        <div class="card-body p-4">
            @if($mascota->lesiones)
                <div class="status-lesion has">
                    <i class="fas fa-exclamation-circle fa-lg"></i>
                    <span>Hay lesiones o traumatismos documentados. Verifica su relación con el cuadro clínico actual.</span>
                </div>
            @else
                <div class="status-lesion none">
                    <i class="fas fa-check-circle fa-lg"></i>
                    <span>Sin lesiones previas registradas. Documenta cualquier hallazgo relevante.</span>
                </div>
            @endif

            {{-- Atajos de región corporal --}}
            <div class="mb-3">
                <p class="font-weight-bold text-gray-800 mb-2" style="font-size:0.87rem;">
                    <i class="fas fa-map-marker-alt mr-1" style="color:#ef6c00;"></i> Atajos de región afectada (haz clic para insertar):
                </p>
                <div class="region-grid" id="regionGrid">
                    <div class="region-btn" data-text="Cabeza/Cráneo"><i class="fas fa-circle"></i>Cabeza</div>
                    <div class="region-btn" data-text="Columna vertebral"><i class="fas fa-grip-lines-vertical"></i>Columna</div>
                    <div class="region-btn" data-text="Miembro anterior izquierdo"><i class="fas fa-hand-paper"></i>M. Ant. Izq.</div>
                    <div class="region-btn" data-text="Miembro anterior derecho"><i class="fas fa-hand-paper"></i>M. Ant. Der.</div>
                    <div class="region-btn" data-text="Miembro posterior izquierdo"><i class="fas fa-shoe-prints"></i>M. Post. Izq.</div>
                    <div class="region-btn" data-text="Miembro posterior derecho"><i class="fas fa-shoe-prints"></i>M. Post. Der.</div>
                    <div class="region-btn" data-text="Tórax/Costillas"><i class="fas fa-lungs"></i>Tórax</div>
                    <div class="region-btn" data-text="Abdomen"><i class="fas fa-circle-notch"></i>Abdomen</div>
                </div>
            </div>

            <form action="{{ route('expedientes.consultas.lesiones.guardar', [$mascota->id, $consulta->id]) }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label for="lesiones" class="font-weight-bold text-gray-800 mb-2">
                        <i class="fas fa-pen-nib mr-1" style="color:#ef6c00;"></i> Descripción de Lesiones:
                    </label>
                    <textarea class="form-control" id="lesiones" name="lesiones"
                        placeholder="Describe la región afectada, tipo de lesión (fractura, luxación, contusión...), fecha aproximada y tratamiento previo...">{{ old('lesiones', $mascota->lesiones) }}</textarea>
                    <small class="form-text text-muted mt-2">
                        <i class="fas fa-info-circle mr-1"></i> Usa los atajos de región para agilizar el registro.
                    </small>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-save-lesion">
                        <i class="fas fa-save mr-2"></i> Guardar Lesiones
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    let editorLesiones;
    ClassicEditor.create(document.querySelector('#lesiones'), {
        toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
    }).then(editor => {
        editorLesiones = editor;
        // Region shortcuts
        document.querySelectorAll('.region-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const text = btn.getAttribute('data-text');
                editorLesiones.model.change(writer => {
                    editorLesiones.model.insertContent(writer.createText('• ' + text + ': '));
                });
                btn.classList.add('active');
                setTimeout(() => btn.classList.remove('active'), 400);
            });
        });
    }).catch(error => console.error(error));
</script>
@endpush
