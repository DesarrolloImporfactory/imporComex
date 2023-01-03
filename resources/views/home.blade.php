@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row">
        <div class="col-md-3">
            <x-adminlte-small-box title="{{$usuarios}}" text="Usuarios" icon="fas fa-users " theme="gradient-primary"
                url="#" url-text="Reputation history" id="sbUpdatable" />
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="{{$cotizaciones}}" text="Cotizaciones" icon="fas fa-chart-bar" theme="warning"
                url="#" url-text="Reputation history" id="cotizaciones" />
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="{{$pendientes}}" text="Pendientes" icon="fa-solid fa-circle-exclamation" theme="danger"
                url="#" url-text="Reputation history" id="pendientes" />
        </div>
        <div class="col-md-3">
            <x-adminlte-small-box title="{{$contenedores}}" text="Contenedores" icon="fa-brands fa-docker " theme="success"
                url="#" url-text="Reputation history" id="contenedores" />
        </div>
    </div>

@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <x-adminlte-card theme="" theme-mode="outline">
                <canvas id="myChart"></canvas>
            </x-adminlte-card>

        </div>
        <div class="col-md-6">
            <x-adminlte-card theme="" theme-mode="outline">
                <canvas id="grafico2"></canvas>
            </x-adminlte-card>
        </div>
    </div>
    <form action="{{ route('admin.dashboard.all') }}" method="post" id="form">
        @csrf
        <input type="hidden" name="id" value="">
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@push('js')
    <script>
        $(document).ready(function() {
            var cData = JSON.parse(`<?php echo $data; ?>`);

            const ctx = document.getElementById('myChart');

            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: cData.label,
                    datasets: [{
                        label: 'Cantidad de Cargas por Experto',
                        data: cData.data,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

        $(document).ready(function() {
            var cData = JSON.parse(`<?php echo $data2; ?>`);

            const ctx = document.getElementById('grafico2');

            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: cData.label,
                    datasets: [{
                        label: 'Cantidad de Cargas por Pais',
                        data: cData.data,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

        $(document).ready(function() {

            let sBox = new _AdminLTE_SmallBox('sbUpdatable');
            let sBox1 = new _AdminLTE_SmallBox('cotizaciones');
            let sBox2 = new _AdminLTE_SmallBox('pendientes');
            let sBox3 = new _AdminLTE_SmallBox('contenedores');

            let updateBox = () => {
                // Stop loading animation.
                sBox.toggleLoading();
                // Update data.
                $.ajax({
                    url: "{{ route('admin.dashboard.totalCotizaciones') }}",
                    method: "POST",
                    data: $("#form").serialize()
                }).done(function(res) {

                    let rep = res.usuarios;
                    let idx = rep < 10 ? 0 : (rep > 50 ? 2 : 1);
                    let text = 'Usuarios' + [idx];
                    let data = {
                        text,
                        title: rep
                    };
                    sBox.update(data);
                });

            };
            let updateBox1 = () => {
                // Stop loading animation.
                sBox1.toggleLoading();
                // Update data.
                $.ajax({
                    url: "{{ route('admin.dashboard.totalCotizaciones') }}",
                    method: "POST",
                    data: $("#form").serialize()
                }).done(function(res) {

                    let rep = res.cotizaciones;
                    let idx = rep < 10 ? 0 : (rep > 50 ? 2 : 1);
                    let text = 'Cotizaciones' + [idx];
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
                $.ajax({
                    url: "{{ route('admin.dashboard.totalCotizaciones') }}",
                    method: "POST",
                    data: $("#form").serialize()
                }).done(function(res) {

                    let rep = res.pendientes;
                    let idx = rep < 10 ? 0 : (rep > 50 ? 2 : 1);
                    let text = 'Pendientes' + [idx];
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
                    url: "{{ route('admin.dashboard.totalCotizaciones') }}",
                    method: "POST",
                    data: $("#form").serialize()
                }).done(function(res) {

                    let rep = res.contenedores;
                    let idx = rep < 10 ? 0 : (rep > 50 ? 2 : 1);
                    let text = 'Contenedores' + [idx];
                    let icon = 'fas fa-users ' + [idx];
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
