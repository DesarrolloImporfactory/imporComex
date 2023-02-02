<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->string('barcode');
            $table->string('estado')->nullable();
            $table->bigInteger('usuario_id')->unsigned()->nullable();
            $table->foreign('usuario_id')->references('id')->on('users')->onUpdate('cascade');

            $table->bigInteger('especialista_id')->unsigned()->nullable();
            $table->foreign('especialista_id')->references('id')->on('users')->onUpdate('cascade');

            $table->bigInteger('pais_id')->unsigned()->nullable();
            $table->foreign('pais_id')->references('id')->on('paises')->onUpdate('cascade');

            $table->bigInteger('modalidad_id')->unsigned()->nullable();
            $table->foreign('modalidad_id')->references('id')->on('modalidades')->onUpdate('cascade');

            $table->bigInteger('cargas_id')->unsigned()->nullable();
            $table->foreign('cargas_id')->references('id')->on('tipo_cargas')->onUpdate('cascade');

            // $table->string('producto')->nullable();
            $table->string('tiene_bateria')->nullable();
            $table->string('liquidos');
            $table->string('inflamable');
            // $table->string('precio_china')->nullable();

            $table->bigInteger('incoterms_id')->unsigned()->nullable();
            $table->foreign('incoterms_id')->references('id')->on('incoterms')->onUpdate('cascade');

            $table->bigInteger('tarifa_id')->unsigned()->nullable();
            $table->foreign('tarifa_id')->references('id')->on('tarifa_gruapls')->onUpdate('cascade');

            $table->bigInteger('ciudad_id')->unsigned()->nullable();
            $table->foreign('ciudad_id')->references('id')->on('ciudads')->onUpdate('cascade');

            $table->string('gastos_exw')->nullable();
            $table->boolean('seguro')->nullable();
            $table->integer('proceso')->nullable();
            $table->string('origen')->nullable();
            $table->string('peso')->nullable();
            $table->string('volumen')->nullable();
            $table->string('direccion')->nullable();
            // $table->string('ciudad_entrega')->nullable();
            $table->string('ruta')->nullable();
            $table->string('total_logistica')->nullable();
            $table->string('total_impuesto')->nullable();
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