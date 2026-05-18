@extends('layouts.app')

@section('hide_sidebar', true)

@section('titulo_pagina', 'Expedientes - Veterinaria')

@section('contenido')
    {{-- Page Heading --}}
    <h1 class="h3 mb-4 text-gray-800" style="font-weight: 300;">Expedientes</h1>

    {{-- Mensaje o contenido --}}
    <div class="card shadow mb-4">
        <div class="card-body text-gray-500">
            Aquí irá el contenido de la vista de expedientes.
        </div>
    </div>
@endsection
