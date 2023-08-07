<!-- Button trigger modal -->
<button type="button" class="btn btn-primary mt-4" id="abrir" data-bs-toggle="modal" data-bs-target="#modalProducto">
    Agregar producto
</button>
<!-- Modal -->
<div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="formProducto">
                @csrf
                <div class="modal-body formulario">
                    <div id="validaciones">
                        <ul id="erroresProducto">

                        </ul>
                    </div>
                    <div class="form-group">
                        <label for="">Nombre del producto: </label>
                        <input type="text" class="form-control" name="nombreInsumo" id="nombreInsumo"
                            placeholder="Nombre del producto">
                    </div>
                    <div class="form-group">
                        <label for="">Porcentaje: </label>
                        <input type="number" min="0" class="form-control" id="porcentajeInsumo"
                            name="porcentajeInsumo" placeholder="Valor porcentual">
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <p for="">Impt. adicional: </p>
                                <input type="text" class="form-control form-control-sm" id="adicional"
                                    name="adicional">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <p for="">Variable: </p>
                            <select name="variable" id="variable" class="form-select form-control-sm">
                                <option value="unidad">Unidad</option>
                                <option value="porcentual">Porcentual</option>
                                <option value="kilogramos">Kilogramos</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <p for="">Valor: </p>
                                <input type="text" class="form-control form-control-sm" id="valor_adicional"
                                    name="valor_adicional">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <p for="">Resultado: </p>
                            <input type="text" readonly class="form-control form-control-sm" id="total"
                                name="total">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="crearProducto">Agregar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#adicional').on('input', function() {
        // Remover caracteres no permitidos y sustituir comas por puntos
        this.value = this.value.replace(/[^0-9.]/g, '').replace(/,/g, '.');

        // Limitar a un solo punto decimal
        var countDots = (this.value.match(/\./g) || []).length;
        if (countDots > 1) {
            this.value = this.value.replace(/\./g, '');
        }

        // Limitar a dos decimales
        var decimalIndex = this.value.indexOf('.');
        if (decimalIndex !== -1 && this.value.length - decimalIndex > 3) {
            this.value = this.value.slice(0, decimalIndex + 3);
        }
    });

    $(document).ready(function() {
        $('#adicional, #variable, #valor_adicional').on('change', function() {
            var adicional = parseFloat($('#adicional').val());
            var variable = $('#variable').val();
            var valorAdicional = parseFloat($('#valor_adicional').val());
            var resultado;

            if (variable == 'unidad') {
                $('#valor_adicional').off('input').on('input', function() {
                    this.value = this.value.replace(/[^\d]/g, '');
                });
                resultado = adicional * valorAdicional;
            } else if (variable == 'porcentual') {
                $('#valor_adicional').off('input').on('input', function() {
                    this.value = this.value.replace(/[^\d]/g, '');
                });
                resultado = adicional * (valorAdicional/100);
            } else if (variable == 'kilogramos') {
                $('#valor_adicional').off('input').on('input', function() {
                    this.value = this.value.replace(/[^0-9.]/g, '').replace(/,/g, '.');
                    var countDots = (this.value.match(/\./g) || []).length;
                    if (countDots > 1) {
                        this.value = this.value.replace(/\./g, '');
                    }
                    var decimalIndex = this.value.indexOf('.');
                    if (decimalIndex !== -1 && this.value.length - decimalIndex > 3) {
                        this.value = this.value.slice(0, decimalIndex + 3);
                    }
                });
                resultado = adicional * valorAdicional;
            }

            $('#total').val(resultado.toFixed(2));
        });
        productos();

        function productos() {
            $("#insumos").append(`<option>Seleccione lo que esta buscando...</option>`);
            $.ajax({
                type: "GET",
                url: "{{ route('admin.colombia.index') }}",
                dataType: "json",
                success: function(response) {
                    $.each(response.insumos, function(key, insumo) {
                        $("#insumos").append(
                            `<option value="${insumo.id}" porcentaje="${insumo.porcentaje}">${insumo.nombre}</option>`
                        );
                    });
                }
            });
        }
        $(document).on("click", "#abrir", function(e) {
            e.preventDefault();
            $("#validaciones").removeClass('alert alert-danger');
            $("#erroresProducto").html("");
            $('.formulario').find('input').val("");
            $("#crearProducto").text("Crear");
        });

        $(document).on('click', '#crearProducto', function(e) {
            e.preventDefault();
            var data = {
                'nombreInsumo': $("#nombreInsumo").val(),
                'porcentajeInsumo': $('#porcentajeInsumo').val(),
                'adicional': $('#adicional').val(),
                'variable': $('#variable').val(),
                'valor' : $('#valor_adicional').val()
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
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
                        $(".formulario").find('input').val("");
                        $("#modalProducto").modal('hide');
                        $("#insumos").html("");
                        $('#exampleModal').find('input').val("");
                        productos();
                    }
                }
            });
        });
    });
</script>
