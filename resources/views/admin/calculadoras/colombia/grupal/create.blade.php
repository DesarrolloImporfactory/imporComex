@extends('adminlte::page')

@section('title', 'Calculadora colombia')

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
                <p><b>Cotizador {{ $paises->nombre_pais }}</b></p>
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
                <x-adminlte-button data-toggle="modal" data-target="#modalCustom" label="Agregar Cliente" theme="dark"
                    icon="fa-solid fa-user-plus" class="float-left" />
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

            <!-- /.card-header -->
            <x-adminlte-card title="Modalidad {{ $modalidad->modalidad }}" theme="dark">
                <form action="{{ route('admin.colombia.store') }}" method="post" id="formCreate">

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
                                    <input type="text" name="volumen" id="volumen" class="form-control decimal"
                                        value="{{ old('volumen') }}" placeholder="Ingresar en CBM, mas informacion"
                                        aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button title="Calculadora" class="btn btn-outline-secondary" type="button"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal"><i
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
                                <label for="">Peso bruto</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="peso"
                                        value="{{ old('peso') }}" placeholder="Ingresar un valor o N/A">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa-sharp fa-solid fa-k"></i><i
                                                class="fa-brands fa-google"></i></span>
                                    </div>
                                </div>
                                @error('peso')
                                    <small style="color: red">
                                        <p>En caso de no disponer ingresar N/A</p>
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
                                    placeholder="Dir. donde recibirás tu carga" value="{{ old('direccion') }}">
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
                                <x-adminlte-select2 name="ciudad_entrega">
                                    <option value="">Selecciona una opción....</option>
                                    <option value="Quito"{{ old('ciudad_entrega') == 'Quito' ? 'selected' : '' }}>Quito
                                    </option>
                                    <option value="Guayaquil"{{ old('ciudad_entrega') == 'Guayaquil' ? 'selected' : '' }}>
                                        Guayaquil</option>
                                    <option value="Cuenca"{{ old('ciudad_entrega') == 'Cuenca' ? 'selected' : '' }}>Cuenca
                                    </option>
                                    <option value="Ambato"{{ old('ciudad_entrega') == 'Ambato' ? 'selected' : '' }}>Ambato
                                    </option>
                                    <option value="Latacunga"{{ old('ciudad_entrega') == 'Latacunga' ? 'selected' : '' }}>
                                        Latacunga</option>
                                    <option value="Riobamba"{{ old('ciudad_entrega') == 'Riobamba' ? 'selected' : '' }}>
                                        Riobamba</option>
                                    <option value="Manabi"{{ old('ciudad_entrega') == 'Manabi' ? 'selected' : '' }}>Manabi
                                    </option>
                                    <option
                                        value="Esmeraldad"{{ old('ciudad_entrega') == 'Esmeraldad' ? 'selected' : '' }}>
                                        Esmeraldad</option>
                                    <option value="Machala"{{ old('ciudad_entrega') == 'Machala' ? 'selected' : '' }}>
                                        Machala</option>
                                </x-adminlte-select2>
                            </div>
                        </div>
                        <div class="col-md-4">
                            @can('admin.calculadoras.cliente')
                                <input type="hidden" value="si" name="existe">
                                <div class="form-group">
                                    <label for="">Seleccionar Cliente2: </label>
                                    <x-adminlte-select2 name="cliente" id="cliente">
                                        <option value="">Selecciona una opción....</option>
                                        @foreach ($clientes as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
                            @endcan

                        </div>
                    </div>
                </form>

                @include('admin.calculadoraCBM.calculadora')

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
