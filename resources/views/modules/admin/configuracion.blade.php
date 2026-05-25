@extends('layouts.admin')

@section('titulo_pagina', 'Configuración del Sistema')

@push('styles')
<style>
    .config-hero {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        border-radius: 16px; padding: 32px 36px; color: white;
        margin-bottom: 28px; position: relative; overflow: hidden;
        box-shadow: 0 8px 32px rgba(15, 52, 96, 0.45);
    }
    .config-hero::after {
        content: ''; position: absolute; top: -40px; right: -40px;
        width: 200px; height: 200px; border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }
    .config-hero h2 { font-size: 1.6rem; font-weight: 800; }
    .config-hero .subtitle { opacity: 0.75; font-size: 0.9rem; }

    .config-card {
        border: none; border-radius: 16px; overflow: hidden;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06); margin-bottom: 24px;
    }
    .config-card .card-header-custom {
        padding: 18px 24px; display: flex; align-items: center; gap: 14px;
        border-bottom: 2px solid;
    }
    .config-card .hico {
        width: 42px; height: 42px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 1.1rem; flex-shrink: 0;
    }
    .form-label-custom { font-weight: 700; color: #2d3748; font-size: 0.88rem; margin-bottom: 6px; }
    .form-control-premium {
        border: 1.5px solid #e2e8f0; border-radius: 10px;
        padding: 10px 14px; font-size: 0.95rem;
        transition: all 0.2s ease;
    }
    .form-control-premium:focus {
        border-color: #4e73df; box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
    }
    textarea.form-control-premium { min-height: 100px; }
    .btn-save-config {
        background: linear-gradient(135deg, #1a1a2e, #0f3460);
        color: white; border: none; padding: 14px 36px; border-radius: 50px;
        font-size: 1rem; font-weight: 700; letter-spacing: 0.5px;
        box-shadow: 0 6px 20px rgba(15, 52, 96, 0.4);
        transition: all 0.3s ease;
    }
    .btn-save-config:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(15,52,96,0.5); color: white; }
    .servicio-row {
        display: flex; gap: 10px; align-items: center; margin-bottom: 8px;
    }
    .servicio-row .form-control-premium { flex: 1; }
    .servicio-row .btn-remove { flex-shrink: 0; }
    .alert-config-success {
        background: linear-gradient(135deg, #e8f5e9, #f1f8e9);
        border: 1.5px solid #a5d6a7; border-radius: 12px;
        color: #2e7d32; padding: 16px 20px;
        display: flex; align-items: center; gap: 12px; margin-bottom: 20px;
    }
    .logo-preview {
        width: 120px; height: 120px; border-radius: 16px;
        border: 2px dashed #cbd5e0; display: flex; align-items: center;
        justify-content: center; overflow: hidden; background: #f7fafc;
    }
    .logo-preview img { max-width: 100%; max-height: 100%; object-fit: contain; }
</style>
@endpush

@section('contenido')

    <div class="config-hero">
        <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:12px;">
            <div>
                <h2><i class="fas fa-cogs mr-2" style="opacity:0.8;"></i> Configuración del Sistema</h2>
                <div class="subtitle">Personaliza la información de tu clínica veterinaria</div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-config-success">
            <i class="fas fa-check-circle fa-lg" style="color:#43a047;"></i>
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    <form action="{{ route('admin.configuracion.guardar') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Información General --}}
        <div class="card config-card">
            <div class="card-header-custom" style="background:#f0f4ff; border-color:#c5cae9;">
                <div class="hico" style="background:linear-gradient(135deg,#1a237e,#3949ab);"><i class="fas fa-building"></i></div>
                <div>
                    <h6 class="mb-0 font-weight-bold" style="color:#1a237e;">Información de la Clínica</h6>
                    <small class="text-muted">Nombre, dirección y contacto</small>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom"><i class="fas fa-clinic-medical mr-1 text-primary"></i> Nombre de la Clínica</label>
                        <input type="text" name="nombre_clinica" class="form-control form-control-premium" value="{{ old('nombre_clinica', $config->nombre_clinica) }}" placeholder="Ej: Veterinaria San Miguel">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom"><i class="fas fa-phone mr-1 text-primary"></i> Teléfono de Contacto</label>
                        <input type="text" name="telefono_contacto" class="form-control form-control-premium" value="{{ old('telefono_contacto', $config->telefono_contacto) }}" placeholder="Ej: (614) 123-4567">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom"><i class="fas fa-map-marker-alt mr-1 text-primary"></i> Dirección Física</label>
                    <textarea name="direccion_fisica" class="form-control form-control-premium" rows="2" placeholder="Dirección completa de la clínica...">{{ old('direccion_fisica', $config->direccion_fisica) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom"><i class="fas fa-image mr-1 text-primary"></i> Logo de la Clínica</label>
                    <div class="d-flex align-items-center" style="gap:20px;">
                        <div class="logo-preview">
                            @if($config->logo_path)
                                <img src="{{ asset('storage/'.$config->logo_path) }}" alt="Logo">
                            @else
                                <i class="fas fa-camera fa-2x text-muted"></i>
                            @endif
                        </div>
                        <div>
                            <input type="file" name="logo" class="form-control form-control-premium" accept="image/*">
                            <small class="text-muted mt-1 d-block">Formatos: JPG, PNG. Tamaño máximo recomendado: 500x500px</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Misión, Visión, Valores --}}
        <div class="card config-card">
            <div class="card-header-custom" style="background:#f0fdf4; border-color:#a5d6a7;">
                <div class="hico" style="background:linear-gradient(135deg,#1b5e20,#43a047);"><i class="fas fa-bullseye"></i></div>
                <div>
                    <h6 class="mb-0 font-weight-bold" style="color:#1b5e20;">Misión, Visión y Valores</h6>
                    <small class="text-muted">Identidad corporativa de la clínica</small>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="form-label-custom"><i class="fas fa-crosshairs mr-1" style="color:#2e7d32;"></i> Misión</label>
                    <textarea name="mision" class="form-control form-control-premium" rows="3" placeholder="¿Cuál es el propósito de la clínica?">{{ old('mision', $config->mision) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom"><i class="fas fa-eye mr-1" style="color:#2e7d32;"></i> Visión</label>
                    <textarea name="vision" class="form-control form-control-premium" rows="3" placeholder="¿A dónde quiere llegar la clínica?">{{ old('vision', $config->vision) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom"><i class="fas fa-heart mr-1" style="color:#2e7d32;"></i> Valores</label>
                    <textarea name="valores" class="form-control form-control-premium" rows="3" placeholder="Honestidad, compromiso, amor por los animales...">{{ old('valores', $config->valores) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Historia --}}
        <div class="card config-card">
            <div class="card-header-custom" style="background:#fef9f0; border-color:#ffcc80;">
                <div class="hico" style="background:linear-gradient(135deg,#e65100,#fb8c00);"><i class="fas fa-book-open"></i></div>
                <div>
                    <h6 class="mb-0 font-weight-bold" style="color:#e65100;">Historia</h6>
                    <small class="text-muted">La historia de la clínica</small>
                </div>
            </div>
            <div class="card-body p-4">
                <textarea name="historia" class="form-control form-control-premium" rows="4" placeholder="Describe la historia y trayectoria de la clínica veterinaria...">{{ old('historia', $config->historia) }}</textarea>
            </div>
        </div>

        {{-- Precios de Servicios --}}
        <div class="card config-card">
            <div class="card-header-custom" style="background:#fef0f5; border-color:#f48fb1;">
                <div class="hico" style="background:linear-gradient(135deg,#880e4f,#e91e63);"><i class="fas fa-dollar-sign"></i></div>
                <div>
                    <h6 class="mb-0 font-weight-bold" style="color:#880e4f;">Precios de Servicios</h6>
                    <small class="text-muted">Catálogo de servicios y precios</small>
                </div>
            </div>
            <div class="card-body p-4">
                <div id="servicios-container">
                    @if($config->precios_servicios)
                        @foreach($config->precios_servicios as $servicio)
                            <div class="servicio-row">
                                <input type="text" name="servicios_nombre[]" class="form-control form-control-premium" value="{{ $servicio['nombre'] }}" placeholder="Nombre del servicio">
                                <input type="number" name="servicios_precio[]" class="form-control form-control-premium" value="{{ $servicio['precio'] }}" placeholder="Precio $" step="0.01" style="max-width:150px;">
                                <button type="button" class="btn btn-sm btn-outline-danger btn-remove" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="agregarServicio()" style="border-radius:20px;">
                    <i class="fas fa-plus mr-1"></i> Agregar Servicio
                </button>
            </div>
        </div>

        <div class="text-right mb-4">
            <button type="submit" class="btn btn-save-config">
                <i class="fas fa-save mr-2"></i> Guardar Configuración
            </button>
        </div>
    </form>

@endsection

@push('scripts')
<script>
function agregarServicio() {
    const container = document.getElementById('servicios-container');
    const row = document.createElement('div');
    row.className = 'servicio-row';
    row.innerHTML = `
        <input type="text" name="servicios_nombre[]" class="form-control form-control-premium" placeholder="Nombre del servicio">
        <input type="number" name="servicios_precio[]" class="form-control form-control-premium" placeholder="Precio $" step="0.01" style="max-width:150px;">
        <button type="button" class="btn btn-sm btn-outline-danger btn-remove" onclick="this.parentElement.remove()"><i class="fas fa-times"></i></button>
    `;
    container.appendChild(row);
}
</script>
@endpush
