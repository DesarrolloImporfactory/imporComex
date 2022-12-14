<div>
    <div class="modal fade" id="example{{$incoterm->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog ">
        <div class="modal-content">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Editar Incoterms</h3>
            </div>
            <form action="{{url('/admin/modalidades/'.$incoterm->id)}}" method="post" id="formulario">
                {{method_field('PATCH')}}
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Incoterms</label>
                    <input type="hidden" name="tipo"  value="in">
                    <input type="text" class="form-control"  name="name"  value="{{ isset($incoterm->name)?$incoterm->name:'' }}">
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