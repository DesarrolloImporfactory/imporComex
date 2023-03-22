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
        <div class="col-md-12">
            <x-adminlte-card title="Gestionar cotizaciones asignadas" theme="dark" icon="fa-solid fa-handshake-angle">
                <form action="{{ route('admin.especialistas.update', $cotizacion->id) }}" method="post" id="formCreate">
                    {{ method_field('PATCH') }}
                    @csrf
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
                        <div class="col">
                            <div class="form-group">
                                <label for="">BarCode: {{ $cotizacion->barcode }}</label>
                                {!! DNS1D::getBarcodeHTML("$cotizacion->barcode", 'C128A') !!}   
                            </div>
                        </div>
                        <div class="col">
                            <label for="">Estado:</label>
                            <div class="form-group">
                                <select name="estado" class="selectpicker" data-width="100%" data-style="btn-primary">
                                    @if ($cotizacion->estado == 'Aprobado')
                                        <option value="{{ $cotizacion->estado }}">{{ $cotizacion->estado }}</option>
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="Finalizado">Finalizado</option>
                                    @endif
                                    @if ($cotizacion->estado == 'Pendiente')
                                        <option value="{{ $cotizacion->estado }}">{{ $cotizacion->estado }}</option>
                                        <option value="Aprobado">Aprobado</option>
                                        <option value="Finalizado">Finalizado</option>
                                    @endif
                                    @if ($cotizacion->estado == 'Finalizado')
                                        <option value="{{ $cotizacion->estado }}">{{ $cotizacion->estado }}</option>
                                        <option value="Aprobado">Aprobado</option>
                                        <option value="Pendiente">Pendiente</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="">Usuario:</label>
                                <input type="text" name="estado" class="form-control"
                                    value="{{ $cotizacion->usuario->name }}" disabled>
                            </div>
                        </div>
                        <div class="col">
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
                                <input type="text" name="peso" class="form-control" value="{{ $cotizacion->peso }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Volumen de Exportacion:</label>
                                <input type="text" name="volumen" class="form-control"
                                    value="{{ $cotizacion->volumen }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Ciudad y dir. de entrega:</label>
                                <input type="text" name="estado" class="form-control"
                                    value="{{ $cotizacion->ciudad_entrega }} - {{ $cotizacion->direccion }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Costo total:</label>
                                <input type="text" name="total" class="form-control"
                                    value="{{ $cotizacion->total }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            @if ($proveedor == 'false' && $proveedores == 'false')
                                <div class="alert alert-danger">
                                    No existe informacion de proveedores
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="">Cantidad de proveedores: </label>
                                    <input type="text" name="total" class="form-control"
                                        value="{{ $proveedores->proveedores }}" disabled>
                                </div>
                            @endif

                        </div>
                        <div class="col-md-3">
                            <div class="form-group">

                            </div>
                        </div>

                    </div>
                </form>

            </x-adminlte-card>
        </div>
        <div class="col-md-3">

        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <x-adminlte-card title="Informacion del proveedor" theme="dark" icon="fa-solid fa-handshake-angle">
                @if ($proveedor == 'false' && $proveedores == 'false')
                    <div class="alert alert-danger">
                        No existe informacion de proveedores
                    </div>
                @else
                    @php
                        $contador = 1;
                        $contador1 = 1;
                        $contador2 = 1;
                    @endphp
                    <p for="">Tiene liquidos?: {{ $proveedores->liquidos }}</p>
                    <p for="">Es inflamable?: {{ $proveedores->inflamable }}</p>
                    <table class="table">

                        <thead>
                            @foreach ($proveedor as $item)
                                <tr>

                                    <th scope="col">Proveedor {{ $contador++ }}: </th>
                                    <td>{{ $item->nombre_pro }}</td>
                                    <th scope="col">Cantidad de cartones: </th>
                                    <td>{{ $item->total_cartones }}</td>
                                </tr>

                                <tr>
                                    <th scope="col">Foto: </th>
                                    <td><a href="{{ route('admin.dowload', $item->id) }}" class="btn btn-danger">Foto
                                            {{ $contador1++ }}</a></td>
                                    <th scope="col">Archivo: </th>
                                    <td><a href="{{ route('admin.dowload.archivo', $item->id) }}"
                                            class="btn btn-primary">Archivo
                                            {{ $contador2++ }}</a></td>
                                </tr>

                                <tr>
                                    <th scope="col">Enlace: </th>
                                    <td>{{ $item->enlace }}</td>
                                    <th scope="col">Contacto: </th>
                                    <td>{{ $item->contacto }}</td>
                                </tr>
                            @endforeach
                        </thead>
                    </table>
                @endif

            </x-adminlte-card>
        </div>
    </div>

@stop
