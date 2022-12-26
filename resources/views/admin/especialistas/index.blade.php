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
            <x-adminlte-small-box title="{{ $cotizaciones }}" text="User Registrations" icon="fas fa-user-plus text-teal" theme="primary"
                url="#" url-text="View all users" />
        </div>
        <div class="col-md-4">
            <x-adminlte-small-box title="{{ $cotizaciones }}" text="Reputation" icon="fas fa-medal text-Silver" theme="danger"
                url="#" url-text="Reputation history" id="sbUpdatable" />
        </div>
    </div>

@stop

@section('content')
    @include('admin.especialistas.table')
@stop

