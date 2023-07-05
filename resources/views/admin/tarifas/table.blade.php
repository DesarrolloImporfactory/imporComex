<div class="card">
    <div class="card-header">
        GESTION DE TARIFAS POR CIUDAD
        <button class="btn btn-warning float-right newTarifa" data-bs-toggle="modal" data-bs-target="#modalCrearTarifa">Nuevo</button>
        @include('admin.tarifas.create')
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped text-center" id="tableTarifa">
            <thead class="">
                <tr>
                    <th>ID</th>
                    <th>TRANSPORTE</th>
                    <th>ORIGEN</th>
                    <th>DESTINO</th>
                    <th>PESO MIN</th>
                    <th>PESO MAX</th>
                    <th>COSTO</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@include('admin.tarifas.edit')
<script>
    $(document).ready(function() {

        tablaTarifa = $('#tableTarifa').DataTable({
            responsive: true,
            autoWidth: false,
            ajax: '../admin/tarifa/create',
            columns: [{
                    data: 'id'
                },
                {
                    data: 'transporte'
                },
                {
                    data: 'origen'
                },
                {
                    data: 'destino'
                },
                {
                    data: 'peso_min'
                },
                {
                    data: 'peso_max'
                },
                {
                    data: 'costo'
                },
                {
                    data: "action",
                    orderable: false,
                    searchable: false
                },
            ]
        });


        $(document).on("click", ".editarTarifa", function(e) {
            e.preventDefault();
            $("#alertTarifa").removeClass("alert alert-danger");
            $("#erroresTarifa").html("");
            $("#modalEditarTarifa").modal("show");
            var id = $(this).attr("value");
            $.ajax({
                type: "GET",
                url: "../admin/tarifa/" + id,
                dataType: "json",
                success: function(response) {
                    if (response.status = 200) {
                        $("#transporte_edit").val(response.tarifa.transporte);
                        $("#origen_edit").val(response.tarifa.origen);
                        $("#destino_edit").val(response.tarifa.destino);
                        $("#peso_min_edit").val(response.tarifa.peso_min);
                        //  $("#trayecto").val(response.tarifa.).trigger("change");
                        $("#peso_max_edit").val(response.tarifa.peso_max);
                        $("#costo_edit").val(response.tarifa.costo);
                        $("#id").val(response.tarifa.id);
                    } else {
                        alert(response.message);
                    }
                }
            });
        });

        $("#tarifaEdit").submit(function(e) {
            e.preventDefault();
            var id = $("#id").val();
            $.ajax({
                type: "PUT",
                url: "../admin/tarifa/" + id,
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    $("#alertTarifa").removeClass("alert alert-danger");
                    $("#erroresTarifa").html("");
                    if (response.status == 400) {
                        $("#alertTarifa").addClass("alert alert-danger");
                        $.each(response.errors, function(key, error) {
                            $("#erroresTarifa").append(`
                                      <li class="text-danger">${error}</li>
                                 `);
                        });
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $("#modalEditarTarifa").modal("hide");
                        tablaTarifa.ajax.reload(null, false);
                    }
                }
            });
        });

        $("#tarifaNew").submit(function (e) { 
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "../admin/tarifa",
                data: $(this).serialize(),
                dataType: "json",
                success: function (response) {
                    $("#alertCreate").removeClass("alert alert-danger");
                    $("#erroresCreate").html("");
                    if (response.status == 400) {
                        $("#alertCreate").addClass("alert alert-danger");
                        $.each(response.errors, function(key, error) {
                            $("#erroresCreate").append(`
                                     <li class="text-danger">${error}</li>
                                `);
                        });
                    } else {
                        $(".btnTarifa").text("Actualizando...");
                        $(".btnTarifa").attr("disabled", true);
                        $("#modalCrearTarifa").modal("hide");
                        tablaTarifa.ajax.reload(null, false);
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.messages,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $("#alertCreate").removeClass("alert alert-danger");
                        $("#erroresCreate").html("");
                        $(".tarifaNew").find('input').val("");
                        $(".btnTarifa").text("Guardar");
                        $(".btnTarifa").attr("disabled", false);
                    }
                }
            });
        });

        $(document).on('click', '.delete-tarifa', function(e) {
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
                        url: "../admin/tarifa/" + relacion_id,
                        success: function(response) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            tablaTarifa.ajax.reload(null, false);
                        }
                    });
                }
            })
        });

    });
</script>
