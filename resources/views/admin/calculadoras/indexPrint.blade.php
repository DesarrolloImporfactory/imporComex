@extends('adminlte::page')

@section('title', 'Imprimir')

@section('content_header')

    <div>
        <x-adminlte-small-box title="NOTAS ADICIONALES" text="Cotización no es válida para carga peligrosa o perecedera, ni para carga Bonded.
                    -Es válida para carga General, apilable y correctamente embalada. Casos EUR1, originales entregamos al SHIPPER.
                   " icon="fas fa-circle-exclamation text-dark" theme="teal"
            url="{{ route('admin.cotizaciones.show', $cotizacion->usuario_id) }}" url-text="Ver mis cotizaciones" />
    </div>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <a href="https://walink.co/e40e8e" title="Deseas que un experto de ayude a calcular tus impuestos?" class="float"
        target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a>
    <style>
        .float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
        }

        .float:hover {
            text-decoration: none;
            color: #25d366;
            background-color: #fff;
        }

        .my-float {
            margin-top: 16px;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6 ">

            <x-adminlte-card title="Calculemos tus impuestos" theme="success" icon="fa-sharp fa-solid fa-coins">
                <form action="{{ route('calcular.impuestos.update', $cotizacion->id) }}" method="post">
                    {{ method_field('PATCH') }}
                    @csrf
                    <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}" id="">
                    @php
                        $i = 1;
                    @endphp
                    @if ($impuestoCotizacion == 'falso')
                        @foreach ($impuesto as $item)
                            <div class="form-group">
                                <label for="my-input">{{ $item->nombre }}</label>
                                <input type="hidden" name="impuesto{{ $i }}" value="{{ $item->id }}">
                                <input class="form-control" type="text" name="valor{{ $i }}">

                            </div>
                            <input class="form-control" type="hidden" name="signo" value="{{ $item->signo }}">
                            <input type="hidden" name="estado[]" value="{{ $i++ }}" class="form-control">
                        @endforeach
                    @else
                    @foreach ($impuestoCotizacion as $item)
                            <div class="form-group">
                                <label for="my-input">{{ $item->impuesto->nombre }}</label>
                                <input type="hidden" name="impuesto{{ $i }}" value="{{ $item->impuesto->id }}">
                                <input class="form-control" type="text" name="valor{{ $i }}" value="{{$item->valor}}">
                                
                            </div>
                            <input class="form-control" type="hidden" name="signo" value="{{ $item->impuesto->signo }}">
                            <input type="hidden" name="estado[]" value="{{ $i++ }}" class="form-control">
                        @endforeach
                    @endif



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
