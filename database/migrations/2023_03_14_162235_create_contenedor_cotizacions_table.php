<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('contenedor_cotizacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id')->nullable()->constrained('cotizaciones')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('contenedor_id')->nullable()->constrained('contenedores')->cascadeOnUpdate()->nullOnDelete();
            //$table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('contenedor_cotizacions');
    }
};
