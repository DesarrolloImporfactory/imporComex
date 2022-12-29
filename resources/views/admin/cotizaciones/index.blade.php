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
    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>Cotizaciones</h3>
                    <p>Total: </p>
                </div>
                <div class="icon">
                    <i class="fa-sharp fa-solid fa-coins"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Aprobadas</h3>
                    <p>Total: </p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-face-smile"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>Pendientes</h3>
                    <p>Total: </p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-face-frown"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    @stop

    @section('content')

        @include('admin.cotizaciones.table')

    @stop
