@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')

    <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#crearRol">
        Agregar Rol
    </button>


@stop

@section('content')

    @if (session('mensaje'))
        <div class="alert alert-success" role="alert">
            <strong>{{ session('mensaje') }}</strong>
        </div>
    @endif
    <br><br>
    <div class="card">

        <div class="card-body">
            <x-table>
                <thead>
                    <tr class="table-dark">
                        <th>ID</th>
                        <th>Role</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <a class="" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa-solid fa-bars"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item " href="{{ route('admin.roles.edit', $role) }} "><i
                                                class="bi bi-pencil-square"></i> Editar</a>
                                        </a>
                                    </li>
                                    <li>
                                        <!-- Modal eliminar -->
                                        <form action="{{ route('admin.roles.destroy', $role) }}" method="post">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="dropdown-item"><i
                                                    class="bi bi-trash"></i>Eliminar</button>
                                        </form>
                                        <!-- Modal editar -->
                                    </li>

                                </ul>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </x-table>

        </div>

    </div>
    @include('admin.roles.formCreate')
@stop
