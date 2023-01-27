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
    <div class="row">
        <div class="col-md-8">
            @php
                $heads3 = ['Nombre', 'Estado', 'Salida', 'Llegada', 'Tipo', 'Latitud', 'Longitud', 'Acciones'];
            @endphp

            <x-adminlte-card title="Gestion de Contenedores" theme="dark" icon="fa-brands fa-docker">
                <x-adminlte-datatable :heads="$heads3" head-theme="" id="tableContenedores">

                    @foreach ($contenedores as $contenedor)
                        <tr>
                            <td>{!! $contenedor->name !!}</td>
                            <td>{!! $contenedor->estado->name !!}</td>
                            <td>{!! $contenedor->salida !!}</td>
                            <td>{!! $contenedor->llegada !!}</td>
                            <td>{!! $contenedor->tipo !!}</td>
                            <td>{!! $contenedor->latitud !!}</td>
                            <td>{!! $contenedor->longitud !!}</td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-xs btn-default text-primary mx-1 shadow" href=" "
                                        data-bs-toggle="modal" data-bs-target="#modalContenedor{{ $contenedor->id }}"
                                        title="{{ $contenedor->id }}">
                                        <i class="fa fa-lg fa-fw fa-pen"></i>
                                    </a>
                                    @include('admin.contenedores.delete')
                                </div>
                            </td>
                        </tr>
                        @include('admin.contenedores.edit')
                    @endforeach

                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
        <div class="col-md-4">
            @include('admin.contenedores.table')
        </div>
    </div>

@stop
