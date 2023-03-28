@extends('adminlte::page')
@section('title', 'Perfil')

@section('content_header')
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
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Perfil de usuario</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Perfil de usuario</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-dark">
                <div class="card-header">
                    INFORMACION DE PERFIL
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.perfil.update', $usuario->id) }}" method="post" id="updateUsuario">
                        {{ method_field('PATCH') }}
                        @csrf
                        <div class="form-group">
                            <p>Nombre de usuario</p>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                value="{{ $usuario->name }}" name="name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <p>Email</p>
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                value="{{ $usuario->email }}" name="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <p>Telefono</p>
                            <input type="text" class="form-control @error('telefono') is-invalid @enderror"
                                value="{{ $usuario->telefono }}" name="telefono">
                            @error('telefono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <p>Ruc:</p>
                            <input type="text" class="form-control @error('ruc') is-invalid @enderror"
                                value="{{ $usuario->ruc }}" name="ruc">
                            @error('ruc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <p>Cedula</p>
                            <input type="text" class="form-control @error('cedula') is-invalid @enderror"
                                value="{{ $usuario->cedula }}" name="cedula">
                            @error('cedula')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-dark float-right" form="updateUsuario"><i
                            class="fa-solid fa-rotate"></i> Actualizar</button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            @include('admin.usuarios.changePassword')
            <div class="card card-danger">
                <div class="card-header">
                    BORRAR CUENTA
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.destroyUser', $usuario->id) }}" id="destroy" method="POST">
                        {{ method_field('DELETE') }}
                        @csrf
                        <p class="text-justify">Una vez que se elimine su cuenta, todos sus recursos y datos se eliminarán
                            de forma permanente. Antes de eliminar su cuenta, descargue cualquier dato o información que
                            desee conservar.</p>
                        <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i> Borrar
                            Cuenta</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script>
        $("#destroy").submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Estas Seguro?',
                text: "No podrás revertir esto !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminalo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                    Swal.fire(
                        'Eliminado!',
                        'Su registro ha sido eliminado.',
                        'Exito'
                    )
                }
            })
        });
    </script>
@stop
