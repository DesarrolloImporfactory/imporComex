<div class="modal fade" id="viewLCL" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles cotización
                    {{ $cotizacion->modalidad->modalidad }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light ">
                            <tr>
                                <th>DESCRIPCIÓN</th>
                                <th>VALOR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>FLETE MARITIMO:</b></td>
                                <td>{{ $cotizacion->flete_maritimo }}$</td>
                            </tr>
                            <tr>
                                <td><b>GASTOS ORIGEN:</b></td>
                                <td>{{ $cotizacion->gastos_origen }}$</td>
                            </tr>
                            <tr>
                                <td><b>GASTOS LOCALES:</b></td>
                                <td>{{ $cotizacion->gastos_local }}$</td>
                            </tr>
                            <tr>
                                <td><b>OTROS GASTOS:</b><br>
                                    Agente aduana: 302.40$ <br>
                                    Flete interno: {{ $cotizacion->flete}}$ <br>
                                    @if ($cotizacion->modalidad_id == 2)
                                        Bodegaje: {{ $variables->valor }}$
                                    @else
                                        Bodegaje: {{ $variables->minimo }}$
                                    @endif
                                </td>
                                <td>{{ $cotizacion->otros_gastos }}$</td>
                            </tr>
                            <tr class="table-danger">
                                <td><b>TOTAL COTIZACION FINAL:</b></td>
                                <td>{{ $cotizacion->total_logistica }}$</td>
                            </tr>
                            <tr class="table-success">
                                <td><b>LOGISTICA INTERNACIONAL:</b></td>
                                <td>{{ $cotizacion->otros_gastos + $cotizacion->gastos_local }}$</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
