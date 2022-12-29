@extends('adminlte::page')
@section('title', 'Especialistas')

@section('content_header')

    <div class="row">
        <div class="col-md-4">
            <x-adminlte-small-box title="{{ $cotizaciones }}" text="Total de Cotizaciones" icon="fas fa-star" url="#"
                url-text="View details" />
        </div>
        <div class="col-md-4">
            <x-adminlte-small-box title="{{ $cotizacionesAprobadas }}" text="Cotizaciones Aprobadas" icon="fas fa-chart-bar"
                theme="info" url="#" url-text="More info" />
        </div>
        <div class="col-md-4">
            <x-adminlte-small-box title="{{ $cotizacionesPendientes }}" text="Cotizaciones Pendientes"
                icon="fas fa-eye text-dark" theme="teal" url="#" url-text="View details" />
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <x-adminlte-small-box title="Downloads" text="1205" icon="fas fa-download text-white" theme="purple"
                url="#" url-text="View details" />
        </div>
        <div class="col-md-4">
            <x-adminlte-small-box title="{{ $cotizaciones }}" text="User Registrations" icon="fas fa-user-plus text-teal"
                theme="primary" url="#" url-text="View all users" />
        </div>
        <div class="col-md-4">
            <x-adminlte-small-box title="0" text="Reputation" icon="fas fa-medal text-dark" theme="danger"
                url="#" url-text="Reputation history" id="sbUpdatable" />
        </div>
    </div>
    {{-- Custom --}}
   
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

            let sBox = new _AdminLTE_SmallBox('sbUpdatable');

            let updateBox = () => {
                // Stop loading animation.
                sBox.toggleLoading();

                // Update data.
                let rep = Math.floor(1000 * Math.random());
                let idx = rep < 100 ? 0 : (rep > 500 ? 2 : 1);
                let text = 'Reputation - ' + ['Basic', 'Silver', 'Gold'][idx];
                let icon = 'fas fa-medal ' + ['text-primary', 'text-light', 'text-warning'][idx];
                let url = ['{{ route('admin.especialistas.count') }}'][idx];

                let data = {
                    text,
                    title: rep,
                    icon,
                    url
                };
                sBox.update(data);
            };

            let startUpdateProcedure = () => {
                // Simulate loading procedure.
                sBox.toggleLoading();

                // Wait and update the data.
                setTimeout(updateBox, 2000);
            };

            setInterval(startUpdateProcedure, 10000);
        })
    </script>
@endpush
