@extends('adminlte::page')

@section('title', 'Searcher')

@section('content_header')
    <h1>Buscador</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">País Origen: </label>
                                </div>
                                <div class="col-md-9">
                                    <x-adminlte-select2 name="pais" id="pais" onchange="colocar()"
                                        data-placeholder="">
                                        <option>Seleccione un pais...</option>
                                        @foreach ($paises as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre_pais }}</option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
                            </div>
                            <div class="row  mt-4">
                                <div class="col-md-3">
                                    <label for="">Descripción Comercial: </label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group has-search">
                                        <div class="ui-widget">
                                            <span class="fa fa-search form-control-feedback"></span>
                                            <input type="text" name="descripcion" valor="" id="descripcion"
                                                class="form-control" placeholder="Digite el nombre del producto">
                                        </div>
                                    </div>
                                    <div id="countryList">
                                        <ul class="list-group" style="display:block; position:relative" id="listadoDes">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row  mt-4">
                                <div class="col-md-3">
                                    <label for="">Partida Aduanera: </label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group has-search">
                                        <div class="ui-widget">
                                            <span class="fa fa-search form-control-feedback"></span>
                                            <input type="text" name="partida" id="partida" class="form-control"
                                                placeholder="Digite el codigo de partida">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row  mt-4">
                                <div class="col-md-3">
                                    <label for="">Importador: </label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group has-search">
                                        <span class="fa fa-search form-control-feedback"></span>
                                        <input type="text" name="importador" id="importador" class="form-control"
                                            placeholder="Digite el nombre de la empresa importadora">
                                    </div>
                                </div>
                            </div>
                            <div class="row  mt-4">
                                <div class="col-md-3">
                                    <label for="">Exportador: </label>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group has-search">
                                        <span class="fa fa-search form-control-feedback"></span>
                                        <input type="text" name="exportador" id="exportador" class="form-control"
                                            placeholder="Digite el nombre de la empresa exportadora">
                                    </div>
                                </div>
                            </div>
                            <div class="row  mt-4">
                                <label for="" class=" text-secondary">Información en linea</label>
                                <div class="col-md-3 mt-3">
                                    <label for="">Desde: </label>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-3 mt-3 text-center">
                                    <label for="">Hasta: </label>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    Filtros de busqueda
                                </div>
                                <div class="card-body textDesc">
                                    <span class="badge bg-danger"><i class="fa-solid fa-check "></i> </span> Desc.
                                    Comercial:
                                </div>
                                <div class="card-body textPais">
                                    <span class="badge bg-danger "><i class="fa-solid fa-check "></i> </span> Pais:
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#partida").autocomplete({
            // source: 'http://localhost/imporComex/public/search/prueba'
            source: '../search/descripcion',
            minLength: 2,
            select: function(event, ui) {
                event.preventDefault();
                console.log(ui.item.id);
                $("#partida").val(ui.item.label);
            }
        });

        function colocar() {
            $(".textPais").html("");
            var pais = $("#pais option:selected").text();
            console.log(pais);
            $(".textPais").append(`
                <span  class="badge bg-teal "><i class="fa-solid fa-check "></i> </span>  Pais: ${pais} 
            `);
        }

        $("#descripcion").autocomplete({
            source: '../search/descripcion',
            minLength: 2,
            select: function(event, ui) {
                $(".textDesc").html("");

                event.preventDefault();
                console.log(ui.item.id);
                $("#descripcion").val(ui.item.label);
                $(this).attr('valor', ui.item.label); //asigna valor a un atributo del input
                $(".textDesc").append(`
                <span id="spanDesc" class="badge bg-teal "><i id="iconoDesc" class="fa-solid fa-check "></i> </span>  Desc. Comercial: ${ui.item.label} 
                `);
            }
        });

        // $(document).on('click', '.ui-menu-item', function() {
        //     $('#descripcion').val($(this).text());
        //     var valor = $(this).text();
        //     $("#listadoDes").html("");
        //     console.log(valor);
        // });
    </script>
@stop

@section('css')
    <style>
        .has-search .form-control {
            padding-left: 2.375rem;
        }

        .has-search .form-control-feedback {
            position: absolute;
            z-index: 2;
            display: block;
            width: 2.375rem;
            height: 2.375rem;
            line-height: 2.375rem;
            text-align: center;
            pointer-events: none;
            color: #aaa;
        }

        .list:hover {
            color: black;
            background: #0088cc;
        }
    </style>
@stop
