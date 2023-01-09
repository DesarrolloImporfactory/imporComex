@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <x-adminlte-info-box title="Gestion de:" text="Contenedores y cotizaciones" icon="fa-solid fa-list text-primary"
        theme="gradient-primary" icon-theme="white" />

    <div class="row">
        <div class="col-md-12">
            <x-adminlte-button class="btn btn-primary float-right" label="Agregar Contenedor" theme="dark"
                icon="fa-solid fa-plus" data-bs-toggle="modal" data-bs-target="#crearContenedor" />
            @include('admin.contenedores.create')
        </div>
    </div>

@stop



@section('content')
    @if (Session::has('mensaje'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ Session::get('mensaje') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @include('admin.contenedores.table')
@stop
