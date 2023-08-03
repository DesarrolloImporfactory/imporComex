<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('imporcomex')->create('aereo_temps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('usuario_id')->unsigned()->nullable();
            $table->foreign('usuario_id')->references('id')->on('users')->onUpdate('cascade');
            $table->integer('cartones');
            $table->double('largo',8,2);
            $table->double('ancho',8,2);
            $table->double('alto',8,2);
            $table->double('peso_volumetrico_pieza',8,2)->nullable();
            $table->double('peso_volumetrico_total',8,2)->nullable();
            $table->double('peso_bruto_carton',8,2)->nullable();
            $table->double('peso_bruto_piezas',8,2)->nullable();
            $table->double('total',8,2)->nullable();
        });
    }

    public function down()
    {
        Schema::connection('imporcomex')->dropIfExists('aereo_temps');
    }
};
