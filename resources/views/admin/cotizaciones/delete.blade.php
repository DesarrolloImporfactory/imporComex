

<form action="{{route('admin.cotizaciones.destroy',$cotizacion->id)}}" method="post" class="btnDelete">
    @csrf
    {{method_field('DELETE')}}
    <button type="submit" class="dropdown-item text-danger" title="Delete" ><i class="fa fa-lg fa-fw fa-trash"></i>Eliminar</button>  
</form>

<script>
    $('.btnDelete').submit(function(e) {
        e.preventDefault();
        // -----------------------------
        Swal.fire({
            title: 'Estas seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        })
        // ----------------------------
    });
</script>