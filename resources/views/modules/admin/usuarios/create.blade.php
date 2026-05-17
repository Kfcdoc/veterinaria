@extends('layouts.admin')

@section('titulo_pagina', 'Nuevo Usuario')

@section('contenido')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-plus mr-2 text-primary"></i> Registrar Nuevo Usuario
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
            <form action="{{ route('admin.usuarios.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Nombre Completo</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="rol">Rol de Usuario</label>
                        <select class="form-control" id="rol" name="rol" required onchange="toggleVetFields()">
                            <option value="">Seleccione un rol...</option>
                            <option value="administrador" {{ old('rol') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                            <option value="veterinario" {{ old('rol') == 'veterinario' ? 'selected' : '' }}>Veterinario</option>
                        </select>
                    </div>
                </div>

                {{-- Campos específicos de Veterinario (Ocultos por defecto) --}}
                <div id="veterinario_fields" style="display: none;" class="p-3 bg-light rounded mt-2 mb-3">
                    <h6 class="font-weight-bold text-primary mb-3">Datos Profesionales del Veterinario</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cedula_profesional">Cédula Profesional</label>
                            <input type="text" class="form-control" id="cedula_profesional" name="cedula_profesional" value="{{ old('cedula_profesional') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="especialidad">Especialidad (Opcional)</label>
                            <input type="text" class="form-control" id="especialidad" name="especialidad" value="{{ old('especialidad') }}">
                        </div>
                    </div>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary">Registrar Usuario</button>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('startbootstrap/js/admin/usuarios/create.js') }}"></script>
@endpush
