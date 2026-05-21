@extends('layouts.app')

@section('titulo_pagina', 'Diagnóstico de Consulta - Veterinaria')

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Diagnóstico</h1>
        <a href="{{ route('expedientes.consultas.detalle', [$mascota->id, $consulta->id]) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a Detalles de Consulta</a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Diagnóstico Médico - Paciente: {{ $mascota->nombre }}</h6>
                    <span class="badge badge-info">{{ $consulta->fecha_consulta ? $consulta->fecha_consulta->format('d/m/Y H:i') : 'Consulta sin fecha' }}</span>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if($consulta->diagnostico)
                        {{-- Muestra el diagnóstico existente --}}
                        <div class="alert alert-success mb-4">
                            <i class="fas fa-check-circle mr-2"></i> Diagnóstico registrado previamente. Puedes revisarlo o actualizarlo.
                        </div>
                    @else
                        {{-- Muestra alerta si no hay diagnóstico --}}
                        <div class="alert alert-warning mb-4">
                            <i class="fas fa-exclamation-triangle mr-2"></i> Aún sin diagnóstico. Por favor, registra la valoración médica a continuación.
                        </div>
                    @endif

                    <form action="{{ route('expedientes.consultas.diagnostico.guardar', [$mascota->id, $consulta->id]) }}" method="POST">
                        @csrf
                        {{-- Aquí irá la lógica de guardado después --}}
                        
                        <div class="form-group">
                            <label for="diagnostico" class="font-weight-bold text-gray-800">Detalles del Diagnóstico e Informe Médico:</label>
                            <textarea class="form-control" id="diagnostico" name="diagnostico" placeholder="Escribe aquí las observaciones clínicas, síntomas detectados y la valoración médica del paciente...">{{ old('diagnostico', $consulta->diagnostico) }}</textarea>
                            <small class="form-text text-muted">Asegúrate de incluir toda la información relevante de la consulta actual.</small>
                        </div>
                        
                        <div class="mt-4 text-right">
                            <button type="submit" class="btn btn-primary shadow-sm">
                                <i class="fas fa-save mr-1"></i> Guardar Diagnóstico
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .ck-editor__editable_inline {
        min-height: 250px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        ClassicEditor
            .create(document.querySelector('#diagnostico'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endpush
