<button type="button" class="btn btn-primary float-right crear">
    Crear variable
</button>
<div class="modal fade" id="crearVariable" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Variable</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="" id="alertVariables" role="alert">
                    <ul id="erroresVariables">

                    </ul>
                </div>
                <form action="" id="store">
                    @csrf
                    <div id="formularioProducto">
                        <div class="form-group">
                            <p>Nombre de Variable</p>
                            <input type="text" class="form-control" id="nombre_variable" name="nombre_variable">
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <p>Valor de Variable</p>
                                <input type="number" step="any" inputmode="decimal" class="form-control" id="valor_variable" name="valor_variable">
                            </div>
                            <div class="col-md-6 form-group">
                                <p>Valor extra</p>
                                <input type="number" placeholder="Valor opcional" value="0" class="form-control"
                                    id="valor_extra" name="valor_extra">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Tipo Modalidad</label>
                                <select name="tipo_modalidad" id="tipo_modalidad" class="my-select"
                                    title="Choose one of the following..." data-live-search="true" data-width="100%">
                                    @foreach ($modalidades as $item)
                                        <option value="{{ $item->id }}">{{ $item->modalidad }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">Tipo Operación</label>
                                <select name="tipo_operacion" id="tipo_operacion" class="my-select"
                                    title="Choose one of the following..." data-live-search="true" data-width="100%">
                                    @foreach ($operaciones as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Tipo de gasto</label>
                            <select name="tipo_gasto" id="tipo_gasto" class="my-select"
                                title="Choose one of the following..." data-live-search="true" data-width="100%">
                                <option value="Tasa mensual naviera">Tasa mensual naviera</option>
                                <option value="Flete maritimo">Flete maritimo</option>
                                <option value="Gastos origen">Gastos origen</option>
                                <option value="Gastos locales simple">Gastos locales simple</option>
                                <option value="Gastos locales compuesta">Gastos locales compuesta</option>
                                <option value="Otros gastos">Otros gastos</option>
                                <option value="COLLECT FEE">COLLECT FEE</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit " form="store" class="btn btn-primary btnStore">Guardar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.my-select').selectpicker();
        $(document).on('click', '.crear', function() {
            $(".btnStore").text("Guardar");
            $("#crearVariable").modal("hide");
            $("#crearVariable").modal("show");
        });
        $('#store').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "variables",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    $("#alertVariables").removeClass("alert alert-danger");
                    $("#erroresVariables").html("");
                    if (response.status == 400) {
                        $("#alertVariables").addClass("alert alert-danger");
                        $.each(response.errors, function(key, error) {
                            $("#erroresVariables").append(`
                                     <li class="text-danger">${error}</li>
                                `);
                        });
                    } else {
                        $(".btnStore").text("Actualizando...");
                        $("#crearVariable").modal("hide");
                        variables.ajax.reload(null, false);
                        $("#formularioProducto").find('input').val("");
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.mensaje,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            });
        });
    });
</script>
