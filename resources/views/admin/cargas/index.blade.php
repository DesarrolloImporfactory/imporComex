@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')


@stop

@section('content')
    @php
        $heads = ['ID', 'M3', 'VXCBM', 'TCBM', 'Acciones'];
        $heads2 = ['ID', 'Tipo de carga', 'Acciones'];
    @endphp

    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Gestionar Tipo de Cargas
                    <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal"
                        data-bs-target="#crearCarga">
                        Agregar Carga
                    </button>
                </div>
                <div class="card-body">
                    <x-adminlte-datatable :heads="$heads2" head-theme="dark" id="table">

                        @foreach ($cargas as $carga)
                            <tr>
                                <th scope="row">{!! $carga->id !!}</th>
                                <td>{!! $carga->tipoCarga !!}</td>
                                <td>
                                    <a class="" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-bars"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item " href=" " data-bs-toggle="modal"
                                                data-bs-target="#exampleModal{{ $carga->id }}"><i
                                                    class="bi bi-pencil-square"></i> Editar</a>
                                            </a>
                                        </li>
                                        <li>
                                            <!-- Modal eliminar -->
                                            @include('admin.cargas.formDelete')
                                            <!-- Modal editar -->
                                        </li>

                                    </ul>
                                </td>
                            </tr>
                            <!-- Modal editar -->
                            @include('admin.cargas.formEdit')
                            <!-- Modal editar -->
                        @endforeach
                    </x-adminlte-datatable>
                </div>

            </div>

        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Gestionar Tarifas Grupales
                </div>
                <div class="card-body">
                    <x-adminlte-datatable :heads="$heads" head-theme="dark" id="table_id">
                        @foreach ($tarifas as $tarifa)
                            <tr>
                                <td>{!! $tarifa->id !!}</td>
                                <td>{!! $tarifa->m3 !!}</td>
                                <td>{!! $tarifa->vxcbm !!}</td>
                                <td>{!! $tarifa->tcbm !!}</td>

                                <td>
                                    <a class="" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-bars"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item " href=" " data-bs-toggle="modal"
                                                data-bs-target="#example{{ $tarifa->id }}"><i
                                                    class="bi bi-pencil-square"></i> Editar</a>
                                            </a>
                                        </li>
                                        <li>
                                            <!-- Modal eliminar -->
                                            @include('admin.cargas.formDelete')
                                            <!-- Modal editar -->
                                        </li>

                                    </ul>
                                </td>
                            </tr>
                            <!-- ---------------MODAL-------------------- -->
                            @include('admin.cargas.editTarifa')
                            <!-- ---------------FIN MODAL----------------- -->
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
    <!-- ---------------MODAL-------------------- -->
    @include('admin.cargas.formCreate')
    <!-- ---------------FIN MODAL----------------- -->

@stop
