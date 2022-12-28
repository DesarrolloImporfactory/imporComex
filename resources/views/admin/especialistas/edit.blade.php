<div>
    <div class="modal fade" id="modalContenedor{{ $cotizacion->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cliente: {{ $cotizacion->usuario->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <form action="{{ route('admin.especialistas.update', $cotizacion->id) }}" method="post">
                        {{ method_field('PATCH') }}
                        @csrf
                        <div class="card-body text-center">
                            <div class="form-group">
                                <select name="estado" class="selectpicker " data-style="btn-primary">
                                    
                                    <option value="Aprobado"{{ $cotizacion->estado=="Aprobado" ? 'selected' : '' }}>Aprobado</option>
                                    <option value="Pendiente"{{ $cotizacion->estado=="Pendiente" ? 'selected' : '' }}>Pendiente</option>
                                    <option value="Finalizado"{{ $cotizacion->estado=="Finalizado" ? 'selected' : '' }}>Finalizado</option>
                                </select>
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

