@extends('layouts.admin')

@section('titulo_pagina', 'Editar Usuario')

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-edit mr-2 text-primary"></i> Editar Usuario: {{ $user->name }}
        </h1>
        <a href="{{ route('admin.usuarios.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-2"></i> Volver a la lista
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.usuarios.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Nombre Completo</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password">Contraseña <small class="text-muted">(Dejar en blanco para conservar la actual)</small></label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="rol">Rol de Usuario</label>
                        <input type="text" class="form-control bg-light" value="{{ ucfirst($user->rol) }}" readonly>
                        <small class="text-muted">El rol de un usuario no puede modificarse por seguridad.</small>
                    </div>
                </div>

                @if($user->rol === 'veterinario')
                    {{-- Campos específicos de Veterinario --}}
                    <div class="p-3 bg-light rounded mt-2 mb-3">
                        <h6 class="font-weight-bold text-primary mb-3">Datos Profesionales del Veterinario</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cedula_profesional">Cédula Profesional</label>
                                <input type="text" class="form-control" id="cedula_profesional" name="cedula_profesional" value="{{ old('cedula_profesional', $user->veterinario->cedula_profesional ?? '') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="especialidad">Especialidad (Opcional)</label>
                                <input type="text" class="form-control" id="especialidad" name="especialidad" value="{{ old('especialidad', $user->veterinario->especialidad ?? '') }}">
                            </div>
                        </div>
                    </div>
                @endif

                <hr>
                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
            </form>
        </div>
    </div>

@endsection
