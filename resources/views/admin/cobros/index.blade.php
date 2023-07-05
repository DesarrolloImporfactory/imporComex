@extends('adminlte::page')
@section('title', 'Tarifas')

@section('content_header')
    <div class="modal fade" id="editModal"  aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Valor de la Cotización</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="" id="alert" role="alert">
                        <ul id="errores">

                        </ul>
                    </div>
                    <form action="" id="editForm">
                        @csrf
                        <div class="form-group">
                            <label for="">Valor total de cotizacion</label>
                            <input type="hidden" name="id_cotizacion" id="id_cotizacion">
                            <input type="text" class="form-control" id="cotizacion" name="cotizacion" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Nuevo valor</label>
                            <input type="number" class="form-control" id="valor" name="valor"
                                placeholder="ingresar valor">
                        </div>
                        <div class="form-group">
                            <label for="">Accion</label>
                            <select name="accion" id="accion" class="my-select" data-live-search="true" data-width="100%">
                                <option value="">Seleccione una opcion.....</option>
                                <option value="1">Agregar al valor</option>
                                <option value="0">Restar al valor</option>
                            </select >
                        </div>
                        <div class="form-group">
                            <label for="">Detallar el motivo</label>
                            <input type="text" class="form-control" id="motivo" name="motivo">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" form="editForm" class="btn btn-primary">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>
    {{-- <style>
        .select2-container--open .select2-dropdown {
            z-index: 1070;
        }
    </style> --}}
@stop

@section('content')
    <br>
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-12 ">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">CUENTAS POR COBRAR</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped text-center" id="tableCobros">
                            <thead class="">
                                <tr>
                                    <th>ID</th>
                                    <th>COTIZACION</th>
                                    <th>CLIENTE</th>
                                    <th>FECHA</th>
                                    <th>ESTADO</th>
                                    <th>CREDITO</th>
                                    <th>SALDO</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            tabla = $('#tableCobros').DataTable({
                responsive: true,
                autoWidth: false,
                ajax: 'cuentas/create',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'cotizacion_id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'fecha_cotizacion'
                    },
                    {
                        data: 'estado'
                    },
                    {
                        data: 'total'
                    },
                    {
                        data: 'saldo'
                    },
                    {
                        data: "action",
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(document).on('click', '.edit', function(e) {
                e.preventDefault();
                
                var id = $(this).attr('value');
                $.ajax({
                    type: "GET",
                    url: "ajustes/" + id,
                    dataType: "json",
                    success: function(response) {
                        $('#cotizacion').val(response.data.total);
                        $('#id_cotizacion').val(response.data.id);
                        $('.my-select').selectpicker();
                        $('#editModal').modal('show');
                    }
                });

            })

            $("#editForm").submit(function(e) {
                e.preventDefault();
                var id = $("#id_cotizacion").val();
                $.ajax({
                    type: "PUT",
                    url: "../admin/ajustes/" + id,
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

                            $("#editModal").modal("hide");
                            tabla.ajax.reload(null, false);
                        }
                    }
                });
            });

            $(document).on('click', '.abonos', function(e) {
                e.preventDefault();
                var id = $(this).attr('value');
                var url = "cuentas/" + id + "/edit";
                $(location).attr('href', url);
            });

            $(document).on('click', '.notificar', function(e) {
                e.preventDefault();
                Swal.fire(
                    'Buen Trabajo!',
                    'Email Enviado con exito!',
                    'success'
                )
                var id = $(this).attr('value');
                $.ajax({
                    type: "GET",
                    url: "../notificar/cuentas/" + id,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                    }
                });

            });
        });
    </script>
@stop
