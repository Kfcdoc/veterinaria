@extends('layouts/main')

@section('titulo_pagina', 'Home - Veterinaria')

@section('contenido')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card mt-4">
                    <div class="card-body">
                        <h2>Bienvenido al sistema de Veterinaria</h2>
                        <a href="{{ route('logout') }}" class="btn btn-danger">Salir del sistema</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
