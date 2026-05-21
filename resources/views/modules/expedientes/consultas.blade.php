@extends('layouts.app')

@section('titulo_pagina', 'Consultas - Veterinaria')

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Consultas de {{ $mascota->nombre }}</h1>
        <a href="{{ route('expedientes.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Expedientes</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Información del Paciente</h6>
        </div>
        <div class="card-body">
            <p><strong>Folio (ID):</strong> {{ $mascota->id }}</p>
            <p><strong>Especie:</strong> {{ $mascota->especie }}</p>
            <p><strong>Dueño:</strong> {{ $mascota->dueno ? $mascota->dueno->nombre_completo : 'Sin dueño' }}</p>
            <hr>
            <h5 class="mt-4">Historial de Consultas</h5>
            <div class="alert alert-info">
                Aquí se mostrará el historial de consultas de esta mascota próximamente.
            </div>
            <!-- Aquí irá la tabla de consultas -->
        </div>
    </div>
@endsection
