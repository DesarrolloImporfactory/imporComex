@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <x-adminlte-info-box title="Gestion de:" text="Modalidades, Contenedores e Incoterms"
        icon="fa-solid fa-list text-primary" theme="gradient-primary" icon-theme="white" />

@stop

@section('content')
    @php
        $heads = ['ID', 'Nombre', 'Acciones'];
        $heads2 = ['ID', 'Modalidad', 'Descripcion', 'Acciones'];
        
    @endphp
    <div class="row">
        <div class="col-md-6">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Listado de Modalidades</h3>
                    <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal"
                        data-bs-target="#crearModalidad">
                        Agregar Modalidad
                    </button>
                </div>
                <div class="card-body">
                    <x-adminlte-datatable :heads="$heads2" head-theme="dark" id="table1">

                        @foreach ($modalidades as $modalidad)
                            <tr>
                                <th scope="row">{!! $modalidad->id !!}</th>
                                <td>{!! $modalidad->modalidad !!}</td>
                                <td>{!! $modalidad->descripcion !!}</td>
                                <td>
                                    <a class="" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-bars"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item " href=" " data-bs-toggle="modal"
                                                data-bs-target="#exampleModal{{ $modalidad->id }}"><i
                                                    class="bi bi-pencil-square"></i> Editar
                                            </a>
                                        </li>
                                        <li>
                                            <!-- Modal eliminar -->
                                            @include('admin.modalidades.formDelete')
                                            <!-- Modal editar -->
                                        </li>

                                    </ul>
                                </td>
                            </tr>
                            <!-- Modal editar -->
                            @include('admin.modalidades.formEdit')
                            <!-- Modal editar -->
                        @endforeach

                    </x-adminlte-datatable>
                </div>

            </div>

            <!-- ---------------MODAL-------------------- -->
            @include('admin.modalidades.formCreate')
            <!-- ---------------FIN MODAL----------------- -->
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Incoterms</h3>
                    <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal"
                        data-bs-target="#crearIncoterms">
                        Agregar Incoterms
                    </button>
                </div>
                <div class="card-body">
                    <x-adminlte-datatable :heads="$heads" head-theme="dark" id="table">

                        @foreach ($incoterms as $incoterm)
                            <tr>
                                <th scope="row">{!! $incoterm->id !!}</th>
                                <td>{!! $incoterm->name !!}</td>

                                <td>
                                    <a class="" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-bars"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item " href=" " data-bs-toggle="modal"
                                                data-bs-target="#example{{ $incoterm->id }}"><i
                                                    class="bi bi-pencil-square"></i> Editar
                                            </a>
                                        </li>
                                        <li>
                                            <!-- Modal eliminar -->
                                            @include('admin.modalidades.incoterms.formDelete')
                                            <!-- Modal editar -->
                                        </li>

                                    </ul>
                                </td>
                            </tr>
                            @include('admin.modalidades.incoterms.formEdit')
                        @endforeach

                    </x-adminlte-datatable>

                </div>

            </div>
            @include('admin.modalidades.incoterms.formCreate')
        </div>

    </div>
@stop
