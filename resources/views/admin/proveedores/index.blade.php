@extends('adminlte::page')

@section('title', 'Imprimir')

@section('content_header')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center ">
            <div>
                <p><b>Cotizador {{ $cotizacion->pais->nombre_pais }}</b></p>
                <p>{{ $cotizacion->proceso }} de 4 <strong> Completado</strong></p>

            </div>
            <x-adminlte-progress theme="warning" value=75 animated with-label />
        </div>
        <div class="col-md-3">
        </div>
    </div>

@stop

@section('content')
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <a href="{{ route('admin.showProv', $cotizacion->id) }}" class="btn btn-dark float-right"><i
                    class="fa-solid fa-arrow-right"></i> Siguiente</a>
        </div>
        <div class="col-md-1"></div>
    </div><br>

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <x-adminlte-card title="Visualizar detalles de tu cotizacion" theme="dark">
                <div class="proveedores">
                    <div class="" id="alerta" role="alert">

                    </div>
                    <div class="">

                        <form action="" id="crearProveedores" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-warning">Agregar</button>
                                </div>
                            </div>
                            <input type="hidden" id="proveedores" value="{{ $proveedores }}">
                            <input type="hidden" id="cotizacion_id" name="cotizacion_id" value="{{ $cotizacion->id }}">
                            <div id="contenido">

                            </div>
                        </form>
                    </div>
                </div><br>
                <x-table class="table table-striped">
                    <thead class="table-warning">
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $item)
                            <tr>
                                <td>{{ $item->insumo->id }}</td>
                                <td>{{ $item->insumo->nombre }}</td>
                                <td>{{ $item->cantidad }}</td>
                                <td>{{ $item->precio }}</td>
                                </td>
                                <td><a href="" type="button" class="btn btn-info agregarProveedor"
                                        value="{{ $item->id }}">+</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
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

    <script>
        $(document).ready(function() {

            inputs();
            proveedores();

            function inputs() {
                var proveedores = $("#proveedores").val();
                var i = 1;
                for (i = 1; i <= proveedores; i++) {
                    $("#contenido").append(`
                    <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Nombre proveedor ${i}: </label>
                                    <input type="text" class="form-control" name="nombre_pro${i}" id="nombre_pro${i}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Enlace proveedor ${i}: </label>
                                    <input type="text" class="form-control" name="enlace${i}" id="enlace${i}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Contacto proveedor ${i}: </label>
                                    <input type="text" class="form-control" name="contacto${i}" id="contacto${i}">
                                </div>
                            </div>
                            <div class="col-md-3">
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
                var id = $(this).attr("value");
                $("#agregarProveedor").modal("show");
                $("#id").val(id);
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
                        }
                        $("#class1").removeClass('alert alert-danger');
                        $("#errores").html("");
                        Swal.fire(
                            'Good job!',
                            response.message,
                            'success'
                        )
                        $('.formAsignar').find('input').val("");
                        $("#agregarProveedor").modal("hide");
                        proveedores();
                    }
                });
            });

            $("#crearProveedores").submit(function(e) {
                e.preventDefault();
                $("#alerta").html("");
                $("#alerta").removeClass("alert alert-warning alert-dismissible fade show");
                var formData = new FormData(document.getElementById("crearProveedores"));
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.guardarProveedor') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $("#alerta").addClass(
                                "alert alert-danger alert-dismissible fade show");
                            $("#alerta").append(`
                                <strong>Por favor complete todos los campos.</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            `);
                        } else {
                            //$("#alerta").empty();
                            $(".proveedores").remove();
                            Swal.fire(
                                'Good job!',
                                response.message,
                                'success'
                            )
                        }
                    }
                });
            });

        });
    </script>

@stop
