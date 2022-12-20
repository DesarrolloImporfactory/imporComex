@extends('adminlte::page')
@section('title', 'Registrar Usuarios')

@section('content_header')
    <x-adminlte-info-box title="528" text="Editar Usuario" icon="fas fa-lg fa-user-plus text-primary"
        theme="gradient-primary" icon-theme="white" />

    <div class="row">
        <div class="col-md-12">
            <x-adminlte-button label="Editar Usuario" theme="dark" icon="fas fa-lg fa-save" class="float-right" type="sumbit"
                form="formCreate" />
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="dark" theme-mode="outline">
                {!! Form::model($user, ['route'=>['admin.usuarios.update',$user->id], 'method'=>'put', 'id'=>'formCreate']) !!}
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
                                        <option value="{{ $idioma->nombre }}">{{ $idioma->nombre }}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Telefono: </label>
                                <input type="number" class="form-control" placeholder="02-2956862" name="telefono"
                                    value="{{ $user->telefono}}">
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
                                            value="{{ $user->password }}">
                                        @error('password')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" style="color: red">Asignación de roles</label>
                        @foreach($rol as $roles)
                        <div>
                            <label>
                                {!! Form::checkbox('roles[]', $roles->id, null, ['class'=>'mr-1']) !!}
                                {{$roles->name}}
                            </label>
                        </div>
                        @endforeach
                        
                    


                        </div>

                    </div>

                    {!! Form::close() !!}
            </x-adminlte-card>
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
