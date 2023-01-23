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
    <div class="row">
        <div class="col-md-12">

            <x-adminlte-card title="Detalle de cotizacion" theme="dark">
                <form action="{{route('admin.colombia.save')}}" method="post">
                    @csrf
                    {{ $cotizacion->id }}
                    <div class="row">
                        
                        <input type="hidden" name="cotizacion_id" value="{{ $cotizacion->id }}">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-center">Info Producto</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="">Nombre</label>
                                            <input type="text" class="form-control" name="nombre">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="">Categoria</label>
                                            <select name="categoria_id" id="" class="form-control">
                                                <option value="">Seleccione........</option>
                                                @foreach ($categoria as $item)
                                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="">Cantidad</label>
                                            <input type="number" min="0" class="form-control" name="cantidad">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="">Precio</label>
                                            <input type="text" class="form-control" name="precio" id="precio_total" readonly>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-center">Info Insumos</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                
                                        <div class="form-group col-6">
                                            <label for="">Nombre</label>
                                            <select name="insumos" id="insumos" onchange="colocarPrecio()" class="form-control">
                                                <option value="">Seleccione......</option>
                                                @foreach ($insumo as $item)
                                                    <option precio="{{$item->precio}}" value="{{$item->id}}">{{$item->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="">Cantidad</label>
                                            <input type="number" min="0" name="" id="cantidad" class="form-control"  >
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="">Precio</label>
                                            <input type="text" name="" id="precio" class="form-control"  readonly>
                                        </div>
                                    </div>
                                    <button type="button" onclick="agregar()" class="btn btn-success float-right" >Agregar</button>
                                </div>
                                
                            </div>
                            
                            <table class="table table-light">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Sub Total</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tblInsumo">
                                    <tr>
                                        <td></td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </x-adminlte-card>

        </div>
    </div>
@stop
@section('js')
    <script>
        function colocarPrecio(){
            var precio = $("#insumos option:selected").attr('precio');
            $("#precio").val(precio);
        }

        function agregar(){
            var insumo_id=$("#insumos option:selected").val();
            var insumo_text=$("#insumos option:selected").text();
            var cantidad =$("#cantidad").val();
            var precio = $('#precio').val();
            if(cantidad >0 && precio >0){
                $('#tblInsumo').append(`
                    <tr id="tr-${insumo_id}">
                        <td>
                            <input type="hidden" name="insumo_id[]" value="${insumo_id}"/>
                            <input type="hidden" name="cantidades[]" value="${cantidad}"/>
                            ${insumo_text}
                        </td>
                        <td>${cantidad}</td>
                        <td>${precio}</td>
                        <td>${parseInt(cantidad)*parseInt(precio)}</td>
                        <td>
                            <button type="button" class="btn btn-danger" onClick="eliminar_insumo(${insumo_id}, ${parseInt(cantidad)* parseInt(precio)})">X</button>    
                        </td>
                    </tr>
                `);
                var precio_total = $("#precio_total").val() || 0;
                $("#precio_total").val(parseInt(precio_total) + (parseInt(cantidad)* parseInt(precio)));
            }else{
                alert("se debe ingresar una cantidad o precio valido");
            }
        }

        function eliminar_insumo(id, subTotal){
            $("#tr-"+id).remove();
            var precio_total = $("#precio_total").val() || 0;
            $("#precio_total").val(parseInt(precio_total)- subTotal);
        }
    </script>
@stop
