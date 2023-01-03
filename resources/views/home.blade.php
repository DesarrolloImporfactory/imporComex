@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row">
        <div class="col-md-4">
            <x-adminlte-small-box title="0" text="Cantidad de paises" icon="fas fa-medal text-dark" theme="danger" url="#"
                url-text="Reputation history" id="sbUpdatable" />
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
    </div>
@stop

@section('content')
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

            let sBox = new _AdminLTE_SmallBox('sbUpdatable');

            let updateBox = () => {
                // Stop loading animation.
                sBox.toggleLoading();
                // Update data.
                $.ajax({
                    url: "{{ route('admin.dashboard.all') }}",
                    method: "POST",
                    data: $("#form").serialize()
                }).done(function(res) {

                    let rep = res;
                    let idx = rep < 10 ? 0 : (rep > 50 ? 2 : 1);
                    let text = 'Cantidad de paises - ' + ['Bajo', 'Medio', 'Alto'][idx];
                    let icon = 'fas fa-medal ' + ['text-primary', 'text-light', 'text-warning'][idx];
                    //let url = ['url1', 'url2', 'url3'][idx];

                    let data = {
                        text,
                        title: rep,
                        icon
                    };
                    sBox.update(data);
                });

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
