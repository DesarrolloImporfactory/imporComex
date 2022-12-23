<div class="card-body">
    <div class="form-group">
        <label for="exampleInputEmail1">Nombre del Estado</label>
        <input type="text" class="form-control" name="name" placeholder="estado"
            value="{{ isset($estado->name) ? $estado->name : old('name') }}">
    </div>
    @error('name')
        <small style="color: red">{{ $message }}</small>
    @enderror
    
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-primary">Guardar</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
</div>
