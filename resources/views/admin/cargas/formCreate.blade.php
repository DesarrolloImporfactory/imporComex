<div>
<div class="modal fade " id="crearCarga" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
    <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Registrar Carga</h3>
              </div>
              <form action="{{url('/admin/cargas')}}" method="post" id="formulario">
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Tipo de carga</label>
                    <input type="text" class="form-control" id="tipoCarga" name="tipoCarga" placeholder="Español">
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