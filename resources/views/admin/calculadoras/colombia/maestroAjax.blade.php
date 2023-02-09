@extends('adminlte::page')

@section('title', 'Calculadora colombia')

@section('content_header')

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center ">
            <div>
                <p><b>Cotizador {{ $cotizacion->pais->nombre_pais }}</b></p>
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
                icon: 'error',
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
                        <label for="">Valor del FOB</label>
                        <input type="number" min="1" class="form-control" name="fob" id="edit_fob" readonly>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Valor del CIF</label>
                        <input type="number" min="1" class="form-control" name="cif" id="edit_cif" readonly>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Valor %</label>
                        <input type="number" min="1" class="form-control" name="porcentaje" id="edit_porcentaje"
                            readonly>
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
            <div class="card bg-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>Informacion de tu cotizacion</b></h3>
                </div>

                <input style="background:white " id="valor" type="hidden" class="form-control "
                    value="{{ $cotizacion->total_logistica }}" disabled>

                <div class="card-footer">

                    <form action="{{ route('validacion.store') }}" method="POST" id="formularioCotizacion">
                        @csrf
                        <div class="row">
                            <input type="hidden" value="{{ $cotizacion->id }}" name="cotizacion_id">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Total logistica : </label>
                                    <input style="background:#38ACFC; border: blue" name="logistica" id="logistica"
                                        type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Total impuestos: </label>
                                    <input style="background:#38ACFC; border: blue" name="impuestos" id="impuestos"
                                        type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Total compra: </label>
                                    <input style="background:#38ACFC; border: blue" name="compra" id="compra"
                                        type="text" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group" style="color: white">
                                    <label for="">TOTAL: </label>
                                    <input style="background:white "" type="text" name="cotizacion_total"
                                        id="cotizacion_total" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="REGISTRO DE PROVEEDORES" theme="dark" icon="fas fa-lg fa-street-view">
                <div id="class2">
                    <ul id="errores_proveedor">

                    </ul>
                </div>
                <div class="row">
                    <form action="" enctype="multipart/form-data" id="proveedores">

                        <input type="hidden" name="cotizacion_id" id="cotizacion_id" value="{{ $cotizacion->id }}">
                        <div class="row" id="formulario-proveedor">

                            <div class="col-md-2">
                                <label for="">Nombre del proveedor</label>
                                <input type="text" name="nombre_proveedor" id="nombre_proveedor"
                                    class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label for="">Cantidad de cartones</label>
                                <input type="number" min="0" name="cantidad_cartones" id="cantidad_cartones"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label for="">Foto</label>
                                <input type="file" name="foto" id="foto" class="form-control"
                                    accept="image/*">
                            </div>
                            <div class="col-md-2">
                                <label for="">factura</label>
                                <input type="file" name="factura" id="factura" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label for="">Enlace</label>
                                <input type="text" name="enlace" id="enlace" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label for="">Contacto</label>
                                <input type="text" name="contacto" id="contacto" class="form-control">
                            </div>

                        </div>
                        <div class="row mt-3 mb-3">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary crearProveedor ">Agregar</button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="row">
                    <table class="table table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>PROVEEDOR</th>
                                <th>CARTONES</th>
                                <th>FACTURA</th>
                                <th>FOTO</th>
                                <th>ENLACE</th>
                                <th>CONTACTO</th>
                                <th colspan="2">OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="bodyProveedores">

                        </tbody>
                    </table>
                </div>
            </x-adminlte-card>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="CALCULEMOS TUS IMPUESTOS" theme="dark" icon="fas fa-lg fa-calculator">
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
                        <div class="col-md-2 mt-3">
                            @include('admin.productos.index')
                        </div>
                        <div class="col-md-2">
                            <label for="">Cantidad</label>
                            <input type="number" min="0" name="cantidad" id="cantidad"
                                class="form-control @error('cantidad') is-invalid @enderror"
                                value="{{ old('cantidad') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="">Precio</label>
                            <input type="number" min="0" name="" id="precio" class="form-control"
                                value="{{ old('precio') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="">Porcentaje</label>
                            <input type="number" min="0" name="" id="porcentaje" class="form-control"
                                value="{{ old('porcentaje') }}" readonly>
                        </div>
                        <div class="form-group col-md-1 mt-4">
                            <button type="button" class="btn btn-primary crear mt-2">Agregar</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>PRODUCTO</th>
                                <th>PRECIO</th>
                                <th>CANTIDAD</th>
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
    {{-- <div class="modal fade" id="ver" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="height:700px;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body verArchivo">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div> --}}
