@extends('adminlte::page')

@section('title', 'Imprimir')

@section('content_header')


    <x-adminlte-small-box title="NOTAS ADICIONALES" text="Cotización no es válida para carga peligrosa o perecedera, ni para carga Bonded.
        -Es válida para carga General, apilable y correctamente embalada. Casos EUR1, originales entregamos al SHIPPER.
       " icon="fas fa-circle-exclamation text-dark" theme="teal" url="{{route('admin.cotizaciones.show',$cotizacion->usuario_id)}}" url-text="Ver mis cotizaciones" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-6 ">
            <a type="button" href="https://walink.co/e40e8e" class="btn btn-outline-success" style="width: 100%" target="_blank">Deseas que un experto te ayude a calcular tus inpuesto?</a>
            <x-adminlte-card title="Calculemos tus impuestos" theme="success" icon="fa-sharp fa-solid fa-coins">
                <form action="{{route('calcular.impuestos.update',$cotizacion->id)}}" method="post">
                    {{method_field('PATCH')}}
                    @csrf
                    <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}" id="">
                    @php
                        $i=1;
                    @endphp
                    @foreach ($impuesto as $item)
                    <div class="form-group">
                        <label for="my-input">{{$item->nombre}}</label>
                        <input type="hidden" name="impuesto{{$i}}" value="{{$item->id}}">
                        <input class="form-control" type="text" name="valor{{$i}}" >
                    </div>
                    <input class="form-control" type="hidden" name="signo" value="{{$item->signo}}">
                    <input type="hidden" name="estado[]" value="{{$i++}}" class="form-control">
                   
                    @endforeach
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </form>
            </x-adminlte-card>
        </div>
        <div class="col-md-6 ">

            <div class="form-row">
                <div class="col-md-12 text-center">
                    <a href="{{ route('cotizacion.pdf', $cotizacion->id) }}">
                        <x-adminlte-button style="width: 100%;" class="btn-flat" label="Imprimir Cotizacion" theme="success"
                            icon="fas fa-lg fa-save" />
                    </a>
                </div>
            </div>
            <br>
            @include('components.cotizacion')
        </div>


    </div><br>
@stop
