<div>
    <div class="modal fade " id="crearEstado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Registrar Estado</h3>
                    </div>
                    <form action="{{ route('admin.estados.store')}}" method="post" >
                        @csrf
                        @include('admin.modalidades.estados.formulario')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>