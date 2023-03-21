<form action="{{url('/admin/modalidades/'.$incoterm->id)}}" method="post" >
    @csrf
    {{method_field('DELETE')}}
    <input type="hidden" name="tipo" value="in">
    <button type="submit" class="dropdown-item" ><i class="bi bi-trash"></i> Eliminar</button>             
</form>