@extends('layouts.app')

@section('hide_sidebar', true)

@section('titulo_pagina', 'Expedientes - Veterinaria')

@section('contenido')
    {{-- Page Heading --}}
    <h1 class="h3 mb-4 text-gray-800" style="font-weight: 300;">Expedientes</h1>

    {{-- Mensaje o contenido --}}
    <div class="card shadow mb-4 border-bottom-primary">
        <div class="card-body py-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 text-center">
                    <h5 class="text-gray-800 mb-4">Búsqueda de Pacientes</h5>
                    
                    {{-- Buscador --}}
                    <div class="position-relative">
                        <div class="input-group input-group-lg mb-4 shadow-sm rounded">
                            <input type="text" id="buscador-mascotas" class="form-control bg-light border-0 small" placeholder="Buscar por nombre, dueño, folio..." aria-label="Buscar paciente">
                            <div class="input-group-append">
                                <button class="btn btn-primary px-4" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        {{-- Contenedor de Resultados Flotante --}}
                        <div id="resultados-busqueda" class="list-group position-absolute w-100 shadow" style="top: 100%; left: 0; z-index: 1000; display: none; text-align: left; max-height: 300px; overflow-y: auto;">
                        </div>
                    </div>

                    {{-- Botones de Acción --}}
                    <div>
                        <button type="button" class="btn btn-outline-primary btn-lg mx-1 shadow-sm mb-2">
                            <i class="fas fa-stethoscope mr-2"></i> Ver consultas
                        </button>
                        <button type="button" class="btn btn-success btn-lg mx-1 shadow-sm mb-2">
                            <i class="fas fa-plus-circle mr-2"></i> Nuevo paciente
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputBuscador = document.getElementById('buscador-mascotas');
    const contenedorResultados = document.getElementById('resultados-busqueda');

    inputBuscador.addEventListener('input', function() {
        let query = this.value.trim();
        if (query.length < 2) {
            contenedorResultados.style.display = 'none';
            return;
        }

        fetch(`/expedientes/buscar?q=${query}`)
            .then(response => response.json())
            .then(data => {
                contenedorResultados.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(mascota => {
                        let duenoNombre = mascota.dueno ? mascota.dueno.nombre_completo : 'Sin dueño';
                        let html = `
                            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1 text-primary"><i class="fas fa-paw mr-2"></i>${mascota.nombre} (Folio: ${mascota.id})</h5>
                                    <small class="text-muted">${mascota.especie}</small>
                                </div>
                                <p class="mb-1 text-gray-800">Dueño: ${duenoNombre}</p>
                            </a>
                        `;
                        contenedorResultados.innerHTML += html;
                    });
                    contenedorResultados.style.display = 'block';
                } else {
                    contenedorResultados.innerHTML = `<div class="list-group-item text-muted">No se encontraron resultados para "${query}"</div>`;
                    contenedorResultados.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    // Ocultar al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!inputBuscador.contains(e.target) && !contenedorResultados.contains(e.target)) {
            contenedorResultados.style.display = 'none';
        }
    });
});
</script>
@endpush
