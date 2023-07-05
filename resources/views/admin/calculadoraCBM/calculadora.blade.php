<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Calculadora de Metros Cubicos</h1>
                <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Agregar
                    Producto</button>
            </div>
            <div class="modal-body">
                <form action="" id="create">
                    <input type="hidden" name="cotizacion_id" value="{{ $datos->id }}">
                    @csrf
                    <div class="row formulario">
                        <div class="form-group col-12 col-md-12  col-lg-4">
                            <p for="">Producto</p>
                            <x-adminlte-select2 name="insumo_id" id="productos" class="form-control form-control-sm">
                            
                            </x-adminlte-select2>

                        </div>
                        <div class="form-group col-3 col-md-3 col-lg-2">
                            <p for="">Cartones</p>
                            <input type="number" min="0" name="cartones" class="form-control form-control-sm">

                        </div>
                        <div class="form-group col-3 col-md-3 col-lg-2">
                            <p for="">Largo</p>
                            <input type="number" min="0" name="largo" class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-3 col-md-3 col-lg-2">
                            <p for="">Ancho</p>
                            <input type="number" name="ancho" min="0" id="ancho"
                                class="form-control form-control-sm">
                        </div>
                        <div class="form-group col-3 col-md-3 col-lg-2">
                            <p for="">Alto</p>
                            <input type="number" name="alto" min="0" id="altura"
                                class="form-control form-control-sm">
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>Producto</th>
                                    <th>Cartones</th>
                                    <th>Longitud</th>
                                    <th>Ancho</th>
                                    <th>Altura</th>
                                    <th>Total</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody id="calculos">

                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <input style="color: red" placeholder="Volumen total" type="button"
                            class="form-control form-control-sm" name="total" id="total" readonly>
                    </div>
                    <div class="col-md-7">
                        <button type="submit" class="btn btn-primary  btn-sm" form="create">Calcular</button>
                        <button type="button" class="btn btn-success  btn-sm" id="agregar">Agregar</button>
                        <button type="button" class="btn btn-secondary float-right btn-sm"
                            data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Agregar producto</h1>
            </div>
            <form action="" method="post" id="formProducto">
                @csrf
                <div class="form-group">
                    <input type="hidden" min="0" value="0" class="form-control" id="porcentajeInsumo"
                        name="porcentajeInsumo" placeholder="Valor porcentual">
                </div>
                <div class="modal-body " id="formularioProducto">
                    <div id="validaciones">
                        <ul id="erroresProducto">

                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="">Nombre del producto: </label>
                        <input type="text" class="form-control" name="nombreInsumo" id="nombreInsumo"
                            placeholder="Nombre del producto">
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-target="#exampleModal"
                        data-bs-toggle="modal">Regresar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="crearProducto">Agregar</button>
                </div>
            </form>
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
        table();
        total();
        productos();
        function productos() {
            $("#productos").append(`<option>Seleccione ...</option>`);
            $.ajax({
                type: "GET",
                url: "{{ route('admin.colombia.index') }}",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $.each(response.insumos, function(key, insumo) {
                        $("#productos").append(
                            `<option value="${insumo.id}">${insumo.nombre}</option>`
                        );
                    });
                }
            });
        }
        
        $("#formProducto").submit(function(e) {
            e.preventDefault();
            var data = $("#formProducto").serialize();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.save.producto') }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {
                        $("#erroresProducto").html("");
                        $("#validaciones").addClass('alert alert-danger');
                        $.each(response.message, function(key, error) {
                            $("#erroresProducto").append(`
                                <li>${error}</li>
                             `);
                        });
                        $("#crearProducto").text("Volver a intentar");
                    } else {
                        $("#crearProducto").text("Agregando....");
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $("#formularioProducto").find('input').val("");
                        $("#modalProducto").modal('hide');
                        $("#productos").html("");
                        productos();
                    }
                }
            });
        });
        $('#create').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('admin.ajustes.store') }}",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.status == 404) {
                        alert('Completar los campos')
                    } else {
                        $('.formulario').find('input').val("");
                        table();
                        total();
                    }
                }
            });

        });

        function table() {
            let id = '{{ $datos->id }}';
            $.ajax({
                type: "GET",
                url: "../../admin/ajustes/" + id + "/edit",
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        $('#calculos').html("");
                        $.each(response.calculos, function(key, calculo) {
                            $('#calculos').append(`
                        <tr>
                            <td>${(calculo.producto.nombre)}</td>
                    <td>${calculo.cartones}</td>
                    <td>${(calculo.largo)}</td>
                    <td>${(calculo.ancho)}</td>
                    <td>${(calculo.alto)}</td>
                    <td>${(calculo.total)}</td>
                    <td style="width: 5%;">
                        <a type="button" value="${calculo.id}" id="delete" class="btn-sm"><i class="fa-regular fa-trash-can text-danger"></i></a>
                    </td>
                </tr>
                        `);
                        });
                    } else {
                        console.log('sin registros');
                    }
                }
            });
        }

        function total() {
            let id = '{{ $datos->id }}';
            $.ajax({
                type: "GET",
                url: "../../total/" + id,
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        $('#total').val((response.total).toFixed(2));

                    }
                }
            });
        }

        $(document).on('click', '#agregar', function() {
            let valor = $('#total').val();
            $('#volumen').val(valor);
        });

        $(document).on('click', '#delete', function(e) {
            e.preventDefault();
            let id = $(this).attr('value');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "DELETE",
                url: "../../admin/ajustes/" + id,
                success: function(response) {
                    if (response.status == 200) {
                        table();
                        total();
                    } else {
                        alert(response.message);
                    }
                }
            });
        });
    });
</script>
