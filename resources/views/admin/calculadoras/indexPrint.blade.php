@extends('adminlte::page')

@section('title', 'Imprimir')

@section('content_header')
    <x-adminlte-info-box title="NOTAS ADICIONALES" text="
    -Cotización no es válida para carga peligrosa o perecedera, ni para carga Bonded.
    -Es válida para carga General, apilable y correctamente embalada. Casos EUR1, originales entregamos al SHIPPER.
    -Cotización NO incluye el seguro de la mercadería. Favor enviarnos el valor CFR de la carga para proceder con la cotización respectiva.
    -Muy importante notar que la Aduana Ecuatoriana se reserva el derecho de aplicar o no las partidas enviadas por los clientes/ agentes.

    " icon="fas fa-lg fa-eye text-dark" theme="gradient-teal" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-6 ">

            <div class="form-row">
                <div class="col-md-12 text-center">
                    <a href="{{ route('ticket.pdf', $cotizacion->id) }}">
                        <x-adminlte-button style="width: 100%;" class="btn-flat" label="Imprimir Ticket" theme="success"
                            icon="fas fa-lg fa-save" />
                    </a>
                </div>
            </div>
            <br>
            @include('components.ticket')
        </div>
        <div class="col-md-6 ">

            <div class="form-row">
                <div class="col-md-12 text-center">
                    <a href="{{ route('cotizacion.pdf', $cotizacion->id) }}">
                        <x-adminlte-button style="width: 100%;" class="btn-flat" label="Imprimir Ticket" theme="success"
                            icon="fas fa-lg fa-save" />
                    </a>
                </div>
            </div>
            <br>
            @include('components.cotizacion')
        </div>


    </div><br>
@stop
