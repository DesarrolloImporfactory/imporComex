<div>
  <div class="modal fade" id="exampleModal{{$modalidad->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Editar Modalidad</h3>
          </div>
          <form action="{{url('/admin/modalidades/'.$modalidad->id)}}" method="post" id="formulario">
              {{method_field('PATCH')}}
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nombre de la Modalidad</label>
                  <input type="hidden" name="tipo"  value="mo">
                  <input type="text" class="form-control" id="modalidad" name="modalidad" placeholder="Modalidad" value="{{ isset($modalidad->modalidad)?$modalidad->modalidad:'' }}">
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