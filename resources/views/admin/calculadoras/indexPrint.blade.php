@extends('adminlte::page')

@section('title', 'Imprimir')

@section('content_header')
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
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


