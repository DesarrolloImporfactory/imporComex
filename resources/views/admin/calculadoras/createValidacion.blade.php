<div class="card">
    <div class="card-body">
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">

                    <label for="">¿Tiene bateria?</label>
                    <x-adminlte-select2 name="bateria" value="{{ old('bateria') }}">
                        <option value="">Selecciona una opción....</option>
                        <option value="si">Si</option>
                        <option value="no">No</option>
                    </x-adminlte-select2>
                </div>
                <div class="form-group">
                    <label for="">¿Es inflamable?</label>
                    <x-adminlte-select2 name="inflamable" value="{{ old('inflamable') }}">
                        <option value="">Selecciona una opción....</option>
                        <option value="si">Si</option>
                        <option value="no">No</option>
                    </x-adminlte-select2>
                    
                </div> 

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">¿Tiene liquidos?</label>
                    <x-adminlte-select2 name="liquidos" value="{{ old('liquidos') }}">
                        <option value="">Selecciona una opción....</option>
                        <option value="si">Si</option>
                        <option value="no">No</option>
                    </x-adminlte-select2>
                   
                </div>
                <div class="form-group">
                    <label for="">¿Cuantos proveedores tiene?</label>
                    <x-adminlte-select2 name="proveedores" id="numero" onchange="ejecutar()" class="form-control" value="{{ old('proveedores') }}">
                        <option value="">Selecciona una opción....</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </x-adminlte-select2>
                    {{-- <input type="number" class="form-control add-btn " id="numero" onkeyup="ejecutar()" name="proveedores"
                        placeholder="Cantidad" value="{{ old('proveedores') }}"> --}}
                    
                </div>
                
            </div>
            <div class="form-group">
                <label for="">Enlace</label>
                <input type="text" class="form-control" name="enlace" placeholder="www.imporcomex.com"
                    value="{{ old('enlace') }}">
                @error('enlace')
                    <small style="color:red">{{ $message }}</small>
                @enderror
            </div>
            {{-- div para los inputs dinamicos --}}
            <div class="newData"></div>

            {{-- div para los inputs dinamicos --}}
        </div>
    </div>
</div>

<script type="text/javascript">
    function ejecutar(valor) {
        
        var i = 1;
        valor = $("#numero").val();
        var stop=valor;
        for (let step = 0; step < stop; step++) {
            
            $('.newData').append('<div id="newRow'+i+'" class="form-row">'
            +'<div class="col-md-6">'
              +'<label style="color:red">Foto del producto '+i+'</label>'
              +'<input type="file" name="foto'+i+'"  class="form-control">'
            +'</div>'
            +'<div class="col-md-6">'
              +'<label style="color:red">Subir factura '+i+'</label>'
              +'<input type="file" name="factura'+i+'" class="form-control">'
              +'<input type="hidden" name="estado[]" value="'+i+'" class="form-control">'
            +'</div>'
            +'</div>'
          ); 
          i++; 
        }
    }
</script>
