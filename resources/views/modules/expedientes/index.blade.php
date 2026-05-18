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
                    <div class="input-group input-group-lg mb-5 shadow-sm rounded">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar por nombre, dueño, teléfono..." aria-label="Buscar paciente">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4" type="button">
                                <i class="fas fa-search"></i>
                            </button>
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
