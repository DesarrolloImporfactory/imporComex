@extends('adminlte::page')

@section('title', 'Calculadora colombia')

@section('content_header')
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="text-center">
                <p class="letter-spacing"><b>COTIZADOR {{ $cotizacion->pais }} </b><span
                        class=" letter-spacing badge rounded-pill text-bg-warning">{{ $cotizacion->modalidad->modalidad }}</span></p>
                <p>2 de 4 <strong> Completado</strong></p>
            </div>
            <x-adminlte-progress theme="secondary" value=50 animated with-label />
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class=" col-md-10 mx-auto mb-3">
            @if ($cotizacion->modalidad->modalidad != 1)
                <a class="btn btn-danger float-left btn-sm" href="{{ route('editar.paso1', $cotizacion->id) }}"><i class="fa-solid fa-angles-left"></i> Regresar</a>
            @endif
            <a href="{{ route('admin.colombia.edit', $cotizacion->id) }}" class="btn btn-dark float-right"><i
                    class="fa-solid fa-arrow-right"></i> Simular costeo</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                
                <div class="card-body">
                    <div class="btn-group">
                        @livewire('aprobar-cotizacion', ['idCotizacion' => $cotizacion->id], key($cotizacion->id))
                        <a href="{{ route('print.cotizacion', $cotizacion->id) }}"
                            class="btn btn-xs btn-default text-danger mx-1 shadow float-left" target="_blank"
                            title="Descargar">
                            <i class="fa-solid fa-file-pdf"></i> Descargar Cotización
                        </a>
                    </div>
                    <hr>
                    <div class="label border p-2 bg-dark text-light rounded mb-2"><i
                            class="fa-solid fa-money-bill-transfer"></i> DETALLES DE COTIZACIÓN.</div>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#origen" aria-expanded="false" aria-controls="flush-collapseOne">
                                    <div class="d-flex gap-2 w-100 justify-content-between">
                                        <div>
                                            <h6 class="mb-0">FLETE MARITIMO:</h6>
                                            <p class="mb-0 opacity-75">{{ $cotizacion->flete_maritimo }}$</p>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    <div class="d-flex gap-2 w-100 justify-content-between">
                                        <div>
                                            <h6 class="mb-0">GASTOS DE ORIGEN</h6>
                                            <p class="mb-0 opacity-75">{{ $cotizacion->gastos_origen }}$.</p>
                                        </div>
                                        {{-- <small class="opacity-50 text-nowrap">Detalles</small> --}}
                                    </div>
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <table class="table table-sm table-bordered table-sm">
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
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
                                    <div class="d-flex gap-2 w-100 justify-content-between">
                                        <div>
                                            <h6 class="mb-0">GASTOS LOCALES</h6>
                                            <p class="mb-0 opacity-75">{{ number_format($cotizacion->gastos_local), 2 }}$
                                            </p>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
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
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTree" aria-expanded="false"
                                    aria-controls="flush-collapseTree">
                                    <div class="d-flex gap-2 w-100 justify-content-between">
                                        <div>
                                            <h6 class="mb-0 text-danger">LOGISTICA INTERNACIONAL:</h6>
                                            <p class="mb-0 opacity-75">
                                                {{ number_format($cotizacion->gastos_origen + $cotizacion->gastos_local + $cotizacion->flete_maritimo, 2) }}$
                                            </p>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="flush-collapseTree" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <table class="table table-sm table-bordered table-sm">
                                        <tbody>
                                            <tr>
                                                <td>GASTOS DE ORIGEN:</td>
                                                <td>USD {{ $cotizacion->gastos_origen }}$</td>
                                            </tr>
                                            <tr class="table-light">
                                                <td>GASTOS LOCALES</td>
                                                <td>USD {{ $cotizacion->gastos_local }}$</td>
                                            </tr>
                                            <tr>
                                                <td>FLETE MARITIMO:</td>
                                                <td>USD {{ $cotizacion->flete_maritimo }}$USD </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-warning" role="alert">
                        <p class="text-justify">NOTA: RECUERDA QUE ESTE ES UN SIMULADOR, AL DAR CLIC EN EL BOTÓN APROBAR SE ENVIARÁ UN E-AMIL A LA AGENCIA DE CARGA Y ELLOS RESPONDERÁN CON LA COTIZACIÓN FINAL, LA CUALRECIBIRÁS EN TU E-MAIL REGISTRADO
                            NOTA: DEBES TOMAR EN CONSIDERACION, OTROS GASTOS COMO FLETE INTERNO - AGENTE DE ADUANA Y BODEGAJE. ESTOS SERVICIOS SERÁN FACTURADOS POR EL ENTE ENCARGADO
                            </p>
                        <p class="mb-0 text-justify">ESTAS TARIFAS SON ENTREGADAS POR NUESTROS ALIADOS BRAGAL GROUP. EMAIL. : asistentegerencia@bragalgroup.com.</p>
                    </div>
                    <div class="label border p-2 bg-dark text-light rounded mb-2"><i
                            class="fa-solid fa-money-bill-transfer"></i> OTROS GASTOS</div>
                    <div class="ml-2 mr-2">
                        <table class="table table-sm table-borderless">
                            <thead class="thead-light ">
                                <tr>
                                    <th>DESCRIPCIÓN</th>
                                    <th>VALOR</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Flete interno: </td>
                                    <td>{{ number_format($cotizacion->flete, 2) }}$</td>
                                    <td width="50">
                                        <button title="Detalles" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#editGasto" type="button"><i
                                                class="fa-solid fa-pen-to-square fa-beat"
                                                style="color: #d71d1d;"></i></button>
                                    </td>
                                </tr>
                                @if ($cotizacion->bodegaje > 0 || $cotizacion->aduana > 0)
                                    <tr>
                                        <td>Bodegaje : </td>
                                        <td>{{ $cotizacion->bodegaje }}$</td>
                                    </tr>
                                    <tr>
                                        <td>Agente de aduana: </td>
                                        <td>{{ $cotizacion->aduana }}$</td>
                                    </tr>
                                @else
                                    @foreach ($otrosGastos as $item)
                                        <tr>
                                            <td>{{ $item->nombre }} : </td>
                                            <td>{{ $item->valor }}$</td>
                                        </tr>
                                    @endforeach
                                @endif
                                <tr class="table-danger">
                                    <td><b>TOTAL OTROS GASTOS:</b></td>
                                    <td>{{ $cotizacion->otros_gastos }}$</td>
                                </tr>
                                {{-- <tr class="table-danger">
                                    <td><b>TOTAL COTIZACION FINAL:</b></td>
                                    <td>{{ $cotizacion->total_logistica }}$</td>
                                </tr> --}}
                            </tbody>
                        </table>
                        <div class="label border p-2 bg-success text-light rounded mb-2"><i
                                class="fa-solid fa-money-bill-transfer"></i> LOGISTICA INTERNACIONAL MÁS OTROS GASTOS:
                            {{ $cotizacion->total_logistica }}$</div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.calculadoras.editLocales')
    @stop
    @section('js')
    @stop
