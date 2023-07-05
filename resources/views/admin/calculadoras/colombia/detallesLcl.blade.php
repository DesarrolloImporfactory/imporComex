@extends('adminlte::page')

@section('title', 'Calculadora colombia')

@section('content_header')
    <div class="row">
        <div class="col-md-2">
            @if ($cotizacion->modalidad->modalidad != 1)
                <a class="btn btn-danger float-left btn-sm" href="{{ route('editar.paso1', $cotizacion->id) }}"><i
                        class="fa-solid fa-arrow-left"></i> Regresar</a>
            @endif
        </div>
        <div class="col-md-4 col-5 col-lg-3">
            <div>
                <p><b>COTIZADOR MODALIDAD </b><span class="badge rounded-pill text-bg-warning">
                        {{ $cotizacion->modalidad->modalidad }}</span></p>
            </div>
        </div>
        <div class="col-md-5 col-lg-5 col-4 text-center ">

            <div class="progress mt-2" role="progressbar" aria-label="Animated striped example" aria-valuenow="100"
                aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 50%">
                    <div class="mt-3">
                        <p>{{ $cotizacion->proceso }} de 4 <strong> Completado</strong></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.colombia.edit', $cotizacion->id) }}" class="btn btn-dark float-right btn-sm"><i
                    class="fa-solid fa-arrow-right"></i> Simular costeo</a>
        </div>
    </div>
    <div class="row">
        @livewire('aprobar-cotizacion', ['idCotizacion' => $cotizacion->id], key($cotizacion->id))
    </div>
@stop

@section('content')
    <div class="card mt-2">
        <div class="card-header">
            Me permito a continuación detallar la cotización de servicios por usted requerida.
            <a href="{{ route('print.cotizacion', $cotizacion->id) }}"
                class="btn btn-xs btn-default text-danger mx-1 shadow" target="_blank" title="Descargar">
                <i class="fa-solid fa-file-pdf"></i> Descargar Archivo
            </a>
        </div>
        <div class="card-body">
            <div class="">
                <div class="table-responsive">

                    <table class="table table-sm table-bordered">

                        <tbody>
                            <tr>
                                <td class="table-active table-dark text-white">Port of Origin:</td>
                                <td>{{ $cotizacion->incoterms->name }}</td>
                                <td class="table-active table-dark text-white">Estimated Transit Time:</td>
                                <td>30-35 días aprox</td>
                            </tr>
                            <tr>
                                <td class="table-active table-dark text-white">Port of Destination:</td>
                                <td>GUAYAQUIL</td>
                                <td class="table-active table-dark text-white">Tipo de Carga:</td>
                                <td>{{ $cotizacion->modalidad->modalidad }}</td>
                            </tr>
                            <tr>
                                <td class="table-active table-dark text-white">Incoterm:</td>
                                <td>FOB</td>
                                <td class="table-active table-dark text-white">Cbm:</td>
                                <td>{{ $cotizacion->volumen }}</td>
                            </tr>
                            <!-- Puedes agregar más filas según tus necesidades -->
                        </tbody>
                    </table>
                    <div class="row col">
                        @php
                            $i = 1;
                        @endphp
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Producto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $item)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->nombre }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <table class="table table-sm table-bordered">
                        <tbody>
                            <tr>
                                <td><b>FLETE MARITIMO:</b></td>
                                <td>{{ $cotizacion->flete_maritimo }}$</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-4">
                            <table class="table table-sm table-bordered table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="2">GASTOS DE ORIGEN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gastosOrigen as $item)
                                        <tr>
                                            <td>{{ $item->nombre }}</td>
                                            <td>{{ $item->valor }}$</td>
                                        </tr>
                                    @endforeach
                                    <tr class="table-light">
                                        <td>TOTAL</td>
                                        <td>{{ $cotizacion->gastos_origen }}$</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered example table-sm">
                                <thead class="thead-light">
                                    <tr>
                                        <th>GASTOS LOCALES</th>
                                        <th>TARIFA</th>
                                        <th>MINIMO</th>
                                        <th>CALCULO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($gastoSimple as $item)
                                        <tr>
                                            <td>{{ $item->nombre }}</td>
                                            <td>{{ $item->valor }}</td>
                                            <td>{{ $item->minimo }}</td>
                                            <td>{{ $item->valor }}$</td>
                                        </tr>
                                    @endforeach
                                    @foreach ($gastosCompuesta as $item)
                                        <tr>
                                            <td>{{ $item->nombre }}</td>
                                            <td>{{ $item->valor }}</td>
                                            <td>{{ $item->minimo }}</td>
                                            @if ($item->valor * $cotizacion->volumen <= $item->minimo)
                                                <td>{{ $item->minimo }}</td>
                                            @else
                                                <td>{{ $item->valor * $cotizacion->volumen }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>COLLECT FEE</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $cotizacion->collect }}$</td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td></td>
                                        <td></td>
                                        <td>GASTOS LOCALES</td>
                                        <td>{{ $cotizacion->gastos_sin_iva }}$</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>IVA 12%</td>
                                        <td>{{ number_format($cotizacion->gastos_sin_iva * 0.12), 2 }}$</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>TOTAL INCL IVA</td>
                                        <td>{{ number_format($cotizacion->gastos_local), 2 }}$</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="aler alert-light mb-3">
                        <b>LOGISTICA INTERNACIONAL:
                            {{ number_format($cotizacion->otros_gastos + $cotizacion->gastos_local, 2) }}$</b>

                    </div>
                    <table class="table table-sm table-bordered">
                        <thead class="thead-light ">
                            <tr>
                                <th>DESCRIPCIÓN</th>
                                <th>VALOR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @foreach ($otrosGastos as $item)
                                        <p>{{ $item->nombre }} : {{ $item->valor }}$</p>
                                    @endforeach
                                    <p>Flete interno: {{ $cotizacion->flete }}$</p>
                                </td>
                                <td>{{ $cotizacion->otros_gastos }}$</td>
                            </tr>
                            <tr class="table-danger">
                                <td><b>TOTAL COTIZACION FINAL:</b></td>
                                <td>{{ $cotizacion->total_logistica }}$</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <div class="alert alert-warning">
                <p class="text-justify">NOTA: RECUERDA QUE DEBES TOMAR EN CONSIDERACION, OTROS GASTOS COMO FLETE INTERNO -
                    AGENTE DE ADUANA Y
                    BODEGAJE.</p>

                <p class="text-justify">ESTAS TARIFAS SON ENTREGADAS POR NUESTROS ALIADOS
                    ALL TRANS CARGO: EMAIL</p>

            </div>
        </div>
    </div>

@stop
@section('js')


@stop
