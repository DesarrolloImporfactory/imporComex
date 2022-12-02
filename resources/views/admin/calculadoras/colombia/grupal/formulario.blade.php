@extends('adminlte::page')

@section('title', 'Calculadora colombia')

@section('content_header')

    <div class="row ">
        <div class="col-sm-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Cotizador Colombia modalidad Grupal, </strong> !Revise que todo este correcto.

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center ">
            <div>
                <p>PROGRESO DE TU IMPORTACION</p>
                <p>{{$cotizacion->proceso}} de 4 <strong> Completado</strong></p>
               
            </div>
            <x-adminlte-progress theme="secondary" value=25 animated with-label />
        </div>
        <div class="col-md-3">
        </div>
    </div>


@stop

@section('content')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form action="{{route('admin.colombia.update',$cotizacion->id)}}" method="post">
                {{method_field('PATCH')}}
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <x-adminlte-button label="Siguiente" theme="dark" icon="fa-solid fa-arrow-right" class="float-right" type="sumbit"/>
                    </div>
                </div><br>
                <x-adminlte-card title="Detalle de cotizacion" theme="dark">
                    <div class="input-group has-validation">
                        <span class="input-group-text"><b>Producto:</b></span>
                        <div class="form-floating is-invalid">
                            <input type="text" class="form-control " value="{{$cotizacion->producto}}" disabled>
                        </div>
                    </div><br>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><b>Peso:</b></span>
                        <div class="form-floating is-invalid">
                            <input type="text" class="form-control " value="{{$cotizacion->peso}}" disabled>
                        </div>
                    </div><br>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><b>Carga:</b></span>
                        <div class="form-floating is-invalid">
                            <input type="text" class="form-control " value="{{$cotizacion->cargas_id}}" disabled>
                        </div>
                    </div><br>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><b>Ciudad de entrega:</b></span>
                        <div class="form-floating is-invalid">
                            <input type="text" class="form-control " value="{{$cotizacion->ciudad_entrega}}" disabled>
                        </div>
                    </div><br>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><b>Cartones:</b></span>
                        <div class="form-floating is-invalid">
                            <input type="text" class="form-control " value="{{$cotizacion->total_cartones}}" disabled>
                        </div>
                    </div><br>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><b>Volumen:</b></span>
                        <div class="form-floating is-invalid">
                            <input type="text" class="form-control " value="{{$cotizacion->volumen}}" disabled>
                        </div>
                    </div><br>
                    <div class="input-group has-validation">
                        <span class="input-group-text"><b>Total:</b></span>
                        <div class="form-floating is-invalid">
                            <input type="text" class="form-control " value="{{$cotizacion->total}}" disabled>
                        </div>
                    </div>

                </x-adminlte-card>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
@stop
