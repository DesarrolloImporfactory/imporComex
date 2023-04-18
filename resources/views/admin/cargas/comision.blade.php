<div class="card card-primary card-outline">
    <div class="card-header">
        Comisión Bancaria <button type="button" class="btn btn-primary float-right btnCreate" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            Agregar Comisión
        </button>
    </div>
    <div class="card-body">
        <table class="table table-hover" id="table_comision">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>VALOR</th>
                    <th>MIN</th>
                    <th>MAX</th>
                    <th>EDIT</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear comisión bancaria</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="alert">
                    <ul id="errores"></ul>
                </div>
                <form action="" id="formComision">
                    @csrf
                    <div class="formulario">
                        <div class="form-group">
                            <p>Valor: </p>
                            <input class="form-control" type="number" name="valor" id="valor" placeholder=""
                                step="any">
                        </div>
                        <div class="form-group">
                            <p>Rango minimo: </p>
                            <input class="form-control" type="number" name="valor_min" id="valor_min" placeholder=""
                                step="any">
                        </div>
                        <div class="form-group">
                            <p>Rango maximo: </p>
                            <input class="form-control" type="number" name="valor_max" id="valor_max" placeholder=""
                                step="any">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" form="formComision" class="btn btn-primary btnComision">Guardar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar comisión bancaria</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="edit_alert">
                    <ul id="edit_errores"></ul>
                </div>
                <form action="" id="updateComision">
                    @csrf
                    <div class="formulario">
                        <div class="form-group">
                            <p>Valor: </p>
                            <input type="hidden" id="id" name="id">
                            <input class="form-control" type="number" name="edit_valor" id="edit_valor" placeholder=""
                                step="any">
                        </div>
                        <div class="form-group">
                            <p>Rango minimo: </p>
                            <input class="form-control" type="number" name="edit_valor_min" id="edit_valor_min"
                                placeholder="" step="any">
                        </div>
                        <div class="form-group">
                            <p>Rango maximo: </p>
                            <input class="form-control" type="number" name="edit_valor_max" id="edit_valor_max"
                                placeholder="" step="any">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" form="updateComision" class="btn btn-primary btnComision">Guardar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        comision = $('#table_comision').DataTable({
            responsive: true,
            autoWidth: false,
            ajax: 'comision/create',
            columns: [{
                    data: 'id'
                },
                {
                    data: 'valor'
                },
                {
                    data: 'valor_min'
                },
                {
                    data: 'valor_max'
                },
                {
                    data: "action",
                    orderable: false,
                    searchable: false
                },
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
            }
        });

        $(document).on("click", ".editComision", function(e) {
            e.preventDefault();
            var id = $(this).attr("value");
            $("#modalEdit").modal("show");
            $.ajax({
                type: "GET",
                url: "comision/" + id + "/edit",
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
                        $("#id").val(response.comision.id);
                        $("#edit_valor").val(response.comision.valor);
                        $("#edit_valor_min").val(response.comision.valor_min);
                        $("#edit_valor_max").val(response.comision.valor_max);
                    }

                }
            });
        });

        $("#updateComision").submit(function(e) {
            e.preventDefault();
            var id = $("#id").val();
            var data = $(this).serialize();
            $.ajax({
                type: "PUT",
                url: "comision/" + id,
                data: data,
                dataType: "json",
                success: function(response) {
                    $("#edit_alert").removeClass("alert alert-danger");
                    $("#edit_errores").html("");
                    if (response.status == 400) {
                        $("#edit_alert").addClass("alert alert-danger");
                        $.each(response.errors, function(key, error) {
                            $("#edit_errores").append(`
                                     <li class="text-danger">${error}</li>
                                `);
                        });
                    } else {
                        $(".btnComision").text("Actualizando...");
                        $(".btnComision").attr("disabled", true);
                        $("#modalEdit").modal("hide");
                        comision.ajax.reload(null, false);
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.mensaje,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $("#alert").removeClass("alert alert-danger");
                        $("#errores").html("");
                        $(".formulario").find('input').val("");
                        $(".btnComision").text("Guardar");
                        $(".btnComision").attr("disabled", false);
                    }
                }
            });
        });

        $("#formComision").submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "comision",
                data: data,
                dataType: "json",
                success: function(response) {
                    $("#alert").removeClass("alert alert-danger");
                    $("#errores").html("");
                    if (response.status == 400) {
                        $("#alert").addClass("alert alert-danger");
                        $.each(response.messages, function(key, error) {
                            $("#errores").append(`
                                     <li class="text-danger">${error}</li>
                                `);
                        });
                    } else {
                        $(".btnComision").text("Actualizando...");
                        $(".btnComision").attr("disabled", true);
                        $("#exampleModal").modal("hide");
                        comision.ajax.reload(null, false);
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.messages,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $("#alert").removeClass("alert alert-danger");
                        $("#errores").html("");
                        $(".formulario").find('input').val("");
                        $(".btnComision").text("Guardar");
                        $(".btnComision").attr("disabled", false);
                    }
                }
            });
        });
    });
</script>
