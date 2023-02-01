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

    {{-- modal editar --}}
    <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar valores</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="errores_formEdit"></ul>
                    <input type="hidden" id="relacion_id">
                    <div class="form-group mt-3">
                        <label for="">Valor del CIF</label>
                        <input type="number" min="1" class="form-control" name="cif" id="edit_cif">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary actualizar">Actualizar valor</button>
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
                <div class="card-body">
                    <label for="" class="text-light">La cotizacion
                        {{ $cotizacion->tiene_bateria }} tiene bateria,
                        {{ $cotizacion->liquidos }} tiene liquidos y {{ $cotizacion->inflamable }}
                        es inflamable</label>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Peso bruto : </label>
                                <input style="background:#38ACFC; border: blue" type="text" class="form-control " value="{{ $cotizacion->peso }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Tipo de Carga: </label>
                                <input style="background:#38ACFC; border: blue" type="text" class="form-control " value="{{ $cotizacion->carga->tipoCarga }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Direccion de entrega: </label>
                                <input style="background:#38ACFC; border: blue" type="text" class="form-control " value="{{ $cotizacion->direccion }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Ciudad de entrega:</label>
                                <input style="background:#38ACFC; border: blue" type="text" class="form-control " value="{{ $cotizacion->ciudad_entrega }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Dimensiones/Volumen:</label>
                                <input style="background:#38ACFC; border: blue" type="text" class="form-control " value="{{ $cotizacion->volumen }}" disabled>

                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" style="color: white">
                                <label for="">Total valor logistica: </label>
                                <input style="background:white "" type="text" class="form-control " value="{{ $cotizacion->total_logistica }}"
                                    disabled >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Registro de productos" theme="dark" icon="fas fa-lg fa-moon">

                <div class="row">
                    <ul id="errores_formulario"></ul>
                    <input type="hidden" name="cotizacion_id" id="cotizacion_id" value="{{ $cotizacion->id }}">
                    <div class="row" id="exampleModal">
                        <div class="form-group col-md-3">
                            <label for="">Buscar referencia</label>
                            <x-adminlte-select2 name="insumos" id="insumos" onchange="colocarPrecio()" enable-old-support>
                                <option value="">Seleccione lo que esta buscando</option>
                                @foreach ($insumo as $item)
                                    <option precio="{{ $item->precio }}" porcentaje="{{ $item->porcentaje }}"
                                        value="{{ $item->id }}">
                                        {{ $item->nombre }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>
                        <div class="col-md-2 mt-3">
                            @include('admin.productos.index')
                        </div>
                        <div class="col-md-2">
                            <label for="">Cantidad</label>
                            <input type="number" min="0" name="cantidad" id="cantidad"
                                class="form-control @error('cantidad') is-invalid @enderror" value="{{ old('cantidad') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="">Precio</label>
                            <input type="text" name="" id="precio" class="form-control" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="">Porcentaje</label>
                            <input type="text" name="" id="porcentaje" class="form-control" readonly>
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
                                <th>FOB</th>
                                <th>SEGURO</th>
                                <th>FLETE</th>
                                <th>CIF</th>
                                <th>AD VALOREM</th>
                                <th>%</th>
                                <th>FODINFA</th>
                                <th>IVA </th>
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
    <script>
        function colocarPrecio() {
            var precio = $("#insumos option:selected").attr('precio');
            $("#precio").val(precio);
            var porcentaje = $("#insumos option:selected").attr('porcentaje');
            $("#porcentaje").val(porcentaje);
        }
        $(document).ready(function() {
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
                                    <td>${producto.id}</td>
                                    <td>${producto.insumo.nombre}</td>
                                    <td>${producto.precio}</td>
                                    <td>${producto.cantidad}</td>
                                    <td>${producto.fob}</td>
                                    <td>${producto.seguro}</td>
                                    <td>${producto.flete}</td>
                                    <td>${producto.cif}</td>
                                    <td>${producto.advalorem}</td>
                                    <td>${producto.porcentaje}%</td>
                                    <td>${producto.fodinfa}</td>
                                    <td>${producto.iva}</td>
                                    <td>${producto.total}</td>
                                    <td>
                                        <a type="button" value="${producto.id}" id="btn-eliminar" class=" btn-sm"><i class="fa-solid fa-trash "></i></a>
                                        <a type="button" value="${producto.id}" id="btn-edit" class="btn-sm"><i class="fa-solid fa-pen-to-square "></i></a>
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
                                <td><input type="hidden" class="form-control" id="totalFob"><b>${(response.totalFob).toFixed(2)}</b></td>
                                <td><input type="hidden" class="form-control" id="totalSeguro"><b>${(response.totalSeguro).toFixed(2)}</b></td>
                                <td><input type="hidden" class="form-control" id="totalFlete"><b>${(response.totalFlete).toFixed(2)}</b></td>
                                <td><input type="hidden" class="form-control" id="totalCif"><b>${(response.totalCif).toFixed(2)}</b></td>
                                <td><input type="hidden" class="form-control" id="totalAdvalorem"><b>${(response.totalAdvalorem).toFixed(2)}</b></td>
                                <td></td>
                                <td><input type="hidden" class="form-control" id="totalFodinfa"><b>${(response.totalFodinfa).toFixed(2)}</b></td>
                                <td><input type="hidden" class="form-control" id="totalIva"><b>${(response.totalIva).toFixed(2)}</b></td>
                                <td><input type="hidden" class="form-control" id="total"><b>${(response.total).toFixed(2)}</b></td>
                                <td></td>
                            </tr>
                        `);
                        $("#totalFob").val(response.totalFob);
                        $("#totalSeguro").val(response.totalSeguro);
                        $("#totalFlete").val(response.totalFlete);
                        $("#totalCif").val(response.totalCif);
                        $("#totalAdvalorem").val(response.totalAdvalorem);
                        $("#totalFodinfa").val(response.totalFodinfa);
                        $("#totalIva").val(response.totalIva);
                        $("#total").val(response.total);

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
                            $('#edit_cif').val(response.relacion.cif);
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
                    'cif': $('#edit_cif').val()
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
                    url: "{{asset('../../admin/relaciones')}}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            //una forma para vaciar un div errores_formEdit
                            $('#errores_formulario').html("");
                            $('#errores_formulario').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values) {
                                $('#errores_formulario').append(`
                                    <li>${err_values}</li>
                                 `);
                            });
                        } else {
                            Swal.fire(
                                'Good job!',
                                response.message,
                                'success'
                            )
                            fetchProducts();
                            $('#exampleModal').find('input').val("");
                        }
                    }
                });
            });
        });
    </script>
@stop
