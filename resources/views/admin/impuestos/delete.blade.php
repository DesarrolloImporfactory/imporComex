<form action="{{route('admin.impuestos.destroy',$item->id)}}" method="POST" class="btnDelete">
    @csrf
    {{method_field('DELETE')}}
    <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" ><i class="fa fa-lg fa-fw fa-trash"></i></button>
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