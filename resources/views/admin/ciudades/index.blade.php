@extends('adminlte::page')
@section('title', 'Tarifas')

@section('content_header')
    
@stop

@section('content')
<br>
    <div class="container-fluid ">
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">TARIFA POR CIUDAD</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="" id="alert" role="alert">
                            <ul id="errores">

                            </ul>
                        </div>
                        <form action="" id="formEdit">
                            @csrf
                            <div class="form-group">
                                <p>Provincia</p>
                                <input type="text" class="form-control" id="provincia" name="provincia">
                                <input type="hidden" class="form-control" id="id" name="id">
                            </div>
                            <div class="form-group">
                                <p>Canton</p>
                                <input type="text" class="form-control" id="canton" name="canton">
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <p>Tarifa</p>
                                    <input type="text" class="form-control" id="tarifa" name="tarifa">
                                </div>
                                <div class="form-group col-md-6">
                                    <p>Kilo adicional</p>
                                    <input type="text" class="form-control" id="kilo" name="kilo">
                                </div>
                            </div>
                            <div class="form-group">
                                <p>Tipo de trayecto</p>
                                <x-adminlte-select2 name="trayecto" id="trayecto" enable-old-suport>
                                    <option value="">Seleccione una opcion.....</option>
                                    <option value="PRINCIPAL">1. PRINCIPAL</option>
                                    <option value="SECUNDARIO">2. SECUNDARIO</option>
                                    <option value="ESPECIAL">3. ESPECIAL</option>
                                </x-adminlte-select2>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <p>Tiemp. Guayaquil</p>
                                    <input type="text" class="form-control" id="tiemp_guayaquil" name="tiemp_guayaquil">
                                </div>
                                <div class="form-group col-md-6">
                                    <p>Tiemp. Quito</p>
                                    <input type="text" class="form-control" id="tiemp_quito" name="tiemp_quito">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" form="formEdit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ">
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
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
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
@stop
