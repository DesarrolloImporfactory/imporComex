@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
  <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#crearPais">
    Agregar Pais
  </button>
    
@stop

@section('content')
    <br><br>
<div class="card">
    
  <div class="card-body">
  <x-table>
      <thead class="">
        <tr class="table-dark">          
          <th>ID</th>
          <th>Nombre Pais</th>
          <th>Acciones</th>                                       
        </tr>
      </thead>
      <tbody>
        @foreach($paises as $pais)              
        <tr>
          <th scope="row">{{$pais->id}}</th>
            <td>{{$pais->nombre_pais}}</td>        
            <td>
              <a class="" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bars"></i>
              </a>
              <ul class="dropdown-menu">
                <li>
                <a class="dropdown-item "  href=" " data-bs-toggle="modal" 
                data-bs-target="#exampleModal{{$pais->id}}"><i class="bi bi-pencil-square"></i>   Editar</a>
              </a></li>
                <li>
                    <!-- Modal eliminar -->
                    @include('admin.paises.formDelete')
                    <!-- Modal editar --> 
                </li>
                
              </ul>
            </td>
        </tr>
<!-- Modal editar -->
      @include('admin.paises.formEdit')
<!-- Modal editar -->              
      @endforeach
      </tbody>
    </x-table>
  </div>            
              
</div>

<!-- ---------------MODAL-------------------- -->
@include('admin.paises.formCreate')
<!-- ---------------FIN MODAL----------------- -->
<br>
@stop

