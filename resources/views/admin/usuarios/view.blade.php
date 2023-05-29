@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')

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
    @php
        $heads = ['ID', 'NAME', 'PHONE', 'SESSION', 'VERIFIED', 'CI', 'RUC', 'EMAIL', 'ROL', 'OPTION'];
        
    @endphp
    <br>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gestión de Usuarios</h3>
            <a href="{{ route('admin.usuarios.create') }}" class="float-right">
                <x-adminlte-button label="Agregar Usuario" theme="warning" icon="fas fa-lg fa-user-plus" />
            </a>
        </div>
        <div class="card-body">
            <x-adminlte-datatable :heads="$heads" class="text-center table table-hover" head-theme="dark" id="table">

                @foreach ($usuarios as $usuario)
                    <tr>
                        <th scope="row">{!! $usuario->id !!}</th>
                        <td>{!! $usuario->name !!}</td>
                        <td>{!! $usuario->telefono !!}</td>
                        <td>{!! $usuario->session !!}</td>
                        @if (isset($usuario->email_verified_at))
                            <td><i class="fa-regular fa-circle-check text-teal"></i></td>
                        @else
                            <td><i class="fa-regular fa-circle-xmark"></i></td>
                        @endif
                        @if (isset($usuario->cedula))
                            <td>{!! $usuario->cedula !!}</td>
                        @else
                            <td>{!! $usuario->ruc !!}</td>
                        @endif

                        @if (isset($usuario->ruc))
                            <td><i class="fa-regular fa-circle-check text-teal"></i></td>
                        @else
                            <td><i class="fa-regular fa-circle-xmark"></i></td>
                        @endif
                        <td>{!! $usuario->email !!}</td>
                        <td>
                            @if (!empty($usuario->getRoleNames()))
                                @foreach ($usuario->getRoleNames() as $item)
                                    <h5><span class="badge rounded-pill text-bg-success">{{ $item }}</span></h5>
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
                                    <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="post"
                                        class="btn-delete">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="dropdown-item"><i class="bi bi-trash"></i>
                                            Eliminar</button>
                                    </form>
                                </li>

                            </ul>
                        </td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>
    </div>
    <script>
        $(".btn-delete").submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Estas seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });
    </script>
@stop
