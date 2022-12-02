<div>
    <div class="modal fade" id="example{{$tarifa->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog ">
        <div class="modal-content">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Editar Tarifa</h3>
            </div>
            <form action="{{url('/tarifa/'.$tarifa->id)}}" method="post" id="formulario">
                {{method_field('PATCH')}}
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">M3</label>
                    <input type="text" class="form-control"  name="m3"  value="{{ isset($tarifa->m3)?$tarifa->m3:'' }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">VXCBM</label>
                    <input type="text" class="form-control" name="vxcbm"  value="{{ isset($tarifa->vxcbm)?$tarifa->vxcbm:'' }}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">TCBM</label>
                    <input type="text" class="form-control"  name="tcbm"  value="{{ isset($tarifa->tcbm)?$tarifa->tcbm:'' }}">
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