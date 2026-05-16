@extends('layouts.admin')

@section('titulo_pagina', 'Confirmar Eliminación')

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-exclamation-triangle mr-2 text-danger"></i> Eliminar Usuario
        </h1>
        <a href="{{ route('admin.usuarios.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-2"></i> Cancelar y Volver
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card shadow mb-4 border-bottom-danger">
                <div class="card-header py-3 bg-danger text-white">
                    <h6 class="m-0 font-weight-bold">Atención: Acción Irreversible</h6>
                </div>
                <div class="card-body">
                    <p>Estás a punto de eliminar permanentemente al siguiente usuario del sistema:</p>
                    
                    <ul class="list-group mb-4">
                        <li class="list-group-item"><strong>Nombre:</strong> {{ $user->name }}</li>
                        <li class="list-group-item"><strong>Correo:</strong> {{ $user->email }}</li>
                        <li class="list-group-item">
                            <strong>Rol:</strong> 
                            <span class="badge {{ $user->rol == 'administrador' ? 'badge-primary' : 'badge-success' }} px-2 py-1">
                                {{ ucfirst($user->rol) }}
                            </span>
                        </li>
                        @if($user->rol === 'veterinario' && $user->veterinario)
                            <li class="list-group-item"><strong>Cédula:</strong> {{ $user->veterinario->cedula_profesional }}</li>
                            <li class="list-group-item"><strong>Especialidad:</strong> {{ $user->veterinario->especialidad ?? 'General' }}</li>
                        @endif
                    </ul>

                    @if($tieneDependencias)
                        <div class="alert alert-warning">
                            <i class="fas fa-ban mr-2"></i> <strong>No se puede eliminar:</strong> 
                            Este usuario tiene registros médicos asociados (como citas o pacientes) en el sistema. Debes reasignar esos registros antes de poder eliminar al usuario.
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle mr-2"></i> <strong>Advertencia:</strong> 
                            Si confirmas la acción, todos los datos de acceso de esta persona y su perfil asociado se borrarán de manera permanente y no podrán recuperarse.
                        </div>

                        <form action="{{ route('admin.usuarios.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-trash-alt mr-2"></i> Sí, eliminar definitivamente
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection
