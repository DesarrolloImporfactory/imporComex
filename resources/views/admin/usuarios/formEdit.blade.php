<div>
  <div class="modal fade" id="exampleModal{{$pais->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Editar Carga</h3>
          </div>
          <form action="{{url('/admin/paises/'.$pais->id)}}" method="post" id="formulario">
              {{method_field('PATCH')}}
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Pais</label>
                  <input type="text" class="form-control" id="nombre_pais" name="nombre_pais" placeholder="Ingrese el Pais" value="{{ isset($pais->nombre_pais)?$pais->nombre_pais:'' }}">
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