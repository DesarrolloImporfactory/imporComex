<div>
    @if ($boton == false)
        <button wire:click='aprobar("Aprobado")' class="btn btn-success float-right" wire:loading.remove type="button"
            wire:target='aprobar'>Aprobar</button>
    @else
        <button wire:loading.remove wire:target='aprobar' wire:click='aprobar("Pendiente")' type="button" class="btn btn-success float-right"><i
                class="fa-regular fa-circle-check"></i> Aprobado</button>
    @endif
    <div wire:loading class="float-right">
        <button type="button" class="btn btn-warning float-right">
            <i class="fa-solid fa-spinner fa-spin"></i>  Aprobado.....</button>
    </div>

</div>
