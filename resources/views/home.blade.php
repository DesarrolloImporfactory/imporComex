@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <form action="{{ route('admin.dashboard.all') }}" method="post" id="form">
        @csrf
        <input type="text" name="id" value="1" >
    </form>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('admin.dashboard.all') }}",
                method:"POST",
                data:$("#form").serialize()
            }).done(function(res){
                alert(res);
            });

        });
    </script>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

@stop
