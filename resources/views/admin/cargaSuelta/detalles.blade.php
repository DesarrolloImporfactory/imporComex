<div class="modal fade" id="viewLCL" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles cotización LCL</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <p for="">FLETE MARITIMO: <b>{{$cotizacion->flete_maritimo}}$</b></p>
          </div>
          <div class="form-group">
            <p for="">GASTOS ORIGEN: <b>{{$cotizacion->gastos_origen}}$</b></p>
          </div>
          <div class="form-group">
            <p for="">GASTOS LOCALES: <b>{{$cotizacion->gastos_local}}$</b></p>
          </div>
          <div class="form-group">
            <p for="">OTROS GASTOS: {{$cotizacion->otros_gastos}}$</p>
          </div>
          <div class="form-group">
            <p for="">LOGISTICA INTERNACIONAL: <b>{{$cotizacion->otros_gastos + $cotizacion->gastos_local}}$</b></p>
          </div>
          <div class="form-group">
            <p for="">LOGISTICA TOTAL: <b>{{$cotizacion->total_logistica}}$</b></p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>