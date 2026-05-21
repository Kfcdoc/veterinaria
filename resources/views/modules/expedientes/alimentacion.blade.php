@extends('layouts.app')

@section('titulo_pagina', 'Dieta y Alimentación - Veterinaria')

@section('contenido')

@push('styles')
<style>
    /* === ALIMENTACIÓN: Temática de Nutrición / Verde-Lima Natural === */
    .alim-hero {
        background: linear-gradient(135deg, #1b5e20 0%, #2e7d32 55%, #43a047 100%);
        border-radius: 16px;
        padding: 32px 36px;
        color: white;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(46, 125, 50, 0.38);
    }
    .alim-hero .bg-icon {
        position: absolute;
        right: 28px; top: 50%; transform: translateY(-50%);
        font-size: 8rem; color: rgba(255,255,255,0.07); line-height: 1;
    }
    .alim-hero h2 { font-size: 1.65rem; font-weight: 800; margin-bottom: 6px; }
    .alim-hero .subtitle { opacity: 0.82; font-size: 0.92rem; }
    .alim-hero .chip {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.2); color: white;
        padding: 6px 14px; border-radius: 20px;
        font-size: 0.78rem; font-weight: 600;
    }

    .card-alim {
        border: none; border-radius: 16px;
        box-shadow: 0 4px 24px rgba(46, 125, 50, 0.1);
        overflow: hidden;
    }
    .card-alim .header-alim {
        background: linear-gradient(90deg, #f1f8e9, #e8f5e9);
        border-bottom: 2px solid #a5d6a7;
        padding: 18px 24px; display: flex; align-items: center; gap: 14px;
    }
    .card-alim .header-alim .icon-circle {
        width: 44px; height: 44px;
        background: linear-gradient(135deg, #1b5e20, #43a047);
        border-radius: 12px; display: flex; align-items: center;
        justify-content: center; color: white; font-size: 1.2rem;
    }

    /* Nutrition Type Selector */
    .food-type-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 10px;
        margin-bottom: 20px;
    }
    .food-card {
        background: #f9fbe7; border: 2px solid #dcedc8;
        border-radius: 12px; padding: 14px 10px;
        text-align: center; cursor: pointer;
        transition: all 0.2s ease; user-select: none;
        color: #33691e; font-size: 0.8rem; font-weight: 600;
    }
    .food-card i { display: block; font-size: 1.8rem; margin-bottom: 6px; color: #558b2f; }
    .food-card:hover, .food-card.selected {
        background: #33691e; color: white; border-color: #33691e;
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(51,105,30,0.3);
    }
    .food-card.selected i, .food-card:hover i { color: white; }

    /* Frecuencia/Porción mini-form */
    .portion-row {
        background: #f9fbe7; border: 1.5px solid #dcedc8;
        border-radius: 12px; padding: 16px 20px;
        margin-bottom: 20px;
        display: flex; align-items: center; flex-wrap: wrap; gap: 16px;
    }
    .portion-row label { font-weight: 700; color: #33691e; font-size: 0.85rem; margin-bottom: 0; white-space: nowrap; }
    .portion-row .form-control-sm { border-radius: 8px; border: 1.5px solid #a5d6a7; width: 90px; }
    .portion-row select.form-control-sm { width: 120px; }

    .status-alim {
        border-radius: 12px; padding: 14px 20px;
        display: flex; align-items: center; gap: 14px;
        margin-bottom: 20px; font-weight: 600;
    }
    .status-alim.has { background: #f1f8e9; border: 1.5px solid #a5d6a7; color: #2e7d32; }
    .status-alim.none { background: #fafafa; border: 1.5px dashed #bdbdbd; color: #757575; }

    .btn-save-alim {
        background: linear-gradient(135deg, #1b5e20, #43a047);
        color: white; border: none;
        padding: 14px 36px; border-radius: 50px;
        font-size: 1rem; font-weight: 700; letter-spacing: 0.5px;
        box-shadow: 0 6px 20px rgba(67, 160, 71, 0.4);
        transition: all 0.3s ease;
    }
    .btn-save-alim:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(67,160,71,0.5); color: white; }
    .ck-editor__editable_inline { min-height: 220px; font-size: 1.05rem; }
    .alert-success-custom {
        background: linear-gradient(135deg, #e8f5e9, #f1f8e9);
        border: 1.5px solid #a5d6a7; border-radius: 12px;
        color: #2e7d32; padding: 16px 20px;
        display: flex; align-items: center; gap: 12px; margin-bottom: 20px;
    }
</style>
@endpush

    {{-- Hero Header --}}
    <div class="alim-hero">
        <div class="bg-icon"><i class="fas fa-leaf"></i></div>
        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:12px;">
            <div>
                <div class="chip mb-2"><i class="fas fa-apple-alt"></i> Antecedentes del Paciente</div>
                <h2>Dieta y Alimentación</h2>
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

    <div class="card card-alim mb-4">
        <div class="header-alim">
            <div class="icon-circle"><i class="fas fa-utensils"></i></div>
            <div>
                <h6 class="mb-0 font-weight-bold" style="color:#1b5e20;">Plan Nutricional del Paciente</h6>
                <small class="text-muted">Tipo de alimento, marcas, porciones y frecuencia de alimentación</small>
            </div>
        </div>
        <div class="card-body p-4">
            @if($mascota->alimentacion)
                <div class="status-alim has">
                    <i class="fas fa-utensils fa-lg" style="flex-shrink:0;"></i>
                    <span>Dieta registrada. Actualiza si el paciente ha cambiado su régimen alimenticio.</span>
                </div>
            @else
                <div class="status-alim none">
                    <i class="fas fa-question-circle fa-lg" style="flex-shrink:0;"></i>
                    <span>Sin información nutricional registrada. Completa el plan de dieta a continuación.</span>
                </div>
            @endif

            {{-- Tipo de alimento --}}
            <div class="mb-3">
                <p class="font-weight-bold text-gray-800 mb-2" style="font-size:0.87rem;">
                    <i class="fas fa-bowl-food mr-1" style="color:#2e7d32;"></i> Tipo de alimento principal (selecciona e inserta):
                </p>
                <div class="food-type-grid">
                    <div class="food-card" data-text="Croquetas (alimento seco)"><i class="fas fa-circle"></i>Croquetas</div>
                    <div class="food-card" data-text="Comida húmeda / lata"><i class="fas fa-drumstick-bite"></i>Lata/Húmedo</div>
                    <div class="food-card" data-text="Dieta BARF (cruda natural)"><i class="fas fa-leaf"></i>BARF</div>
                    <div class="food-card" data-text="Comida casera cocida"><i class="fas fa-fire"></i>Casera</div>
                    <div class="food-card" data-text="Dieta de prescripción veterinaria"><i class="fas fa-prescription"></i>Prescripción</div>
                    <div class="food-card" data-text="Dieta mixta (seco + húmedo)"><i class="fas fa-random"></i>Mixta</div>
                </div>
            </div>

            {{-- Porción y frecuencia visual --}}
            <div class="portion-row">
                <label><i class="fas fa-weight mr-1"></i> Porción:</label>
                <input type="text" id="portionInput" class="form-control form-control-sm" placeholder="ej. 250g">
                <label><i class="fas fa-clock mr-1"></i> Frecuencia:</label>
                <select id="freqSelect" class="form-control form-control-sm">
                    <option value="">-- Selecciona --</option>
                    <option>1 vez al día</option>
                    <option>2 veces al día</option>
                    <option>3 veces al día</option>
                    <option>A libre acceso</option>
                </select>
                <button type="button" id="insertPortionBtn" class="btn btn-sm" style="background:#2e7d32; color:white; border-radius:8px; font-weight:700;">
                    <i class="fas fa-plus mr-1"></i> Insertar
                </button>
            </div>

            <form action="{{ route('expedientes.consultas.alimentacion.guardar', [$mascota->id, $consulta->id]) }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label for="alimentacion" class="font-weight-bold text-gray-800 mb-2">
                        <i class="fas fa-clipboard-list mr-1" style="color:#2e7d32;"></i> Descripción Completa del Plan Nutricional:
                    </label>
                    <textarea class="form-control" id="alimentacion" name="alimentacion"
                        placeholder="Especifica el tipo de alimento, marca, porción diaria, número de comidas y cualquier suplemento...">{{ old('alimentacion', $mascota->alimentacion) }}</textarea>
                    <small class="form-text text-muted mt-2">
                        <i class="fas fa-info-circle mr-1"></i> Esta información queda en el expediente permanente de la mascota.
                    </small>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-save-alim">
                        <i class="fas fa-save mr-2"></i> Guardar Plan Nutricional
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    let editorAlim;
    ClassicEditor.create(document.querySelector('#alimentacion'), {
        toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
    }).then(editor => {
        editorAlim = editor;

        // Food type shortcuts
        document.querySelectorAll('.food-card').forEach(card => {
            card.addEventListener('click', () => {
                const text = card.getAttribute('data-text');
                editorAlim.model.change(writer => {
                    editorAlim.model.insertContent(writer.createText('Tipo de alimento: ' + text + '\n'));
                });
                document.querySelectorAll('.food-card').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
            });
        });

        // Portion + frequency insert
        document.getElementById('insertPortionBtn').addEventListener('click', () => {
            const portion = document.getElementById('portionInput').value.trim();
            const freq    = document.getElementById('freqSelect').value;
            if (!portion && !freq) return;
            let txt = '';
            if (portion) txt += 'Porción: ' + portion + ' ';
            if (freq)    txt += '· Frecuencia: ' + freq;
            editorAlim.model.change(writer => {
                editorAlim.model.insertContent(writer.createText(txt.trim() + '\n'));
            });
        });

    }).catch(error => console.error(error));
</script>
@endpush
