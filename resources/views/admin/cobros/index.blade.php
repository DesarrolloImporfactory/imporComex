@extends('adminlte::page')
@section('title', 'Tarifas')

@section('content_header')

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
                                        <td><a href="{{route('admin.cuentas.edit',$cuenta->id)}}"><i class="fa-solid fa-wallet"></i></a></td>
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
            $('#tableCobros').DataTable({
                responsive: true,
                autoWidth: false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
        });
    </script>
@stop
