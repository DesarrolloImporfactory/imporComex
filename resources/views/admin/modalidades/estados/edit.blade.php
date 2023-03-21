<div>
    <div class="modal fade" id="modalEstado{{ $estado->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Editar Estado</h3>
                    </div>
                    <form action="{{ route('admin.estados.update', $estado->id) }}" method="post">
                        {{ method_field('PATCH') }}
                        @csrf
                        @include('admin.modalidades.estados.formulario')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
