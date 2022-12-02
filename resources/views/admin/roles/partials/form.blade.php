
                        
    <div class="form-group">
        
        {!! Form::label('name', 'Rol:') !!}
        {!! Form::text('name', null, ['class'=>'form-control','placeholder'=>'Ingrese el nombre del rol', 'required']) !!}
        @error('name')
            <small class="text-danger">Ingrese un rol valido</small>
        @enderror
    </div>
    <label for="">Lista de permisos</label>
    @foreach ($permissions as $permission)
        <div>
            <label for="">
                {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=>'mr-1']) !!}
                {{$permission->description}}
            </label>
        </div>
    @endforeach
