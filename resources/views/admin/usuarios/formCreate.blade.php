@extends('adminlte::page')
@section('title', 'Registrar Usuarios')

@section('content_header')
    <x-adminlte-info-box title="528" text="Registro de Usuarios" icon="fas fa-lg fa-user-plus text-primary"
        theme="gradient-primary" icon-theme="white" />

    <div class="row">
        <div class="col-md-12">
            <x-adminlte-button label="Guardar Usuario" theme="dark" icon="fas fa-lg fa-save" class="float-right" type="sumbit"
                form="formCreate" />
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="dark" theme-mode="outline">
                <form action="{{ route('admin.usuarios.store') }}" method="post" id="formCreate">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nombre de usuario:</label>
                                <input type="text" class="form-control" placeholder="Adrian Torres" name="name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Idioma:</label>
                                <x-adminlte-select2 name="idioma">
                                    <option value="">Selecciones una opción.......</option>
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
                                    value="{{ old('telefono') }}">
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
                                <input type="date" name="date" id="" class="form-control" value="{{ old('date') }}">
                                @error('date')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Importacion: </label>
                                <input type="number" class="form-control" name="importacion" min="0"
                                    value="{{ old('importacion') }}">
                                @error('importacion')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Estado:</label>
                                <x-adminlte-select2 name="estado">
                                    <option value="">Selecciones una opción.......</option>
                                    <option value="true">Activo</option>
                                    <option value="0">Inactivo</option>
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
                                        <input type="number" class="form-control" name="ruc" placeholder="1727569840001"
                                            value="{{ old('ruc') }}">
                                        @error('ruc')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Cedula: </label>
                                        <input type="numer" class="form-control" name="cedula" placeholder="1727569840"
                                            value="{{ old('cedula') }}">
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
                                        <input type="mail" class="form-control" name="email" placeholder="usuario@gmail.com"
                                            value="{{ old('email') }}">
                                        @error('email')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Password: </label>
                                        <input type="password" class="form-control" name="password" placeholder=""
                                            value="{{ old('password') }}">
                                        @error('password')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                    
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Seleccione los roles</label>
                            <select name="roles[]" id="select2" class="form-control" title="Asignar roles" multiple="multiple">
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                                @endforeach
                            </select>
                    
                    
                        </div>
                    
                    </div>
                </form>
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
