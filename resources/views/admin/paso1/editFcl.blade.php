@extends('adminlte::page')

@section('title', 'Calculadora FCL')

@section('content_header')

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center ">
            <div>
                <p><b>COTIZADOR {{ $datos->pais }} </b><span
                        class="badge rounded-pill text-bg-warning">{{ $datos->modalidad->modalidad }}</span></p>
                <p>1 de 4 <strong> Completado</strong></p>
            </div>
            <x-adminlte-progress theme="secondary" value=25 animated with-label />
        </div>
        <div class="col-md-3"></div>
    </div>

@stop

@section('content')
    <div class="row">
        <div class="col-md-11">
            <x-adminlte-button label="Siguiente" theme="dark" icon="fa-solid fa-arrow-right" class="float-right"
                type="sumbit" form="formCreate" />
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <!-- /.card-header -->
            <x-adminlte-card title="{{ $datos->modalidad->descripcion }}" theme="dark">
                <form action="{{ route('actualizar.paso1', $datos->id) }}" method="post" id="formCreate">
                    {{ method_field('PATCH') }}
                    @csrf
                    <input type="hidden" name="modalidad" value="{{ $datos->modalidad_id }}">
                    <input type="hidden" name="pais" value="{{ $datos->pais }}" id="">
                    <input type="hidden" name="origen" value="China" id="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}" id="">
                                <label for="">Tipo de carga</label>
                                <x-adminlte-select2 name="tipo_carga" id="tipo_carga">
                                    <option value="">Selecciona una opción....</option>
                                    <option value="GENERAR"{{ $datos->tipo_carga == 'GENERAR' ? 'selected' : '' }}>CARGA
                                        GENERAR ( PLÁSTICOS - TEXTILES - ETC)</option>
                                    <option value="PELIGROSA"{{ $datos->tipo_carga == 'PELIGROSA' ? 'selected' : '' }}>CARGA
                                        PELIGROSA (CONTIENE BATERIAS, LIQUIDOS O ES INFLAMABLE) </option>
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="form-group">
                                    <label for="">Cantidad de proveedores: </label>
                                    <input type="hidden" name="cargas_id" id="" value="1">
                                    <input type="number" min="1"
                                        class="form-control @error('cantidad_proveedores') is-invalid @enderror"
                                        name="cantidad_proveedores"
                                        value="{{ isset($datos->cantidad_proveedores) ? $datos->cantidad_proveedores : old('cantidad_proveedores') }}">
                                    @error('cantidad_proveedores')
                                        <small style="color: #d80e22ed">
                                            <b> {{ $message }}</b>
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Terminos de negociación</label>
                                <x-adminlte-select2 name="termino" id="termino" enable-old-support>
                                    <option value="">Selecciona una opción....</option>
                                    @foreach ($puertosChina as $item)
                                        @if ($item->id == 1 || $item->id == 4)
                                            <option
                                                value="{{ $item->name }}"{{ $datos->termino == $item->name ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @else
                                            <option value="{{ $item->name }}" disabled>{{ $item->name }} -
                                                proximamente</option>
                                        @endif
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Puerto Salida: </label>
                                <x-adminlte-select2 name="puerto_id" id="puerto_id" onchange="asignar()" enable-old-support>
                                    <option value="">Selecciona el puerto....</option>
                                    @foreach ($puertos as $item)
                                        <option
                                            value="{{ $item->id }}"{{ $datos->puerto->id == $item->id ? 'selected' : '' }}
                                            cont_20="{{ $item->cont_20 }}" cont_40="{{ $item->cont_40 }}">
                                            {{ $item->puerto_salida }}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Tipo contenedor: {{ $datos->flete }}</label>
                                <x-adminlte-select2 name="volumen" id="volumen" enable-old-support>
                                    {{-- <option value="{{ $datos->flete_maritimo }}">{{ $datos->flete_maritimo }}
                                    </option> --}}
                                </x-adminlte-select2>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Peso bruto</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('peso') is-invalid @enderror"
                                        name="peso" value="{{ isset($datos->peso) ? $datos->peso : old('peso') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa-sharp fa-solid fa-k"></i><i
                                                class="fa-brands fa-google"></i></span>
                                    </div>
                                </div>
                                @error('peso')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Direccion de entrega</label>
                                <input type="text" name="direccion" id=""
                                    class="form-control @error('direccion') is-invalid @enderror"
                                    value="{{ isset($datos->direccion) ? $datos->direccion : old('direccion') }}">
                                @error('direccion')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Ciudad de entrega</label>
                                <x-adminlte-select2 value="{{ old('ciudad_entrega') }}" name="ciudad_entrega"
                                    enable-old-support>
                                    @foreach ($tarifarios as $item)
                                        <option
                                            value="{{ $item->id }}"{{ $datos->tarifa__id == $item->id ? 'selected' : '' }}>
                                            {{ $item->destino }} -
                                            {{ $item->transporte }}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            @can('admin.calculadoras.cliente')
                                <input type="hidden" value="si" name="existe">
                                <div class="form-group">
                                    <label for="">Seleccionar Cliente: </label>
                                    <x-adminlte-select2 name="cliente" id="cliente" enable-old-support>
                                        <option value="">Seleccione una opcion......</option>
                                        @foreach ($clientes as $item)
                                            <option
                                                value="{{ $item->id }}"{{ $datos->usuario_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                    {{-- @livewire('clientes-list') --}}
                                </div>
                            @endcan

                        </div>

                    </div>
                </form>
            </x-adminlte-card>
        </div>
        {{-- $cotizaciones --}}
        <div class="col-md-1"></div>
    </div>
    <script>
        $(document).ready(function() {
            let valor = {{ $datos->flete }};
            var cont_20 = $("#puerto_id option:selected").attr("cont_20");
            var cont_40 = $("#puerto_id option:selected").attr("cont_40");

            $("#volumen").append(`
                    <option value="${cont_20}">20´ - ${cont_20} </option>
                    <option value="${cont_40}">40´ - ${cont_40} </option>
            `);
            $("#volumen").val(valor);
        });

        function asignar() {
            $("#volumen").empty();
            var cont_20 = $("#puerto_id option:selected").attr("cont_20");
            var cont_40 = $("#puerto_id option:selected").attr("cont_40");
            $("#volumen").append(`
                    <option value="${cont_20}">20´ - ${cont_20} </option>
                    <option value="${cont_40}">40´ - ${cont_40} </option>
            `);
        }
    </script>
@stop
