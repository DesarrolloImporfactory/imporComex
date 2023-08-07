@extends('adminlte::page')

@section('title', 'Calculadora colombia')

@section('content_header')

    <div class="row">
        <div class="col-md-3">
            @if ($cotizacion->modalidad->id == 4)
                <a class="btn btn-danger float-left btn-sm" href="{{ url('cotizacion/aerea/' . $cotizacion->id) }}"><i
                        class="fa-solid fa-arrow-left"></i> Regresar</a>
            @else
                @if ($cotizacion->modalidad->id != 2)
                    <a class="btn btn-danger float-left btn-sm" href="{{ route('editar.paso1', $cotizacion->id) }}"><i
                            class="fa-solid fa-arrow-left"></i> Regresar</a>
                @else
                    <a class="btn btn-danger float-left btn-sm" href="{{ route('admin.colombia.show', $cotizacion->id) }}"><i
                            class="fa-solid fa-arrow-left"></i> Regresar</a>
                @endif
            @endif
        </div>
        <div class="col-md-6 text-center ">
            <div>
                <p class="letter-spacing"><b>COTIZADOR {{ $cotizacion->pais }} </b><span
                        class="letter-spacing badge rounded-pill text-bg-warning">
                        {{ $cotizacion->modalidad->modalidad }}</span></p>
                <p>{{ $cotizacion->proceso }} de 4 <strong> Completado</strong></p>

            </div>
            <x-adminlte-progress theme="secondary" value='75' animated with-label />
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
            <div class="card">
                <div class="card-header">
                    {{-- @if ($cotizacion->modalidad_id != 3)
                        <button title="Detalles" class="btn btn-outline-success float-righ btn-sm" type="button"
                            data-bs-toggle="modal" data-bs-target="#viewLCL">Ver detalles <i
                                class="fa-solid fa-eye fa-bounce" style="color: #20941e;"></i></button>
                    @endif --}}
                    DETALLES DE COTIZACIÓN
                </div>

                <input style="background:white " id="valor" type="hidden" class="form-control "
                    value="{{ $cotizacion->total_logistica }}" disabled>
                <div class="card-footer">
                    @include('admin.cargaSuelta.detalles')
                    @include('admin.calculadoras.editFlete')
                    @include('admin.calculadoras.editFleteLCL')
                    <form action="{{ route('validacion.store') }}" method="POST" id="formularioCotizacion">
                        @csrf
                        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 ">
                            <input type="hidden" value="{{ $cotizacion->id }}" name="cotizacion_id">
                            <div class="col">
                                <div class="form-group">
                                    <div class="logistica">
                                    </div>
                                    <div class="input-group">
                                        <input name="logistica" id="logistica" type="text"
                                            class="form-control form-control-sm" readonly>
                                        @if ($cotizacion->modalidad_id == 2)
                                            @can('admin.calculadoras.cliente')
                                                <div class="input-group-append">
                                                    <button title="Detalles" class="btn btn-outline-danger"
                                                        data-bs-toggle="modal" data-bs-target="#editLcl" type="button"><i
                                                            class="fa-solid fa-pen-to-square fa-beat"
                                                            style="color: #d71d1d;"></i></button>
                                                </div>
                                            @endcan
                                        @endif
                                        @if ($cotizacion->modalidad_id == 3)
                                            @can('admin.calculadoras.cliente')
                                                <div class="input-group-append">
                                                    <button title="Detalles" class="btn btn-outline-danger"
                                                        data-bs-toggle="modal" data-bs-target="#editFlete" type="button"><i
                                                            class="fa-solid fa-pen-to-square fa-beat"
                                                            style="color: #d71d1d;"></i></button>
                                                </div>
                                            @endcan
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group ">
                                    <div class="impuestos"></div>
                                    <input name="impuestos" id="impuestos" type="text"
                                        class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <div class="compra">
                                    </div>
                                    <input name="compra" id="compra" type="text"
                                        class="form-control form-control-sm" readonly>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <div class="cotizacion_total"></div>
                                    <input type="text" name="cotizacion_total" id="cotizacion_total"
                                        class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <div class="productos_total">
                                    </div>
                                    <input type="text" name="cantidad_productos" id="productos_total"
                                        class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <div class="fob_total"></div>
                                    <input type="text" name="total_fob" id="fob_total"
                                        class="form-control form-control-sm" readonly>
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

            <x-adminlte-card title="CALCULEMOS TUS IMPUESTOS" class="mt-2" theme="light"
                icon="fas fa-lg fa-calculator">
                <div id="class1">
                    <ul id="errores">
                    </ul>
                </div>
                <div class="container-fluid">
                    <form action="" id="crearCalculo">
                        @csrf
                        <input type="hidden" name="cotizacion_id" id="cotizacion_id" value="{{ $cotizacion->id }}">
                        <div class="d-flex">
                            <div class="mt-2 flex-grow-1">
                                <label for="">Buscar referencia</label>
                                <x-adminlte-select2 name="insumo_id" id="insumos" onchange="colocar()"
                                    enable-old-support>
                                    @foreach ($insumo as $item)
                                        <option value="{{ $item->id }}" porcentaje={{ $item->porcentaje }}>
                                            {{ $item->nombre }}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                            <div class="mt-3  ml-2 flex-grow-1">
                                @include('admin.productos.index')
                            </div>
                            <div class="mt-2 ml-3 flex-grow-1">
                                <label for="">Cantidad</label>
                                <input type="number" min="0" name="cantidad" id="cantidad"
                                    class="form-control @error('cantidad') is-invalid @enderror"
                                    value="{{ old('cantidad') }}">
                            </div>
                            <div class="mt-2 ml-3 flex-grow-1">
                                <label for="">Precio</label>
                                <input type="text" name="precio" id="precio" class="form-control"
                                    value="{{ old('precio') }}">
                            </div>
                            <div class="mt-2 ml-3  flex-grow-1">
                                <label for="">Porcentaje</label>
                                <input type="number" min="0" name="porcentaje" id="porcentaje"
                                    class="form-control" value="{{ old('porcentaje') }}">
                            </div>
                            <div class="mt-3 ml-3 flex-grow-1">
                                <button type="submit" class="btn btn-primary float-right rounded-circle mt-4 "><i
                                        class="fa-solid fa-plus"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="table-responsive-lg">
                        <table class="table table-bordered text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>PRODUCTO</th>
                                    <th>PRECIO</th>
                                    <th>CANTIDAD</th>
                                    <th>FOB</th>
                                    <th>FLETE</th>
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

                </div>
            </x-adminlte-card>
        </div>
    </div>
