@extends('adminlte::page')
@section('title', 'Especialistas')

@section('content_header')
<input type="hidden" name="id" id="id" value="{{ Auth::user()->id }}">
    <div class="row">
        <div class="col-md-4">
            <x-adminlte-small-box title="{{ $cotizaciones }}" text="COTIZACIONES" icon="fas fa-star" url="#"
                url-text="View details" id="cotizaciones" />
        </div>
        <div class="col-md-4">
            <x-adminlte-small-box title="{{ $cotizacionesAprobadas }}" text="COTIZACIONES APROBADAS" icon="fas fa-chart-bar"
                theme="info" url="#" url-text="More info" id="aprobadas" />
        </div>
        <div class="col-md-4">
            <x-adminlte-small-box title="{{ $cotizacionesPendientes }}" text="COTIZACIONES PENDIENTES"
                icon="fas fa-eye text-dark" theme="teal" url="#" url-text="View details" id="pendientes" />
        </div>
    </div>

@stop

@section('content')

    @if (Session::has('mensaje'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ Session::get('mensaje') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @include('admin.especialistas.table')
@stop
@push('js')
    <script>
        $(document).ready(function() {
            var id = $("#id").val();

            let sBox = new _AdminLTE_SmallBox('cotizaciones');
            let sBox2 = new _AdminLTE_SmallBox('aprobadas');
            let sBox3 = new _AdminLTE_SmallBox('pendientes');
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
                    url: "../../admin/dashboard/" + id,
                    method: "GET",
                    dataType: "json",
                }).done(function(res) {

                    var respuesta = res.cotizaciones;

                    let rep = respuesta;
                    let idx = respuesta < 10 ? 0 : (respuesta > 50 ? 2 : 1);
                    let text = 'COTIZACIONES;
                    let icon = 'fas fa-star' + ['text-dark', 'text-light', 'text-warning'][idx];

                    let data = {
                        text,
                        title: rep,
                        icon
                    };
                    sBox.update(data);
                });

            };
            let updateBox2 = () => {
                // Stop loading animation.
                sBox2.toggleLoading();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // Update data.
                $.ajax({
                    url: "../../admin/dashboard/" + id,
                    method: "GET",
                    dataType:"json",
                }).done(function(res) {

                    var respuesta = res.aprobadas;

                    let rep = respuesta;
                    let idx = respuesta < 10 ? 0 : (respuesta > 50 ? 2 : 1);
                    let text = 'COTIZACIONES APROBADAS';
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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // Update data.
                $.ajax({
                    url: "../../admin/dashboard/" + id,
                    method: "GET",
                    dataType: "json",
                }).done(function(res) {

                    var respuesta = res.pendientes;

                    let rep = respuesta;
                    let idx = respuesta < 10 ? 0 : (respuesta > 50 ? 2 : 1);
                    let text = 'COTIZACIONES PENDIENTES';
                    let data = {
                        text,
                        title: rep
                    };
                    sBox3.update(data);
                });

            };

            let startUpdateProcedure = () => {
                // Simulate loading procedure.
                sBox.toggleLoading();
                sBox2.toggleLoading();
                sBox3.toggleLoading();
                // Wait and update the data.
                setTimeout(updateBox, 2000);
                setTimeout(updateBox2, 2000);
                setTimeout(updateBox3, 2000);
            };

            setInterval(startUpdateProcedure, 10000);
        })
    </script>
@endpush
