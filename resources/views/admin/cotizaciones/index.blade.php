@extends('adminlte::page')
@section('title', 'Cotizaciones')

@section('content_header')
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
    <input type="hidden" id="id_user" value="{{ Auth::user()->id }}">
    <div class="row">
        <div class="col-md-4">
            <x-adminlte-small-box title="Cotizaciones" text="total : {{ $cotizaciones }}" icon="fas fa-coins " theme="danger"
                url="#" url-text="Reputation history" id="sbUpdatable" />
        </div>
        <div class="col-md-4">
            <x-adminlte-small-box title="Aprobadas" text="total : {{ $aprobadas }}" icon="fas fa-face-smile "
                theme="primary" url="{{ route('admin.cotizaciones.aprobadas', Auth::user()->id) }}" url-text="Ver detalles"
                id="aprobadas" />
        </div>
        <div class="col-md-4">
            <x-adminlte-small-box title="Pendientes" text="total : {{ $pendientes }}" icon="fas fa-circle-exclamation"
                theme="warning" url="#" url-text="Reputation history" id="pendientes" />
        </div>

    @stop

    @section('content')
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                        Cotizaciones
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        @include('admin.cotizaciones.table')
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Cotizaciones Individuales
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        @include('admin.cotizaciones.individual')
                    </div>
                </div>
            </div>

        </div>



    @stop

    @push('js')
        <script>
            $(document).ready(function() {
                var id = $("#id_user").val();
                let sBox1 = new _AdminLTE_SmallBox('sbUpdatable');

                let updateBox1 = () => {
                    // Stop loading animation.
                    sBox1.toggleLoading();
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

                        let rep = 'Cotizaciones';
                        let idx = respuesta < 10 ? 0 : (respuesta > 50 ? 2 : 1);
                        let text = 'total : ' + respuesta + ' - ' + ['Bajo', 'Medio', 'Alto'][idx];
                        let icon = 'fas fa-coins ' + ['text-dark', 'text-light', 'text-warning'][idx];
                        //let url = ['url1', 'url2', 'url3'][idx];

                        let data = {
                            text,
                            title: rep,
                            icon
                        };
                        sBox1.update(data);
                    });

                };

                let startUpdateProcedure = () => {
                    // Simulate loading procedure.
                    sBox1.toggleLoading();
                    // Wait and update the data.
                    setTimeout(updateBox1, 2000);
                };
                setInterval(startUpdateProcedure, 10000);
            })
        </script>
    @endpush
    @push('js')
        <script>
            $(document).ready(function() {
                var id = $("#id_user").val();
                let sBox2 = new _AdminLTE_SmallBox('aprobadas');

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
                        dataType:"json"
                    }).done(function(res) {

                        var respuesta = res.aprobadas;

                        let rep = 'Aprobadas';
                        let idx = respuesta < 10 ? 0 : (respuesta > 50 ? 2 : 1);
                        let text = 'total : ' + respuesta + ' - ' + ['Bajo', 'Medio', 'Alto'][idx];
                        let icon = 'fas fa-face-smile ' + ['text-dark', 'text-light', 'text-warning'][idx];
                        //let url = ['url1', 'url2', 'url3'][idx];

                        let data = {
                            text,
                            title: rep,
                            icon
                        };
                        sBox2.update(data);
                    });

                };

                let startUpdateProcedure = () => {
                    // Simulate loading procedure.
                    sBox2.toggleLoading();
                    // Wait and update the data.
                    setTimeout(updateBox2, 2000);
                };
                setInterval(startUpdateProcedure, 10000);
            })
        </script>
    @endpush

    @push('js')
        <script>
            $(document).ready(function() {
                var id = $("#id_user").val();
                let sBox3 = new _AdminLTE_SmallBox('pendientes');

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
                        dataType:"json",
                    }).done(function(res) {

                        var respuesta = res.pendientes;

                        let rep = 'Pendientes';
                        let idx = respuesta < 10 ? 0 : (respuesta > 50 ? 2 : 1);
                        let text = 'total : ' + respuesta + ' - ' + ['Bajo', 'Medio', 'Alto'][idx];
                        let icon = 'fas fa-triangle-exclamation' + ['text-dark', 'text-light',
                            'text-warning'
                        ][idx];

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
                    sBox3.toggleLoading();
                    // Wait and update the data.
                    setTimeout(updateBox3, 2000);
                };
                setInterval(startUpdateProcedure, 10000);
            })
        </script>
    @endpush
