<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('imporcomex')->create('calculadoras', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cotizacion_id')->unsigned()->nullable();
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('insumo_id')->unsigned()->nullable();
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('cartones');
            $table->string('largo');
            $table->string('ancho');
            $table->string('alto');
            $table->string('total');
        });
    }
    public function down()
    {
        Schema::connection('imporcomex')->dropIfExists('calculadoras');
    }
};
