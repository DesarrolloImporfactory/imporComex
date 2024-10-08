@extends('adminlte::page')
@section('title', 'View')

@section('content_header')
    <x-adminlte-small-box title="Ver Detalles de {{ $cotizacion->usuario->name }}"
        text="Especialista asignado: {{ $cotizacion->especialista->name }} " icon="fas fa-eye text-dark" theme="teal"
        url="{{ route('admin.especialistas.show', $cotizacion->usuario_id) }}" url-text="Volver a las gestion" />

    <div class="row">

        <div class="col-md-12">
            <x-adminlte-button label="Guardar Usuario" theme="dark" icon="fas fa-lg fa-save" class="float-right" type="sumbit"
                form="formCreate" />
        </div>
    </div>


@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            <x-adminlte-card title="Gestionar cotizaciones asignadas" theme="dark" icon="fa-solid fa-handshake-angle">
                <form action="{{ route('admin.especialistas.update', $cotizacion->id) }}" method="post" id="formCreate">
                    {{ method_field('PATCH') }}
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">BarCode:</label>

                                {!! DNS1D::getBarcodeHTML("$cotizacion->barcode", 'C128A') !!}
                                <div class="text-center">
                                    {{$cotizacion->barcode}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="">Estado:</label>
                            <div class="form-group">
                                
                                <input type="text" name="estado" class="form-control" value="{{$cotizacion->estado}}" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Usuario:</label>
                                <input type="text" name="estado" class="form-control"
                                    value="{{ $cotizacion->usuario->name }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Especialista Asignado:</label>
                                <input type="text" name="usuario_id" class="form-control"
                                    value="{{ $cotizacion->especialista->name }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Pais de cotizacion:</label>
                                <input type="text" name="pais_id" class="form-control"
                                    value="{{ $cotizacion->pais->nombre_pais }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Tipo de Modalidad:</label>
                                <input type="text" name="modalidad_id" class="form-control"
                                    value="{{ $cotizacion->modalidad->modalidad }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Tipo de Carga:</label>
                                <input type="text" name="cargas_id" class="form-control"
                                    value="{{ $cotizacion->carga->tipoCarga }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Nombre del Producto:</label>
                                <input type="text" name="producto" class="form-control"
                                    value="{{ $cotizacion->producto }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Cantidad de Productos:</label>
                                <input type="text" name="total_productos" class="form-control"
                                    value="{{ $cotizacion->total_productos }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Precio China:</label>
                                <input type="text" name="precio_china" class="form-control"
                                    value="{{ $cotizacion->precio_china }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Pais de Origen:</label>
                                <input type="text" name="origen" class="form-control" value="{{ $cotizacion->origen }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Peso de Exportacion:</label>
                                <input type="text" name="peso" class="form-control"
                                    value="{{ $cotizacion->peso }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Volumen de Exportacion:</label>
                                <input type="text" name="volumen" class="form-control"
                                    value="{{ $cotizacion->volumen }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Ciudad y dir. de entrega:</label>
                                <input type="text" name="estado" class="form-control"
                                    value="{{ $cotizacion->ciudad_entrega }} - {{ $cotizacion->direccion }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Costo total:</label>
                                <input type="text" name="total" class="form-control"
                                    value="{{ $cotizacion->total }}" disabled>
                            </div>
                        </div>

                    </div>
                    @if ($dato==0)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-danger" role="alert">
                                    la cotizacion no tiene asignado un contenedor
                                  </div>
                            </div>
                        </div>
                    @else
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Contenedor: </label>
                                <input type="text" name="volumen" class="form-control"
                                    value="{{ $contenedor->name }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Estado del contenedor: </label>
                                <input type="text" name="estado" class="form-control"
                                    value="{{$contenedor->estado->name}}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div> 
                    @endif
                </form>
            </x-adminlte-card>
        </div>
        <div class="col-md-2">
            <x-adminlte-card title="Archivos Adjuntados" theme="dark" icon="fa-solid fa-handshake-angle">
                @php
                    $contador = 1;
                @endphp
                @foreach ($proveedor as $item)
                        <a href="{{route('admin.dowload',$item->id)}}" class="btn btn-danger">Foto {{$contador++}}</a><br><br>                 
                @endforeach
                @foreach ($proveedor as $item)
                        <a href="{{route('admin.dowload.archivo',$item->id)}}" class="btn btn-primary">Archivo {{$contador++}}</a><br><br>                 
                @endforeach
            </x-adminlte-card>
        </div>
    </div>

@stop
