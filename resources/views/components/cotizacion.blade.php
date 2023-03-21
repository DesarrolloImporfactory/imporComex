<div class="modal fade" id="PDF" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="height:700px;">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">PDF DE COTIZACION DE IMPORTACION</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <embed src="{{ route('cotizacion.pdf', $cotizacion->id) }}" type="application/pdf" width="100%" height="100%">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->


<!-- Modal -->
