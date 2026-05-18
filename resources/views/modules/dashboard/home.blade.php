@extends('layouts.app')

@section('hide_sidebar', true)

@section('titulo_pagina', 'Dashboard - Veterinaria')

@section('contenido')

    {{-- Page Heading --}}
    <h1 class="h3 mb-4 text-gray-800" style="font-weight: 300;">Panel de inicio</h1>

    {{-- Mensaje de bienvenida --}}
    <div class="d-flex align-items-center text-primary mb-4" style="font-size: 1.1rem; font-weight: 500;">
        <i class="fas fa-home mr-2"></i> Bienvenido al sistema
    </div>

    {{-- Texto indicativo --}}
    <p class="text-gray-500">
        Hola, Veterinario. Selecciona una opción del menú lateral para comenzar.
    </p>
@endsection
