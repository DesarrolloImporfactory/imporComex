@extends('adminlte::page')
@section('title', 'Registrar Usuarios')

@section('content_header')


    <div class="row">
        <div class="col-md-12">

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    Editar Usuario
                </div>
                <div class="card-body">
                    {!! Form::model($user, [
                        'route' => ['admin.usuarios.update', $user->id],
                        'method' => 'put',
                        'id' => 'formCreate',
                    ]) !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nombres de usuario:</label>
                                <input type="text" class="form-control" placeholder="Adrian Torres" name="name"
                                    value="{{ $user->name }}">
                                @error('name')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Idioma:</label>
                                <x-adminlte-select2 name="idioma">
                                    <option value="{{ $user->idioma }}">{{ $user->idioma }}</option>
                                    @foreach ($idiomas as $idioma)
                                        @if ($user->idioma != $idioma->nombre)
                                            <option value="{{ $idioma->nombre }}">{{ $idioma->nombre }}</option>
                                        @endif
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Telefono: </label>
                                <input type="number" class="form-control" placeholder="02-2956862" name="telefono"
                                    value="{{ $user->telefono }}">
                                @error('telefono')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha de nacimiento:</label>
                                <input type="date" name="date" id="" class="form-control"
                                    value="{{ $user->date }}">
                                @error('date')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Importacion: </label>
                                <input type="number" class="form-control" name="importacion" min="0"
                                    value="{{ $user->importacion }}">
                                @error('importacion')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Estado:</label>
                                <x-adminlte-select2 name="estado">
                                    @if ($user->estado = 'true')
                                        <option value="true">Activo</option>
                                        <option value="0">Inactivo</option>
                                    @else
                                        <option value="0">Inactivo</option>
                                        <option value="true">Activo</option>
                                    @endif
                                </x-adminlte-select2>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Ruc: </label>
                                        <input type="number" class="form-control" name="ruc"
                                            placeholder="1727569840001" value="{{ $user->ruc }}">
                                        @error('ruc')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Cedula: </label>
                                        <input type="numer" class="form-control" name="cedula" placeholder="1727569840"
                                            value="{{ $user->cedula }}">
                                        @error('cedula')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email: </label>
                                        <input type="mail" class="form-control" name="email"
                                            placeholder="usuario@gmail.com" value="{{ $user->email }}">
                                        @error('email')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Password: </label>
                                        <input type="password" class="form-control" name="password" placeholder=""
                                            value="{{ $user->password }}" >
                                        @error('password')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Seleccione un rol</label>
                            <x-adminlte-select2 value="{{ old('ciudad_entrega') }}" name="roles" enable-old-support>
                                @foreach ($user->roles as $role)
                                    @foreach ($rol as $item)
                                    <option value="{{ $item->id}}"{{ $role->id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                @endforeach
                            </x-adminlte-select2>

                        </div>

                    </div>

                    {!! Form::close() !!}
                </div>
                <div class="card-footer">
                    <x-adminlte-button label="Editar Usuario" theme="dark" icon="fas fa-lg fa-save"
                        class="float-right" type="sumbit" form="formCreate" />
                </div>
            </div>
            <div class="card card-dark">
                <div class="card-header">
                    ACTUALIZAR CONTRASEÑA
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.resetPassword', $usuario->id) }}" method="POST" id="changePassword">
                        {{ method_field('PATCH') }}
                        @csrf
                        <div class="form-group">
                            <p>Contraseña actual</p>
                            <input type="password" class="form-control @error('contraseña_actual') is-invalid @enderror"
                                name="contraseña_actual">
                            @error('contraseña_actual')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <p>Nueva contraseña</p>
                            <input type="password" class="form-control @error('nueva_contraseña') is-invalid @enderror"
                                name="nueva_contraseña">
                            @error('nueva_contraseña')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <p>Confirmar contrseña</p>
                            <input type="password"
                                class="form-control @error('confirmar_contraseña') is-invalid @enderror"
                                name="confirmar_contraseña">
                            @error('confirmar_contraseña')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-dark float-right" form="changePassword"><i
                            class="fa-solid fa-rotate"></i> Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#select2').select2({
                theme: "bootstrap",

            });
        });
    </script>
@stop
