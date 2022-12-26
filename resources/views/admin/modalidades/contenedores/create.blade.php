<div>
    <div class="modal fade " id="crearContenedor" data-bs-backdrop="static" data-bs-keyboard="false" 
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Registrar Contenedor</h3>
                    </div>
                    <form action="{{ route('admin.contenedores.store')}}" method="post" >
                        @csrf
                        @include('admin.modalidades.contenedores.formulario')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
