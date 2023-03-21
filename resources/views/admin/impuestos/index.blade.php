@extends('adminlte::page')
@section('title', 'Impuestos')

@section('content_header')

@if (Session::has('mensaje'))
<script>
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: '{{ Session::get('mensaje') }}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif

<div class="info-box">
    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">Gestion de Impuestos</span>
      <span class="info-box-number">1,410</span>
    </div>
  </div>
<div class="row">
    <div class="col-md-12">
        <x-adminlte-button label="Agregar Impuesto" data-toggle="modal" data-target="#modalCustom" theme="dark" icon="fas fa-plus" class="float-right"/>
        @include('admin.impuestos.create')
    </div>
</div>
@stop

@section('content')

<x-adminlte-card title="Tabla de impuestos" theme="dark" icon="fa-solid fa-money-bill-transfer">
    <x-table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Signo</th>
                <th>Estado</th>
                <th>Valor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datos as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->nombre}}</td>
                <td>{{$item->signo}}</td>
                <td>{{$item->estado}}</td>
                <td>{{$item->valor}}</td>
                <td>
                    <div class="btn-group">
                        <a class="btn btn-xs btn-default text-primary mx-1 shadow" data-bs-toggle="modal"
                            data-bs-target="#modal{{ $item->id }}" title="{{ $item->id }}">
                            <i class="fa fa-lg fa-fw fa-pen"></i>
                        </a>
                       @include('admin.impuestos.delete')
                    </div>
                </td>
                @include('admin.impuestos.edit')
            </tr>
           
            @endforeach
        </tbody>
    </x-table>
</x-adminlte-card>

@stop
