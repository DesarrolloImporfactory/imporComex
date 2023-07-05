@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard Cliente</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ul class="nav justify-content-end">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Dashboard</a>
                    </li>
                </ul>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-small-box title="{{ $cotizacionesTotal }}" text="Cotizaciones" icon="fas fa-users "
                        theme="gradient-primary" url="#" url-text="Reputation history" id="sbUpdatable" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-small-box title="{{ $productosTotal }}" text="Productos" icon="fas fa-chart-bar"
                        theme="warning" url="#" url-text="Reputation history" id="cotizaciones" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            COTIZACIONES
                        </div>
                        <div class="card-body table-responsive">
                            <x-table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>FECHA</th>
                                        <th>MODALIDAD</th>
                                        <th>ESPECIALISTA</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cotizaciones as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->time }}</td>
                                            <td>{{ $item->modalidad->modalidad }}</td>
                                            <td>{{ $item->especialista->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </x-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <x-adminlte-card theme="" theme-mode="outline">
                <div id="chart1"></div>
            </x-adminlte-card>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            PRODUCTOS
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered" id="productos">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>NOMBRE</th>
                                        <th>PORCENTAJE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->nombre }}</td>
                                            <td>{{ $item->porcentaje }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@push('js')
    <script>
        $(document).ready(function() {
            $('#productos').DataTable();
        });
        Highcharts.chart('chart1', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'Cotizaciones por modalidad'
            },
            accessibility: {
                announceNewData: {
                    enabled: false
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Cuota de mercado porcentual total'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> del total<br/>'
            },
            series: [{
                name: 'Cotizaciones',
                colorByPoint: true,
                data: JSON.parse(`<?php echo $data1; ?>`)
            }]
        });
    </script>
@endpush
