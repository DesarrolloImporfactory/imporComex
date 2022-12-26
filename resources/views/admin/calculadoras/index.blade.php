@extends('adminlte::page')

@section('title', 'Cauculadoras')

@section('content_header')
    <div class="text-center">
        <br><br>
        <h1><b>SELECCIONA TU PAIS</b></h1>
    </div>

@stop

@section('content')
    <br><br>


    <div class="row">
        @foreach ($paises as $pais)
            @if ($pais->nombre_pais == 'ECUADOR')
                <div class="col-md-6">

                    <div class="card text-center">

                        <div class="card-body">
                            <h5>{{ $pais->nombre_pais }}</h5>
                            <img src="../assets/imporcomexImage/ecuador.jpg" width="150px" alt="">

                        </div>

                        <div>
                            <form action="{{ route('admin.colombia.create') }}">

                                @csrf
                                <input type="hidden" name="pais" id="" value="{{ $pais->id }}">
                                <select class="form-control select2 text-center" style="width: 50%;" name="modalidad"
                                    required>

                                    <option value="1">FCL</option>
                                    <option value="3">GRUPAL</option>
                                    <option value="2">LCL</option>
                                </select><br>
                                <button type="submit" class="btn btn-warning"><b>INGRESAR</b></button>
                            </form>
                        </div><br>

                    </div>

                </div>
            @endif
            @if ($pais->nombre_pais == 'COLOMBIA')
           
            <div class="col-md-6">
                <div class="card text-center ">
                    <div class="card-body">
                        <h5 class="">{{ $pais->nombre_pais }}</h5>
                        <img src="../assets/imporcomexImage/colombia.jpg" width="155px" alt="">

                    </div>
                    <div>
                        <form action="{{ route('admin.colombia.create') }}">

                            @csrf
                            <input type="hidden" name="pais" id="" value="{{ $pais->id }}">
                            <select class="form-control select2 text-center" style="width: 50%;" name="modalidad"
                                required>
                                <option value="1">FCL</option>
                                <option value="3">GRUPAL</option>
                                <option value="2">LCL</option>
                            </select><br>
                            <button type="submit" class="btn btn-warning"><b>INGRESAR</b></button>
                        </form>
                    </div><br>

                </div>
            </div>
                 
            @endif
        @endforeach

    </div>

@stop

@section('css')
    <style>
        .card {
            background: #8A9695 !important;
            position: relative !important;

        }

        .select2 {

            width: 100px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
        }

    </style>
@stop

