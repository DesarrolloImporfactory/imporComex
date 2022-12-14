@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#crearUsuario">
        Agregar Usuario
    </button>


@stop

@section('content')
    @php
        $heads = ['ID', 'Nombre', 'Telefono', 'Fecha', 'Importacion', 'Idioma', 'Estado', 'Cedula', 'Ruc', 'Email', 'Acciones'];
        
    @endphp
    <br><br>

    <div class="card">

        <div class="card-body">
            <x-adminlte-datatable :heads="$heads" head-theme="dark" id="table">

                @foreach ($usuarios as $usuario)
                    <tr>
                        <th scope="row">{!! $usuario->id !!}</th>
                        <td>{!! $usuario->name !!}</td>
                        <td>{!! $usuario->telefono !!}</td>
                        <td>{!!$usuario->date !!}</td>
                        <td>{!! $usuario->importacion !!}</td>
                        <td>{!! $usuario->idioma !!}</td>
                        @if ($usuario->estado = '1')
                            <td>Activo</td>
                        @else
                            <td>Inactivo</td>
                        @endif
                        <td>{!! $usuario->cedula!!}</td>
                        <td>{!! $usuario->ruc !!}</td>
                        <td>{!! $usuario->email !!}</td>
                        <td>
                            <a class="" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item " href=" {{ route('admin.usuarios.edit', $usuario->id) }}"><i
                                            class="bi bi-pencil-square"></i> Editar</a>
                                    </a>
                                </li>
                                <li>
                                    <!-- Modal eliminar -->

                                    <!-- Modal editar -->
                                </li>

                            </ul>
                        </td>
                    </tr>
                    <!-- Modal editar -->

                    <!-- Modal editar -->
                @endforeach

            </x-adminlte-datatable>

        </div>

    </div>
    @include('admin.usuarios.formCreate')
    <!-- ---------------FIN MODAL----------------- -->
@stop
