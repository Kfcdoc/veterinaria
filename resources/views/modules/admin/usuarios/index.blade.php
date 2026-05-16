@extends('layouts.admin')

@section('titulo_pagina', 'Gestión de Usuarios')

@section('contenido')

    {{-- Page Heading --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users-cog mr-2 text-primary"></i> Gestión de Usuarios
        </h1>
        <a href="{{ route('admin.usuarios.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-user-plus fa-sm text-white-50 mr-2"></i> Nuevo Usuario
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Content --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de usuarios en el sistema</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Cédula / Especialidad</th>
                            <th>Fecha de Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->id }}</td>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>
                                    @if($usuario->rol == 'administrador')
                                        <span class="badge badge-primary px-2 py-1">Administrador</span>
                                    @else
                                        <span class="badge badge-success px-2 py-1">Veterinario</span>
                                    @endif
                                </td>
                                <td>
                                    @if($usuario->rol == 'veterinario' && $usuario->veterinario)
                                        <small><strong>Cédula:</strong> {{ $usuario->veterinario->cedula_profesional }}<br>
                                        <strong>Esp:</strong> {{ $usuario->veterinario->especialidad ?? 'General' }}</small>
                                    @else
                                        <span class="text-muted"><small>N/A</small></span>
                                    @endif
                                </td>
                                <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('admin.usuarios.show', $usuario) }}" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No hay usuarios registrados en el sistema.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>

@endsection
