@extends('adminlte::page')

@section('title', 'Calculadora Aerea')

@section('content_header')
@stop

@section('content')
    <div class="content-header">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card border-light mt-3">
                    <div class="card-header">
                        <div class="content-header">
                            <div class="container-fluid">
                                <div class="row ">
                                    <div class="col-sm-6">
                                        <h3 class="m-0"><i class="fa-solid fa-plane-departure"></i> <b> COTIZADOR
                                                AÉREO</b>
                                        </h3>
                                    </div>
                                    <div class="col-sm-6">
                                        <ul class="nav justify-content-end">
                                            <li class="nav-item">
                                                <a class="nav-link " aria-current="page" href="{{ route('edit.aerea', $cotizacion->id) }}">Formulario</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link active" href="{{ url('cotizacion/aerea/'. $cotizacion->id) }}" aria-disabled="true">Información </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link disabled" aria-disabled="true">Cotización </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-header">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="label border p-2 bg-dark text-light rounded mb-2"><i
                                            class="fa-solid fa-circle-info"></i> INFORMACIÓN GENERAL</div>
                                    <div class="ml-2 mr-2">
                                        <h5>FLETE AEREO: <span class="float-end">${{ $cotizacion->flete }} USD</span></h5>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="ml-2 mr-2">
                                        <h5>TRAMITE NACIONALIZACION Y ENVIO: <span class="float-end">$100 USD</span></h5>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="ml-2 mr-2">
                                        <h5>TOTAL LOGISTICA: <span
                                                class="float-end">${{ $cotizacion->total_logistica }} USD</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <a href="{{ route('admin.colombia.edit', $cotizacion->id) }}" class="btn btn-dark float-right"><i
                                class="fa-solid fa-arrow-right"></i> Simular costeo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
@stop
