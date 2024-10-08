@extends('adminlte::page')

@section('title', 'Imprimir')

@section('content_header')
    <div class="row">
        <div class="col-md-3"><a class="btn btn-danger float-left btn-sm" href="{{ route('back') }}"><i
                    class="fa-solid fa-arrow-left"></i> Regresar</a></div>
        <div class="col-md-6 text-center ">
            <div>
                <p><b>COTIZADOR {{ $cotizacion->pais }}</b></p>
                <p>{{ $cotizacion->proceso }} de 4 <strong> Completado</strong></p>

            </div>
            <x-adminlte-progress theme="warning" value=100 animated with-label />
        </div>
        <div class="col-md-3">
        </div>
    </div>

@stop

@section('content')
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <a href="{{ route('admin.cotizaciones.show', $cotizacion->usuario_id) }}" class="btn btn-warning float-left"><i
                    class="fa-solid fa-list-check"></i> Mis cotizaciones</a>
            <a href="{{ route('admin.showProv', $cotizacion->id) }}" class="btn btn-dark float-right"><i
                    class="fa-solid fa-arrow-right"></i> Siguiente</a>
        </div>
        <div class="col-md-1"></div>
    </div><br>

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="alert alert-warning">
                <p>NOTA: LOS VALORES MOSTRADOS EN ESTA TABLA SOIN UNA SIMULACION Y PUEDEN SER MODIFICADOS EN CUALQUIER
                    MOMENTO.</p>
            </div>
            <x-adminlte-card title=" DETALLES DE TU SIMULACIÓN " theme="dark">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="btn-group">
                            @livewire('aprobar-cotizacion', ['idCotizacion' => $cotizacion->id], key($cotizacion->id))
                            <a href="{{ route('print.cotizacion', $cotizacion->id) }}"
                                class="btn btn-xs btn-default text-danger mx-1 shadow float-left" target="_blank"
                                title="Descargar">
                                <i class="fa-solid fa-file-pdf"></i> Descargar Cotización
                            </a>
                            <a href="{{ route('cotizacion.download', $cotizacion->id) }}"
                                class="btn btn-xs btn-default text-danger mx-1 shadow" title="Descargar">
                                <i class="fa-solid fa-file-pdf"></i> Descargar Costeo
                            </a>
                        </div>
                    </div>
                </div><br>
                <table class="table table-bordered text-center table-striped">
                    <thead class="table-warning">
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Impuesto Unitario</th>
                            <th>Logistica Unitaria</th>
                            {{-- <th>%</th> --}}
                            <th>Divisa unitario</th>
                            <th>Producto unitario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $item)
                            <tr>
                                <td>{{ $item->insumo->id }}</td>
                                <td>{{ $item->insumo->nombre }}</td>
                                <td>{{ $item->cantidad }}</td>
                                <td>{{ $item->precio }}</td>
                                <td>{{ number_format($item->impuesto_unitario, 2) }}</td>
                                <td>{{ number_format($item->logistica_unitaria, 2) }}</td>
                                {{-- <td>{{ number_format($item->valor_porcentual,2) }}%</td> --}}
                                <td>{{ number_format($item->divisa_unitario, 2) }}</td>
                                <td>{{ number_format($item->producto_unitario, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <table class="table table-striped">
                    <thead class="table-warning">
                        <tr>
                            <th>DESCRIPCION</th>
                            <th>INFORMACION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>CBM Total: </b></td>
                            <td>{{ $cotizacion->volumen }}</td>
                        </tr>
                        <tr>
                            <td><b>Peso bruto total: </b></td>
                            <td>{{ $cotizacion->peso }}</td>
                        </tr>
                        <tr>
                            <td><b>Lugar de entrega: </b></td>
                            <td>{{ $cotizacion->ciudad->provincia ?? '' }} -
                                {{ $cotizacion->ciudad->canton ?? $cotizacion->tarifa->destino }} -
                                {{ $cotizacion->direccion }}
                            </td>
                        </tr>

                    </tbody>
                </table>
                <table class="table table-striped">
                    <thead class="table-danger">
                        <tr>
                            <th>GASTOS DE IMPORTACION</th>
                            <th>PRECIO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>Total Servicio Logístico</b></td>
                            <td>{{ $cotizacion->total_logistica }}$</td>
                        </tr>
                        <tr>
                            <td><b>Impuestos apróx. </b></td>
                            <td>{{ $cotizacion->total_impuesto }}$</td>
                        </tr>
                        <tr>
                            <td><b>Valor de compra. </b></td>
                            <td>{{ $cotizacion->total_fob }}$</td>
                        </tr>
                        <tr>
                            <td><b>ISD. </b></td>
                            <td>{{ $cotizacion->ISD }}$</td>
                        </tr>
                        <tr>
                            <td><b>Comisión bancaria. </b></td>
                            <td>{{ $cotizacion->comision }}$</td>
                        </tr>
                        <tr>
                            <td><b>Gtos. TOTAL A PAGAR: </b></td>
                            <td>{{ $cotizacion->total }}$</td>
                        </tr>

                    </tbody>
                </table>
            </x-adminlte-card>
        </div>
        <div class="col-md-1"></div>
        <div class="modal fade" id="agregarProveedor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">ASIGNAR PROVEEDOR </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="class1">
                            <ul id="errores">

                            </ul>
                        </div>
                        <form action="" id="formAsignar">
                            @csrf
                            <input type="hidden" id="cotizacion" name="cotizacion" value="{{ $cotizacion->id }}">
                            <input type="hidden" id="id" name="id">
                            <div class="form-group formAsignar">
                                <label for="">Seleccionar proveedor: </label>
                                <select data-width="100%" name="proveedor_id" id="proveedor_id">
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="formAsignar">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.cotizacion')



@stop