@stop
@section('js')
    <script>
        function colocar() {
            var porcentaje = $("#insumos option:selected").attr('porcentaje');
            $("#porcentaje").val(porcentaje);
        }
        $(document).ready(function() {
            fetchProducts();
            //proveedores();



            function fetchProducts() {
                var $id_cotizacion = $('#cotizacion_id').val();
                $.ajax({
                    type: "GET",
                    url: "../../admin/relacion/" + $id_cotizacion,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        $('#body').html("");
                        $.each(response.productos, function(key, producto) {
                            $('#body').append(`
                                <tr>
                                    <td>${(producto.id)}</td>
                                    <td>${producto.insumo.nombre}</td>
                                    <td>${(producto.precio).toFixed(2)}</td>
                                    <td>${(producto.cantidad).toFixed(2)}</td>
                                    
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
                                 <td><input type="hidden" class="form-control" id="totalImpuestos"><b>${(response.totalImpuestos).toFixed(2)}</b></td>
                                 <td><input type="hidden" class="form-control" id="totalTotal"><b>${(response.totalTotal).toFixed(2)}</b></td>
                                 <td></td>
                             </tr>
                         `);
                        $("#compra").val((response.totalFob).toFixed(2));
                        $("#impuestos").val((response.totalImpuestos).toFixed(2));
                        var logistica = $("#valor").val();
                        $("#logistica").val((logistica));

                        $("#cotizacion_total").val((response.totalFob + response.totalImpuestos +
                            parseFloat(
                                logistica)).toFixed(2));

                        // $("#totalFob").val(response.totalFob);
                        // $("#totalSeguro").val(response.totalSeguro);
                        // $("#totalFlete").val(response.totalFlete);
                        // $("#totalCif").val(response.totalCif);
                        // $("#totalAdvalorem").val(response.totalAdvalorem);
                        // $("#totalFodinfa").val(response.totalFodinfa);
                        // $("#totalIva").val(response.totalIva);
                        // $("#total").val(response.total);

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
                        if (response.status == 400) {
                            Swal.fire({
                                position: 'top-end',
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
                                position: 'top-end',
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        } else {
                            $('#edit_cif').val(response.relacion.cif);
                            $('#edit_fob').val(response.relacion.fob);
                            $('#edit_porcentaje').val(response.relacion.porcentaje);
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
                                'Good job!',
                                response.message,
                                'success'
                            )
                        } else {
                            $('#errores_formEdit').html("");
                            fetchProducts();
                            Swal.fire(
                                'Good job!',
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
                                    position: 'top-end',
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

            //funcion para crear registro
            $(document).on('click', '.crear', function(e) {

                e.preventDefault();

                $("#bodyTotal").html("");
                var data = {
                    'insumo_id': $('#insumos').val(),
                    'cantidad': $('#precio').val(),
                    'precio': $('#cantidad').val(),
                    'porcentaje': $('#porcentaje').val(),
                    'cotizacion_id': $('#cotizacion_id').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

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
                                'Good job!',
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

            // $(document).on("click", ".crearProveedor", function(e) {
            //     e.preventDefault();
            //     var foto = $('#foto').prop('files')[0];
            //     var nombre_proveedor = $("#nombre_proveedor").val();
            //     var formData = new FormData();
            //     formData.append('foto', foto);
            //     formData.append('factura', $('#factura').prop('files')[0]);
            //     formData.append('nombre_proveedor', nombre_proveedor);
            //     formData.append('cantidad_cartones', $("#cantidad_cartones").val());
            //     formData.append('enlace', $("#enlace").val());
            //     formData.append('contacto', $("#contacto").val());
            //     formData.append('cotizacion_id', $('#cotizacion_id').val());
            //     console.log(foto);
            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //     });
            //     $.ajax({
            //         type: "POST",
            //         url: "../../admin/proveedor",
            //         data: formData,
            //         cache: false,
            //         contentType: false,
            //         processData: false,
            //         dataType: 'json',
            //         success: function(response) {
            //             console.log(response);
            //             if (response.status == 400) {
            //                 $("#errores_proveedor").html("");
            //                 $("#class2").addClass('alert alert-danger');
            //                 $.each(response.errors, function(key, err_values) {
            //                     $("#errores_proveedor").append(`
        //                         <li>${err_values}</li>
        //                      `);
            //                 });
            //                 $.each(response.errores, function(key, err_values) {
            //                     $("#errores_proveedor").append(`
        //                         <li>${err_values}</li>
        //                      `);
            //                 });
            //                 $(".crearProveedor").text("Intentar");
            //             } else {
            //                 $(".crearProveedor").text("Agregando.....");
            //                 Swal.fire({
            //                     position: 'top-end',
            //                     icon: 'success',
            //                     title: response.message,
            //                     showConfirmButton: false,
            //                     timer: 1500
            //                 })
            //                 $("#class2").removeClass('alert alert-danger');
            //                 $("#errores_proveedor").html("");
            //                 $("#formulario-proveedor").find('input').val("");
            //                 $(".crearProveedor").text("Agregar");
            //                 proveedores();
            //             }
            //         }
            //     });
            // });

            // function proveedores() {
            //     var id_cotizacion = $('#cotizacion_id').val();
            //     console.log(id_cotizacion);
            //     $.ajax({
            //         type: "GET",
            //         url: "../../admin/proveedor/" + id_cotizacion,
            //         dataType: "json",
            //         success: function(response) {
            //             console.log(response);
            //             $("#bodyProveedores").html("");
            //             $.each(response.proveedores, function(key, proveedor) {
            //                 $("#bodyProveedores").append(`
        //                 <tr>
        //                     <td>${proveedor.id}</td>   
        //                     <td>${proveedor.nombre_pro}</td>   
        //                     <td>${proveedor.total_cartones}</td>   
        //                     <td>
        //                         <a type="button" class="btn-sm" value="${proveedor.factura}" id="btn-ver">
        //                             <i class="fa-sharp fa-solid fa-eye text-teal" title="ver archivo"></i>
        //                         </a>    
        //                     </td>   
        //                     <td><img src="../../storage/${proveedor.foto}" width="35px" alt=""></td>   
        //                     <td>${proveedor.enlace}</td> 
        //                     <td>${proveedor.contacto}</td>  
        //                     <<td>
        //                             <a type="button" value="${proveedor.id}" id="eliminar" class=" btn-sm"><i class="fa-solid fa-trash text-danger"></i></a>

        //                     </td> 
        //                 </tr>
        //             `);

            //             });
            //         }
            //     });
            // }

            // $(document).on('click', '#btn-ver', function(e) {
            //     e.preventDefault();
            //     $(".verArchivo").html("");
            //     var ruta = $(this).attr('value');
            //     $("#ver").modal('show');
            //     $(".verArchivo").append(`
        //         <embed src="../../storage/${ruta}" type="application/pdf" width="100%" height="100%">
        //     `);
            // });

            // $(document).on('click', '#eliminar', function(e) {
            //     e.preventDefault();
            //     var id = $(this).attr('value');
            //     Swal.fire({
            //         title: 'Estas seguro?',
            //         text: "¡No podrás revertir esto!",
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonColor: '#3085d6',
            //         cancelButtonColor: '#d33',
            //         cancelButtonText: 'Cancelar',
            //         confirmButtonText: 'Si, Eliminalo!'
            //     }).then((result) => {
            //         if (result.isConfirmed) {
            //             $.ajaxSetup({
            //                 headers: {
            //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //                 }
            //             });
            //             $.ajax({
            //                 type: "DELETE",
            //                 url: "../../admin/proveedor/" + id,
            //                 success: function(response) {
            //                     Swal.fire({
            //                         position: 'top-end',
            //                         icon: 'success',
            //                         title: response.message,
            //                         showConfirmButton: false,
            //                         timer: 1500
            //                     })
            //                     proveedores();
            //                 }
            //             });
            //         }
            //     })
            // });
        });
    </script>
@stop
