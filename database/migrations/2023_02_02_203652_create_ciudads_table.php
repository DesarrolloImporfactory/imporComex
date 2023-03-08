<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('ciudads', function (Blueprint $table) {
            $table->id();
            $table->string('provincia');
            $table->string('canton');
            $table->float('tarifa',8,2);
            $table->float('kilo_adicional',8,2);
            $table->string('tipo_trayecto');
            $table->string('tiemp_guayaquil');
            $table->string('tiemp_quito');
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('ciudads');
    }
};
