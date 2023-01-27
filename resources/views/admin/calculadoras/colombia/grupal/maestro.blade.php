@extends('adminlte::page')

@section('title', 'Calculadora colombia')

@section('content_header')

    @if ($mensaje == 'false')
        <script>
            Swal.fire({
                title: '<strong><u>lo sentimos mucho</u></strong>',
                icon: 'error',
                html: 'En carga GRUPAL no se puede cargar este tipo de producto. Dirigete al siguiente enlace para realizar una cotizacion invidual:</b>  ' +
                    '<a href="{{ route('admin.individual.create') }}" >Cotizacion invididual</a> ',
                showCloseButton: false,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> OK!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                cancelButtonAriaLabel: 'Thumbs down'
            })
        </script>
    @endif
    {{-- @if (Session::has('mensaje'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ Session::get('mensaje') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif --}}
    @if (Session::has('mensaje'))
        <div class="alert alert-danger">
            {{ Session::get('mensaje') }}
        </div>
    @endif

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


    <br>
    <div class="row">
        <div class="col-md-12">
            @include('admin.productos.index')
            {{-- @livewire('create-products') --}}
            <button type="submit" form="formProducto" class="btn btn-success">Guardar</button>
            <form action="{{ route('admin.colombia.save') }}" method="post" id="formProducto">
                @csrf

                <div class="row">

                    <input type="hidden" name="cotizacion_id" value="{{ $cotizacion->id }}">
                    <div class="col-md-6">
                        <x-adminlte-card title="Agregar producto" theme="light">

                            <div class="row">
                                <div class="col-md-8">
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
                                <div class="col-md-4 mt-2">
                                    <div class="mt-4">

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="">Cantidad</label>
                                    <input type="number" min="0" name="cantidad" id="cantidad" class="form-control @error('cantidad') is-invalid @enderror" value="{{old('cantidad')}}">
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
                                <div class="form-group col-md-3 mt-2">
                                    <button type="button" onclick="agregar()" class="btn btn-primary  mt-4 "><i
                                            class="fa-solid fa-cart-plus"></i></button>
                                </div>
                            </div>


                        </x-adminlte-card>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="text-success">La cotizacion {{ $cotizacion->tiene_bateria }} tiene bateria,
                                            {{ $cotizacion->liquidos }} tiene liquidos y {{ $cotizacion->inflamable }}
                                            es inflamable</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="">Peso bruto : </label>
                                            <input type="text" class="form-control " value="{{ $cotizacion->peso }}"
                                                disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Tipo de Carga: </label>
                                            <input type="text" class="form-control "
                                                value="{{ $cotizacion->carga->tipoCarga }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Direccion de entrega: </label>
                                            <input type="text" class="form-control "
                                                value="{{ $cotizacion->direccion }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Ciudad de entrega:</label>
                                            <input type="text" class="form-control "
                                                value="{{ $cotizacion->ciudad_entrega }}" disabled>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Dimensiones/Volumen:</label>
                                            <input type="text" class="form-control "
                                                value="{{ $cotizacion->volumen }}" disabled>
                                        </div>
                                        <div class="form-group" style="color: red">
                                            <label for="">Total valor logistica: </label>
                                            <input type="text" class="form-control "
                                                value="{{ $cotizacion->total_logistica }}" disabled style="color: red">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <label for="">Total FOB</label>
                        <input class="form-control" type="text" readonly name="total_fob" id="total_fob">
                    </div>
                    <div class="col-md-3">
                        <label for="">Total SEGURO</label>
                        <input class="form-control" type="text" disabled name="total_seguro" id="total_seguro">
                    </div>
                    <div class="col-md-3">
                        <label for="">Total FLETE</label>
                        <input class="form-control" type="text" disabled name="total_flete" id="total_flete">

                    </div>
                    <div class="col-md-3">
                        <label for="">Total CIF</label>
                        <input class="form-control" type="text" disabled name="total_cif" id="total_cif">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="">Total AD VALOREM</label>
                        <input class="form-control" type="text" disabled name="total_valorem" id="total_valorem">
                    </div>
                    <div class="col-md-3">
                        <label for="">Total FODINFA</label>
                        <input class="form-control" type="text" disabled name="total_fodinfa" id="total_fodinfa">
                    </div>
                    <div class="col-md-3">
                        <label for="">Total IVA</label>
                        <input class="form-control" type="text" disabled name="total_iva" id="total_iva">
                    </div>
                    <div class="col-md-3">
                        <label for="">Precio</label>
                        <input class="form-control" type="text" class="" name="precio" id="precio_total"
                            disabled>
                    </div>

                </div><br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>FOB</th>
                                            <th>Seguro</th>
                                            <th>Flete</th>
                                            <th>CIF</th>
                                            <th>AD Valorem</th>
                                            <th>%</th>
                                            <th>FODINFA</th>
                                            <th>IVA</th>
                                            <th>Total</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tblInsumo">

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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

        function agregar() {
            var insumo_id = $("#insumos option:selected").val();
            var insumo_text = $("#insumos option:selected").text();
            var cantidad = $("#cantidad").val();
            var precio = $('#precio').val();
            var porcentaje = $('#porcentaje').val();

            if (cantidad > 0 && precio > 0) {
                var fob = (parseFloat(cantidad) * parseFloat(precio));
                var seguro = (parseFloat(fob * 0.01));
                var flete = (parseFloat(fob / 5));
                var cif = (parseFloat(fob + seguro + flete));
                var adValorem = (parseFloat(cif * porcentaje));
                var fodinfa = (parseFloat(cif * 0.005));
                var iva = (parseFloat((cif + adValorem + fodinfa) * 0.12))
                $('#tblInsumo').append(`
                    <tr id="tr-${insumo_id}">
                        <td>
                            <input type="hidden" name="insumo_id[]" value="${insumo_id}"/>
                            <input type="hidden" name="cantidades[]" value="${cantidad}"/>
                            ${insumo_text}
                        </td>
                        <td>${cantidad}</td>
                        <td>${precio}</td>
                        <td>${fob}</td>
                        <td>${seguro}</td>
                        <td>${flete}</td>
                        <td>${cif}</td>
                        <td>${adValorem}</td>
                        <td>${porcentaje}%</td>
                        <td>${fodinfa}</td>
                        <td>${iva}</td>
                        <td>${parseFloat(adValorem)+parseFloat(fodinfa)+parseFloat(iva)}</td>
                        <td>
                            <button type="button" class="btn btn-danger" onClick="eliminar_insumo(${insumo_id}, ${parseFloat(adValorem)+parseFloat(fodinfa)+parseFloat(iva)}, ${iva}, ${fodinfa}, ${adValorem}, ${cif}, ${flete}, ${seguro}, ${fob})"><i class="fa-solid fa-trash"></i></button>    
                        </td>
                    </tr>
                `);
                
                //mandar valores a los inputs -> acumuladores
                var precio_total = $("#precio_total").val() || 0;
                $("#precio_total").val(parseFloat(precio_total) + (parseFloat(adValorem) + parseFloat(fodinfa) + parseFloat(
                    iva)));
                var total_iva = $("#total_iva").val() || 0;
                $("#total_iva").val(parseFloat(total_iva) + iva);

                var total_fodinfa = $("#total_fodinfa").val() || 0;
                $("#total_fodinfa").val(parseFloat(total_fodinfa) + fodinfa);

                var total_valorem = $("#total_valorem").val() || 0;
                $("#total_valorem").val(parseFloat(total_valorem) + adValorem);

                var total_cif = $("#total_cif").val() || 0;
                $("#total_cif").val(parseFloat(total_cif) + cif);

                var total_flete = $("#total_flete").val() || 0;
                $("#total_flete").val(parseFloat(total_flete) + flete);

                var total_seguro = $("#total_seguro").val() || 0;
                $("#total_seguro").val(parseFloat(total_seguro) + seguro);

                var total_fob = $("#total_fob").val() || 0;
                $("#total_fob").val(parseFloat(total_fob) + fob);

            } else {
                alert("se debe ingresar una cantidad o precio valido");
            }
        }

        function eliminar_insumo(id, subTotal, ivaEliminar, fodinfaEliminar, valoremEliminar, cifEliminar, fleteEliminar,
            seguroEliminar, fobEliminar) {
            $("#tr-" + id).remove();
            //por cada input al que se le asigna el valor
            var precio_total = $("#precio_total").val() || 0;
            $("#precio_total").val(parseFloat(precio_total) - subTotal);

            var total_iva = $("#total_iva").val() || 0;
            $("#total_iva").val(parseFloat(total_iva) - ivaEliminar);

            var total_fodinfa = $("#total_fodinfa").val() || 0;
            $("#total_fodinfa").val(parseFloat(total_fodinfa) - fodinfaEliminar);

            var total_valorem = $("#total_valorem").val() || 0;
            $("#total_valorem").val(parseFloat(total_valorem) - valoremEliminar);

            var total_cif = $("#total_cif").val() || 0;
            $("#total_cif").val(parseFloat(total_cif) - cifEliminar);

            var total_flete = $("#total_flete").val() || 0;
            $("#total_flete").val(parseFloat(total_flete) - fleteEliminar);

            var total_seguro = $("#total_seguro").val() || 0;
            $("#total_seguro").val(parseFloat(total_seguro) - seguroEliminar);

            var total_fob = $("#total_fob").val() || 0;
            $("#total_fob").val(parseFloat(total_fob) - fobEliminar);

        }
    </script>
@stop
