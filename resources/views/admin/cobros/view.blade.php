@extends('adminlte::page')
@section('title', 'Abonos')

@section('content_header')
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-3 ">
                <x-adminlte-small-box title="Cliente" text="{{ $cuentas->cotizacion->usuario->name }}"
                    icon="fas fa-solid fa-user" theme="primary" />
            </div>
            <div class="col-md-3 ">
                <x-adminlte-small-box title="${{ $cuentas->cotizacion->total }}" text="Monto de credito"
                    icon="fas fa-regular fa-sack-dollar" theme="teal" />
            </div>
            <div class="col-md-3 " id="countAbono">
                <x-adminlte-small-box title="0" text="Total abonado" id="abonosTotal"
                    icon="fas fa-chart-bar text-dark" />
            </div>
            <div class="col-md-3 ">
                <x-adminlte-small-box title="0" text="Total saldo" id="saldoTotal" icon="fas fa-duotone fa-wallet"
                    theme="info" />
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-12 ">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">ABONOS DE CLIENTES</h3>
                        <button class="btn btn-warning float-right" id="modal">Agregar Abono</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-lg">
                            <table class="table table-bordered table-striped text-center" id="tableCobros">
                                <thead class="">
                                    <tr>
                                        <th>ID</th>
                                        <th>FECHA</th>
                                        <th>CREDITO</th>
                                        <th>ABONO</th>
                                        <th>SALDO</th>
                                        <th>FORMA PAGO</th>
                                        <th>TRANSACCION</th>
                                        <th>OPCIONES</th>
                                    </tr>
                                </thead>
                                <tbody id="body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAbono" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registro de Abonos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="" id="alert" role="alert">
                        <ul id="errores">

                        </ul>
                    </div>
                    <form action="" id="crearAbono">

                        @csrf
                        <input type="hidden" id="cabecera_id" name="cabecera_id" value="{{ $cuentas->id }}">
                        <div class="inputs">
                            <div class="form-group">
                                <label for="">Abono</label>
                                {{-- <input type="hidden" id="" name="" value="{{ $cuentas->saldo }}"> --}}
                                <input type="text" class="form-control" name="valor" id="valor"
                                    placeholder="Ingrese un valor">
                            </div>
                            <div class="form-group">
                                <label for="">Forma de pago</label>
                                <x-adminlte-select2 name="pago_id" id="pago_id" enable-old-suport>
                                    <option value="">Seleccione una opcion.....</option>
                                    @foreach ($formas as $item)
                                        <option value="{{ $item->id }}">{{ $item->tipo_pago }}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                            <div class="form-group">
                                <label for="">Tipo de transaccion</label>
                                <x-adminlte-select2 name="transaccion_id" id="transaccion_id" enable-old-suport>
                                    <option value="">Seleccione una opcion.....</option>
                                    @foreach ($transacciones as $item)
                                        <option value="{{ $item->id }}">{{ $item->tipo_transaccion }}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" form="crearAbono" class="btn btn-primary">Abonar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar abono</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="" id="edit_alert" role="alert">
                        <ul id="edit_errores">

                        </ul>
                    </div>
                    <form action="" id="formEdit">
                        @csrf
                        <input type="hidden" id="id_abono" name="id_abono" value="">
                        <div class="inputs">
                            <div class="form-group">
                                <label for="">Abono</label>
                                <input type="text" class="form-control" name="edit_valor" id="edit_valor"
                                    placeholder="Ingrese un valor">
                            </div>
                            <div class="form-group">
                                <label for="">Forma de pago</label>
                                <x-adminlte-select2 name="edit_pago" id="edit_pago" enable-old-suport>
                                    <option value="">Seleccione una opcion.....</option>
                                    @foreach ($formas as $item)
                                        <option value="{{ $item->id }}">{{ $item->tipo_pago }}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                            <div class="form-group">
                                <label for="">Tipo de transaccion</label>
                                <x-adminlte-select2 name="edit_transaccion" id="edit_transaccion" enable-old-suport>
                                    <option value="">Seleccione una opcion.....</option>
                                    @foreach ($transacciones as $item)
                                        <option value="{{ $item->id }}">{{ $item->tipo_transaccion }}</option>
                                    @endforeach
                                </x-adminlte-select2>
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
    <style>
        .select2-container--open .select2-dropdown {
            z-index: 1070;
        }
    </style>
    <script>
        $(document).ready(function() {
            let sBox1 = new _AdminLTE_SmallBox('abonosTotal');
            let sBox2 = new _AdminLTE_SmallBox('saldoTotal');
            abonos();

            function abonos() {
                sBox1.toggleLoading();
                sBox2.toggleLoading();
                var clave = {{ $cuentas->id }};
                $.ajax({
                    type: "GET",
                    url: "../../cuentas/" + clave,
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        $('#body').html("");
                        $.each(response.abonos, function(key, abono) {
                            $('#body').append(`
                        <tr>
                            <td>${(abono.id)}</td>
                            <td>${abono.fecha_vencimiento}</td>
                            <td>${(abono.cabecera.cotizacion.total)}</td>
                            <td>${abono.valor}</td>
                            <td>${(abono.cabecera.saldo)}</td>
                            <td>${abono.transaccion.tipo_transaccion}</td>
                            <td>${(abono.pago.tipo_pago)}</td>
                            <td>
                                <a type="button" value="${abono.id}" id="btn-edit" class="btn-sm"><i class="fa-solid fa-pen-to-square "></i></a>
                            </td>
                        </tr>
                     `);
                        });
                        let rep = response.total;
                        let idx = rep < 10 ? 0 : (rep > 50 ? 2 : 1);
                        let text = 'Total abonado';
                        let data = {
                            text,
                            title: '$' + rep
                        };
                        sBox1.update(data);
                        sBox1.toggleLoading();

                        let rep1 = response.saldo;
                        let idx1 = rep1 < 10 ? 0 : (rep1 > 50 ? 2 : 1);
                        let text1 = 'Total saldo';
                        let data1 = {
                            text1,
                            title: '$' + rep1
                        };
                        sBox2.update(data1);
                        sBox2.toggleLoading();
                    }
                });

            }
            $(document).on('click', '#modal', function(e) {
                e.preventDefault();
                $('.inputs').find('input').val("");
                $("#modalAbono").modal("show");

            });

            $(document).on('click','#btn-edit', function (e) {
                e.preventDefault();
                var id = $(this).attr("value");
                $("#modalEdit").modal("show");
                $.ajax({
                    type: "GET",
                    url: "../../../editAbono/"+id,
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 200) {
                            console.log(response);
                            $("#id_abono").val(response.abono.id);
                            $("#edit_valor").val(response.abono.valor);
                            $("#edit_pago").val(response.abono.pago_id).trigger("change");
                            $("#edit_transaccion").val(response.abono.transaccion_id).trigger("change");
                        } else {
                            console.log("error");
                        }
                    }
                });

            });

            $("#formEdit").submit(function (e) { 
                e.preventDefault();
                var data = $(this).serialize();
                var id = $("#id_abono").val();
                $.ajax({
                    type: "PUT",
                    url: "../../cuentas/"+id,
                    data: data,
                    dataType: "json",
                    success: function (response) {
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
                            Swal.fire(
                                'Buen Trabajo!',
                                response.mensaje,
                                'success'
                            )
                            $("#modalEdit").modal("hide");
                            abonos();
                        }
                    }
                });
            });
            $("#crearAbono").submit(function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "../../cuentas",
                    data: data,
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
                                response.mensaje,
                                'success'
                            )
                            $("#modalAbono").modal("hide");
                            abonos();
                        }
                    }
                });
            });


        });
    </script>
@stop
