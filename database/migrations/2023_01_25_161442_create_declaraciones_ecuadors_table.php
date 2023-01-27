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
        Schema::create('declaraciones_ecuadors', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('fecha_id')->unsigned()->nullable();
            $table->foreign('fecha_id')->references('id')->on('fechas')->onUpdate('cascade');
            $table->bigInteger('ciudadEmbar_id')->unsigned()->nullable();
            $table->foreign('ciudadEmbar_id')->references('id')->on('ciudad_embarques')->onUpdate('cascade');
            $table->bigInteger('regimen_id')->unsigned()->nullable();
            $table->foreign('regimen_id')->references('id')->on('regimens')->onUpdate('cascade');
            $table->bigInteger('estDeclaracion_id')->unsigned()->nullable();
            $table->foreign('estDeclaracion_id')->references('id')->on('estado_declaracions')->onUpdate('cascade');
            $table->bigInteger('arancelCapitulo_id')->unsigned()->nullable();
            $table->foreign('arancelCapitulo_id')->references('id')->on('arancel_capitulos')->onUpdate('cascade');
            $table->bigInteger('agencia_id')->unsigned()->nullable();
            $table->foreign('agencia_id')->references('id')->on('agencias')->onUpdate('cascade');
            $table->bigInteger('paisEmbarque_id')->unsigned()->nullable();
            $table->foreign('paisEmbarque_id')->references('id')->on('pais_embarques')->onUpdate('cascade');
            $table->bigInteger('arancelPartida_id')->unsigned()->nullable();
            $table->foreign('arancelPartida_id')->references('id')->on('arancel_partidas')->onUpdate('cascade');

            $table->string('cif2');
            $table->string('adv_liq_partida');
            $table->string('adv_pag_partida');
            $table->string('agencia');
            $table->string('agente_afianzado');
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
        Schema::dropIfExists('declaraciones_ecuadors');
    }
};
