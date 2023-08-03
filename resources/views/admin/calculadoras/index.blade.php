@extends('adminlte::page')

@section('title', 'Cauculadoras')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="row text-center mb-3 mt-4">
                <h1 style="white-space: nowrap;"><b><i class="fa-solid fa-earth-americas"></i> SELECCIONA TU PAÍS</b></h1>
            </div>
            @foreach ($countries as $index => $country)
                <div class="col-6 col-md-4 col-lg-4">
                    <div class="p-4 bg-body-tertiary rounded-3 mt-4">
                        <form action="{{ route('admin.colombia.create') }}">

                            @csrf
                            <div class="container-fluid">
                                <div class="row">
                                    <span class="m-1 letter-spacing text-center" style="white-space: nowrap;">
                                        {{ $country['name']['common'] }}</span>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <img style="height: 150px;" src="{{ $country['flags']['svg'] }}" alt="logo4"
                                            class="rounded-3 {{ $country['name']['common'] == 'Peru' ? 'myImagen' : '' }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center mt-3">
                                        <input type="hidden" name="pais" value="{{ $country['name']['common'] }}">
                                        <div class="form-group">
                                            <select class="selectpicker" id="tipo" name="modalidad" data-style=""
                                                data-width="60%" title="SELECCIONA TU TIPO DE CARGA" required>
                                                @foreach ($modalidades as $item)
                                                    @if ($item->id != 3)
                                                        <option value="{{ $item->id }}" data-subtext="{{ $item->descripcion }}">
                                                            {{ $item->modalidad }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('tipo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <button type="submit" class="btn btn-dark mt-4"
                                            {{ $country['name']['common'] == 'Peru' ? 'disabled' : '' }}><i
                                                class="fa-solid fa-arrow-right"></i>
                                            {{ $country['name']['common'] == 'Peru' ? 'PROXIMAMENTE' : 'EMPEZAR' }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- @livewire('country.list-country') --}}
    </div>
@stop

@section('content')
    <div class="row mt-2">
        <div class="col-md-12 text-center mt-3 mb-3">
            <a class="btn btn-outline-dark mt-3" href="{{ route('admin.individual.create') }}" target="_blank">SI TU PAÍS
                NO
                ESTA EN LA LISTA SELECCIONA AQUÍ</a>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card {
            background: #E3E3E3 !important;
            position: relative !important;
        }

        .myImagen {
            filter: grayscale(100%);
        }

        .content-wrapper {
            min-height: 100vh;
            background-image: url({{ asset('imagenes/elemento-1.png') }}) !important;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
@stop
