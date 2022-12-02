@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#crearModalidad">
        Agregar Modalidad
    </button>

@stop

@section('content')
    <br><br>
    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-sm-9">
                    <h3 class="card-title">Listado de Modalidades</h3>
                </div>
                <div class="col-sm-3 text-center">
                </div>
            </div>
        </div>
        <div class="card-body">
            <x-table>
                <thead>
                    <tr class="table-dark">
                        <th>ID</th>
                        <th>Nombre Modalidad</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($modalidades as $modalidad)
                        <tr>
                            <th scope="row">{{ $modalidad->id }}</th>
                            <td>{{ $modalidad->modalidad }}</td>
                            <td>{{ $modalidad->descripcion }}</td>
                            <td>
                                <a class="" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa-solid fa-bars"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item " href=" " data-bs-toggle="modal"
                                            data-bs-target="#exampleModal{{ $modalidad->id }}"><i
                                                class="bi bi-pencil-square"></i> Editar</a>
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
                </tbody>
            </x-table>
        </div>

    </div>

    <!-- ---------------MODAL-------------------- -->
    @include('admin.modalidades.formCreate')
    <!-- ---------------FIN MODAL----------------- -->
@stop
