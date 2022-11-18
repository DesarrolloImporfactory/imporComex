<div>
<div class="modal fade " id="crearUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
        <!-- Input addon -->
        <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Registrar Usuario</h3>
              </div>
              <form action="{{route('admin.usuarios.store')}}" method="post" id="formulario">
              @csrf
              <div class="card-body">
                <label for="">Nombre: </label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Adrian Torres" name="name">
                  <div class="input-group-append">
                    <span class="input-group-text">.00</span>
                  </div>
                </div>

                <label for="">Telefono: </label>
                <div class="input-group mb-3">
                  <input type="number" class="form-control" placeholder="02-2956862" name="telefono">
                  <div class="input-group-append">
                    <span class="input-group-text">.00</span>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                  <label>Date:</label>
                    <div class="input-group date" >
                        <input type="date" class="form-control datetimepicker-input" name="date">
                        
                    </div>
                    <!-- /input-group -->
                  </div>
                  <!-- /.col-lg-6 -->
                  <div class="col-lg-6">
                  <label for="">Importacion: </label>
                    <div class="input-group">
                      <input type="number" class="form-control" name="importacion">
                      <div class="input-group-prepend">
                        <span class="input-group-text">icon</span>
                      </div>
                    </div>
                    <!-- /input-group -->
                  </div>
                  <!-- /.col-lg-6 -->
                </div><br>
                <!-- /.row -->

                <div class="row">
                  <div class="col-lg-6">
                  <label>Idioma:</label>
                    <div class="input-group " >
                        <input type="text" class="form-control" name="idioma" placeholder="Español" >
                        
                    </div>
                    <!-- /input-group -->
                  </div>
                  <!-- /.col-lg-6 -->
                  <div class="col-lg-6">
                  <label for="">Rol: </label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="rol" placeholder="Administrador">
                      <div class="input-group-prepend">
                        <span class="input-group-text">icon</span>
                      </div>
                    </div>
                    <!-- /input-group -->
                  </div>
                  <!-- /.col-lg-6 -->
                </div><br>
                <!-- /.row -->

                <div class="row">
                  <div class="col-lg-6">
                  <label>Estado:</label>
                    <div class="input-group" >
                        <input type="text" class="form-control" name="estado" placeholder="activo">
                        
                    </div>
                    <!-- /input-group -->
                  </div>
                  <!-- /.col-lg-6 -->
                  <div class="col-lg-6">
                  <label for="">Cedula: </label>
                    <div class="input-group"> 
                      <input type="numer" class="form-control" name="cedula" placeholder="1727569840">
                      <div class="input-group-prepend">
                        <span class="input-group-text">icon</span>
                      </div>
                    </div>
                    <!-- /input-group -->
                  </div>
                  <!-- /.col-lg-6 -->
                </div><br>
                <!-- /.row -->

                <label for="">Ruc: </label>
                <div class="input-group mb-3">
                  <input type="number" class="form-control" name="ruc" placeholder="1727569840001">
                  <div class="input-group-append">
                    <span class="input-group-text">.00</span>
                  </div>
                </div>

                <label for="">Email: </label>
                <div class="input-group mb-3">
                  <input type="mail" class="form-control" name="email" placeholder="usuario@gmail.com">
                  <div class="input-group-append">
                    <span class="input-group-text">.00</span>
                  </div>
                </div>

                <label for="">Password: </label>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" name="password" placeholder="">
                  <div class="input-group-append">
                    <span class="input-group-text">.00</span>
                  </div>
                </div>
                
              </div>
              <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Guardar</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
    </div>
  </div>
</div>
</div>

