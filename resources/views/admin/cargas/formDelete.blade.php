<form action="{{url('/admin/cargas/'.$carga->id)}}" method="post" >
    @csrf
    {{method_field('DELETE')}}
    <button type="submit" class="dropdown-item" ><i class="bi bi-trash"></i> Eliminar</button>             
</form>