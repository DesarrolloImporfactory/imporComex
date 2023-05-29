<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('tarifarios', function (Blueprint $table) {
            $table->id();
            $table->string('transporte')->nullable();
            $table->string('origen')->nullable();
            $table->string('destino')->nullable();
            $table->double('peso_min',8,2)->nullable();
            $table->double('peso_max',8,2)->nullable();
            $table->double('costo',8,2)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tarifarios');
    }
};
