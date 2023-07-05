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
            $table->dateTime('time')->nullable();
            $table->bigInteger('usuario_id')->unsigned()->nullable();
            $table->foreign('usuario_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('especialista_id')->unsigned()->nullable();
            $table->foreign('especialista_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

            // $table->bigInteger('pais_id')->unsigned()->nullable();
            // $table->foreign('pais_id')->references('id')->on('paises')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('modalidad_id')->unsigned()->nullable();
            $table->foreign('modalidad_id')->references('id')->on('modalidades')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('cargas_id')->unsigned()->nullable();
            $table->foreign('cargas_id')->references('id')->on('tipo_cargas')->onUpdate('cascade')->onDelete('cascade');

            $table->string('tiene_bateria')->nullable();
            $table->string('liquidos');
            $table->string('inflamable');

            $table->bigInteger('incoterms_id')->unsigned()->nullable();
            $table->foreign('incoterms_id')->references('id')->on('incoterms')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('tarifa_id')->unsigned()->nullable();
            $table->foreign('tarifa_id')->references('id')->on('tarifa_gruapls')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('ciudad_id')->unsigned()->nullable();
            $table->foreign('ciudad_id')->references('id')->on('ciudads')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('puerto_id')->unsigned()->nullable();
            $table->foreign('puerto_id')->references('id')->on('puertos')->onDelete('cascade');

            $table->boolean('seguro')->nullable();
            $table->integer('proceso')->nullable();
            $table->string('origen')->nullable();
            $table->string('peso')->nullable();
            $table->string('volumen')->nullable();
            $table->string('direccion')->nullable();
            $table->string('cantidad_proveedores')->nullable();
            $table->string('cantidad_productos')->nullable();

            $table->string('flete_maritimo')->nullable();
            $table->string('gastos_origen')->nullable();
            $table->string('gastos_local')->nullable();
            $table->string('otros_gastos')->nullable();

            $table->float('total_fob')->nullable();
            $table->float('ISD')->nullable();
            $table->float('total_logistica')->nullable();
            $table->float('total_impuesto')->nullable();
            $table->float('total_compra')->nullable();
            $table->float('total')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cotizaciones');
    }
};