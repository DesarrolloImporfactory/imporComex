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
        Schema::create('producto_insumos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('insumo_id')->unsigned()->nullable();
            $table->foreign('insumo_id')->references('id')->on('insumos')->onUpdate('cascade');
            $table->bigInteger('cotizacion_id')->unsigned()->nullable();
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->onUpdate('cascade');
            $table->integer('cantidad');
            $table->integer('precio');
            $table->integer('porcentaje');
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
        Schema::dropIfExists('producto_insumos');
    }
};
