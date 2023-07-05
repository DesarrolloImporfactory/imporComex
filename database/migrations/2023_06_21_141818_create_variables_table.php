<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::connection('imporcomex')->create('variables', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('modalidad_id')->unsigned()->nullable();
            $table->foreign('modalidad_id')->references('id')->on('modalidades')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('operacion_id')->unsigned()->nullable();
            $table->foreign('operacion_id')->references('id')->on('puerto_chinas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('tipo');
            $table->string('nombre');
            $table->double('valor',8,2);
            $table->double('minimo',8,2)->nullable();
        });
    }

    public function down()
    {
        Schema::connection('imporcomex')->dropIfExists('variables');
    }
};
