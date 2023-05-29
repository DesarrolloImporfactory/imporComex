@extends('adminlte::page')
@section('title', 'Tarifas')

@section('content_header')

@stop

@section('content')

    <div class="content-header">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="ciudades-tab" data-toggle="tab" href="#ciudades" role="tab"
                    aria-controls="ciudades" aria-selected="true">CIUDADES</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tarifas-tab" data-toggle="tab" href="#tarifas" role="tab"
                    aria-controls="tarifas" aria-selected="false">CIUDADES FCL</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="ciudades" role="tabpanel" aria-labelledby="ciudades-tab">
                <div class="row mt-3">
                    @include('admin.ciudades.edit')
                    <div class="row">
                        <div class="col-md-12">
                            @include('admin.ciudades.table')
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tarifas" role="tabpanel" aria-labelledby="tarifas-tab">
                <div class="row mt-3">
                    <div class="row">
                        <div class="col-md-12">
                            @include('admin.tarifas.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <style>
        .select2-container--open .select2-dropdown {
            z-index: 1070;
        }
    </style>
@stop
