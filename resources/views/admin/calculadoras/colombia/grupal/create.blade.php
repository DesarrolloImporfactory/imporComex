@extends('adminlte::page')

@section('title', 'Calculadora colombia')

@section('content_header')


    <div class="row ">
        <div class="col-sm-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Cotizador Colombia modalidad Grupal, </strong> !Recuerde llenar todos los campos del formulario.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center ">
            <div>
                <p>PROGRESO DE TU IMPORTACION</p>
                <p>1 de 4 <strong> Completado</strong></p>
            </div>
            <x-adminlte-progress theme="secondary" value=10 animated with-label />
        </div>
        <div class="col-md-3"></div>
    </div>


@stop

@section('content')
    {{-- cotizador GRUPAL --}}
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Cotizador Colombia - China (GRUPAL)</h3>

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
                                <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}" id="">
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
                                <x-adminlte-select2 value="{{ old('ciudad_entrega') }}" name="ciudad_entrega">
                                    <option value="Quito">Quito</option>
                                    <option value="Guayaquil">Guayaquil</option>
                                    <option value="Cuenca">Cuenca</option>
                                    <option value="Ambato">Ambato</option>
                                    <option value="Latacunga">Latacunga</option>
                                    <option value="Riobamba">Riobamba</option>
                                    <option value="Manabi">Manabi</option>
                                    <option value="Esmeraldad">Esmeraldad</option>
                                    <option value="Machala">Machala</option>
                                </x-adminlte-select2>
                                @error('ciudad_entrega')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for=""></label>
                                <label for=""></label>
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Siguiente</button>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
        {{-- $cotizaciones --}}
        <div class="col-md-3"></div>
    </div>

@stop
