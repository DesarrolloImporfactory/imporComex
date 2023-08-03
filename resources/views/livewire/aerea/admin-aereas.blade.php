<div>
    @section('title', 'Cotizador')
    <div class="content-header">
        <div class="card border-light mt-3">
            <div class="card-header">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row ">
                            <div class="col-sm-6">
                                <h3 class="m-0"><i class="fa-solid fa-plane-departure"></i> <b> COTIZADOR AÉREO</b>
                                </h3>
                            </div>
                            <div class="col-sm-6">
                                <button wire:loading.attr='disabled' type="submit" form="cotizador"
                                    class="btn btn-dark float-right">Siguiente <i
                                        class="fa-solid fa-angles-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            @error('costo_envio')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="label border p-2 bg-dark text-light rounded mb-2"><i
                                    class="fa-solid fa-circle-info"></i> INFORMACIÓN GENERAL</div>
                            <div class="ml-2 mr-2">
                                <form wire:submit.prevent='create' action="" id="cotizador">
                                    <div class="row">
                                        <input type="hidden" wire:model='costo_envio'>
                                        <div class="col-md-4">
                                            <div wire:ignore class="form-group">
                                                <p for="">TIPO DE CARGA:</p>
                                                <select class="my-select" data-width="100%" id="carga"
                                                    title="Seleccionar..">
                                                    <option value="GENERAL" data-subtext="PLÁSTICOS - TEXTILES - ETC">
                                                        CARGA GENERAL</option>
                                                    <option value="PELIGROSA"
                                                        data-subtext="CONTIENE BATERIAS, LIQUIDOS O ES INFLAMABLE">
                                                        CARGA
                                                    </option>
                                                </select>
                                            </div>
                                            @error('carga')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <div wire:ignore class="form-group">
                                                <p for="">CANTIDAD DE PROVEEDORES:</p>
                                                <select class="my-select" data-width="100%" id="proveedor"
                                                    title="Seleccionar..">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                            @error('proveedor')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            @can('admin.calculadoras.cliente')
                                                <div wire:ignore class="form-group">
                                                    <p for="">SELECCIONAR CLIENTE: </p>
                                                    <select class="my-select" data-width="100%" title="Seleccionar.."
                                                        id="cliente" data-live-search="true">
                                                        @foreach ($clientes as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('cliente')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            @endcan
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form wire:submit.prevent='calcular' action="">
                        <div class="row">

                            <div class="col">
                                <div class="form-group">
                                    <p>Cartones: </p>
                                    <input type="number"
                                        class="form-control form-control-sm @error('cartones') is-invalid @enderror"
                                        wire:model='cartones'>
                                    @error('cartones')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <p>Largo: </p>
                                    <input type="text" id='numero'
                                        class="form-control form-control-sm @error('largo') is-invalid @enderror"
                                        wire:model='largo'>
                                    @error('largo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <p>Alto: </p>
                                    <input type="text" id='numero'
                                        class="form-control form-control-sm @error('alto') is-invalid @enderror"
                                        wire:model='alto'>
                                    @error('alto')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <p>Ancho: </p>
                                    <input type="text" id='numero'
                                        class="form-control form-control-sm @error('ancho') is-invalid @enderror"
                                        wire:model='ancho'>
                                    @error('ancho')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <p>Peso bruto: </p>
                                    <input type="text" id='numero'
                                        class="form-control form-control-sm @error('peso_bruto_carton') is-invalid @enderror"
                                        placeholder="peso bruto por carton" wire:model='peso_bruto_carton'>
                                    @error('peso_bruto_carton')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col mt-3">
                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-primary float-right btn-sm rounded-circle mt-4 "><i
                                            class="fa-solid fa-plus"></i></button>
                                </div>
                            </div>

                        </div>
                    </form>
                    <hr>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="">
                                <tr>
                                    <th>CARTONES</th>
                                    <th>LARGO</th>
                                    <th>ANCHO</th>
                                    <th>ALTO</th>
                                    <th>P.V POR PIEZA</th>
                                    <th class="table-light">P.V TOTAL</th>
                                    <th>P.B POR CARTON</th>
                                    <th class="table-light">P.B TOTAL PIEZA</th>
                                    <th>TOTAL</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($calculos->count())
                                    @foreach ($calculos as $item)
                                        <tr>
                                            <td>{{ $item->cartones }}</td>
                                            <td>{{ $item->largo }}</td>
                                            <td>{{ $item->ancho }}</td>
                                            <td>{{ $item->alto }}</td>
                                            <td>{{ $item->peso_volumetrico_pieza }} Kgs</td>
                                            <td class="table-light">{{ $item->peso_volumetrico_total }} Kgs</td>
                                            <td>{{ $item->peso_bruto_carton }} Kgs</td>
                                            <td class="table-light">{{ $item->peso_bruto_piezas }} Kgs</td>
                                            <td>{{ $item->total }} Kgs</td>
                                            <td><a class="" title="eliminar" type="button"
                                                    wire:click="$emit('deleteRegistro',{{ $item->id }})"><i
                                                        class="fa-regular fa-trash-can text-danger"></i></a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>..</td>
                                        <td>..</td>
                                        <td>..</td>
                                        <td>..</td>
                                        <td>..</td>
                                        <td>..</td>
                                        <td>..</td>
                                        <td>..</td>
                                        <td>..</td>
                                        <td>..</td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>PESO FINAL ENVÍO:</th>
                                    <th>{{ $total }} Kgs</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="label border p-2 bg-dark text-light rounded mb-2"><i
                            class="fa-solid fa-file-invoice-dollar"></i> Costos Aproximados del Envío</div>
                    <div class="row">
                        <div class=" table-responsive col-md-12">
                            @if ($total > 0)
                                <table class="table-sm table table-bordered text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>TASA AEROLINEA</th>
                                            <th>FLETE AEREO</th>
                                            <th>AWB FEE</th>
                                            <th>HANDLE FEE</th>
                                            <th>COSTO APROXIMADO ENVIO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>${{ number_format($tasa->valor, 2) }} USD</td>
                                            <td>${{ $flete_aereo }} USD</td>
                                            <td><button type="button" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="GESTION GUIA AEREA">
                                                ${{ $awb }} USD
                                            </button></td>
                                            <td><button type="button" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="MANEJO DE LA CARGA">
                                                ${{ $handle }} USD
                                            </button></td>
                                            <td>${{ $costo_envio }} USD</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@push('js')
    <script>
        $('#numero').on('input', function() {
            this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
        });
        Livewire.on('deleteRegistro', idRegistro => {
            Swal.fire({
                title: 'Esta seguro de eliminar?',
                text: "No habra forma de revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminalo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('aerea.admin-aereas', 'delete', idRegistro);
                }
            })
        })
        $(document).ready(function() {
            $('.my-select').selectpicker();
            $('#carga').on('change', function(e) {
                @this.set('carga', e.target.value);
            });
            $('#proveedor').on('change', function(e) {
                @this.set('proveedor', e.target.value);
            });
            $('#cliente').on('change', function(e) {
                @this.set('cliente', e.target.value);
            });
        });
    </script>
@endpush
