<div class="card">
    <div class="card-header">
        GESTION DE TARIFAS POR CIUDAD
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped text-center" id="example">
            <thead class="">
                <tr>
                    <th>ID</th>
                    <th>PROVINCIA</th>
                    <th>CANTON</th>
                    <th>TARIFA</th>
                    <th>KILO</th>
                    <th>TRAYECTO</th>
                    <th>TIEMP. GUAYAQUIL</th>
                    <th>TIEMP. QUITO</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
        $(document).ready(function() {

            tablaUsuarios = $('#example').DataTable({
                responsive: true,
                autoWidth: false,
                ajax: 'tarifas/create',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'provincia'
                    },
                    {
                        data: 'canton'
                    },
                    {
                        data: 'tarifa'
                    },
                    {
                        data: 'kilo_adicional'
                    },
                    {
                        data: 'tipo_trayecto'
                    },
                    {
                        data: 'tiemp_guayaquil'
                    },
                    {
                        data: 'tiemp_quito'
                    },
                    {
                        data: "action",
                        orderable: false,
                        searchable: false
                    },
                ]
            });


            $(document).on("click", ".edit", function(e) {
                e.preventDefault();
                $("#alert").removeClass("alert alert-danger");
                $("#errores").html("");
                $("#modalEditar").modal("show");
                var id = $(this).attr("value");
                $.ajax({
                    type: "GET",
                    url: "tarifas/" + id,
                    dataType: "json",
                    success: function(response) {
                        if (response.status = 200) {
                            $("#provincia").val(response.ciudad.provincia);
                            $("#canton").val(response.ciudad.canton);
                            $("#tarifa").val(response.ciudad.tarifa);
                            $("#kilo").val(response.ciudad.kilo_adicional);
                            $("#trayecto").val(response.ciudad.tipo_trayecto).trigger("change");
                            $("#tiemp_guayaquil").val(response.ciudad.tiemp_guayaquil);
                            $("#tiemp_quito").val(response.ciudad.tiemp_quito);
                            $("#id").val(response.ciudad.id);
                        } else {
                            alert("El registro no existe");
                        }
                    }
                });
            });

            $("#formEdit").submit(function(e) {
                e.preventDefault();
                //var data = $(this).serialize();
                var id = $("#id").val();
                $.ajax({
                    type: "PUT",
                    url: "tarifas/" + id,
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        $("#alert").removeClass("alert alert-danger");
                        $("#errores").html("");
                        if (response.status == 400) {
                            $("#alert").addClass("alert alert-danger");
                            $.each(response.errors, function(key, error) {
                                $("#errores").append(`
                                     <li class="text-danger">${error}</li>
                                `);
                            });
                        } else {
                            Swal.fire(
                                'Buen Trabajo!',
                                response.message,
                                'success'
                            )
                            $("#modalEditar").modal("hide");
                            tablaUsuarios.ajax.reload(null, false);
                            ciudades();
                        }
                    }
                });
            });
        });
    </script>