<div>
    <div class="modal fade" id="modalContenedor{{ $contenedor->id }}"  aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Editar Contenedor</h3>
                    </div>
                    <form action="{{ route('admin.contenedores.update', $contenedor->id) }}" method="post" id="formEdit">
                        {{ method_field('PATCH') }}
                        @csrf
                        @include('admin.contenedores.formulario')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .error{
        color: red !important;
    }
</style>
<script>
    $(document).ready(function() {
        $('#formEdit').validate({
            rules: {
                name: "required",
            },
            messages: {
                name: "Campo requerido",
            },
        });
    });
</script>
