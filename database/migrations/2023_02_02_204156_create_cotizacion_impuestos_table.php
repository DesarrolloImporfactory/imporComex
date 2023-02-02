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
        Schema::create('cotizacion_impuestos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cotizacion_id')->unsigned()->nullable();
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->onUpdate('cascade');

            $table->bigInteger('impuesto_id')->unsigned()->nullable();
            $table->foreign('impuesto_id')->references('id')->on('impuestos')->onUpdate('cascade');

            $table->bigInteger('usuario_id')->unsigned()->nullable();
            $table->foreign('usuario_id')->references('id')->on('users')->onUpdate('cascade');

            $table->string('valor')->nullable();
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
        Schema::dropIfExists('cotizacion_impuestos');
    }
};
