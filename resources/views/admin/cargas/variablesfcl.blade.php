<div class="modal fade" id="editarFcl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Variable FCL</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="" id="alertVariables" role="alert">
                    <ul id="erroresVariables">

                    </ul>
                </div>
                <form action="" id="formFcl">
                    @csrf
                    <input type="hidden" id="idfcl">
                    <div class="form-group">
                        <p>Nombre de Variable</p>
                        <input type="text" class="form-control" id="variablefcl" name="variablefcl">
                    </div>
                    <div class="form-group">
                        <p>Valor de Variable</p>
                        <input type="number" min="1" class="form-control" id="valorfcl" name="valorfcl">
                    </div>
                    <div class="form-group">
                        <p>Valor extra</p>
                        <input type="number" placeholder="Valor opcional" value="0" class="form-control"
                            id="minimofcl" name="minimofcl">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit " form="formFcl" class="btn btn-primary btnFcl">Guardar
                    Cambios</button>
            </div>
        </div>
    </div>
</div>
<div class="card card-primary card-outline">
    <div class="card-header">
        Gestion de Variables FCL
    </div>
    <div class="card-body">
        <table class="table table-hover" id="variables_fcl">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>VARIABLE</th>
                    <th>VALOR</th>
                    <th>OTRO</th>
                    <th>EDIT</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {

        variablesFcl = $('#variables_fcl').DataTable({
            responsive: true,
            autoWidth: false,
            ajax: 'variables/fcl/create',
            columns: [{
                    data: 'id'
                },
                {
                    data: 'nombre'
                },
                {
                    data: 'valor'
                },
                {
                    data: 'minimo'
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

        $(document).on('click', '.editFcl', function(e) {
            e.preventDefault();
            $(".btnFcl").text("Guardar Cambios");
            $("#alertVariables").removeClass("alert alert-danger");
            $("#erroresVariables").html("");
            var id = $(this).attr('value');
            $.ajax({
                type: "GET",
                url: "variables/" + id+"/edit",
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {
                        console.log('error');
                    } else {
                        $("#editarFcl").modal("show");
                        $("#variablefcl").val(response.variable.nombre);
                        $("#valorfcl").val(response.variable.valor);
                        $("#minimofcl").val(response.variable.minimo);
                        $("#idfcl").val(response.variable.id);
                    }
                }
            });
        });

        $("#formFcl").submit(function(e) {
            e.preventDefault();
            var id = $("#idfcl").val();
            var data = $(this).serialize();
            $.ajax({
                type: "PUT",
                url: "fcl/" + id,
                data: data,
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
                        $(".btnFcl").text("Actualizando...");
                        $("#editarFcl").modal("hide");
                        variablesFcl.ajax.reload(null, false);
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

    })
</script>