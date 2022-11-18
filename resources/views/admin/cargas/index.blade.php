@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
<div class="row">
  <div class="col-md-6">
     <h1>Gestión de Cargas</h1>
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
      <h3 class="card-title">Listado de Cargas</h3>
    </div>
    <div class="col-sm-3 text-center">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearCarga">
          Agregar Carga
      </button>
  </div>
</div>
  </div>
  <div class="card-body">
  <table class="table table-striped table-hover text-center">
      <thead >
        <tr>          
          <th>ID</th>
          <th>Tipo de carga</th>
          <th>Acciones</th>                                       
        </tr>
      </thead>
      <tbody>
        @foreach($cargas as $carga)              
        <tr>
          <th scope="row">{{$carga->id}}</th>
            <td>{{$carga->tipoCarga}}</td>        
            <td>
              <a class="" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-three-dots-vertical"></i> 
              </a>
              <ul class="dropdown-menu">
                <li>
                <a class="dropdown-item "  href=" " data-bs-toggle="modal" 
                data-bs-target="#exampleModal{{$carga->id}}"><i class="bi bi-pencil-square"></i>   Editar</a>
              </a></li>
                <li>
                    <!-- Modal eliminar -->
                    @include('admin.cargas.formDelete')
                    <!-- Modal editar --> 
                </li>
                
              </ul>
            </td>
        </tr>
<!-- Modal editar -->
      @include('admin.cargas.formEdit')
<!-- Modal editar -->              
      @endforeach
      </tbody>
    </table>
  </div>            
              
</div>

<!-- ---------------MODAL-------------------- -->
@include('admin.cargas.formCreate')
<!-- ---------------FIN MODAL----------------- -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop