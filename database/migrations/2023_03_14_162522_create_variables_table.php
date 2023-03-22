<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('variables', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->double('valor',8,2);
            $table->double('minimo',8,2)->nullable();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('variables');
    }
};
