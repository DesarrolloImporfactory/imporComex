<div>
<div class="modal fade " id="crearUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
        <!-- Input addon -->
        <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Registrar Usuario</h3>
                
              </div>
              
              <form action="{{route('admin.usuarios.store')}}" method="post" id="formulario">
              @csrf
              <div class="card-body">
                <label for="">Nombre: </label>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="Adrian Torres" name="name">
                  
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <label for="">Telefono: </label>
                <div class="input-group mb-3">
                  <input type="number" class="form-control" placeholder="02-2956862" name="telefono">
                  
                </div>
                  </div>
                  <!-- /.col-lg-6 -->
                  <div class="col-lg-6">
                    <label>Idioma:</label>
                    <div class="input-group mb-3" >
                      <select class="form-control select2"  style="width: 100%;" name="idioma" required>
                        <option value="">---seleccione---</option>
                        @foreach ($idiomas as $idioma)
                            <option value="{{$idioma->nombre}}">{{$idioma->nombre}}</option>
                        @endforeach
                    </select>
                        
                    </div>
                  </div>
                  <!-- /.col-lg-6 -->
                </div>
                <div class="row">
                  <div class="col-lg-4 ">
                  <label>Date:</label>
                   <input type="date" name="date" id="" class="form-control">
                  </div>
                  <!-- /.col-lg-6 -->
                  <div class="col-lg-4">
                  <label for="">Importacion: </label>
                    <div class="input-group mb-3">
                      <input type="number" class="form-control" name="importacion">
                      
                    </div>
                    <!-- /input-group -->
                  </div>
                  <div class="col-lg-4">
                    <label>Estado:</label>
                    <div class="input-group mb-3" >
                      <select class="form-control select2"  style="width: 100%;" name="estado">
                        <option value="">---seleccione---</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                      
                    </select>
                        
                    </div>
                    </div>
                  <!-- /.col-lg-6 -->
                </div>

                <div class="row">                
                </div>
                <!-- /.row -->
                <div class="row">
                  <div class="col-lg-6">
                    <label for="">Ruc: </label>
                    <div class="input-group mb-3">
                      <input type="number" class="form-control" name="ruc" placeholder="1727569840001">
                      
                    </div>
                  </div>
                  <!-- /.col-lg-6 -->
                  <div class="col-lg-6">
                  <label for="">Cedula: </label>
                    <div class="input-group"> 
                      <input type="numer" class="form-control" name="cedula" placeholder="1727569840">
                     
                    </div>
                    <!-- /input-group -->
                  </div>
                  <!-- /.col-lg-6 -->
                </div>

                <label for="">Email: </label>
                <div class="input-group mb-3">
                  <input type="mail" class="form-control" name="email" placeholder="usuario@gmail.com">
                  
                </div>

                <label for="">Password: </label>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" name="password" placeholder="">
                  
                </div>
                
              </div>
              <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Guardar</button>
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
    </div>
  </div>
</div>
</div>
<script>
  $(document).ready(function() {
      $('.select2').select2({
          theme: "bootstrap"
      });
  });
  
</script>
<style>
  .select2-container--open .select2-dropdown {
  z-index: 1070;
}
</style>

