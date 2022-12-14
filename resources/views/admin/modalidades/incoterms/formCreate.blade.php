
<div>
    <div class="modal fade " id="crearIncoterms" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog ">
        <div class="modal-content">
        <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Registrar Incoterms</h3>
                  </div>
                  <form action="{{url('/admin/modalidades')}}" method="post" id="formulario">
                  @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Incoterms</label>
                        <input type="hidden" name="tipo" id="" value="in">
                        <input type="text" class="form-control"  name="name" >
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