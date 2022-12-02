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
        <div class="col-md-6">
            <div class="card text-center">


                <div class="card-body">
                    <h5 class="">Ecuador</h5>
                    <img src="../assets/imporcomexImage/ecuador.jpg" width="150px" alt="">

                </div>

                <div>
                    <form action="{{ route('ecuador.calculadoras') }}">

                        @csrf
                        <select class="form-control select2 text-center" style="width: 50%;" name="modalidad" required>
                           
                            <option value="FCL">FCL</option>
                            <option value="GRUPAL">GRUPAL</option>
                            <option value="LCL">LCL</option>
                        </select><br>
                        <button type="submit" class="btn btn-warning"><b>INGRESAR</b></button>
                    </form>
                </div><br>


            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center ">
                <div class="card-body">
                    <h5 class="">Colombia</h5>
                    <img src="../assets/imporcomexImage/colombia.jpg" width="155px" alt="">

                </div>
                <div>
                    <form action="{{ route('admin.colombia.create') }}">

                        @csrf
                        <select class="form-control select2 " style="width: 50%;" name="modalidad" required>
                            
                            <option value="FCL">FCL</option>
                            <option value="GRUPAL">GRUPAL</option>
                            <option value="LCL">LCL</option>
                        </select><br>
                        <button type="submit" class="btn btn-warning"><b>INGRESAR</b></button>
                    </form>
                </div><br>

            </div>
        </div>


    </div>
    
@stop

@section('css')
<style>
    .card {
        background: #8A9695!important;
        position: relative!important;

    }

    .select2 {

        width: 100px;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: auto;
    }

    .content-wrapper {
        background-image: url('../assets/imporcomexImage/fondo-3.png') !important;
        height: 10px;
    }
</style>
@stop

@section('js')
   

@stop
