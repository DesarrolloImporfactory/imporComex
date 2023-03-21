<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('transaccions', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_transaccion');
            $table->string('signo');
            $table->timestamps();
        });
    }

 
    public function down()
    {
        Schema::dropIfExists('transaccions');
    }
};
