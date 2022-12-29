@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <x-adminlte-info-box title="Gestion de:" text="Contenedores y cotizaciones" icon="fa-solid fa-list text-primary"
        theme="gradient-primary" icon-theme="white" />

@stop

@section('content')
    @include('admin.contenedores.table')
@stop
