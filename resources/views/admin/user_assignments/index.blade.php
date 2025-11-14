@extends('admin.layouts.base')

@section('content')

    <div class="container-fluid">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h1 class="mb-4 text-gray-800 h3">Observaciones y Sesiones</h1>
            <!-- Button trigger modal -->
            <button type="button" id="crearUsuarioAsignado" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalUsuarioAsignado">Crear <i class="fa-solid fa-plus"></i></button>
        </div>

        @include('admin.user_assignments.partials.table') {{-- Tabla extraída a un partials --}}

        @include('admin.user_assignments.partials.calendar') {{-- Tabla extraída a un partials --}}

    </div>

    @include('admin.user_assignments.partials.modal') {{-- Modal extraído a un partials --}}
    @include('admin.user_assignments.partials.modal_ejercicio_extra') {{-- Modal para ejercicios extra --}}
    @include('admin.user_assignments.partials.table_modal_ver_ejercicios') {{-- Modal para ver ejercicios --}}
    @include('admin.user_assignments.partials.modal_editar_ejercicio') {{-- Modal para editar ejercicio --}}

@endsection

@section('js')
    
    <script src="{{ asset('admin/js/user_assignments/main.js') }}"></script>

    <script src="{{ asset('admin/js/user_assignments/main_ejercicio_extra.js') }}"></script>

    <script src="{{ asset('admin/js/user_assignments/main_editar_ejercicio.js') }}"></script>
    
@endsection
