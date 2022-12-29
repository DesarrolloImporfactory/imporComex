<form action="{{route('admin.contenedores.destroy',$contenedor->id)}}" method="post">
    @csrf
    {{method_field('DELETE')}}
    <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete" ><i class="fa fa-lg fa-fw fa-trash"></i></button>  
</form>