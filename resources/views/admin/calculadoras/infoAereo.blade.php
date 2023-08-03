@extends('adminlte::page')

@section('title', 'Cotizacion')

@section('content_header')
@stop

@section('content')
    <div class="content-header">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card border-light mt-3">
                    <div class="card-header">
                        <div class="content-header">
                            <div class="container-fluid">
                                <div class="row ">
                                    <div class="col-sm-6">
                                        <h3 class="m-0"><i class="fa-solid fa-plane-departure"></i> <b> COTIZADOR
                                                AÉREO</b>
                                        </h3>
                                    </div>
                                    <div class="col-sm-6">
                                        <ul class="nav justify-content-end">
                                            <li class="nav-item">
                                                <a class="nav-link active" aria-current="page" href="{{ route('edit.aerea', $cotizacion->id) }}">Formulario</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="{{ url('cotizacion/aerea/'. $cotizacion->id) }}" aria-disabled="true">Información</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="{{ route('admin.colombia.edit', $cotizacion->id) }}" aria-disabled="true">Simulación</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" aria-disabled="true">Cotización</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-header">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="label border p-2 bg-dark text-light rounded mb-2"><i
                                            class="fa-solid fa-circle-info"></i> DETALLES DE TU SIMULACIÓN</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered text-center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                                <th>Impuesto Unitario</th>
                                                <th>Logistica Unitaria</th>
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
                                                    <td>{{ number_format($item->Impuestos / $item->cantidad, 2) }}</td>
                                                    <td>{{ number_format(($cotizacion->total_logistica * $item->Impuestos) / $cotizacion->total_impuesto / $item->cantidad, 2) }}
                                                    </td>
                                                    <td>{{ number_format($item->divisas / $item->cantidad, 2) }}
                                                    </td>
                                                    <td>{{ number_format($item->precio + $item->Impuestos / $item->cantidad + $cotizacion->total_logistica / $cotizacion->cantidad_productos + $item->divisas / $item->cantidad, 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead class="">
                                            <tr>
                                                <th>CARTONES</th>
                                                <th>LARGO</th>
                                                <th>ANCHO</th>
                                                <th>ALTO</th>
                                                <th>P.V POR PIEZA</th>
                                                <th>P.V TOTAL</th>
                                                <th>P.B POR CARTON</th>
                                                <th>P.B TOTAL PIEZA</th>
                                                <th>TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($aereo as $item)
                                                <tr>
                                                    <td>{{ $item->cartones }}</td>
                                                    <td>{{ $item->largo }}</td>
                                                    <td>{{ $item->ancho }}</td>
                                                    <td>{{ $item->alto }}</td>
                                                    <td>{{ $item->peso_volumetrico_pieza }} Kgs</td>
                                                    <td>{{ $item->peso_volumetrico_total }} Kgs</td>
                                                    <td>{{ $item->peso_bruto_carton }} Kgs</td>
                                                    <td>{{ $item->peso_bruto_piezas }} Kgs</td>
                                                    <td>{{ $item->total }} Kgs</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h5><b>GASTOS DE IMPORTACIÓN</b></h5>
                                </div>
                            </div>
                            <hr>
                            <h6 class="px-4">Total Servicio Logísticos: <span
                                    class="float-end">${{ $cotizacion->total_logistica }}
                                    USD</span></h6>
                            <hr>
                            <h6 class="px-4">Impuestos apróximados: <span
                                    class="float-end">${{ $cotizacion->total_impuesto }} USD</span></h6>
                            <hr>

                            <h6 class="px-4">Valor de compra: <span
                                    class="float-end">${{ $cotizacion->total_fob }} USD</span></h6>

                        </div>
                        <hr>
                        <div class="btn-group d-flex justify-content-center">
                            <a href="{{ route('reporte.aerea', $cotizacion->id) }}"
                                class="btn btn-xs btn-default text-danger mx-1 shadow" title="Descargar">
                                <i class="fa-solid fa-file-pdf"></i> Descargar Archivo
                            </a>
                            <a class="btn btn-xs btn-default text-teal mx-1 shadow" data-bs-toggle="modal"
                                data-bs-target="#PDF" title="Revisar">
                                <i class="fa-solid fa-phone"></i> Contacto BEIRA 8618320025915
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
@stop
