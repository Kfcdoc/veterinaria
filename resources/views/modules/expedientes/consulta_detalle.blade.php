@extends('layouts.app')

@section('titulo_pagina', 'Detalle de Consulta - Veterinaria')

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalle de Consulta - {{ $mascota->nombre }}</h1>
        <a href="{{ route('expedientes.consultas', $mascota->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Consultas</a>
    </div>

    <div class="row">
        <!-- Detalles de Consulta -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Información de la Consulta</h6>
                    <span class="badge badge-info">{{ $consulta->fecha_consulta ? $consulta->fecha_consulta->format('d/m/Y H:i') : 'Fecha no registrada' }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Veterinario a cargo:</strong><br>{{ $consulta->veterinario ? $consulta->veterinario->nombre : 'No especificado' }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Peso:</strong><br>{{ $consulta->peso }} kg</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Talla:</strong><br>{{ $consulta->talla }} cm</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h6 class="font-weight-bold">Diagnóstico:</h6>
                    <p class="text-gray-800">{{ $consulta->diagnostico ?? 'Sin diagnóstico registrado.' }}</p>
                    
                    <h6 class="font-weight-bold mt-4">Tratamiento:</h6>
                    <p class="text-gray-800">{{ $consulta->tratamiento ?? 'Sin tratamiento registrado.' }}</p>
                </div>
            </div>
        </div>

        <!-- Antecedentes de la Mascota -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Antecedentes Clínicos</h6>
                </div>
                <div class="card-body">
                    <p><strong>Especie:</strong> {{ $mascota->especie }}</p>
                    <p><strong>Tipo de Sangre:</strong> {{ $mascota->tipo_sangre ?? 'No registrado' }}</p>
                    <p><strong>Comportamiento:</strong> {{ $mascota->comportamiento ?? 'No registrado' }}</p>
                    <p><strong>Adoptado:</strong> {{ $mascota->es_adoptado ? 'Sí' : 'No' }}</p>
                    <p><strong>Fecha de Nacimiento:</strong> {{ $mascota->fecha_nacimiento ? $mascota->fecha_nacimiento->format('d/m/Y') : 'Desconocida' }}</p>
                    <hr>
                    <div class="alert alert-warning text-sm">
                        <i class="fas fa-exclamation-triangle"></i> Aquí se podrán agregar alergias u otras condiciones preexistentes en el futuro.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
