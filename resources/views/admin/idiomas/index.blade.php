@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    @can('admin.idiomas.store')
        <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Agregar Idioma
        </button>
    @endcan
@stop

@section('content')
    <br><br>
    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-sm-9">
                    <h3 class="card-title">Listado de Idiomas</h3>
                </div>
                <div class="col-sm-3 text-center">



                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table" id="tableIdioma">
                <thead>
                    <tr class="table-dark">
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($idiomas as $idioma)
                        <tr>
                            <th scope="row">{{ $idioma->id }}</th>
                            <td>{{ $idioma->nombre }}</td>
                            <td>{{ $idioma->codigo }}</td>
                            <td>
                                <a class="" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa-solid fa-bars"></i>
                                </a>
                                <ul class="dropdown-menu">

                                    <li>
                                        @can('admin.idiomas.update')
                                            <a class="dropdown-item " href=" " data-bs-toggle="modal"
                                                data-bs-target="#exampleModal{{ $idioma->id }}"><i
                                                    class="bi bi-pencil-square"></i> Editar</a>
                                        @endcan

                                        </a>
                                    </li>
                                    <li>
                                        @include('admin.idiomas.formDelete')
                                    </li>

                                </ul>
                            </td>
                        </tr>

                        <!-- Modal editar -->
                        @include('admin.idiomas.formEdit')
                        <!-- Modal editar -->
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <!-- ---------------MODAL-------------------- -->
    @include('admin.idiomas.formCreate')
    <!-- ---------------FIN MODAL----------------- -->
    <script>
        $(document).ready(function() {
            $('#tableIdioma').DataTable();
        });
    </script>
@stop
