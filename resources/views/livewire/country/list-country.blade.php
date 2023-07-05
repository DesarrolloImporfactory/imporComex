<div>

    {{-- @csrf --}}
    {{-- <div class="row mt-2">
        <div class="col-md-4">
            <div class="form-group" wire:ignore>
                <label>Seleccionar tu tipo de carga:</label>
                <select class="selectpicker" id="tipo" name="modalidad" data-style="btn-primary"
                    title="Seleccionar una opción...">
                    <option value="1">FCL</option>
                    <option value="2">LCL</option>
                </select>
            </div>
            @error('tipo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-4">
            <div class="form-group" wire:ignore>
                <label>Filtrar país por región:</label>
                <select class="selectpicker" id="region" data-style="btn-primary" title="Seleccionar una opción...">
                    <option value="africa">África</option>
                    <option value="americas">Américas</option>
                    <option value="asia">Asia</option>
                    <option value="europe">Europa</option>
                    <option value="oceania">Oceanía</option>
                    <option value="polar">Polares</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-dark float-right mt-4"><i class="fa-solid fa-arrow-right"></i>
                EMPEZAR</button>
        </div>
    </div> --}}
    <br>
    <div class="row">
        <div class="row text-center mb-3">
            <h1><b>SELECCIONA TU PAÍS</b></h1>
        </div>
        @error('pais')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        @foreach ($countries as $index => $country)
            <div class="col-12 col-md-6 col-lg-6">
                <div class="p-4 bg-body-tertiary rounded-3 mt-4">
                    <form action="" wire:submit.prevent='create'>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <img style="height: 150px;" src="{{ $country['flags']['svg'] }}" alt="logo4"
                                        class="rounded-3">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center mt-3">
                                    <input type="text" name="pais" wire:model="pais.{{ $index }}">

                                    <div class="form-group" wire:ignore>
                                        <select class="selectpicker" id="tipo" name="modalidad" data-style=""
                                            title="Seleccionar una opción...">
                                            <option value="1">FCL</option>
                                            <option value="2">LCL</option>
                                        </select>
                                    </div>
                                    @error('tipo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <button type="submit" class="btn btn-dark mt-4"><i
                                            class="fa-solid fa-arrow-right"></i> EMPEZAR</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach


    </div>



    {{-- <style>
        .img-country {
            width: 200px !important;
            height: 100px;
        }
    </style> --}}
</div>
@push('js')
    <script>
        $(document).ready(function() {
            // $('#region').on('change', function(e) {
            //     @this.set('region', e.target.value);
            // });
            $('#tipo').on('change', function(e) {
                @this.set('tipo', e.target.value);
            });
        });
    </script>
@endpush
