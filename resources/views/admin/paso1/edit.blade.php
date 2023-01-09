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
                <form action="{{ route('actualizar.paso1',$datos->id) }}" method="post" id="formCreate">
                    {{method_field('PATCH')}}
                    @csrf
                    <input type="hidden" name="modalidad" value="{{ $datos->id }}">
                    <input type="hidden" name="pais" value="{{ $datos->id }}" id="">
                    <input type="hidden" name="origen" value="China" id="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}" id="">
                                <label>Nombre del Producto(s)</label>
                                <input type="text" name="producto" class="form-control" id="" autofocus
                                    value="{{ isset($datos->producto) ? $datos->producto : old('producto') }}">
                                @error('producto')
                                    <small style="color: red">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">¿Tiene bateria?</label>
                                <x-adminlte-select2 name="tiene_bateria" id="bateria" onchange="accion2()">
                                    <option value="">Selecciona una opción....</option>
                                    <option value="si"{{ $datos->tiene_bateria=="si" ? 'selected' : '' }}>Si</option>
                                    <option value="no"{{ $datos->tiene_bateria=="no" ? 'selected' : '' }}>No</option>
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Peso bruto</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="peso" value="{{ isset($datos->peso) ? $datos->peso : old('peso') }}">
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
                                <label for="">Tipo de Carga</label>
                                <input type="hidden" name="cargas_id" id="" value="1">
                                <input type="text" class="form-control" value="General" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Dimensiones/Volumen</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="volumen" id="" class="form-control" value="{{ isset($datos->volumen) ? $datos->volumen : old('volumen') }}"
                                        placeholder="Ingresar en CBM, mas informacion" aria-label="Recipient's username"
                                        aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="ejecutar()"><i
                                                class="fa-solid fa-question"></i></button>
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
                                <label for="">Precio total de compra</label>
                                <div class="input-group">
                                    <input type="float" name="precio_china" class="form-control" id=""
                                        value="{{ isset($datos->precio_china) ? $datos->precio_china : old('precio_china') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
                                    </div>
                                </div>
                                @error('precio_china')
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
                                <input type="text" name="direccion" id="" class="form-control "
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
                                <x-adminlte-select2 value="{{ old('ciudad_entrega') }}" name="ciudad_entrega">
                                    <option value="">Selecciona una opción....</option>
                                    <option value="Quito"{{ $datos->ciudad_entrega=="Quito" ? 'selected' : '' }}>Quito</option>
                                    <option value="Guayaquil"{{ $datos->ciudad_entrega=="Guayaquil" ? 'selected' : '' }}>Guayaquil</option>
                                    <option value="Cuenca"{{ $datos->ciudad_entrega=="Cuenca" ? 'selected' : '' }}>Cuenca</option>
                                    <option value="Ambato"{{ $datos->ciudad_entrega=="Ambato" ? 'selected' : '' }}>Ambato</option>
                                    <option value="Latacunga"{{ $datos->ciudad_entrega=="Latacunga" ? 'selected' : '' }}>Latacunga</option>
                                    <option value="Riobamba"{{ $datos->ciudad_entrega=="Riobamba" ? 'selected' : '' }}>Riobamba</option>
                                    <option value="Manabi"{{ $datos->ciudad_entrega=="Manabi" ? 'selected' : '' }}>Manabi</option>
                                    <option value="Esmeraldad"{{ $datos->ciudad_entrega=="Esmeraldad" ? 'selected' : '' }}>Esmeraldad</option>
                                    <option value="Machala"{{ $datos->ciudad_entrega=="sMachala" ? 'selected' : '' }}>Machala</option>
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                </form>


            </x-adminlte-card>
        </div>
        {{-- $cotizaciones --}}
        <div class="col-md-1"></div>
    </div>
    <script>
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
            }
        }

        function ejecutar() {
            Swal.fire({
                title: '<strong><u>Información</u></strong>',
                icon: 'info',
                text: 'La dimension total de tu carga debe ser en CBM(M3), si aun no la tienes ingresa al siguiente enlace:',
                html: 'La dimension total de tu carga debe ser en CBM(M3), si aun no la tienes ingresa al siguiente enlace:</b>  ' +
                    '<a href="https://imporcomexcorp.com/calculadora-cbm" target="_blank">www.imporcomexcorp.com/calculadora-cbm</a> ',
                showCloseButton: false,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> OK!',
                confirmButtonAriaLabel: 'Thumbs up, great!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                cancelButtonAriaLabel: 'Thumbs down'
            })
        }
    </script>
@stop
