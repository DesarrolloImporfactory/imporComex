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
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('usuario_id')->unsigned();
            $table->foreign('usuario_id')->references('id')->on('users')->onUpdate('cascade');

            $table->bigInteger('pais_id')->unsigned();
            $table->foreign('pais_id')->references('id')->on('paises')->onUpdate('cascade');

            $table->bigInteger('modalidad_id')->unsigned();
            $table->foreign('modalidad_id')->references('id')->on('modalidades')->onUpdate('cascade');

            $table->bigInteger('carga_id')->unsigned();
            $table->foreign('carga_id')->references('id')->on('tipo_cargas')->onUpdate('cascade');

            $table->string('producto');
            $table->float('total_cartones',8,2);
            $table->string('incoterm');
            $table->string('contenedor');
            $table->string('gastos_exw');
            $table->boolean('seguro');
            $table->string('tipo_carga');
            $table->string('pais_od');
            $table->string('origen');
            $table->string('destino');
            $table->string('ruta');
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
        Schema::dropIfExists('cotizaciones');
    }
};
