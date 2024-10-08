@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
    @php
        $heads = ['ID', 'M3', 'VXCBM', 'TCBM', 'MIN', 'MAX', 'EDIT'];
        $heads2 = ['ID', 'Tipo de carga', 'Acciones'];
    @endphp
    <br>
    <div class="row">
        <div class="col-md-12 ">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    VARIABLES DEL SISTEMA
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <select class="my-select" name="filtro_modalidad" data-width="100%" title="FILTRAR POR" id="filtro_modalidad">
                                <option value="1">FCL</option>
                                <option value="2">LCL</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="my-select" name="filtro_operacion" data-width="100%" id="filtro_operacion" title="FILTRAR POR">
                               @foreach ($operaciones as $item)
                                   <option value="{{$item->id}}">{{$item->name}}</option>
                               @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            @include('admin.cargas.createVariable')
                        </div>
                    </div>
                    <br>
                    <table class="table table-hover text-center mt-3" id="table_variables">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>MODALIDAD</th>
                                <th>OPERACION</th>
                                <th>TIPO</th>
                                <th>VARIABLE</th>
                                <th>VALOR</th>
                                <th>OTRO</th>
                                <th>EDIT</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Tarifa Divisas
                </div>
                <div class="card-body contenido">

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Gestionar Tarifas Grupales
                    <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal"
                        data-bs-target="#createTarifa">
                        Agregar tarifa
                    </button>
                    @include('admin.cargas.create')
                </div>
                <div class="card-body">
                    <x-adminlte-datatable :heads="$heads" head-theme="dark" id="table_id">
                        @foreach ($tarifas as $tarifa)
                            <tr>
                                <td>{!! $tarifa->id !!}</td>
                                <td>{!! $tarifa->m3 !!}</td>
                                <td>{!! $tarifa->vxcbm !!}</td>
                                <td>{!! $tarifa->tcbm !!}</td>
                                <td>{!! $tarifa->valor_min !!}</td>
                                <td>{!! $tarifa->valor_max !!}</td>
                                <td>
                                    <a class="" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-bars"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item " href=" " data-bs-toggle="modal"
                                                data-bs-target="#example{{ $tarifa->id }}"><i
                                                    class="bi bi-pencil-square"></i> Editar</a>
                                            </a>
                                        </li>
                                        <li>

                                        </li>

                                    </ul>
                                </td>
                            </tr>
                            <!-- ---------------MODAL-------------------- -->
                            @include('admin.cargas.editTarifa')
                            <!-- ---------------FIN MODAL----------------- -->
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            {{-- @include('admin.cargas.variablesfcl') --}}
            @include('admin.cargas.comision')
            <div class="card card-primary card-outline">
                <div class="card-header">
                    Gestionar Tipo de Cargas
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal"
                            data-bs-target="#crearCarga">
                            Agregar Carga
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <x-adminlte-datatable :heads="$heads2" head-theme="dark" id="table">

                        @foreach ($cargas as $carga)
                            <tr>
                                <th scope="row">{!! $carga->id !!}</th>
                                <td>{!! $carga->tipoCarga !!}</td>
                                <td>
                                    <a class="" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-bars"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item " href=" " data-bs-toggle="modal"
                                                data-bs-target="#exampleModal{{ $carga->id }}"><i
                                                    class="bi bi-pencil-square"></i> Editar</a>
                                            </a>
                                        </li>
                                        <li>
                                            <!-- Modal eliminar -->
                                            @include('admin.cargas.formDelete')
                                            <!-- Modal editar -->
                                        </li>

                                    </ul>
                                </td>
                            </tr>
                            <!-- Modal editar -->
                            @include('admin.cargas.formEdit')
                            <!-- Modal editar -->
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
    <!-- ---------------MODAL-------------------- -->
    @include('admin.cargas.formCreate')

    <div class="modal fade" id="editarDivisa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">TARIFA DIVISAS</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="formDivisa">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="">Valor de la tarifa divisas: </label>
                            <input type="number" min="1" class="form-control" name="tarifa" id="tarifa"
                                placeholder="Ingrese el valor">
                            <div class="tarifa" id="errores" value="tarifa"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" form="formDivisa">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarVariable" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <form action="" id="formVariable">
                        @csrf
                        <input type="hidden" id="idVar">
                        <div class="form-group">
                            <p>Nombre de Variable</p>
                            <input type="text" class="form-control" id="variable" name="variable">
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <p>Valor de Variable</p>
                                <input type="number" step="any" inputmode="decimal" class="form-control"
                                    id="valornew" name="valornew">
                            </div>
                            <div class="col-md-6 form-group">
                                <p>Valor extra</p>
                                <input type="number" placeholder="Valor opcional" value="0" class="form-control"
                                    id="minimo" name="minimo">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="">Tipo Modalidad</label>
                                <select name="modalidad" id="modalidad" class="my-select"
                                    title="Choose one of the following..." data-live-search="true" data-width="100%">
                                    @foreach ($modalidades as $item)
                                        <option value="{{ $item->id }}">{{ $item->modalidad }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="">Tipo Operación</label>
                                <select name="operacion" id="operacion" class="my-select"
                                    title="Choose one of the following..." data-live-search="true" data-width="100%">
                                    @foreach ($operaciones as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Tipo de gasto</label>
                            <select name="tipo" id="tipo" class="my-select"
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit " form="formVariable" class="btn btn-primary btnVariable">Guardar
                        Cambios</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ---------------FIN MODAL----------------- -->
    <script>
        $(document).ready(function() {

            divisas();
            variables = $('#table_variables').DataTable({
                responsive: true,
                autoWidth: false,
                ajax: 'variables/create',
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'modalidad.modalidad'
                    },
                    {
                        data: 'operacion.name'
                    },
                    {
                        data: 'tipo'
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

            $('#filtro_modalidad, #filtro_operacion').on('change', function() {
                var modalidad = $('#filtro_modalidad').val();
                var operacion = $('#filtro_operacion').val();

                variables.ajax.url('variables/create?modalidad=' + modalidad + '&operacion=' + operacion)
                    .load();
            });


            $(document).on('click', '.deleteVariable', function() {
                Swal.fire({
                    title: 'Estas seguro?',
                    text: "¡Puede tener valores asociados!",
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
                            url: "variables/" + $(this).attr('value'),
                            success: function(response) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: response.mensaje,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                variables.ajax.reload(null, false);
                            }
                        });
                    }
                })

            });


            $(document).on('click', '.editVariable', function(e) {
                e.preventDefault();
                $(".btnVariable").text("Guardar Cambios");
                $("#alertVariables").removeClass("alert alert-danger");
                $("#erroresVariables").html("");
                var id = $(this).attr('value');
                $.ajax({
                    type: "GET",
                    url: "variables/" + id,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            console.log('error');
                        } else {
                            $('.my-select').selectpicker();
                            $("#editarVariable").modal("show");
                            $('#modalidad').val(response.variable.modalidad_id);
                            $('#modalidad').trigger('change');
                            $('#operacion').val(response.variable.operacion_id);
                            $('#operacion').trigger('change');
                            $('#tipo').val(response.variable.tipo);
                            $('#tipo').trigger('change');
                            $("#variable").val(response.variable.nombre);
                            $("#valornew").val(response.variable.valor);
                            $("#minimo").val(response.variable.minimo);
                            $("#idVar").val(response.variable.id);
                        }
                    }
                });
            });

            $("#formVariable").submit(function(e) {
                e.preventDefault();
                var id = $("#idVar").val();
                var data = $(this).serialize();
                $.ajax({
                    type: "PUT",
                    url: "variables/" + id,
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
                            $(".btnVariable").text("Actualizando...");
                            $("#editarVariable").modal("hide");
                            variables.ajax.reload(null, false);
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

            function divisas() {
                $.ajax({
                    type: "GET",
                    url: "admin/divisas",
                    dataType: "json",
                    success: function(response) {
                        $.each(response.datos, function(key, divisa) {
                            $(".contenido").append(`
                                <p><strong>Valor de la tarifa de divisa: </strong>${divisa.tarifa*100}% <a title="editar" value="${divisa.id}" class="edit float-right" type="button"><i class="fa-solid fa-pen-to-square"></i></a></p>
                            `);
                        });
                    }
                });
            }

            $(document).on("click", ".edit", function(e) {
                e.preventDefault();
                var id = $(this).attr("value");
                $("#editarDivisa").modal("show");
                $.ajax({
                    type: "GET",
                    url: "admin/divisas/" + id + "/edit",
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
                            $("#id").val(response.divisas.id);
                            $("#tarifa").val(response.divisas.tarifa);
                        }

                    }
                });
            });

            $("#formDivisa").submit(function(e) {
                e.preventDefault();
                //$('#errores').html("");
                var id = $("#id").val();
                var data = $("#formDivisa").serialize();
                $.ajax({
                    type: "PUT",
                    url: "admin/divisas/" + id,
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.errors, function(key, error) {
                                $("." + key).html("");
                                if (key == $("." + key).attr("value")) {
                                    $('.' + key).append(`
                                     <strong class="text-danger">${error}</strong>
                                    `);
                                }
                            });

                        } else {
                            Swal.fire(
                                'Good job!',
                                response.message,
                                'success'
                            )
                            $('#editarDivisa').modal('hide');
                            $(".contenido").html("");
                            divisas();
                        }

                    }
                });

            });
        })
    </script>
@stop
