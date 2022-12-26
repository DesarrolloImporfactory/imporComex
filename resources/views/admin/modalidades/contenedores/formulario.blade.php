<div class="card-body">
    <div class="form-group">
        <label for="exampleInputEmail1">Nombre del Contenedor</label>
        <input type="text" class="form-control" name="name" placeholder="Contenedor"
            value="{{ isset($contenedor->name) ? $contenedor->name : old('name') }}">
    </div>
    @error('name')
        <small style="color: red">{{ $message }}</small>
    @enderror
    <div class="form-group">
        <label for="exampleInputEmail1">Estado del Contenedor</label>
        <select name="estado_id" class="form-control">
            @foreach ($estados as $item)
                <option value="{{ $item->id }}">{{$item->name}}</option>
            @endforeach
        </select>
        
        {{-- <input type="text" class="form-control" name="estado" placeholder="Estado del contenedor"
            value="{{ isset($contenedor->estado) ? $contenedor->estado : old('estado') }}"> --}}
    </div>
    @error('estado')
        <small style="color: red">{{ $message }}</small>
    @enderror
    <div class="form-group">
        <label for="exampleInputEmail1">Fecha de Salida</label>
        <input type="date" class="form-control" name="salida" placeholder="salida"
            value="{{ isset($contenedor->salida) ? $contenedor->salida : old('salida') }}">
    </div>
    @error('salida')
        <small style="color: red">{{ $message }}</small>
    @enderror
    <div class="form-group">
        <label for="exampleInputEmail1">Fecha de Llegada</label>
        <input type="date" class="form-control" name="llegada" placeholder="llegada"
            value="{{ isset($contenedor->llegada) ? $contenedor->llegada : old('llegada') }}">
    </div>
    @error('llegada')
        <small style="color: red">{{ $message }}</small>
    @enderror
    <div class="form-group">
        <label for="exampleInputEmail1">Tipo de Contenedor</label>
        <input type="text" class="form-control" name="tipo" placeholder="Tipo de contenedor"
            value="{{ isset($contenedor->tipo) ? $contenedor->tipo : old('tipo') }}">
    </div>
    @error('tipo')
        <small style="color: red">{{ $message }}</small>
    @enderror
    <div class="form-group">
        <label for="exampleInputEmail1">Latitud</label>
        <input type="text" class="form-control" name="latitud" placeholder="ingrese la latitud"
            value="{{ isset($contenedor->latitud) ? $contenedor->latitud : old('latitud') }}">
    </div>
    @error('latitud')
        <small style="color: red">{{ $message }}</small>
    @enderror
    <div class="form-group">
        <label for="exampleInputEmail1">Longitud</label>
        <input type="text" class="form-control" name="longitud" placeholder="Ingrese la longitud"
            value="{{ isset($contenedor->longitud) ? $contenedor->longitud : old('longitud') }}">
    </div>
</div>
@error('longitud')
    <small style="color: red">{{ $message }}</small>
@enderror
<div class="card-footer">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
</div>
