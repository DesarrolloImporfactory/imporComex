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
            $table->string('bateria');
            $table->string('liquidos');
            $table->string('inflamable');
            $table->string('proveedores');
            $table->string('factura')->nullable();
            $table->string('foto')->nullable();
            $table->string('enlace');
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
