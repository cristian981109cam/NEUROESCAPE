@extends('admin.layouts.base')

@section('content')

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-4 text-gray-800">Lista de Musculos</h1>
            <!-- Button trigger modal -->
            <button type="button" id="crearMusculo" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalMusculo">Crear</button>
        </div>

        @include('admin.muscles.partials.table') {{-- Tabla extraída a un partials --}}

    </div>

    @include('admin.muscles.partials.modal') {{-- Modal extraído a un partials --}}

@endsection

@section('js')
    
    <script src="{{ asset('admin/js/muscles/main.js') }}"></script>
    
@endsection
