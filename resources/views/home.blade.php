@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $usuarios }}" text="Usuarios" icon="fas fa-users " theme="gradient-primary"
                url="#" url-text="Reputation history" id="sbUpdatable" />
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $cotizaciones }}" text="Cotizaciones" icon="fas fa-chart-bar" theme="warning"
                url="#" url-text="Reputation history" id="cotizaciones" />
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $pendientes }}" text="Pendientes" icon="fa-solid fa-circle-exclamation"
                theme="danger" url="#" url-text="Reputation history" id="pendientes" />
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="{{ $contenedores }}" text="Contenedores" icon="fa-brands fa-docker " theme="info"
                url="#" url-text="Reputation history" id="contenedores" />
        </div>
    </div>

@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <x-adminlte-card theme="" theme-mode="outline">
                <div id="chart"></div>
            </x-adminlte-card>
        </div>
        <div class="col-md-6">
            <x-adminlte-card theme="" theme-mode="outline">
                <div id="chart1"></div>
            </x-adminlte-card>
        </div>
    </div>
    <input type="hidden" name="id" id="id" value="{{ Auth::user()->id }}">

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@push('js')
    
    <script>
        Highcharts.chart('chart', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'Cotizaciones asignadas a especialistas'
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
                data: JSON.parse(`<?php echo $data; ?>`)
            }]
        });

        Highcharts.chart('chart1', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'Top 5, usuarios con más cotizaciones'
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
                data: JSON.parse(`<?php echo $data2; ?>`)
            }]
        });
    </script>

    <script>
        $(document).ready(function() {
            var id = $("#id").val();

            let sBox = new _AdminLTE_SmallBox('sbUpdatable');
            let sBox1 = new _AdminLTE_SmallBox('cotizaciones');
            let sBox2 = new _AdminLTE_SmallBox('pendientes');
            let sBox3 = new _AdminLTE_SmallBox('contenedores');

            let updateBox = () => {
                // Stop loading animation.
                sBox.toggleLoading();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // Update data.
                $.ajax({
                    type: "GET",
                    url: "admin/dashboard/" + id,
                    dataType: "json",
                    success: function(response) {
                        let rep = response.usuarios;
                        let idx = rep < 10 ? 0 : (rep > 50 ? 2 : 1);
                        let text = 'Usuarios';
                        let data = {
                            text,
                            title: rep
                        };
                        sBox.update(data);
                    }
                });


            };
            let updateBox1 = () => {
                // Stop loading animation.
                sBox1.toggleLoading();
                // Update data.
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "admin/dashboard/" + id,
                    method: "GET",
                    dataType: "json",
                }).done(function(res) {

                    let rep = res.cotizaciones;
                    let idx = rep < 10 ? 0 : (rep > 50 ? 2 : 1);
                    let text = 'Cotizaciones';
                    let data = {
                        text,
                        title: rep
                    };
                    sBox1.update(data);
                });

            };

            let updateBox2 = () => {
                // Stop loading animation.
                sBox2.toggleLoading();
                // Update data.
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "admin/dashboard/" + id,
                    method: "GET",
                    dataType: "json",
                }).done(function(res) {

                    let rep = res.pendientes;
                    let idx = rep < 10 ? 0 : (rep > 50 ? 2 : 1);
                    let text = 'Pendientes';
                    let data = {
                        text,
                        title: rep
                    };
                    sBox2.update(data);
                });

            };

            let updateBox3 = () => {
                // Stop loading animation.
                sBox3.toggleLoading();
                // Update data.
                $.ajax({
                    url: "admin/dashboard/" + id,
                    method: "GET",
                    dataType: "json",
                }).done(function(res) {

                    let rep = res.contenedores;
                    let idx = rep < 10 ? 0 : (rep > 50 ? 2 : 1);
                    let text = 'Contenedores';
                    let icon = 'fa-brands fa-docker ';
                    let data = {
                        text,
                        title: rep,
                        icon
                    };
                    sBox3.update(data);
                });

            };

            let startUpdateProcedure = () => {
                // Simulate loading procedure.
                sBox.toggleLoading();
                sBox1.toggleLoading();
                sBox2.toggleLoading();
                sBox3.toggleLoading();
                // Wait and update the data.
                setTimeout(updateBox, 2000);
                setTimeout(updateBox1, 2000);
                setTimeout(updateBox2, 2000);
                setTimeout(updateBox3, 2000);
            };

            setInterval(startUpdateProcedure, 10000);
        })
    </script>
@endpush
