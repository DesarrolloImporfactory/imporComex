@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
<h1>Editar Rol</h1>
    
@stop

@section('content')

    @if(session('mensaje'))
        <div class="alert alert-success" role="alert">
            <strong>{{session('mensaje')}}</strong>
        </div>
    
    @endif
        
    <div class="card">
        <div class="card-body">
        
            {!! Form::model($role, ['route'=>['admin.roles.update',$role], 'method'=>'put']) !!}
               
            @include('admin.roles.partials.form')
            {!! Form::submit('Editar rol', ['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}

        </div>
    </div>


@stop

