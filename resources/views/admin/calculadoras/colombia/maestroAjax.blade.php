@extends('adminlte::page')

@section('title', 'Calculadora colombia')

@section('content_header')

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center ">
            <div>
                <p><b>COTIZADOR {{ $cotizacion->pais->nombre_pais }}</b></p>
                <p>{{ $cotizacion->proceso }} de 4 <strong> Completado</strong></p>

            </div>
            <x-adminlte-progress theme="secondary" value=50 animated with-label />
        </div>
        <div class="col-md-3">
        </div>
    </div>

@stop

@section('content')
    @if (Session::has('message'))
        <script>
            Swal.fire({
                position: 'center',
                title: '{{ Session::get('message') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    <div class="row">
        <div class="col-md-12">
            {{-- <x-adminlte-button label="Siguiente" theme="primary" icon="fa-solid fa-arrow-right" class="float-left"
                form="formularioCotizacion" type="sumbit" /> --}}
            <x-adminlte-button label="Siguiente" theme="dark" icon="fa-solid fa-arrow-right" class="float-right"
                form="formularioCotizacion" type="sumbit" />
        </div>
    </div><br>
    {{-- modal editar --}}
    <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar valores</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="class">
                        <ul id="errores_formEdit"></ul>
                    </div>
                    <input type="hidden" id="relacion_id">
                    <div class="form-group">
                        <label for="">Cantidad: </label>
                        <input type="number" class="form-control" id="edit_cantidad" name="edit_cantidad">
                    </div>
                    <div class="form-group">
                        <label for="">Precio: </label>
                        <input type="number" class="form-control" id="edit_precio" name="edit_precio">
                    </div>
                    @can('admin.calculadoras.cliente')
                        <div class="form-group">
                            <label for="">Porcentaje: </label>
                            <input type="number" class="form-control" id="edit_porcentaje" name="edit_porcentaje">
                        </div>
                    @endcan

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary actualizar">Actualizar valor</button>
                </div>
            </div>
        </div>
    </div>
    {{-- modal ver --}}
    <div class="modal fade" id="verModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Detalle de valores</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="form-group mt-3">

                    </div>
                    <div class="form-group mt-3">
                        <label for="">Valor del CIF</label>
                        <input type="number" min="1" class="form-control" name="cif" id="edit_cif" readonly>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">% AD VALOREM</label>
                        <input type="number" min="1" class="form-control" name="porcentaje" id="edit_por" readonly>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">ADVALOREM</label>
                        <input type="number" min="1" class="form-control" name="advalorem" id="edit_advalorem"
                            readonly>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">FODINFA</label>
                        <input type="number" min="1" class="form-control" name="fodinfa" id="edit_fodinfa"
                            readonly>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">IVA</label>
                        <input type="number" min="1" class="form-control" name="iva" id="edit_iva"
                            readonly>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    Informacion de tu cotizacion
                </div>

                <input style="background:white " id="valor" type="hidden" class="form-control "
                    value="{{ $cotizacion->total_logistica }}" disabled>

                <div class="card-footer">
                    @include('admin.cargaSuelta.detalles')
                    @include('admin.calculadoras.editFlete')
                    <form action="{{ route('validacion.store') }}" method="POST" id="formularioCotizacion">
                        @csrf
                        <div class="row">
                            <input type="hidden" value="{{ $cotizacion->id }}" name="cotizacion_id">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="logistica">
                                    </div>
                                    <div class="input-group">
                                        <input name="logistica" id="logistica" type="text" class="form-control"
                                            readonly>
                                        @if ($cotizacion->modalidad_id != 3)
                                            <div class="input-group-append">
                                                <button title="Detalles" class="btn btn-outline-success" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#viewLCL"><i
                                                        class="fa-solid fa-eye fa-bounce"
                                                        style="color: #20941e;"></i></button>
                                            </div>
                                        @else
                                            @can('admin.calculadoras.cliente')
                                                <div class="input-group-append">
                                                    <button title="Detalles" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#editFlete"
                                                        type="button"><i class="fa-solid fa-pen-to-square fa-beat"
                                                            style="color: #d71d1d;"></i></button>
                                                </div>
                                            @endcan
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <div class="impuestos"></div>
                                    <input name="impuestos" id="impuestos" type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="compra">
                                    </div>
                                    <input name="compra" id="compra" type="text" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="cotizacion_total"></div>
                                    <input type="text" name="cotizacion_total" id="cotizacion_total"
                                        class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="productos_total">
                                    </div>
                                    <input type="text" name="cantidad_productos" id="productos_total"
                                        class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="fob_total"></div>
                                    <input type="text" name="total_fob" id="fob_total" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="CALCULEMOS TUS IMPUESTOS" theme="light" icon="fas fa-lg fa-calculator">
                <div id="class1">
                    <ul id="errores">

                    </ul>
                </div>
                <div class="row">

                    <input type="hidden" name="cotizacion_id" id="cotizacion_id" value="{{ $cotizacion->id }}">
                    <div class="row" id="exampleModal">
                        <div class="form-group col-md-3">
                            <label for="">Buscar referencia</label>
                            <x-adminlte-select2 name="insumos" id="insumos" onchange="colocar()" enable-old-support>

                            </x-adminlte-select2>
                        </div>
                        <div class="col-md-2 mt-4">
                            @include('admin.productos.index')
                        </div>
                        <div class="col-md-1 text-center">
                            <label for="">Cantidad</label>
                            <input type="number" min="0" name="cantidad" id="cantidad"
                                class="form-control @error('cantidad') is-invalid @enderror"
                                value="{{ old('cantidad') }}">
                        </div>
                        <div class="col-md-2 text-center">
                            <label for="">Precio</label>
                            <input type="number" min="0" name="" id="precio" class="form-control"
                                value="{{ old('precio') }}">
                        </div>
                        <div class="col-md-2 text-center">
                            <label for="">Porcentaje</label>
                            <input type="number" min="0" name="" id="porcentaje" class="form-control"
                                value="{{ old('porcentaje') }}" readonly>
                        </div>
                        <div class="form-group col-md-2 mt-4 text-center">
                            <button type="button" class="btn btn-warning crear mt-2 "><i
                                    class="fa-solid fa-cart-shopping"></i> Agregar</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-bordered text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>PRODUCTO</th>
                                <th>PRECIO</th>
                                <th>CANTIDAD</th>
                                <th>FOB</th>
                                <th>TOTAL IMPUESTOS</th>
                                <th>TOTAL</th>
                                <th colspan="2">OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="body">

                        </tbody>
                        <tbody class="table-primary" id="bodyTotal">

                        </tbody>
                    </table>
                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop
@section('js')
    <script src="{{ asset('js/maestro.js') }}"></script>
    <script>
        $(document).ready(function() {
            var modalidad = {{ $cotizacion->modalidad_id }}
            if (modalidad != 3) {
                $("#viewLCL").modal('show');
            }
        });
    </script>
@stop
