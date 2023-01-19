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
        Schema::create('validacions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_pro');
            $table->string('proveedores');
            $table->integer('total_cartones')->nullable();
            $table->string('factura')->nullable();
            $table->string('foto')->nullable();
            $table->string('enlace')->nullable();
            $table->string('contacto')->nullable();
            $table->bigInteger('cotizacion_id')->unsigned();
            $table->foreign('cotizacion_id')->references('id')->on('cotizaciones')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('validacions');
    }
};
