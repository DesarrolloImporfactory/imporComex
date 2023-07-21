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
                <p><b>COTIZADOR {{ $pais }} </b><span
                        class="badge rounded-pill text-bg-info">{{ $modalidad->modalidad }}</span></p>
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
                <form action="{{ route('contenedorCompleto.store') }}" method="post" id="formCreate">
                    @csrf
                    <input type="hidden" name="modalidad" value="{{ $modalidad->id }}">
                    <input type="hidden" name="pais" value="{{ $pais }}" id="">
                    <input type="hidden" name="origen" value="China" id="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}" id="">
                                <label for="">Tipo de carga</label>
                                <x-adminlte-select2 name="tipo_carga" id="tipo_carga">
                                    <option value="">Selecciona una opción....</option>
                                    <option value="GENERAL"{{ old('tipo_carga') == 'GENERAL' ? 'selected' : '' }}>CARGA
                                        GENERAR ( PLÁSTICOS - TEXTILES - ETC)</option>
                                    <option value="PELIGROSA"{{ old('tipo_carga') == 'PELIGROSA' ? 'selected' : '' }}>CARGA
                                        PELIGROSA (CONTIENE BATERIAS, LIQUIDOS O ES INFLAMABLE) </option>
                                </x-adminlte-select2>
                            </div>
                        </div>
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
                                <label for="">Terminos de negociación</label>
                                <x-adminlte-select2 name="termino" id="termino" enable-old-support>
                                    <option value="">Selecciona una opción....</option>
                                    @foreach ($puertosChina as $item)
                                        @if ($item->id == 1 || $item->id == 4)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
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
                                        <option value="{{ $item->id }}" cont_20="{{ $item->cont_20 }}"
                                            cont_40="{{ $item->cont_40 }}">{{ $item->puerto_salida }}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Tipo contenedor: </label>
                                <x-adminlte-select2 name="volumen" id="volumen" enable-old-support>
                                    <option value="">Selecciona el contenedor....</option>
                                </x-adminlte-select2>
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
                                    @foreach ($tarifarios as $item)
                                        <option value="{{ $item->id }}">{{ $item->destino }} -
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
        function asignar() {
            $("#volumen").html("");
            var cont_20 = $("#puerto_id option:selected").attr("cont_20");
            var cont_40 = $("#puerto_id option:selected").attr("cont_40");
            $("#volumen").append(`
                    <option value="${cont_20}">20´ - ${cont_20} </option>
                    <option value="${cont_40}">40´ - ${cont_40} </option>
            `);
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
                        <strong>Advertencia!</strong> El valor del peso bruto es igual o mayor a 4000kg y puede aplicar recargos.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `);
                }
            });
        });
    </script>
@stop
