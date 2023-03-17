@extends('adminlte::page')
@section('title', 'Tarifas')

@section('content_header')
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
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
                            <x-adminlte-select2 name="accion" id="accion" enable-old-suport>
                                <option value="">Seleccione una opcion.....</option>
                                <option value="1">Agregar al valor</option>
                                <option value="0">Restar al valor</option>
                            </x-adminlte-select2>
                        </div>
                        <div class="form-group">
                            <label for="">Detallar el motivo</label>
                            <input type="text" class="form-control" id="motivo" name="motivo">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="editForm" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .select2-container--open .select2-dropdown {
            z-index: 1070;
        }
    </style>
@stop

@section('content')
    <br>
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-12 ">
                <div class="card card-danger card-outline">
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
                            <tbody>
                                @foreach ($cuentas as $cuenta)
                                    <tr>
                                        <td>{{ $cuenta->id }}</td>
                                        <td>{{ $cuenta->cotizacion_id }}</td>
                                        <td>{{ $cuenta->cotizacion->usuario->name }}</td>
                                        <td>{{ $cuenta->fecha_cotizacion }}</td>
                                        <td>
                                            @if ($cuenta->estado == 1)
                                                Pagado
                                            @else
                                                Pendiente
                                            @endif
                                        </td>
                                        <td>${{ $cuenta->cotizacion->total }}</td>
                                        <td>${{ $cuenta->saldo }}</td>
                                        <td>
                                            <a class="" href="#" role="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-bars"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item edit" href="#"><i
                                                            class="bi bi-pencil-square"></i>
                                                        Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item "
                                                        href="{{ route('admin.cuentas.edit', $cuenta->id) }}"><i
                                                            class="fa-solid fa-wallet"></i> Abonos</a>
                                                </li>
                                            </ul>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#tableCobros').DataTable({
                responsive: true,
                autoWidth: false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });

            table.on('click', '.edit', function() {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }
                var data = table.row($tr).data();
                console.log(data);
                $('#cotizacion').val(data[5]);
                $('#id_cotizacion').val(data[1]);
                $('#editModal').modal('show');
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
                            setInterval("location.reload()",1000);
                            Swal.fire(
                                'Buen Trabajo!',
                                response.message,
                                'success'
                            )
                            
                             $("#editModal").modal("hide");
                            // table.ajax.reload(null, false);
                        }
                    }
                });
            });
        });
    </script>
@stop
