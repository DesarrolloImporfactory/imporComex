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
        Schema::create('arancel_capitulos', function (Blueprint $table) {
            $table->id();
            // $table->bigInteger('seccion')->unsigned()->nullable();
            // $table->foreign('seccion')->references('codigo_seccion')->on('arancel_secctions')->onUpdate('cascade');
            // $table->string('capitulo');
            // // $table->date('fecha');
            // $table->string('descripcion');
            // // $table->string('seccion');
            // $table->string('tipo_elemento');
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
        Schema::dropIfExists('arancel_capitulos');
    }
};
