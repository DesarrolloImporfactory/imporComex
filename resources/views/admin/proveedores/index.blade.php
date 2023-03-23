@extends('adminlte::page')

@section('title', 'Imprimir')

@section('content_header')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center ">
            <div>
                <p><b>COTIZADOR {{ $cotizacion->pais->nombre_pais }}</b></p>
                <p>4 de 4 <strong> Completado</strong></p>

            </div>
            <x-adminlte-progress theme="warning" value=100 animated with-label />
        </div>
        <div class="col-md-3">
        </div>
    </div>

@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('admin.showProv', $cotizacion->id) }}" class="btn btn-dark float-right"><i
                    class="fa-solid fa-arrow-right"></i> Siguiente</a>
        </div>
    </div><br>

    <div class="row">

        @include('components.ticket')
        <div class="col-md-12">
            <x-adminlte-card title="Visualizar detalles de tu cotizacion" theme="dark">
                <div class="proveedores">
                    <div class="" id="alerta" role="alert">

                    </div>
                    <div class="">
                        @if ($proveedores > 0)
                            <form action="" id="crearProveedores" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-warning">Agregar</button>
                                    </div>
                                </div>
                                <input type="hidden" id="proveedores" name="proveedores" value="{{ $proveedores }}">
                                <input type="hidden" id="cotizacion_id" name="cotizacion_id" value="{{ $cotizacion->id }}">
                                <div id="contenido">

                                </div>
                            </form>
                        @endif

                        <div class="row " id="ver">
                            <input type="hidden" id="prov" value="{{ $proveedores }}">
                        </div>
                    </div>
                </div><br>
                <table class="table table-bordered">
                    <thead >
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="productos" class="text-center">

                    </tbody>
                </table>
            </x-adminlte-card>
        </div>

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
                            <input type="text" id="product" class="form-control" readonly>
                            <div class="form-group formAsignar">
                                <label for="">Seleccionar proveedor: </label>
                                <x-adminlte-select2 name="proveedor_id" id="proveedor_id">
                                </x-adminlte-select2>
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
    <style>
        .select2-container--open .select2-dropdown {
            z-index: 1070;
        }
    </style>
    <script>
        $(document).ready(function() {

            inputs();
            proveedores();
            mostrarTicket();
            productos();

            function productos() {
                var id = "{{ $cotizacion->id }}";
                $.ajax({
                    type: "GET",
                    url: "../../productos/" + id,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 200) {
                            console.log(response.productos);
                            $.each(response.productos, function(key, producto) {
                                $("#productos").append(`
                                 <tr>
                                <td>${producto.insumo.id}</td>
                                <td>${producto.insumo.nombre}</td>
                                <td>${producto.cantidad}</td>
                                <td>${producto.precio}</td>
                                </td>
                                <td><a href="" type="button" class="btn btn-info agregarProveedor"
                                        value="${producto.id}">+</a></td>
                            </tr>
                                 `);
                            });
                        }
                    }
                });
            }

            function mostrarTicket() {
                var proveedores = $("#prov").val();
                if (proveedores == 0) {
                    $("#ver").append(`
                                <div class="col-md-10">
                                    <div class="alert alert-success" role="alert">
                                        Excelente, ahora solo debemos asignar los proveedores a cada producto.
                                        
                                    </div>
                                </div>
                                <div class="col-md-2"><a class="btn btn-xs btn-default text-teal mx-1 shadow  mt-2" data-bs-toggle="modal"
                                            data-bs-target="#ticket" title="Revisar">
                                            <i class="fa-solid fa-eye"></i> Ver Tickets
                                        </a></div>
                `);
                }

            }

            function inputs() {
                var proveedores = $("#proveedores").val();
                var i = 1;
                for (i = 1; i <= proveedores; i++) {
                    $("#contenido").append(`
                    <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Proveedor ${i}: </label>
                                    <input type="text" placeholder="Nombre" class="form-control" name="nombre_pro${i}" id="nombre_pro${i}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Cajas ${i}: </label>
                                    <input type="number" placeholder="cantidad" min="1" class="form-control" name="cartones${i}" id="cartones${i}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Enlace ${i}: </label>
                                    <input type="text" class="form-control" name="enlace${i}" id="enlace${i}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Contacto  ${i}: </label>
                                    <input type="text" class="form-control" name="contacto${i}" id="contacto${i}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Factura o proforma ${i}: </label>
                                    <input type="file" class="form-control" name="foto${i}" id="foto${i}">
                                    <input type="hidden" name="estado[]" value="${i}" class="form-control">
                                </div>
                            </div>
                    </div>     
                `);
                }
            }

            function proveedores() {
                $("#proveedor_id").append(`<option value="">Selecione una opcion......</option>`);
                var id_cotizacion = $('#cotizacion').val();
                $.ajax({
                    type: "GET",
                    url: "../../admin/proveedor/" + id_cotizacion,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        $.each(response.proveedores, function(key, proveedor) {
                            $("#proveedor_id").append(`
                                <option value="${proveedor.id}">${proveedor.nombre_pro}</option>
                             `);
                        });
                    }
                });
            }

            $(document).on('click', '.agregarProveedor', function(e) {
                e.preventDefault();
                //limpiar y volver a llenar
                $("#proveedor_id").html("");
                proveedores();
                //fin
                var id = $(this).attr("value");
                $("#agregarProveedor").modal("show");
                console.log(id);
                $("#id").val(id);
                $.ajax({
                    type: "GET",
                    url: "../../admin/proveedor/" + id + "/edit",
                    success: function(response) {
                        if (response.status == 400) {

                        } else {
                            $("#product").val(response.insumo.nombre);
                            $("#proveedor_id").val(response.proveedor.id).trigger("change");
                            // $("#proveedor_id option[value='" + response.proveedor.id + "']")
                            //     .attr("selected", true);
                        }
                    }
                });
            });

            $("#formAsignar").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                var id = $("#id").val();
                $.ajax({
                    type: "PUT",
                    url: "../../update/proveedor/" + id,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $("#errores").html("");
                            $('#class1').addClass('alert alert-danger');
                            $.each(response.errores, function(key, err_values) {
                                $('#errores').append(`
                                    <li>${err_values}</li>
                                 `);
                            });
                        } else {

                            $("#class1").removeClass('alert alert-danger');
                            $("#errores").html("");
                            $("#proveedor_id").html("");
                            Swal.fire(
                                'Good job!',
                                response.message,
                                'success'
                            )
                            $('.formAsignar').find('input').val("");
                            $("#agregarProveedor").modal("hide");
                            proveedores();
                            //mostrarTicket();
                        }
                    }
                });
            });

            $("#crearProveedores").submit(function(e) {
                e.preventDefault();
                $("#alerta").html("");
                $("#proveedor_id").html("");
                $("#alerta").removeClass("alert alert-warning alert-dismissible fade show");
                var formData = new FormData(document.getElementById("crearProveedores"));
                console.log(formData);
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.guardarProveedor') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.status == 400) {
                            $("#alerta").addClass(
                                "alert alert-danger alert-dismissible fade show");
                            $("#alerta").append(`
                                <strong>Por favor complete todos los campos.</strong>
                            `);
                        } else {
                            $("#crearProveedores").remove();
                            Swal.fire(
                                'Good job!',
                                response.message,
                                'success'
                            )
                            $("#prov").val(0);
                            proveedores();
                            mostrarTicket();
                        }
                    }
                });
            });

        });
    </script>

@stop
