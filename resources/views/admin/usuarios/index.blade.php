@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
<div class="row">
  <div class="col-md-6">
     <h1>Gestión de Usuarios</h1>
  </div>
  <div class="col-md-6">
   
  </div>
</div><br>
    
@stop

@section('content')
    
<div class="card">
    
  <div class="card-header">
    <div class="row">
    <div class="col-sm-9">
      <h3 class="card-title">Listado de Usuarios</h3>
    </div>
    <div class="col-sm-3 text-center">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearUsuario">
          Agregar Usuario
      </button>
  </div>
</div>
  </div>
  <div class="card-body">
  <table class="table table-striped table-hover text-center">
      <thead >
        <tr>          
          <th>ID</th>
          <th>Nombre</th>
          <th>Telefono</th>        
          <th>Fecha</th>    
          <th>Importacion</th>    
          <th>Idioma</th>    
          <th>Rol</th>                                   
          <th>Estado</th>    
          <th>Cedula</th>    
          <th>Ruc</th>    
          <th>Email</th>    
          <th>Acciones</th>    
        </tr>
      </thead>
      <tbody>
        @foreach($usuarios as $usuario)              
        <tr>
          <th scope="row">{{$usuario->id}}</th>
            <td>{{$usuario->nombre}}</td>      
            <td>{{$usuario->telefono}}</td>   
            <td>{{$usuario->date}}</td>   
            <td>{{$usuario->importacion}}</td>   
            <td>{{$usuario->idioma}}</td>     
            <td>{{$usuario->rol}}</td>   
            <td>{{$usuario->estado}}</td>   
            <td>{{$usuario->cedula}}</td>  
            <td>{{$usuario->ruc}}</td> 
            <td>{{$usuario->email}}</td> 
            <td>
              <a class="" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-three-dots-vertical"></i> 
              </a>
              <ul class="dropdown-menu">
                <li>
                <a class="dropdown-item "  href=" " data-bs-toggle="modal" 
                data-bs-target="#exampleModal{{$usuario->id}}"><i class="bi bi-pencil-square"></i>   Editar</a>
              </a></li>
                <li>
                    <!-- Modal eliminar -->
                  
                    <!-- Modal editar --> 
                </li>
                
              </ul>
            </td>
        </tr>
<!-- Modal editar -->
      
<!-- Modal editar -->              
      @endforeach
      </tbody>
    </table>
  </div>            
              
</div>

<!-- ---------------MODAL-------------------- -->
@include('admin.usuarios.formCreate')
<!-- ---------------FIN MODAL----------------- -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop