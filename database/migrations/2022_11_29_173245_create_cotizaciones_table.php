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
            
            $table->bigInteger('usuario_id')->unsigned()->nullable();
            $table->foreign('usuario_id')->references('id')->on('users')->onUpdate('cascade');

            $table->bigInteger('pais_id')->unsigned()->nullable();
            $table->foreign('pais_id')->references('id')->on('paises')->onUpdate('cascade');

            $table->bigInteger('modalidad_id')->unsigned()->nullable();
            $table->foreign('modalidad_id')->references('id')->on('modalidades')->onUpdate('cascade');

            $table->bigInteger('cargas_id')->unsigned()->nullable();
            $table->foreign('cargas_id')->references('id')->on('tipo_cargas')->onUpdate('cascade');
            $table->string('producto')->nullable();
            $table->float('total_cartones',8,2)->nullable();

            $table->bigInteger('contenedor_id')->unsigned()->nullable();
            $table->foreign('contenedor_id')->references('id')->on('contenedores')->onUpdate('cascade');

            $table->bigInteger('incoterms_id')->unsigned()->nullable();
            $table->foreign('incoterms_id')->references('id')->on('incoterms')->onUpdate('cascade');

            $table->bigInteger('tarifa_id')->unsigned()->nullable();
            $table->foreign('tarifa_id')->references('id')->on('tarifa_gruapls')->onUpdate('cascade');

            $table->string('gastos_exw')->nullable();
            $table->boolean('seguro')->nullable();
            $table->integer('proceso')->nullable();
            $table->string('pais_od')->nullable();
            $table->string('origen')->nullable();
            $table->string('peso')->nullable();
            $table->string('volumen')->nullable();
            $table->string('direccion')->nullable();
            $table->string('ciudad_entrega')->nullable();
            $table->string('ruta')->nullable();
            $table->string('total')->nullable();
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
