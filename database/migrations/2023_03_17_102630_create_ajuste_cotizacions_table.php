<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::create('ajuste_cotizacions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cotizacion_id')->unsigned()->nullable();
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->onUpdate('cascade');
            $table->double('valor',8,2);
            $table->string('motivo');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('ajuste_cotizacions');
    }
};
