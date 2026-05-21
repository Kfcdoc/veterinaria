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
            @if($mascota->consultas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mt-3">
                        <thead class="thead-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Veterinario</th>
                                <th>Peso (kg)</th>
                                <th>Talla (cm)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mascota->consultas as $consulta)
                                <tr>
                                    <td>{{ $consulta->fecha_consulta ? $consulta->fecha_consulta->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td>{{ $consulta->veterinario ? $consulta->veterinario->nombre : 'N/A' }}</td>
                                    <td>{{ $consulta->peso }}</td>
                                    <td>{{ $consulta->talla }}</td>
                                    <td>
                                        <a href="{{ route('expedientes.consultas.detalle', [$mascota->id, $consulta->id]) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mt-3">
                    Aún no hay historial de consultas registrado para esta mascota.
                </div>
            @endif
        </div>
    </div>
@endsection
