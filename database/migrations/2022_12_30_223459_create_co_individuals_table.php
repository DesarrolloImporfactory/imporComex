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
        Schema::create('co_individuals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('usuario_id')->unsigned()->nullable();
            $table->foreign('usuario_id')->references('id')->on('users')->onUpdate('cascade');

            $table->bigInteger('especialista_id')->unsigned()->nullable();
            $table->foreign('especialista_id')->references('id')->on('users')->onUpdate('cascade');
            $table->bigInteger('origen_id')->unsigned()->nullable();
            $table->foreign('origen_id')->references('id')->on('paises')->onUpdate('cascade');
            $table->bigInteger('destino_id')->unsigned()->nullable();
            $table->foreign('destino_id')->references('id')->on('paises')->onUpdate('cascade');

            $table->bigInteger('incoterms_id')->unsigned()->nullable();
            $table->foreign('incoterms_id')->references('id')->on('incoterms')->onUpdate('cascade');

            $table->string('proveedores');
            $table->string('direccion')->nullable();
            $table->string('peso');
            $table->string('valor');
            $table->string('productos');
            $table->string('volumen');
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
        Schema::dropIfExists('co_individuals');
    }
};
