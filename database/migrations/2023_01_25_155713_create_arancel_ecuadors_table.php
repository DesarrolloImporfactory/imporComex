<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arancel_ecuadors', function (Blueprint $table) {
            $table->id();
            // $table->bigInteger('arancelPartida_id')->unsigned()->nullable();
            // $table->foreign('arancelPartida_id')->references('id')->on('arancel_partidas')->onUpdate('cascade');

            // $table->bigInteger('arancelCapitulo_id')->unsigned()->nullable();
            // $table->foreign('arancelCapitulo_id')->references('id')->on('arancel_capitulos')->onUpdate('cascade');
            // $table->string('codigo_complementario');
            // $table->string('codigo_norma');
            // $table->string('codigo_pro_sist');
            // $table->string('codigo_tipo_pro');
            // $table->string('codigo_uni_fisica');
            // $table->string('codigo_suplementario');
            // $table->string('comentarios_apert');
            // $table->string('comentarios_cierre');
            // $table->string('descripcion_elemento');
            // $table->string('elemento_tacito');
            // $table->string('eliminapunto');
            // $table->string('error_descripcion');
            // $table->date('fecha_fin_vigencia');
            // $table->date('fecha_inicio_vigencia');
            // $table->string('longitud');
            // $table->string('naturaleza_prim_merca');
            // $table->string('partida1');
            // $table->string('partida_clave');
            // $table->string('partida2');
            // $table->string('requi_info_vehiculo');
            // $table->string('seccion');
            // $table->string('sub_partida');
            // $table->string('tipo');
            // $table->string('tipo_elemento');
            // $table->string('tratamiento_merca');
            // $table->string('version_nomenclatura');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arancel_ecuadors');
    }
};
