<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('detalle_transaccions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pago_id')->unsigned()->nullable();
            $table->foreign('pago_id')->references('id')->on('forma_pagos')->onUpdate('cascade');
            $table->bigInteger('transaccion_id')->unsigned()->nullable();
            $table->foreign('transaccion_id')->references('id')->on('transaccions')->onUpdate('cascade');
            $table->bigInteger('cabecera_id')->unsigned()->nullable();
            $table->foreign('cabecera_id')->references('id')->on('cabecera_transaccions')->onUpdate('cascade')->onDelete('cascade');
            $table->double('valor',8,2);
            $table->date('fecha_vencimiento');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('detalle_transaccions');
    }
};
