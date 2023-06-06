@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
    @if(session('mensaje'))
        <div class="alert alert-success" role="alert">
            <strong>{{session('mensaje')}}</strong>
        </div>
    
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-3">
                <div class="card-header">
                    EDITAR ROL
                </div>
                <div class="card-body">
                    {!! Form::model($role, ['route'=>['admin.roles.update',$role], 'method'=>'put']) !!}
                       
                    @include('admin.roles.partials.form')
                    {!! Form::submit('Editar rol', ['class'=>'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

