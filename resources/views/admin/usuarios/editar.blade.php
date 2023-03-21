@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
<h1>Asignar un Rol</h1>
    
@stop

@section('content')

    @if(session('mensaje'))
        <div class="alert alert-success" role="alert">
            <strong>{{session('mensaje')}}</strong>
        </div>
    
    @endif

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    Gestionar Usuario
                </div>
                <div class="card-body">
                    <form action="{{url('/admin/show/'.$user->id)}}" method="post" id="formulario">
                        {{method_field('PATCH')}}
                        @csrf
                        <div class="card-body">
                          <div class="row">
                            <div class="col-lg-6">
                                <label for="">Nombre: </label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="{{$user->name}}" name="name">
                                    <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Email: </label>
                                <div class="input-group mb-3">
                                    <input type="mail" class="form-control" name="email" value="{{$user->email}}">
                                    <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                    </div>
                                </div> 
                            </div>
                          </div>
          
                          <div class="row">
                            <div class="col-lg-6">
                              <label for="">Telefono: </label>
                          <div class="input-group mb-3">
                            <input type="number" class="form-control" value="{{$user->telefono}}" name="telefono">
                            <div class="input-group-append">
                              <span class="input-group-text">.00</span>
                            </div>
                          </div>
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                              <label>Idioma:</label>
                              <div class="input-group mb-3" >
                                <select class="form-control select2"  style="width: 100%;" name="idioma" required>
                                    <option value="{{$user->idioma}}">{{$user->idioma}}</option>
                                    @foreach ($idiomas as $idioma)
                                        <option value="{{$idioma->nombre}}">{{$idioma->nombre}}</option>
                                    @endforeach
                                </select>
                                  
                              </div>
                            </div>
                            <!-- /.col-lg-6 -->
                          </div>
                          <div class="row">
                            <div class="col-lg-4 ">
                            <label>Date:</label>
                              <div class="input-group mb-3" >
                                  <input type="" class="form-control" name="date" value="{{$user->date}}">
                                  
                              </div>
                              <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-4">
                            <label for="">Importacion: </label>
                              <div class="input-group mb-3">
                                <input type="number" class="form-control" name="importacion" value="{{$user->importacion}}">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">icon</span>
                                </div>
                              </div>
                              <!-- /input-group -->
                            </div>
                            <div class="col-lg-4">
                              <label>Estado:</label>
                              <div class="input-group mb-3" >
                                <select class="form-control select2"  style="width: 100%;" name="estado" required>
                                    @if ($user->estado="1")
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    @else
                                    <option value="0">Inactivo</option>
                                    <option value="1">Activo</option>
                                    @endif
                                    
                                </select>
                                  
                              </div>
                              </div>
                            <!-- /.col-lg-6 -->
                          </div>
          
                          <div class="row">                
                          </div>
                          <!-- /.row -->
                          <div class="row">
                            <div class="col-lg-6">
                              <label for="">Ruc: </label>
                              <div class="input-group mb-3">
                                <input type="number" class="form-control" name="ruc" value="{{$user->ruc}}">
                                <div class="input-group-append">
                                  <span class="input-group-text">.00</span>
                                </div>
                              </div>
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                            <label for="">Cedula: </label>
                              <div class="input-group"> 
                                <input type="numer" class="form-control" name="cedula" value="{{$user->cedula}}">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">icon</span>
                                </div>
                              </div>
                              <!-- /input-group -->
                            </div>
                            <!-- /.col-lg-6 -->
                          </div>                           
                        </div>
                        
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                          
                        </form>
                </div>
                
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    Administrar Roles
                </div>
                <div class="card-body">
                    <p class="h5">Usuario:</p>
                    {{-- <p class="form-control">{{$user->name}}</p> --}}
                    <input type="text" value="{{$user->name}}" class="form-control" name="name">
                    <h2 class="h5 mt-2" >Listado de Roles</h2><br>
                    {!! Form::model($user, ['route'=>['admin.usuarios.update',$user], 'method'=>'put']) !!}
                        @foreach($rol as $roles)
                        <div>
                            <label>
                                {!! Form::checkbox('roles[]', $roles->id, null, ['class'=>'mr-1']) !!}
                                {{$roles->name}}
                            </label>
                        </div>
                        @endforeach
                        {!! Form::submit('Asignar Rol', ['class'=>'btn btn-primary mt-2']) !!}
                    {!! Form::close() !!}
                </div>
                
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: "bootstrap"
            });
        });
        
      </script>
      <style>
        .select2-container--open .select2-dropdown {
        z-index: 1070;
      }
      </style>

@stop

