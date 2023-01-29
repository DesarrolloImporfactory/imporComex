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
    @include('admin.productos.index')

    <div class="row">
        <div class="col-md-6">
            <x-adminlte-card title="Dark Card" theme="dark" icon="fas fa-lg fa-moon">

                <ul id="errores_formulario"></ul>

                <div class="row">
                    <div class="form-group col-md-12">
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
                </div>
                <div class="row" id="exampleModal">
                    <div class="form-group col-md-3">
                        <label for="">Cantidad</label>
                        <input type="hidden" name="cotizacion_id" id="cotizacion_id" value="{{ $cotizacion->id }}">
                        <input type="number" min="0" name="cantidad" id="cantidad"
                            class="form-control @error('cantidad') is-invalid @enderror" value="{{ old('cantidad') }}">
                        @error('cantidad')
                            <small style="color:#d80e22ed">
                                <b>{{ $message }}</b>
                            </small>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Precio</label>
                        <input type="text" name="" id="precio" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Porcentaje</label>
                        <input type="text" name="" id="porcentaje" class="form-control">
                    </div>
                    <div class="form-group col-md-3 mt-4">
                        <button type="button" class="btn btn-primary crear">Agregar</button>
                    </div>
                </div>
            </x-adminlte-card>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    Listado de productos
                </div>
                <div class="card-body">
                    <table class="table table-striped ">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>INSUMO</th>
                                <th>PRECIO</th>
                                <th>CANTIDAD</th>
                                <th>PORCENTAJE</th>
                                <th>TOTAL</th>
                                <th colspan="2">OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody id="body">

                        </tbody>

                    </table>
                </div>

            </div>
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
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.relacion.index') }}",
                    dataType: "json",
                    success: function(response) {
                        $('#body').html("");
                        $.each(response.productos, function(key, producto) {
                            $('#body').append(`
                                <tr>
                                    <td>${producto.id}</td>
                                    <td>${producto.insumo_id}</td>
                                    <td>${producto.precio}</td>
                                    <td>${producto.cantidad}</td>
                                    <td>${producto.porcentaje}</td>
                                    <td>${parseFloat(producto.precio)*parseFloat(producto.cantidad)}</td>
                                    <td>
                                        <button type="button" value="${producto.id}" id="btn-eliminar" class="btn btn-danger btn-sm">Eliminar</button>
                                        <button type="button" value="${producto.id}" id="btn-edit" class="btn btn-success btn-sm">Editar</button>
                                    </td>
                                </tr>
                             `);
                        });
                        //$("#total").val(response.datos);
                    }
                });
            }

            //funcion para crear registro
            $(document).on('click', '.crear', function(e) {

                e.preventDefault();
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
                    url: "{{ route('admin.relacion.store') }}",
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
