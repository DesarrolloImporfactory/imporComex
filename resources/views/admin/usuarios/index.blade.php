@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
<x-adminlte-info-box title="Recuerde asignar un rol y el estado al usuario" text="Gestión de Usuarios"
        icon="fas fa-lg fa-user-plus text-primary" theme="gradient-primary" icon-theme="white" />
<div class="row">
    <div class="col-md-12 ">
        <a href="{{route('admin.usuarios.create')}}" class="float-right"><x-adminlte-button label="Agregar Usuario" theme="dark" icon="fas fa-lg fa-user-plus"/></a>
    </div>
</div>

@stop

@section('content')
    @php
        $heads = ['ID', 'Nombre', 'Telefono', 'Fecha', 'Importacion', 'Idioma', 'Estado', 'Cedula', 'Ruc', 'Email', 'Rol' ,'Acciones'];
        
    @endphp
    <br>

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
                        @if ($usuario->estado == 'true')
                        <td><i class="fa-solid fa-check"></i></td>
                        @else
                        <td><i class="fa-solid fa-xmark"></i></td>
                        @endif
                        
                        <td>{!! $usuario->cedula!!}</td>
                        <td>{!! $usuario->ruc !!}</td>
                        <td>{!! $usuario->email !!}</td>
                        <td>
                            @if (!empty($usuario->getRoleNames()))
                                @foreach ($usuario->getRoleNames() as $item)
                                    <h5><span class="badge badge-info">{{$item}}</span></h5>
                                @endforeach
                            @endif
                        </td>
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
    
@stop
