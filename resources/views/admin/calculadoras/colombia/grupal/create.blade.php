@extends('adminlte::page')

@section('title', 'Cotizador')

@section('content_header')

    @if (Session::has('mensaje'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ Session::get('mensaje') }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center ">
            <div>
                <p><b>COTIZADOR {{ $paises->nombre_pais }} </b><span class="badge rounded-pill text-bg-warning">{{ $modalidad->modalidad }}</span></p>
                <p>1 de 4 <strong> Completado</strong></p>
            </div>
            <x-adminlte-progress theme="secondary" value=25 animated with-label />
        </div>
        <div class="col-md-3"></div>
    </div>

@stop

@section('content')

    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            @can('admin.calculadoras.cliente')
                @include('admin.calculadoras.colombia.grupal.createUser')
            @endcan

            <x-adminlte-button label="Siguiente" theme="dark" icon="fa-solid fa-arrow-right" class="float-right"
                type="sumbit" form="formCreate" />
        </div>
        <div class="col-md-1"></div>
    </div><br>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="" id="alerta" role="alert">

            </div>
            <!-- /.card-header -->
            <x-adminlte-card title="{{ $modalidad->descripcion }}" theme="dark">
                @if ($modalidad->modalidad == 'LCL')
                    <form action="{{ route('cargaSuelta.store') }}" method="post" id="formCreate">
                    @else
                        <form action="{{ route('admin.colombia.store') }}" method="post" id="formCreate">
                @endif

                @csrf
                <input type="hidden" name="modalidad" value="{{ $modalidad->id }}">
                <input type="hidden" name="pais" value="{{ $paises->id }}" id="">
                <input type="hidden" name="origen" value="China" id="">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}" id="">
                            <label for="">¿Es inflamable?</label>
                            <x-adminlte-select2 name="inflamable" id="inflamable" onchange="accion3()">
                                <option value="">Selecciona una opción....</option>
                                <option value="si"{{ old('inflamable') == 'si' ? 'selected' : '' }}>Si</option>
                                <option value="no"{{ old('inflamable') == 'no' ? 'selected' : '' }}>No</option>
                            </x-adminlte-select2>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">¿Tiene bateria?</label>
                            <x-adminlte-select2 name="tiene_bateria" id="bateria" onchange="accion2()">
                                <option value="">Selecciona una opción....</option>
                                <option value="si"{{ old('tiene_bateria') == 'si' ? 'selected' : '' }}>Si</option>
                                <option value="no"{{ old('tiene_bateria') == 'no' ? 'selected' : '' }}>No</option>
                            </x-adminlte-select2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" id="divLiquido">
                            <label for="">¿Tiene liquidos?</label>
                            <x-adminlte-select2 name="liquidos" id="liquidos" onchange="accion1()" class="liquidos">
                                <option value="">Selecciona una opción....</option>
                                <option value="si"{{ old('liquidos') == 'si' ? 'selected' : '' }}>Si</option>
                                <option value="no"{{ old('liquidos') == 'no' ? 'selected' : '' }}>No</option>
                            </x-adminlte-select2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="form-group">
                                <label for="">Cantidad de proveedores: </label>
                                <input type="hidden" name="cargas_id" id="" value="1">
                                <x-adminlte-select2 name="cantidad_proveedores" enable-old-support>
                                    <option value="">Selecciona una opción....</option>
                                    <option value="1"{{ old('cantidad_proveedores') == '1' ? 'selected' : '' }}>1
                                    </option>
                                    <option value="2"{{ old('cantidad_proveedores') == '2' ? 'selected' : '' }}>2
                                    </option>
                                    <option value="3"{{ old('cantidad_proveedores') == '3' ? 'selected' : '' }}>3
                                    </option>
                                    <option value="4"{{ old('cantidad_proveedores') == '4' ? 'selected' : '' }}>4
                                    </option>
                                    <option value="5"{{ old('cantidad_proveedores') == '5' ? 'selected' : '' }}>5
                                    </option>
                                </x-adminlte-select2>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Dimensiones/Volumen</label>
                            <div class="input-group mb-3">
                                <input type="text" name="volumen" id="volumen"
                                    class="form-control decimal @error('volumen') is-invalid @enderror"
                                    value="{{ old('volumen') }}" placeholder="Ingresar en CBM, mas informacion"
                                    aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button title="Calculadora" class="btn btn-outline-secondary" type="button"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                            class="fa-solid fa-calculator"></i></button>
                                </div>
                            </div>
                            @error('volumen')
                                <small style="color:#d80e22ed">
                                    <b>{{ $message }}</b>
                                </small>
                            @enderror
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Peso bruto</label>
                            <div class="input-group">
                                <input type="text" id="peso"
                                    class="form-control @error('peso') is-invalid @enderror" name="peso"
                                    value="{{ old('peso') }}" placeholder="Ingresar un valor o N/A">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa-sharp fa-solid fa-k"></i><i
                                            class="fa-brands fa-google"></i></span>
                                </div>
                            </div>
                            @error('peso')
                                <small style="color: #d80e22ed">
                                    <p>En caso de no disponer ingresar N/A</p>
                                    <b>{{ $message }}</b>
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
                                class="form-control @error('direccion') is-invalid @enderror "
                                placeholder="Dir. donde recibirás tu carga" value="{{ old('direccion') }}">
                            @error('direccion')
                                <small style="color: #d80e22ed">
                                    <b> {{ $message }}</b>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Ciudad de entrega</label>
                            <x-adminlte-select2 name="ciudad_entrega" enable-old-support>
                                <option value="">Selecciona una opción....</option>
                                @foreach ($ciudades as $item)
                                    <option value="{{ $item->id }}">{{ $item->provincia }} -
                                        {{ $item->canton }}</option>
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

                                </x-adminlte-select2>
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
                //setear un select
                $("#liquidos").val("").trigger("change");
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
                //setear un select
                $("#inflamable").val("").trigger("change");
            }
        }

        function accion2() {

            let valor = $("#bateria").val();

            if (valor == 'si') {
                Swal.fire({
                    title: '<strong><u>CARGA PELIGROSA</u></strong>',
                    icon: 'error',
                    html: 'Para cargas con bateria, necesitamos que solicites el certificado MSDS y lo adjunte en la cotizacion.',
                    showCloseButton: false,
                    showCancelButton: false,
                    focusConfirm: false,
                    confirmButtonText: '<i class="fa-solid fa-circle-exclamation"></i> OK!',
                    confirmButtonAriaLabel: 'Thumbs up, great!',
                    cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                    cancelButtonAriaLabel: 'Thumbs down'
                })
                //setear un select
                // $("#bateria").val("").trigger("change");
            }
        }

        $(document).ready(function() {
            $(document).on('keyup', '#peso', function(e) {
                e.preventDefault();
                var valor = $(this).val();
                $("#alerta").html("");
                $("#alerta").removeClass("alert alert-warning alert-dismissible fade show");
                if (valor >= 400) {
                    $("#alerta").addClass("alert alert-warning alert-dismissible fade show");
                    console.log(valor);
                    $("#alerta").append(`
                        <strong>Advertencia!</strong> El valor del peso bruto es igual o mayor a 400kg y puede aplicar recargos.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `);
                }
            });
        });
    </script>
@stop
