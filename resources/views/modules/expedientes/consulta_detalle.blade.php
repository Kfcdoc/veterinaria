@extends('layouts.app')

@section('titulo_pagina', 'Detalle de Consulta - Veterinaria')

@push('styles')
<style>
    /* ── Consulta Detalle: Layout Premium ── */
    .detalle-hero {
        background: linear-gradient(135deg, #283593 0%, #3949ab 60%, #5c6bc0 100%);
        border-radius: 16px;
        padding: 26px 32px;
        color: white;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(57, 73, 171, 0.32);
    }
    .detalle-hero::after {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }
    .detalle-hero h2 { font-size: 1.5rem; font-weight: 800; margin-bottom: 4px; }
    .detalle-hero .subtitle { opacity: 0.82; font-size: 0.9rem; }
    .detalle-hero .chip {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.18); color: white;
        padding: 6px 14px; border-radius: 20px;
        font-size: 0.8rem; font-weight: 600;
        backdrop-filter: blur(4px);
    }

    /* ── Cards principales ── */
    .card-detalle {
        border: none; border-radius: 16px;
        box-shadow: 0 4px 24px rgba(57,73,171,0.08);
        overflow: hidden; margin-bottom: 20px;
    }
    .card-detalle .section-header {
        padding: 16px 22px;
        display: flex; align-items: center; gap: 12px;
        border-bottom: 2px solid;
    }
    .card-detalle .section-header .hico {
        width: 36px; height: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 1rem; flex-shrink: 0;
    }
    .card-detalle .section-header h6 { margin: 0; font-weight: 700; font-size: 0.95rem; }
    .card-detalle .section-header small { font-size: 0.77rem; }

    /* ── Info Pills ── */
    .info-pill-row { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 16px; }
    .info-pill {
        background: #f5f7ff; border: 1.5px solid #c5cae9;
        border-radius: 10px; padding: 10px 16px;
        display: flex; align-items: center; gap: 10px;
        flex: 1 1 140px; min-width: 0;
    }
    .info-pill .pill-icon {
        width: 32px; height: 32px; border-radius: 8px;
        background: linear-gradient(135deg, #3949ab, #5c6bc0);
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 0.85rem; flex-shrink: 0;
    }
    .info-pill .pill-label { font-size: 0.72rem; color: #9fa8da; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .info-pill .pill-value { font-size: 0.95rem; font-weight: 700; color: #283593; }

    /* ── Bloques de contenido clínico (Dx, Tx) ── */
    .clinical-block {
        background: #f8f9fc; border-radius: 12px;
        padding: 18px 20px; margin-bottom: 16px;
        border-left: 4px solid;
        position: relative;
    }
    .clinical-block .cb-label {
        font-size: 0.75rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.8px;
        margin-bottom: 10px; display: flex; align-items: center; gap: 6px;
    }
    .clinical-block .cb-content {
        font-size: 0.95rem; line-height: 1.7; color: #2d3748;
    }
    .clinical-block .cb-empty {
        font-size: 0.9rem; color: #a0aec0; font-style: italic;
        display: flex; align-items: center; gap: 8px;
    }
    .clinical-block .edit-btn {
        position: absolute; top: 14px; right: 14px;
        background: white; border: 1.5px solid #e2e8f0;
        border-radius: 8px; padding: 4px 12px;
        font-size: 0.75rem; font-weight: 600; color: #3949ab;
        transition: all 0.2s ease; text-decoration: none;
    }
    .clinical-block .edit-btn:hover {
        background: #3949ab; color: white; border-color: #3949ab;
        transform: translateY(-1px);
    }

    /* Dx → azul, Tx → violeta */
    .cb-dx { border-left-color: #3949ab; }
    .cb-tx { border-left-color: #8e24aa; }

    /* ── Antecedentes sidebar ── */
    .card-ant {
        border: none; border-radius: 16px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .ant-header {
        background: linear-gradient(90deg, #eceff1, #fafafa);
        border-bottom: 2px solid #cfd8dc;
        padding: 16px 20px; display: flex; align-items: center; gap: 10px;
    }
    .ant-header .hico {
        width: 34px; height: 34px; border-radius: 9px;
        background: linear-gradient(135deg, #546e7a, #78909c);
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 0.9rem;
    }

    .ant-item {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f3f4;
        display: flex; flex-direction: column; gap: 4px;
        transition: background 0.15s ease;
    }
    .ant-item:last-child { border-bottom: none; }
    .ant-item:hover { background: #fafbff; }

    .ant-item .ant-label {
        font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.7px; display: flex; align-items: center; gap: 6px;
    }
    .ant-item .ant-value {
        font-size: 0.88rem; color: #37474f; line-height: 1.5;
    }
    .ant-item .ant-value.empty {
        color: #90a4ae; font-style: italic; font-size: 0.83rem;
    }
    .ant-item .ant-edit-link {
        font-size: 0.75rem; font-weight: 600;
        text-decoration: none; align-self: flex-start;
        padding: 2px 10px; border-radius: 20px;
        border: 1.5px solid; transition: all 0.2s ease; margin-top: 4px;
    }
    .ant-item .ant-edit-link:hover { transform: scale(1.05); }

    /* colores por sección */
    .lbl-basico { color: #546e7a; } .ico-basico { background: #546e7a !important; }
    .lbl-alergia { color: #c62828; } .ico-alergia { background: linear-gradient(135deg,#c62828,#e53935) !important; }
    .lbl-lesion  { color: #e65100; } .ico-lesion  { background: linear-gradient(135deg,#e65100,#fb8c00) !important; }
    .lbl-pato    { color: #00695c; } .ico-pato    { background: linear-gradient(135deg,#004d40,#00897b) !important; }
    .lbl-alim    { color: #2e7d32; } .ico-alim    { background: linear-gradient(135deg,#1b5e20,#43a047) !important; }

    .link-alergia { color: #c62828; border-color: #ef9a9a; }
    .link-alergia:hover { background: #c62828; color: white; border-color: #c62828; }
    .link-lesion  { color: #e65100; border-color: #ffcc80; }
    .link-lesion:hover  { background: #e65100; color: white; border-color: #e65100; }
    .link-pato    { color: #00695c; border-color: #80cbc4; }
    .link-pato:hover    { background: #00695c; color: white; border-color: #00695c; }
    .link-alim    { color: #2e7d32; border-color: #a5d6a7; }
    .link-alim:hover    { background: #2e7d32; color: white; border-color: #2e7d32; }

    /* Badge indicador */
    .has-badge {
        display: inline-block; width: 8px; height: 8px;
        border-radius: 50%; margin-right: 4px; flex-shrink: 0;
    }

    /* CKEditor rendered content */
    .ck-content ul, .ck-content ol { padding-left: 1.4em; }
    .ck-content blockquote { border-left: 4px solid #9fa8da; padding-left: 12px; color: #5c6bc0; margin: 8px 0; }
    .ck-content table { border-collapse: collapse; width: 100%; margin: 8px 0; }
    .ck-content table td, .ck-content table th { border: 1px solid #e0e0e0; padding: 6px 10px; font-size: 0.9rem; }
    .ck-content h2 { font-size: 1.1rem; font-weight: 700; }
    .ck-content h3 { font-size: 1rem; font-weight: 700; }
</style>
@endpush

@section('contenido')

    {{-- Hero --}}
    <div class="detalle-hero">
        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:12px;">
            <div>
                <h2><i class="fas fa-stethoscope mr-2" style="opacity:0.85;"></i>Detalle de Consulta</h2>
                <div class="subtitle"><i class="fas fa-paw mr-1"></i> <strong>{{ $mascota->nombre }}</strong> · {{ $mascota->especie }}{{ $mascota->raza ? ' · '.$mascota->raza : '' }}</div>
            </div>
            <div class="d-flex align-items-center" style="gap:10px; flex-wrap:wrap;">
                <span class="chip"><i class="fas fa-calendar-alt"></i> {{ $consulta->fecha_consulta ? $consulta->fecha_consulta->format('d/m/Y H:i') : 'Sin fecha' }}</span>
                <a href="{{ route('expedientes.consultas', $mascota->id) }}" class="chip" style="text-decoration:none;">
                    <i class="fas fa-arrow-left"></i> Volver a Consultas
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- ══ COLUMNA IZQUIERDA: Info + Dx + Tx ══ --}}
        <div class="col-lg-8">

            {{-- Info de la Consulta --}}
            <div class="card card-detalle">
                <div class="section-header" style="background:#f5f7ff; border-color:#c5cae9;">
                    <div class="hico" style="background:linear-gradient(135deg,#3949ab,#5c6bc0);"><i class="fas fa-clipboard-list"></i></div>
                    <div>
                        <h6 style="color:#283593;">Información General de la Consulta</h6>
                        <small class="text-muted">Datos registrados durante la visita</small>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="info-pill-row">
                        <div class="info-pill">
                            <div class="pill-icon"><i class="fas fa-user-md"></i></div>
                            <div>
                                <div class="pill-label">Veterinario</div>
                                <div class="pill-value">{{ $consulta->veterinario ? $consulta->veterinario->nombre : 'No especificado' }}</div>
                            </div>
                        </div>
                        <div class="info-pill">
                            <div class="pill-icon"><i class="fas fa-weight"></i></div>
                            <div>
                                <div class="pill-label">Peso</div>
                                <div class="pill-value">{{ $consulta->peso ? $consulta->peso.' kg' : '—' }}</div>
                            </div>
                        </div>
                        <div class="info-pill">
                            <div class="pill-icon"><i class="fas fa-ruler-vertical"></i></div>
                            <div>
                                <div class="pill-label">Talla</div>
                                <div class="pill-value">{{ $consulta->talla ? $consulta->talla.' cm' : '—' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Diagnóstico --}}
            <div class="clinical-block cb-dx">
                <div class="cb-label" style="color:#3949ab;">
                    <i class="fas fa-stethoscope"></i> Diagnóstico Médico
                </div>
                <a href="{{ route('expedientes.consultas.diagnostico', [$mascota->id, $consulta->id]) }}" class="edit-btn">
                    <i class="fas fa-edit mr-1"></i> Editar
                </a>
                @if($consulta->diagnostico)
                    <div class="cb-content ck-content">{!! $consulta->diagnostico !!}</div>
                @else
                    <div class="cb-empty">
                        <i class="fas fa-file-medical" style="color:#c5cae9; font-size:1.4rem;"></i>
                        Aún no se ha registrado un diagnóstico para esta consulta.
                    </div>
                @endif
            </div>

            {{-- Tratamiento --}}
            <div class="clinical-block cb-tx">
                <div class="cb-label" style="color:#8e24aa;">
                    <i class="fas fa-pills"></i> Prescripción / Tratamiento
                </div>
                <a href="{{ route('expedientes.consultas.tratamiento', [$mascota->id, $consulta->id]) }}" class="edit-btn">
                    <i class="fas fa-edit mr-1"></i> Editar
                </a>
                @if($consulta->tratamiento)
                    <div class="cb-content ck-content">{!! $consulta->tratamiento !!}</div>
                @else
                    <div class="cb-empty">
                        <i class="fas fa-prescription-bottle-alt" style="color:#e1bee7; font-size:1.4rem;"></i>
                        Aún no se ha recetado un tratamiento para esta consulta.
                    </div>
                @endif
            </div>

        </div>

        {{-- ══ COLUMNA DERECHA: Antecedentes ══ --}}
        <div class="col-lg-4">
            <div class="card card-ant">
                <div class="ant-header">
                    <div class="hico"><i class="fas fa-folder-open"></i></div>
                    <div>
                        <h6 class="mb-0 font-weight-bold" style="color:#37474f;">Antecedentes Clínicos</h6>
                        <small class="text-muted">Expediente general de {{ $mascota->nombre }}</small>
                    </div>
                </div>

                {{-- Datos básicos --}}
                <div class="ant-item">
                    <div class="ant-label lbl-basico"><i class="fas fa-paw"></i> Ficha Básica</div>
                    <div class="ant-value">
                        <strong>Especie:</strong> {{ $mascota->especie }}<br>
                        @if($mascota->raza)<strong>Raza:</strong> {{ $mascota->raza }}<br>@endif
                        <strong>Tipo de Sangre:</strong> {{ $mascota->tipo_sangre ?? '—' }}<br>
                        <strong>Comportamiento:</strong> {{ $mascota->comportamiento ?? '—' }}<br>
                        <strong>Adoptado:</strong> {{ $mascota->es_adoptado ? 'Sí' : 'No' }}<br>
                        <strong>F. Nacimiento:</strong> {{ $mascota->fecha_nacimiento ? $mascota->fecha_nacimiento->format('d/m/Y') : 'Desconocida' }}
                    </div>
                </div>

                {{-- Alergias --}}
                <div class="ant-item">
                    <div class="ant-label lbl-alergia">
                        @if($mascota->alergias)
                            <span class="has-badge" style="background:#e53935;"></span>
                        @endif
                        <i class="fas fa-allergies"></i> Alergias
                    </div>
                    @if($mascota->alergias)
                        <div class="ant-value ck-content">{!! $mascota->alergias !!}</div>
                    @else
                        <div class="ant-value empty">Sin alergias registradas.</div>
                    @endif
                    <a href="{{ route('expedientes.consultas.alergias', [$mascota->id, $consulta->id]) }}" class="ant-edit-link link-alergia">
                        <i class="fas fa-edit mr-1"></i> {{ $mascota->alergias ? 'Actualizar' : 'Registrar' }}
                    </a>
                </div>

                {{-- Lesiones --}}
                <div class="ant-item">
                    <div class="ant-label lbl-lesion">
                        @if($mascota->lesiones)
                            <span class="has-badge" style="background:#fb8c00;"></span>
                        @endif
                        <i class="fas fa-bone"></i> Lesiones Previas
                    </div>
                    @if($mascota->lesiones)
                        <div class="ant-value ck-content">{!! $mascota->lesiones !!}</div>
                    @else
                        <div class="ant-value empty">Sin lesiones previas registradas.</div>
                    @endif
                    <a href="{{ route('expedientes.consultas.lesiones', [$mascota->id, $consulta->id]) }}" class="ant-edit-link link-lesion">
                        <i class="fas fa-edit mr-1"></i> {{ $mascota->lesiones ? 'Actualizar' : 'Registrar' }}
                    </a>
                </div>

                {{-- Patológicos --}}
                <div class="ant-item">
                    <div class="ant-label lbl-pato">
                        @if($mascota->patologicos)
                            <span class="has-badge" style="background:#00897b;"></span>
                        @endif
                        <i class="fas fa-file-medical-alt"></i> Antec. Patológicos
                    </div>
                    @if($mascota->patologicos)
                        <div class="ant-value ck-content">{!! $mascota->patologicos !!}</div>
                    @else
                        <div class="ant-value empty">Sin antecedentes patológicos.</div>
                    @endif
                    <a href="{{ route('expedientes.consultas.patologicos', [$mascota->id, $consulta->id]) }}" class="ant-edit-link link-pato">
                        <i class="fas fa-edit mr-1"></i> {{ $mascota->patologicos ? 'Actualizar' : 'Registrar' }}
                    </a>
                </div>

                {{-- Alimentación --}}
                <div class="ant-item">
                    <div class="ant-label lbl-alim">
                        @if($mascota->alimentacion)
                            <span class="has-badge" style="background:#43a047;"></span>
                        @endif
                        <i class="fas fa-utensils"></i> Dieta / Alimentación
                    </div>
                    @if($mascota->alimentacion)
                        <div class="ant-value ck-content">{!! $mascota->alimentacion !!}</div>
                    @else
                        <div class="ant-value empty">Sin información de dieta.</div>
                    @endif
                    <a href="{{ route('expedientes.consultas.alimentacion', [$mascota->id, $consulta->id]) }}" class="ant-edit-link link-alim">
                        <i class="fas fa-edit mr-1"></i> {{ $mascota->alimentacion ? 'Actualizar' : 'Registrar' }}
                    </a>
                </div>

            </div>
        </div>
    </div>

@endsection
