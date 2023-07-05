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
        Schema::connection('imporcomex')->create('gastos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cotizacion_id')->unsigned()->nullable();
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->onUpdate('cascade')->onDelete('cascade');
            $table->float('transmicin',8,2)->nullable();
            $table->float('administracion',8,2)->nullable();
            $table->float('logistico',8,2)->nullable();
            $table->float('portuario',8,2)->nullable();
            $table->float('collect',8,2)->nullable();
             $table->float('total',8,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('imporcomex')->dropIfExists('gastos');
    }
};
