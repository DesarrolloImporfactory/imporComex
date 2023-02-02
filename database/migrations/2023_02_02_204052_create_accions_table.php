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
        Schema::create('accions', function (Blueprint $table) {
            $table->id();
            $table->boolean('ingreso_cot');
            $table->boolean('asignar_esp');
            $table->boolean('asignar_cont');
            $table->boolean('generacion_eti');
            $table->string('contacto');
            $table->string('impuesto');
            $table->string('contacto_prov');
            $table->bigInteger('cotizacion_id')->unsigned()->nullable();
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->onUpdate('cascade');
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
        Schema::dropIfExists('accions');
    }
};
