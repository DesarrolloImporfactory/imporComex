<div>
  <div class="modal fade" id="exampleModal{{$idioma->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Registrar Idioma</h3>
          </div>
          <form action="{{url('/admin/idiomas/'.$idioma->id)}}" method="post" id="formulario">
              {{method_field('PATCH')}}
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Idioma</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el idioma" value="{{ isset($idioma->nombre)?$idioma->nombre:'' }}">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Codigo</label>
                  <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ingrese el codigo"  value="{{ isset($idioma->codigo)?$idioma->codigo:'' }}">
                </div>
              </div>
              <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Guardar</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>