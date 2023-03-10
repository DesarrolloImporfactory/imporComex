@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')


@stop

@section('content')
    @php
        $heads = ['ID', 'M3', 'VXCBM', 'TCBM', 'Acciones'];
        $heads2 = ['ID', 'Tipo de carga', 'Acciones'];
    @endphp

    <br>
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
                    Gestionar Tipo de Cargas
                    <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal"
                        data-bs-target="#crearCarga">
                        Agregar Carga
                    </button>
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Gestionar Tarifas Grupales
                </div>
                <div class="card-body">
                    <x-adminlte-datatable :heads="$heads" head-theme="dark" id="table_id">
                        @foreach ($tarifas as $tarifa)
                            <tr>
                                <td>{!! $tarifa->id !!}</td>
                                <td>{!! $tarifa->m3 !!}</td>
                                <td>{!! $tarifa->vxcbm !!}</td>
                                <td>{!! $tarifa->tcbm !!}</td>

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
                                            <!-- Modal eliminar -->
                                            @include('admin.cargas.formDelete')
                                            <!-- Modal editar -->
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
    <!-- ---------------FIN MODAL----------------- -->
    <script>
       
        $(document).ready(function() {

            divisas();

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
