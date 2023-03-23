@extends('adminlte::page')
@section('title', 'View')

@section('content_header')

    {{-- <x-adminlte-small-box title="Ver Detalles de {{ $cotizacion->usuario->name }}"
        text="Especialista asignado: {{ $cotizacion->especialista->name }} " icon="fas fa-eye text-dark" theme="teal"
        url="{{ route('admin.especialistas.show', $cotizacion->usuario_id) }}" url-text="Volver a las gestion" /> --}}

    <div class="row">

        <div class="col-md-12">

        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">Informacion del cliente</h5>
                </div>
                <div class="card-body">

                    <p class="card-text"><i class="fa-solid fa-user"></i> Nombre: {{ $cotizacion->usuario->name }}</p>
                    <p class="card-text"><i class="fa-solid fa-envelope"></i> Email: {{ $cotizacion->usuario->email }}</p>
                    <p class="card-text"><i class="fa-solid fa-phone-volume"></i> Telefono:
                        {{ $cotizacion->usuario->telefono }}</p>
                    <p class="card-text"><i class="fa-solid fa-calendar"></i> Fecha de cotizacion: {{ $cotizacion->time }}
                    </p>
                    <p class="card-text"><i class="fa-solid fa-passport"></i> Cedula: {{ $cotizacion->usuario->cedula }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    Gestionar cotizaciones asignadas
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.especialistas.update', $cotizacion->id) }}" method="post"
                        id="formCreate">
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
                                    <label for="">Especialista Asignado:</label>
                                    <input type="text" name="usuario_id" class="form-control"
                                        value="{{ $cotizacion->especialista->name }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Tipo de Modalidad:</label>
                                    <input type="text" name="modalidad_id" class="form-control"
                                        value="{{ $cotizacion->modalidad->modalidad }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Pais de cotizacion:</label>
                                    <input type="text" name="pais_id" class="form-control"
                                        value="{{ $cotizacion->pais->nombre_pais }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Tipo de Carga:</label>
                                    <input type="text" name="cargas_id" class="form-control"
                                        value="{{ $cotizacion->carga->tipoCarga }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Peso de Exportacion:</label>
                                    <input type="text" name="peso" class="form-control"
                                        value="{{ $cotizacion->peso }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Volumen de Exportacion:</label>
                                    <input type="text" name="volumen" class="form-control"
                                        value="{{ $cotizacion->volumen }}">
                                </div>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Pais de Origen:</label>
                                    <input type="text" name="origen" class="form-control"
                                        value="{{ $cotizacion->origen }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Direccion de entrega:</label>
                                    <input type="text" name="estado" class="form-control"
                                        value="{{ $cotizacion->direccion }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Ciudad de entrega:</label>
                                    <input type="text" name="estado" class="form-control"
                                        value="{{ $cotizacion->ciudad->provincia }} - {{ $cotizacion->ciudad->canton }}">
                                </div>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
                            <div class="col">
                                <div class="form-group">
                                    @if ($proveedor == 'false' && $proveedores == 'false')
                                        <div class="alert alert-danger">
                                            No existe informacion de proveedores
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label for="">Cantidad de proveedores: </label>
                                            <input type="text" name="total" class="form-control"
                                                value="{{ $proveedores->proveedores }}">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">¿Es inflamable?</label>
                                    <input type="text" class="form-control" name="inflamable"
                                        value="{{ $cotizacion->inflamable }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">¿Tiene bateria?</label>
                                    <input type="text" class="form-control" name="bateria"
                                        value="{{ $cotizacion->tiene_bateria }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">¿Tiene liquidos?</label>
                                    <input type="text" class="form-control" name="liquido"
                                        value="{{ $cotizacion->liquidos }}">
                                </div>
                            </div>

                        </div>
                        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Valor del flete:</label>
                                    <input type="text" name="total" class="form-control"
                                        value="{{ $cotizacion->flete_maritimo }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Costo logistico:</label>
                                    <input type="text" name="total" class="form-control"
                                        value="{{ $cotizacion->total_logistica }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Costo total:</label>
                                    <input type="text" name="total" class="form-control"
                                        value="{{ $cotizacion->total }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <x-adminlte-button label="Guardar Cambios" theme="warning" icon="fas fa-lg fa-save" class="float-right"
                    type="sumbit" form="formCreate" />
                </div>
            </div>
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
