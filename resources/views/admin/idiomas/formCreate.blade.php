<div>
<div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
    <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Registrar Idioma</h3>
              </div>
              <form action="{{url('/admin/idiomas')}}" method="post" id="formulario">
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Idioma</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Español">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Codigo</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="ES">
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