@stop
@section('js')
    <script>
        $('#precio').on('input', function() {
            this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
        });

        function colocar() {
            var porcentaje = $("#insumos option:selected").attr('porcentaje');
            $("#porcentaje").val(porcentaje);
        }

        $(document).ready(function() {


            function icono() {
                $(".logistica").html('');
                $(".impuestos").html('');
                $(".compra").html('');
                $(".cotizacion_total").html('');
                $(".productos_total").html('');
                $(".fob_total").html('');

                var logistica = $("#logistica").val();
                if (logistica > 0) {
                    $(".logistica").prepend(`
    <i class="fa-solid fa-check text-teal"></i> <label for="">Total logistica : </label>
    `);
                } else {
                    $(".logistica").prepend(`
    <i class="fa-regular fa-circle-xmark text-danger"></i> <label for="">Total logistica : </label>
    `);
                }
                var impuestos = $("#impuestos").val();
                if (impuestos > 0) {
                    $(".impuestos").prepend(`
    <i class="fa-solid fa-check text-teal"></i> <label for="">Total impuestos : </label>
    `);
                } else {
                    $(".impuestos").prepend(`
    <i class="fa-regular fa-circle-xmark text-danger"></i> <label for="">Total impuestos : </label>
    `);
                }
                var compra = $("#compra").val();
                if (compra > 0) {
                    $(".compra").prepend(`
    <i class="fa-solid fa-check text-teal"></i> <label for="">Total compra : </label>
    `);
                } else {
                    $(".compra").prepend(`
    <i class="fa-regular fa-circle-xmark text-danger"></i> <label for="">Total compra : </label>
    `);
                }
                var cotizacion_total = $("#cotizacion_total").val();
                if (cotizacion_total > 0) {
                    $(".cotizacion_total").prepend(`
    <i class="fa-solid fa-check text-teal"></i> <label for="">Total : </label>
    `);
                } else {
                    $(".cotizacion_total").prepend(`
    <i class="fa-regular fa-circle-xmark text-danger"></i> <label for="">Total : </label>
    `);
                }
                var productos_total = $("#productos_total").val();
                if (productos_total > 0) {
                    $(".productos_total").prepend(`
    <i class="fa-solid fa-check text-teal"></i> <label for="">Total productos : </label>
    `);
                } else {
                    $(".productos_total").prepend(`
    <i class="fa-regular fa-circle-xmark text-danger"></i> <label for="">Total productos : </label>
    `);
                }
                var fob_total = $("#fob_total").val();
                if (fob_total > 0) {
                    $(".fob_total").prepend(`
    <i class="fa-solid fa-check text-teal"></i> <label for="">Total FOB : </label>
    `);
                } else {
                    $(".fob_total").prepend(`
    <i class="fa-regular fa-circle-xmark text-danger"></i> <label for="">Total FOB : </label>
    `);
                }
            }
            fetchProducts();

            function fetchProducts() {
                var $id_cotizacion = $('#cotizacion_id').val();
                $.ajax({
                    type: "GET",
                    url: "../../admin/relacion/" + $id_cotizacion,
                    dataType: "json",
                    success: function(response) {
                        $('#body').html("");
                        $.each(response.productos, function(key, producto) {
                            $('#body').append(`
                <tr>
                    <td>${(producto.id)}</td>
                    <td>${producto.insumo.nombre}</td>
                    <td>${(producto.precio).toFixed(2)}</td>
                    <td>${(producto.cantidad).toFixed(2)}</td>
                    <td>${(producto.fob).toFixed(2)}</td>
                    <td>${(producto.flete).toFixed(2)}</td>
                    <td>${(producto.Impuestos).toFixed(2)}</td>
                    <td>${(producto.total).toFixed(2)}</td>
                    <td>
                        <a type="button" value="${producto.id}" id="btn-eliminar" class=" btn-sm"><i class="fa-solid fa-trash "></i></a>
                        <a type="button" value="${producto.id}" id="btn-edit" class="btn-sm"><i class="fa-solid fa-pen-to-square "></i></a>
                        <a type="button" value="${producto.id}" id="btn-ver" class="btn-sm"><i class="fa-solid fa-eye text-teal"></i></a>
                    </td>
                </tr>
             `);
                        });
                        $("#bodyTotal").append(`
         <tr>
                 <td><b>Total:</b></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td><b>${(response.totalFob).toFixed(2)}</b></td>
                 <td><b>${(response.totalFlete).toFixed(2)}</b></td>
                 <td><b>${(response.totalImpuestos).toFixed(2)}</b></td>
                 <td><b>${(response.totalTotal).toFixed(2)}</b></td>
                 <td></td>
             </tr>
         `);
                        $("#compra").val((response.totalFob).toFixed(2));
                        $("#impuestos").val((response.totalImpuestos).toFixed(2));
                        $("#fob_total").val((response.totalFob).toFixed(2));
                        var logistica = $("#valor").val();
                        $("#logistica").val((logistica));

                        $("#cotizacion_total").val((response.totalFob + response.totalImpuestos +
                            parseFloat(logistica)).toFixed(2));

                        $("#productos_total").val((response.totalProducto));

                        icono();
                    }
                });

            }
            //funcion para editar
            $(document).on('click', '#btn-edit', function(e) {
                e.preventDefault();
                $('#errores_formEdit').html("");
                var id = $(this).attr('value');
                $('#editarModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "../../admin/relacion/" + id + "/edit",
                    success: function(response) {
                        console.log(response);
                        if (response.status == 400) {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            $('#relacion_id').val(response.relacion.id);
                            $('#edit_cantidad').val(response.relacion.cantidad);
                            $('#edit_precio').val(response.relacion.precio);
                            $('#edit_porcentaje').val(response.relacion.porcentaje);
                        }
                    }
                });
            });

            $(document).on('click', '#btn-ver', function(e) {
                e.preventDefault();
                $('#errores_formEdit').html("");
                var id = $(this).attr('value');
                $('#verModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "../../admin/relacion/" + id + "/edit",
                    success: function(response) {
                        if (response.status == 400) {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            $('#edit_cif').val(response.relacion.cif);
                            $('#edit_fob').val(response.relacion.fob);
                            $('#edit_por').val(response.relacion.porcentaje);
                            $('#edit_advalorem').val(response.relacion.advalorem);
                            $('#edit_fodinfa').val(response.relacion.fodinfa);
                            $('#edit_iva').val(response.relacion.iva);
                        }
                    }
                });
            });

            //funcion para actualizar
            $(document).on('click', '.actualizar', function(e) {
                e.preventDefault();
                $("#bodyTotal").html("");
                $(this).text("Actualizando....");
                var relacion_id = $('#relacion_id').val();
                var datos = {
                    'total_fob': $("#fob_total").val(),
                    'cotizacion_id': $('#cotizacion_id').val(),
                    'cantidad': $('#edit_cantidad').val(),
                    'precio': $('#edit_precio').val(),
                    'porcentaje': $('#edit_porcentaje').val(),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "PUT",
                    url: "../../admin/relacion/" + relacion_id,
                    data: datos,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $('#errores_formEdit').html("");
                            $('#errores_formEdit').addClass('alert alert-success');
                            $.each(response.errors, function(key, err_values) {
                                $('#errores_formEdit').append(`
                    <li>${err_values}</li>
                 `);
                            });
                            $(".actualizar").text("Volver a intentar");
                        } else if (response.status == 404) {
                            $('#errores_formEdit').html("");
                            Swal.fire(
                                'Buen Trabajo!',
                                response.message,
                                'success'
                            )
                        } else {
                            $('#errores_formEdit').html("");
                            fetchProducts();
                            Swal.fire(
                                'Buen Trabajo!',
                                response.message,
                                'success'
                            )
                            $('#editarModal').modal('hide');
                            $('#editarModal').find('input').val("");
                            $('.actualizar').text('Actualizar valor');
                        }
                    }
                });
            });
            //funcion para eliminar 
            $(document).on('click', '#btn-eliminar', function(e) {
                e.preventDefault();
                $("#bodyTotal").html("");
                var relacion_id = $(this).attr('value');
                Swal.fire({
                    title: 'Estas seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Si, Eliminalo!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "DELETE",
                            url: "../../admin/relacion/" + relacion_id,
                            success: function(response) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                fetchProducts();
                            }
                        });
                    }
                })
            });

            $('#crearCalculo').submit(function(e) {
                e.preventDefault();
                $("#bodyTotal").html("");
                var data = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "../../admin/relacion",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            //una forma para vaciar un div errores_formEdit
                            $("#errores").html("");
                            $('#class1').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values) {
                                $('#errores').append(`
                    <li>${err_values}</li>
                 `);
                            });
                        } else {
                            $("#class1").removeClass('alert alert-danger');
                            $("#errores").html("");
                            Swal.fire(
                                'Buen Trabajo!',
                                response.message,
                                'success'
                            )
                            fetchProducts();
                            $('#exampleModal').find('input').val("");
                            $("#insumos").val("Seleccione lo que esta buscando").trigger(
                                "change");
                        }
                    }
                });

            });
        });
    </script>
    <script>
        // $(document).ready(function() {
        //     var modalidad = {{ $cotizacion->modalidad_id }};
        //     if (modalidad != 3) {
        //         $("#viewLCL").modal('show');
        //     }
        // });
    </script>
@stop
