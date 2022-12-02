@extends('adminlte::page')

@section('title', 'Calculadora Ecuador')

@section('content_header')


<div class="row ">
    <div class="col-sm-6">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Ecuador,</strong><strong> Bienvenido,</strong> Ahora podras cotizar en la modalidad Grupal.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            @foreach ($modalidades as $modalidad)
                <li class="breadcrumb-item"><a href="#{{ $modalidad->modalidad }}">{{ $modalidad->modalidad }}</a></li>
            @endforeach
        </ol>

    </div>
</div>

@stop

@section('content')



    {{-- cotizador GRUPAL --}}
    <div class="row">
        <div class="col-md-5">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Cotizador Ecuador - China (GRUPAL)</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    {!! Form::open(['route' => 'admin.colombia.store']) !!}
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre del Producto(s)</label>
                                <input type="text" name="producto" class="form-control" id="" autofocus
                                    value="{{ old('producto') }}">
                                @error('producto')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <!-- /.form-group -->
                            <div class="form-group">
                                <label for="">Peso bruto</label>
                                <input type="text" class="form-control" name="peso" value="{{ old('peso') }}">
                                @error('peso')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Tipo de Carga</label>
                                <input type="hidden" name="cargas_id" id="" value="1">
                                <input type="text" class="form-control" value="General" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Direccion</label>
                                <input type="text" name="direccion" id="" class="form-control "
                                    value="{{ old('direccion') }}">
                                @error('direccion')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Total Cartones</label>
                                <input type="float" name="total_cartones" class="form-control" id=""
                                    value="{{ old('total_cartones') }}">
                                @error('total_cartones')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Dimensiones/Volumen</label>
                                <input type="text" name="volumen" id="" class="form-control"
                                    value="{{ old('volumen') }}">
                                @error('volumen')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Ciudad de entrega</label>
                                <select name="ciudad_entrega" id="" class="form-control select2"
                                    value="{{ old('ciudad_entrega') }}">
                                    <option value="Quito">Quito</option>
                                    <option value="Guayaquil">Guayaquil</option>
                                    <option value="Cuenca">Cuenca</option>
                                    <option value="Ambato">Ambato</option>
                                    <option value="Latacunga">Latacunga</option>
                                    <option value="Riobamba">Riobamba</option>
                                    <option value="Manabi">Manabi</option>
                                    <option value="Esmeraldad">Esmeraldad</option>
                                    <option value="Machala">Machala</option>
                                </select>
                                @error('ciudad_entrega')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 20%;">Cotizar</button>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
        {{-- $cotizaciones --}}
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    Tarifa Flete modalidad 'GRUPAL', usuario: {{ Auth::user()->name }}

                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table_id">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Producto</th>
                                <th>Peso</th>
                                <th>Carga</th>
                                <th>Ciudad de entrega</th>
                                <th>Cartones</th>
                                <th>Vol.</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cotizaciones as $cotizacion)
                                @if ($cotizacion->tipo_carga = '1')
                                    <tr>
                                        <td>{{ $cotizacion->id }}</td>
                                        <td>{{ $cotizacion->producto }}</td>
                                        <td>{{ $cotizacion->peso }}</td>
                                        <td>{{ $cotizacion->carga->tipoCarga }}</td>
                                        <td>{{ $cotizacion->ciudad_entrega }} - {{ $cotizacion->direccion }} </td>
                                        <td>{{ $cotizacion->total_cartones }}</td>
                                        <td>{{ $cotizacion->volumen }}</td>
                                        <td>{{ $cotizacion->total }}</td>
                                        <td>Eliminar</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    {{-- fin cotizador grupal --}}
@stop

@section('js')

    <script>
        $(document).ready(function() {
            $('#table_id').DataTable({
                responsive: true,
                autoWidth: false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap"
            });
        });
    </script>

@stop
