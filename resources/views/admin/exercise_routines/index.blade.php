@extends('admin.layouts.base')

@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-4 text-gray-800">Lista de Ejercicios</h1>
            <!-- Button trigger modal -->
            <button type="button" id="crearRutinaEjercicio" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalRutinaEjercicio">Crear</button>
        </div>

        @include('admin.exercise_routines.partials.table') {{-- Tabla extraída a un partials --}}

    </div>

    @include('admin.exercise_routines.partials.modal') {{-- Modal extraído a un partials --}}

@endsection

@section('js')
    
    <!-- Definir la URL base para el almacenamiento público -->
    <script>
        const STORAGE_URL = "{{ asset('storage') }}"; // Define la URL base para el almacenamiento público
    </script>

    <script src="{{ asset('admin/js/exercise_routines/main.js') }}"></script>
    
@endsection
