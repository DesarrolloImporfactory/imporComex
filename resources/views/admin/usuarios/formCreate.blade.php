@extends('adminlte::page')
@section('title', 'Registrar Usuarios')

@section('content_header')
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <x-adminlte-button label="Guardar Usuario" theme="dark" icon="fas fa-lg fa-save" class="float-right" type="sumbit"
                form="formCreate" />
        </div>
        <div class="col-md-1"></div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Registro de Usuario</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.usuarios.store') }}" method="post" id="formCreate">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Nombre de usuario(*):</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Adrian Torres" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Idioma:</label>
                                    <x-adminlte-select2 name="idioma">
                                        <option value="">Selecciones una opción.......</option>
                                        @foreach ($idiomas as $idioma)
                                            <option
                                                value="{{ $idioma->nombre }}"{{ old('idioma') == $idioma->nombre ? 'selected' : '' }}>
                                                {{ $idioma->nombre }}</option>
                                        @endforeach
                                    </x-adminlte-select2>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Telefono: </label>
                                    <input type="number" class="form-control @error('telefono') is-invalid @enderror"
                                        placeholder="02-2956862" name="telefono" value="{{ old('telefono') }}">
                                    @error('telefono')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha de nacimiento:</label>
                                    <input type="date" name="date" id=""
                                        class="form-control @error('date') is-invalid @enderror"
                                        value="{{ old('date') }}">
                                    @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Estado:</label>
                                    <div class="form-group">
                                        <x-adminlte-select2 name="estado">
                                            <option value="">Selecciona una opción....</option>
                                            <option value="true"{{ old('estado') == 'true' ? 'selected' : '' }}>Activo
                                            </option>
                                            <option value="0"{{ old('estado') == '0' ? 'selected' : '' }}>Inactivo
                                            </option>
                                        </x-adminlte-select2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Ruc: </label>
                                <input type="number" class="form-control @error('ruc') is-invalid @enderror" name="ruc"
                                    placeholder="1727569840001" value="{{ old('ruc') }}">
                                @error('ruc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Cedula: </label>
                                            <input type="numer" class="form-control @error('cedula') is-invalid @enderror"
                                                name="cedula" placeholder="1727569840" value="{{ old('cedula') }}">
                                            @error('cedula')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Email(*): </label>
                                            <input type="mail" class="form-control @error('email') is-invalid @enderror"
                                                name="email" placeholder="usuario@gmail.com" value="{{ old('email') }}">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Password: </label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" placeholder="" value="{{ old('password') }}">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Verificar Usuario: </label>
                                        <x-adminlte-select2 name="verificar">
                                            <option value="">Selecciona una opción....</option>
                                            <option value="1"{{ old('verificar') == '1' ? 'selected' : '' }}>SI
                                            </option>
                                            <option value="0"{{ old('verificar') == '0' ? 'selected' : '' }}>NO
                                            </option>
                                        </x-adminlte-select2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Asigne un rol al usuario:</label>
                                <x-adminlte-select2 name="roles">
                                    <option value="">Selecciona una opción....</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->name }}"{{ old('roles') == $rol->name ? 'selected' : '' }}>{{ $rol->name }}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <script>
        $(document).ready(function() {
            $('#select2').select2({
                theme: "bootstrap",

            });
        });
    </script>
@stop
