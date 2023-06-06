                 <div class="form-group">

                     {!! Form::label('name', 'Rol:') !!}
                     {!! Form::text('name', null, [
                         'class' => 'form-control',
                         'placeholder' => 'Ingrese el nombre del rol',
                         'required',
                     ]) !!}
                     @error('name')
                         <small class="text-danger">Ingrese un rol valido</small>
                     @enderror
                 </div>
                 <label for="">Lista de permisos</label>
                 <div class="row">
                     @foreach (collect($permissions)->take(count($permissions) / 2) as $key => $permission)
                         <div class="col-md-6">
                             <div class="ml-3 mt-2 form-check">
                                 <p for="">
                                     {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-1']) !!}
                                     {{ $permission->description }}
                                 </p>
                             </div>
                         </div>
                     @endforeach
                 </div>
                 <div class="row">
                     @foreach (collect($permissions)->skip(count($permissions) / 2) as $key => $permission)
                         <div class="col-md-6">
                             <div class="ml-3 mt-2 form-check">
                                 <p for="">
                                     {!! Form::checkbox('permissions[]', $permission->id, null, ['class' => 'mr-1']) !!}
                                     {{ $permission->description }}
                                 </p>
                             </div>
                         </div>
                     @endforeach
                 </div>
