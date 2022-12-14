@extends('adminlte::page')

@section('title', 'Calculadora colombia')

@section('content_header')
    <div class="row ">
        <div class="col-sm-12">
            <x-adminlte-info-box title="Progreso de tu Importación" text="1/4" icon="fas fa-lg fa-tasks text-orange" theme="warning"
                icon-theme="dark" progress=25 progress-theme="dark" description="25% para completa tu solicitud" />
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center ">
            <div>
                <p><b>Cotizador {{$paises->nombre_pais}}</b></p>
                <p>1 de 4 <strong> Completado</strong></p>
            </div>
            <x-adminlte-progress theme="secondary" value=25 animated with-label />
        </div>
        <div class="col-md-3"></div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-button label="Siguiente" theme="dark" icon="fa-solid fa-arrow-right"
            class="float-right" type="sumbit" form="formCreate"/>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">

            <!-- /.card-header -->
            <x-adminlte-card title="Modalidad {{$modalidad->modalidad}}" theme="dark">
                <form action="{{ route('admin.colombia.store') }}" method="post"  id="formCreate">
                
                @csrf
                <input type="hidden" name="modalidad" value="{{$modalidad->id}}">
                <input type="hidden" name="pais" value="{{$paises->id}}" id="">
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
                </div>
            </form>


            </x-adminlte-card>
        </div>
        {{-- $cotizaciones --}}
        <div class="col-md-3"></div>
    </div>

@stop
