@extends('adminlte::page')

@section('title', 'Cauculadoras')

@section('content_header')
    <div class="text-center">
        <br>
        <h1><b>SELECCIONA TU PAÍS</b></h1>
    </div>

@stop

@section('content')
    <br><br>


    <div class="row ">
        @foreach ($paises as $pais)
            @if ($pais->nombre_pais == 'ECUADOR')
                <div class="col-md-4 ">

                    <div class="card text-center" style="border-radius: 20px;" width="150px">

                        <div class="card-body">
                            {{-- <h5>{{ $pais->nombre_pais }}</h5> --}}
                            <img src="../assets/imporcomexImage/ecuador.jpg" width="150px" alt=""
                                style="border-radius: 20px;">

                        </div>

                        <div>
                            <form action="{{ route('admin.colombia.create') }}">

                                @csrf
                                <input type="hidden" name="pais" id="" value="{{ $pais->id }}">
                                <select class="selectpicker show-tick" data-width="75%" name="modalidad"
                                    title="SELECCIONA TU TIPO DE CARGA" required>

                                    <option value="1">FCL</option>
                                    <option value="3">GRUPAL</option>
                                    <option value="2">LCL</option>
                                </select><br><br>
                                <button type="submit" class="btn btn-dark"><b>INGRESAR</b></button>
                            </form>
                        </div><br>

                    </div>

                </div>
            @endif
            @if ($pais->nombre_pais == 'COLOMBIA')
                <div class="col-md-4 centro">
                    <div class="card text-center " style="border-radius: 20px;">
                        <div class="card-body">
                            {{-- <h5 class="">{{ $pais->nombre_pais }}</h5> --}}
                            <img src="../assets/imporcomexImage/colombia.jpg" width="155px" alt=""
                                style="border-radius: 20px;">

                        </div>
                        <div>
                            <form action="{{ route('admin.colombia.create') }}">

                                @csrf
                                <input type="hidden" name="pais" id="" value="{{ $pais->id }}">
                                <select class="selectpicker show-tick" data-width="75%" name="modalidad"
                                    title="SELECCIONA TU TIPO DE CARGA" required>
                                    <option value="1">FCL</option>
                                    <option value="3">GRUPAL</option>
                                    <option value="2">LCL</option>
                                </select><br><br>
                                <button type="submit" class="btn btn-dark"><b>INGRESAR</b></button>
                            </form>
                        </div><br>

                    </div>
                </div>
            @endif
            @if ($pais->nombre_pais == 'ESTADOS UNIDOS DE AMERICA')
                <div class="col-md-4 centro">
                    <div class="card text-center " style="border-radius: 20px;">
                        <div class="card-body">
                            {{-- <h5 class="">{{ $pais->nombre_pais }}</h5> --}}
                            <img src="../assets/imporcomexImage/eeuu.jpg" width="150px" alt=""
                                style="border-radius: 20px;">

                        </div>
                        <div>
                            <form action="{{ route('admin.colombia.create') }}">

                                @csrf
                                <input type="hidden" name="pais" id="" value="{{ $pais->id }}">
                                <select class="selectpicker show-tick" data-width="75%" name="modalidad"
                                    title="SELECCIONA TU TIPO DE CARGA" required>
                                    <option value="1">FCL</option>
                                    <option value="3">GRUPAL</option>
                                    <option value="2">LCL</option>
                                </select><br><br>
                                <button type="submit" class="btn btn-dark"><b>INGRESAR</b></button>
                            </form>
                        </div><br>

                    </div>
                </div>
            @endif
        @endforeach

    </div><br><br><br><br><br><br><br><br>
<div class="row">
    <div class="col-md-12 text-center">
        <button class="btn btn-outline-dark">SI TU PAÍS NO ESTA EN LA LISTA SELECCIONA AQUÍ</button>
    </div>
</div>
@stop

@section('css')
    <style>
        .card {
            background: #E3E3E3 !important;
            position: relative !important;
            
        }
       
        
       
    </style>
@stop
