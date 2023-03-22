<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('cabecera_transaccions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cotizacion_id')->unsigned()->nullable();
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->onUpdate('cascade')->onDelete('cascade');
            $table->date('fecha_cotizacion')->nullable();
            $table->date('fecha_maxima')->nullable();
            $table->boolean('estado')->nullable();
            $table->double('saldo',8,2)->nullable();
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('cabecera_transaccions');
    }
};
