@extends('adminlte::page')

@section('title', 'Calculadora colombia')

@section('content_header')

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center ">
            <div>
                <p><b>Cotizador {{ $datos->pais->nombre_pais }}</b></p>
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
            <x-adminlte-card title="Modalidad {{ $datos->modalidad->modalidad }}" theme="dark">
                <form action="{{ route('actualizar.paso1', $datos->id) }}" method="post" id="formCreate">
                    {{ method_field('PATCH') }}
                    @csrf
                    <input type="hidden" name="modalidad" value="{{ $datos->id }}">
                    <input type="hidden" name="pais" value="{{ $datos->id }}" id="">
                    <input type="hidden" name="origen" value="China" id="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}" id="">
                                <label for="">¿Es inflamable?</label>
                                <x-adminlte-select2 name="inflamable" id="inflamable" onchange="accion3()">
                                    <option value="">Selecciona una opción....</option>
                                    <option value="si"{{ $datos->inflamable == 'si' ? 'selected' : '' }}>Si</option>
                                    <option value="no"{{ $datos->inflamable == 'no' ? 'selected' : '' }}>No</option>
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">¿Tiene bateria?</label>
                                <x-adminlte-select2 name="tiene_bateria" id="bateria" onchange="accion2()">
                                    <option value="">Selecciona una opción....</option>
                                    <option value="si"{{ $datos->tiene_bateria == 'si' ? 'selected' : '' }}>Si</option>
                                    <option value="no"{{ $datos->tiene_bateria == 'no' ? 'selected' : '' }}>No</option>
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">¿Tiene liquidos?</label>
                                <x-adminlte-select2 name="liquidos" id="liquidos" onchange="accion1()" class="liquidos">
                                    <option value="">Selecciona una opción....</option>
                                    <option value="si"{{ $datos->liquidos == 'si' ? 'selected' : '' }}>Si</option>
                                    <option value="no"{{ $datos->liquidos == 'no' ? 'selected' : '' }}>No</option>
                                </x-adminlte-select2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Tipo de Carga</label>
                                <input type="hidden" name="cargas_id" id="" value="1">
                                <input type="text" class="form-control" value="General" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Dimensiones/Volumen</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="volumen" id="volumen" class="form-control decimal @error('volumen') is-invalid @enderror"
                                        value="{{ isset($datos->volumen) ? $datos->volumen : old('volumen') }}"
                                        placeholder="Ingresar en CBM, mas informacion" aria-label="Recipient's username"
                                        aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button title="Calculadora" class="btn btn-outline-secondary" type="button"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-calculator"></i></button>
                                    </div>
                                </div>
                                @error('volumen')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Peso bruto</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('peso') is-invalid @enderror" name="peso"
                                        value="{{ isset($datos->peso) ? $datos->peso : old('peso') }}">
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
                                <input type="text" name="direccion" id="" class="form-control @error('direccion') is-invalid @enderror"
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
                                <x-adminlte-select2 value="{{ old('ciudad_entrega') }}" name="ciudad_entrega" enable-old-support>
                                    @foreach ($ciudades as $item)
                                    <option value="{{$item->id}}">{{$item->nombre_provincia}} - {{$item->nombre_canton}}</option>
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
                                          <option value="{{$item->id}}"{{ $datos->usuario_id==$item->id ? 'selected' : '' }}>{{$item->name}}</option>
                                      @endforeach
                                    </x-adminlte-select2>
                                    {{-- @livewire('clientes-list') --}}
                                </div>
                            @endcan

                        </div>
                    </div>
                </form>

                @include('admin.calculadoraCBM.calculadoraPrueba')
            </x-adminlte-card>
        </div>
        {{-- $cotizaciones --}}
        <div class="col-md-1"></div>
    </div>
    <script>
        $('#volumen').on('input', function() {
            this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
        });
    </script>
    <script>
        function accion1(valor) {

            valor = $("#liquidos").val();
            if (valor == 'si') {
                Swal.fire({
                    title: '<strong><u>lo sentimos mucho</u></strong>',
                    icon: 'error',
                    html: 'En carga GRUPAL no se puede cargar este tipo de producto. Dirigete al siguiente enlace para realizar una cotizacion invidual:</b>  ' +
                        '<a href="{{ route('admin.individual.create') }}" >Cotizacion invididual</a> ',
                    showCloseButton: false,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonText: '<i class="fa fa-thumbs-up"></i> OK!',
                    confirmButtonAriaLabel: 'Thumbs up, great!',
                    cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                    cancelButtonAriaLabel: 'Thumbs down'
                })

                $('#liquidos').val($('#liquidos > option:first').val());
            }

        }

        function accion3() {

            let valor = $("#inflamable").val();

            if (valor == 'si') {
                Swal.fire({
                    title: '<strong><u>lo sentimos mucho</u></strong>',
                    icon: 'error',
                    html: 'En carga GRUPAL no se puede cargar este tipo de producto. Dirigete al siguiente enlace para realizar una cotizacion invidual:</b>  ' +
                        '<a href="{{ route('admin.individual.create') }}" >Cotizacion invididual</a> ',
                    showCloseButton: false,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonText: '<i class="fa fa-thumbs-up"></i> OK!',
                    confirmButtonAriaLabel: 'Thumbs up, great!',
                    cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                    cancelButtonAriaLabel: 'Thumbs down'
                })
                $('#inflamable').val($('#inflamable > option:first').val());
            }
        }

        function accion2() {

            let valor = $("#bateria").val();

            if (valor == 'si') {
                Swal.fire({
                    title: '<strong><u>lo sentimos mucho</u></strong>',
                    icon: 'error',
                    html: 'En carga GRUPAL no se puede cargar este tipo de producto. Dirigete al siguiente enlace para realizar una cotizacion invidual:</b>  ' +
                        '<a href="{{ route('admin.individual.create') }}" >Cotizacion invididual</a> ',
                    showCloseButton: false,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonText: '<i class="fa fa-thumbs-up"></i> OK!',
                    confirmButtonAriaLabel: 'Thumbs up, great!',
                    cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                    cancelButtonAriaLabel: 'Thumbs down'
                })
                $('#bateria').val($('#bateria > option:first').val());
            }
        }

    </script>
@stop
